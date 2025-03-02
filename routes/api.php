<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ✅ مسارات التوثيق
Route::prefix('auth')->group(function () {
    Route::post('/register/caregiver', [AuthController::class, 'registerCaregiver']); // تسجيل مقدم الرعاية
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify'); // التحقق من البريد
    Route::post('/login/caregiver', [AuthController::class, 'loginCaregiver']); // تسجيل الدخول
    Route::post('/send-reset-password-code', [AuthController::class, 'sendResetOtp']); // إرسال كود استعادة كلمة المرور
    Route::post('/reset-password', [AuthController::class, 'resetPassword']); // إعادة تعيين كلمة المرور
});

// ✅ تسجيل الخروج مع تأمين التوكن
Route::middleware('auth:jwt')->post('/logout', [AuthController::class, 'logout']);
