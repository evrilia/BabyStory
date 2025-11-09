<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'produk_terlaris',
        'jumlah_transaksi',
        'total_pendapatan',
    ];
}
