<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('ktp')->nullable(); // untuk upload KTP
            $table->string('nama_produk');
            $table->string('lama_sewa');
            $table->integer('biaya_pengiriman')->default(0);
            $table->integer('subtotal')->default(0);
            $table->integer('total')->default(0);
            $table->string('status')->default('Konfirmasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
