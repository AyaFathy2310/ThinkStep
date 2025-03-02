<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AlertType;
use App\Enums\Severity;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'alert_type',
        'severity',
    ];

    protected $casts = [
        'alert_type' => AlertType::class,
        'severity' => Severity::class,
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
