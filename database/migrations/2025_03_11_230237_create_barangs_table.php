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
        Schema::create('barang', function (Blueprint $table) {
            $table->uuid('kode_barang')->primary();
            $table->string('nama_barang');
            $table->integer('stok');
            $table->integer('harga');
            $table->string('gambar')->default('default-produk.png');
            $table->integer('diskon')->default(0);
            $table->integer('hasil_diskon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
