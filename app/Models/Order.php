<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'email',
        'no_hp',
        'alamat',
        'kota_tujuan',
        'latitude',
        'longitude',
        'ktp',
        'nama_produk',
        'start_date',
        'end_date',
        'lama_sewa',
        'biaya_pengiriman',
        'subtotal',
        'total',
        'status',
    ];
}