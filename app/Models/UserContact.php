<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Enums\RelationshipType;

class UserContact extends Pivot
{
    use HasFactory;

    protected $table = 'user_contacts';

    protected $fillable = [
        'user_id',
        'contact_id',
        'relationship_type',
    ];

    protected $casts = [
        'relationship_type' => RelationshipType::class, // تحويل RelationshipType إلى Enum
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contact()
    {
        return $this->belongsTo(User::class, 'contact_id');
    }

    public $timestamps = true;
}
