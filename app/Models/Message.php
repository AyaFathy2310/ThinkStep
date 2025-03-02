<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'communication_id',
        'content',
    ];

    /**
     * العلاقة: كل رسالة لها مرسل (User).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * العلاقة: كل رسالة لها مستقبل (User).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * العلاقة: كل رسالة مرتبطة بـ Communication.
     */
    public function communication()
    {
        return $this->belongsTo(Communication::class);
    }
}
