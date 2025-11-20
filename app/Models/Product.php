<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'category_id',
        'kategori',
        'harga',
        'stok',
        'brand',
        'deskripsi',
        'gambar',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}