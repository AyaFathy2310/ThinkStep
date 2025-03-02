<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'speed',
        'direction',
    ];

    /**
     * Relationship: Each location tracking record belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
