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
         Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('stok')->default(0);
            $table->string('brand')->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
        $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
        });
    }
    /**
     * Reverse the migrations.
     */
   
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::dropIfExists('categories');
    }   
};
