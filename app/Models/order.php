<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'total',
        'metode_pembayaran',
        'nominal_pembayaran',
        'kembalian',
        'waktu_order',
        'waktu_pembayaran',
        'status',
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