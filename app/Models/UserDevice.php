<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Enums\Role;
use App\Enums\AccessPermission;

class UserDevice extends Pivot
{
    use HasFactory;

    protected $table = 'user_devices';

    protected $fillable = [
        'user_id',
        'device_id',
        'role',
        'access_permissions',
    ];

    protected $casts = [
        'role' => Role::class,
        'access_permissions' => AccessPermission::class,
    ];

    // جلب جميع الأجهزة التي يمتلكها المستخدم (Owner فقط)
    public function scopeOwnedByUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('role', Role::Caregiver);
    }

    // جلب جميع الأجهزة التي يمكن للمستخدم التحكم بها
    public function scopeControllableByUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('access_permissions', AccessPermission::Control);
    }
}
