<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'heart_rate',
        'activity_level',
        'oxygen_level',
        'blood_pressure',
    ];

    /**
     * Relationship: Each patient status record belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
