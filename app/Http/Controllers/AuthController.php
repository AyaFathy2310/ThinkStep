<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use App\Mail\VerificationLinkMail;
use App\Mail\ResetPasswordCodeMail;

class AuthController extends Controller
{
    // ✅ تسجيل مقدم الرعاية
    public function registerCaregiver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|unique:users|min:10',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'Caregiver',
        ]);

        // إرسال رابط التحقق عبر البريد
        $this->sendVerificationLink($user);

        return response()->json([
            'message' => 'Registration successful. Verification link sent.',
            'user' => $user
        ], 201);
    }

    // ✅ إرسال رابط التحقق عبر البريد
    public function sendVerificationLink(User $user)
    {
        $verificationUrl = URL::signedRoute('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->email)
        ]);

        Mail::to($user->email)->send(new VerificationLinkMail($verificationUrl));
    }

    // ✅ تفعيل الحساب عبر الرابط
    public function verifyEmail(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (!hash_equals(sha1($user->email), (string) $request->hash)) {
            return response()->json(['message' => 'Invalid verification link.'], 400);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Email verified successfully.']);
    }

    // ✅ تسجيل الدخول لمقدم الرعاية
    public function loginCaregiver(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->where('role', 'Caregiver')->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found.'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Incorrect password.'], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'Please verify your email first.'], 403);
        }

        $token = JWTAuth::fromUser($user); // ✅ لا نحتاج إلى تخزين التوكن في قاعدة البيانات

        return response()->json(['access_token' => $token, 'user' => $user]);
    }

    // ✅ إرسال OTP عند نسيان كلمة المرور
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $user = User::where('email', $request->email)->first();

        VerificationCode::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => $otp, 'expires_at' => Carbon::now()->addMinutes(15)]
        );

        Mail::to($request->email)->send(new ResetPasswordCodeMail($otp));

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    // ✅ إعادة تعيين كلمة المرور باستخدام OTP
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $verification = VerificationCode::where('user_id', $user->id)
                                        ->where('token', $request->otp)
                                        ->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }

        if (Carbon::parse($verification->expires_at)->isPast()) {
            $verification->delete(); // ✅ حذف OTP المنتهي الصلاحية
            return response()->json(['message' => 'OTP expired. Please request a new one.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $verification->delete(); // ✅ حذف OTP بعد الاستخدام

        return response()->json(['message' => 'Password reset successfully.']);
    }

    // ✅ تسجيل الخروج
    public function logout()
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            return response()->json(['message' => 'No token provided'], 400);
        }

        try {
            JWTAuth::invalidate($token);
            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid or expired token'], 400);
        }
    }

}
