<?php
// app/Models/Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'idmenu';

    protected $fillable = [
        'namamenu',
        'harga',
    ];

    // Relationship dengan Pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idmenu', 'idmenu');
    }

    // Method untuk format harga
    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}