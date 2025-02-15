<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';  // Explicitly define table name if not pluralized

    protected $fillable = [
        'id_user',
        'nik',
        'npwp',
        'gender',
        'tanggal_lahir',
        'foto'
    ];

    /**
     * Relationship with the User model (One-to-One).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
