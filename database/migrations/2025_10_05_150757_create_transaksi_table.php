<?php
// database/migrations/xxxx_xx_xx_create_transaksi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idtransaksi');
            $table->unsignedBigInteger('idpelanggan');
            $table->dateTime('tglTransaksi');
            $table->integer('totalHarga');
            $table->integer('bayar');
            $table->timestamps();
            
            $table->foreign('idpelanggan')
                  ->references('idpelanggan')
                  ->on('pelanggan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};