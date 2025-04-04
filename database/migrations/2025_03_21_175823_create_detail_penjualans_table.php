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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_penjualan');
            $table->uuid('kode_barang');
            $table->integer('jumlah');
            $table->decimal('total', 10, 2);
            $table->timestamps();
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
