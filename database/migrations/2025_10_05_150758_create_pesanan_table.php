<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('idpesanan');
            $table->unsignedBigInteger('idpelanggan');
            $table->unsignedBigInteger('idmenu');
            $table->integer('jumlah');
            $table->integer('totalharga');
            $table->unsignedBigInteger('idtransaksi')->nullable();
            $table->timestamps();
            $table->foreign('idpelanggan')->references('idpelanggan')->on('pelanggan')->onDelete('cascade');  
            $table->foreign('idmenu')->references('idmenu')->on('menu')->onDelete('cascade');      
            $table->foreign('idtransaksi')->references('idtransaksi')->on('transaksi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};