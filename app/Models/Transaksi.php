<?php
// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'idtransaksi';

    protected $fillable = [
        'idpelanggan',
        'tglTransaksi',
        'totalHarga',
        'bayar',
    ];

    protected $casts = [
        'tglTransaksi' => 'datetime',
    ];

    // Relationship dengan Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }

    // Relationship dengan Pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idtransaksi', 'idtransaksi');
    }

    // Method untuk menghitung kembalian
    public function getKembalianAttribute(): int
    {
        return $this->bayar - $this->totalHarga;
    }

    // Method untuk format total harga
    public function getFormattedTotalHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->totalHarga, 0, ',', '.');
    }

    // Method untuk format bayar
    public function getFormattedBayarAttribute(): string
    {
        return 'Rp ' . number_format($this->bayar, 0, ',', '.');
    }

    // Method untuk format kembalian
    public function getFormattedKembalianAttribute(): string
    {
        return 'Rp ' . number_format($this->kembalian, 0, ',', '.');
    }
}