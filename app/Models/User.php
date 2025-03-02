<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\Role;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject 
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'password',
        'role',
    ];
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'role' => Role::class,
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];
    
    // ✅ العلاقة مع `VerificationCode`
    public function verificationCode()
    {
        return $this->hasOne(VerificationCode::class, 'user_id');
    }

    // العلاقة مع الأجهزة (Many-to-Many عبر user_devices)
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'user_devices')
            ->withPivot('role', 'access_permissions')
            ->withTimestamps();
    }

    // العلاقة مع تتبع الموقع (One-to-Many)
    public function locationTracking()
    {
        return $this->hasMany(LocationTracking::class);
    }

    // العلاقة مع حالة المريض (One-to-Many)
    public function patientStatus()
    {
        return $this->hasMany(PatientStatus::class);
    }

    // العلاقة مع التواصل (Many-to-Many عبر Messages)
    public function communication()
    {
        return $this->belongsToMany(Communication::class, 'messages')
            ->withTimestamps();
    }

    public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}


    // العلاقة مع قائمة الاتصال (Many-to-Many عبر user_contacts)
    public function contacts()
    {
        return $this->belongsToMany(User::class, 'user_contacts', 'user_id', 'contact_id')
                ->withPivot('relationship_type')
                ->withTimestamps();
    }

    //JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
