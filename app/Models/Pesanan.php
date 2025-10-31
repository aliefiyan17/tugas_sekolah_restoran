<?php
// app/Models/Pesanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'idpesanan';

    protected $fillable = [
        'idpelanggan',
        'idmenu',
        'idmeja',
        'jumlah',
        'totalharga',
        'idtransaksi',
    ];

    // Relationship dengan Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }

    // Relationship dengan Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu', 'idmenu');
    }

    // Relationship dengan Meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'idmeja', 'idmeja');
    }

    // Relationship dengan Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'idtransaksi', 'idtransaksi');
    }

    // Method untuk menghitung total harga otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($pesanan) {
            $menu = Menu::find($pesanan->idmenu);
            if ($menu) {
                $pesanan->totalharga = $menu->harga * $pesanan->jumlah;
            }
        });

        static::updating(function ($pesanan) {
            $menu = Menu::find($pesanan->idmenu);
            if ($menu) {
                $pesanan->totalharga = $menu->harga * $pesanan->jumlah;
            }
        });
    }

    // Method untuk format total harga
    public function getFormattedTotalHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->totalharga, 0, ',', '.');
    }
}