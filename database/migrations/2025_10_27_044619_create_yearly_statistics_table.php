<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yearly_statistics', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('produk_terlaris');
            $table->integer('jumlah_transaksi');
            $table->bigInteger('total_pendapatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yearly_statistics');
    }
};
