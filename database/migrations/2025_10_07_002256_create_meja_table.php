<?php
// database/migrations/xxxx_xx_xx_create_meja_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->id('idmeja');
            $table->string('nomor_meja')->unique();
            $table->integer('kapasitas');
            $table->enum('status', ['tersedia', 'terisi', 'reserved'])->default('tersedia');
            $table->string('lokasi')->nullable(); // Area: Indoor, Outdoor, VIP
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tambah kolom idmeja ke tabel pesanan
        Schema::table('pesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('idmeja')->nullable()->after('idpelanggan');
            $table->foreign('idmeja')
                  ->references('idmeja')
                  ->on('meja')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['idmeja']);
            $table->dropColumn('idmeja');
        });
        
        Schema::dropIfExists('meja');
    }
};