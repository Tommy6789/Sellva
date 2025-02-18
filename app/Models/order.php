<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', //fill by auth
        'total', //fill by keranjang checkout
        'metode_pembayaran', //fill when pembayaran
        'nominal_pembayaran', //fill when pembayaran
        'kembalian', //fill when pembayaran
        'waktu_order', //fill by keranjang checkout
        'waktu_pembayaran', //fill when pembayaran
        'status', //enum status and selesai  //fill by keranjang checkout, default proses
    ];

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id');
    }
}