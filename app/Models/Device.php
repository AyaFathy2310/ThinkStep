<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DeviceType;
use App\Enums\DeviceStatus;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_type',
        'battery_status',
        'device_status',
    ];

    protected $casts = [
        'device_type' => DeviceType::class,
        'device_status' => DeviceStatus::class,
    ];

    // العلاقة مع المستخدمين (Many-to-Many عبر user_devices)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_devices')
            ->withPivot('role', 'access_permissions')
            ->withTimestamps();
    }

    // العلاقة مع إشارات الدماغ (One-to-Many)
    public function brainwaveSignals()
    {
        return $this->hasMany(BrainwaveSignal::class);
    }

    // العلاقة مع التنبيهات (One-to-Many)
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
