<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CommandType;
use App\Enums\CommandStatus;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'signal_id',
        'command_type',
        'command_status',
    ];

    /**
     * Convert attributes to their respective Enum types.
     */
    protected $casts = [
        'command_type' => CommandType::class,  // تحويل command_type إلى Enum
        'command_status' => CommandStatus::class,  // تحويل command_status إلى Enum
    ];

    /**
     * Relationship: Each command belongs to one brainwave signal.
     */
    public function brainwaveSignal()
    {
        return $this->belongsTo(BrainwaveSignal::class, 'signal_id');
    }
}
