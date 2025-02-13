<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class produk extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'tanggal_masuk',
        'expire',
        'gambar',
    ];


    public function keranjang()
    {
        return $this->hasMany(keranjang ::class, 'id_produk', 'id');
    }

    public function orderDetail()
    {
        return $this->hasMany(orderDetail::class, 'id_produk', 'id');
    }
}