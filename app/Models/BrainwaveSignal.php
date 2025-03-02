<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SignalType;
use App\Enums\ProcessedStatus;

class BrainwaveSignal extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'raw_data',
        'signal_type',
        'processed_status',
    ];

    protected $casts = [
        'signal_type' => SignalType::class,
        'processed_status' => ProcessedStatus::class,
    ];

    // العلاقة مع الأجهزة
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    // العلاقة مع الأوامر
    public function commands()
    {
        return $this->hasMany(Command::class);
    }
}
