<?php
// database/seeders/MenuSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['namamenu' => 'Nasi Goreng', 'harga' => 15000],
            ['namamenu' => 'Mie Goreng', 'harga' => 12000],
            ['namamenu' => 'Ayam Goreng', 'harga' => 18000],
            ['namamenu' => 'Ayam Bakar', 'harga' => 20000],
            ['namamenu' => 'Sate Ayam', 'harga' => 25000],
            ['namamenu' => 'Soto Ayam', 'harga' => 13000],
            ['namamenu' => 'Gado-Gado', 'harga' => 10000],
            ['namamenu' => 'Rendang', 'harga' => 22000],
            ['namamenu' => 'Es Teh Manis', 'harga' => 3000],
            ['namamenu' => 'Es Jeruk', 'harga' => 5000],
            ['namamenu' => 'Jus Alpukat', 'harga' => 8000],
            ['namamenu' => 'Kopi Hitam', 'harga' => 5000],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}