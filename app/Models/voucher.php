<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jumlah_diskon',
        'syarat',
        'limit',
        'expire',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_voucher', 'id');
    }
}
