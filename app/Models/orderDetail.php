<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_order',
        'id_produk',
        'quantity',
        'harga',
        'subtotal',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(order::class, 'id_order', 'id');
    }
}
