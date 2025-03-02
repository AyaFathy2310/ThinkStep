<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactList extends Model
{
    use HasFactory;

    protected $fillable = ['contact_info', 'contact_type'];

    /**
     * العلاقة مع المستخدمين (Many-to-Many عبر user_contacts)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_contacts')
                    ->withTimestamps();
    }
}
