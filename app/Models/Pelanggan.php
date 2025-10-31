<?php
// app/Models/Pelanggan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'idpelanggan';

    protected $fillable = [
        'namapelanggan',
        'alamat',
        'nomortelepon',
    ];

    // Relationship dengan Pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idpelanggan', 'idpelanggan');
    }

    // Relationship dengan Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'idpelanggan', 'idpelanggan');
    }

    // Method untuk mendapatkan info lengkap pelanggan
    public function getInfoLengkapAttribute(): string
    {
        return $this->namapelanggan . ' - ' . $this->nomortelepon;
    }
}