<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_produk',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(produk::class, 'id_produk', 'id');
    }
}
