<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\MessageType;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message_type',
        'content',
    ];

    /**
     * Convert attributes to their respective Enum types.
     */
    protected $casts = [
        'message_type' => MessageType::class,  // تحويل message_type إلى Enum
    ];

    /**
     * Relationship: Each communication message belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: One communication can have many messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
