<?php
// database/seeders/MejaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    public function run(): void
    {
        // Meja untuk 2 orang (6 meja)
        $mejaDua = [
            ['nomor_meja' => 'A1', 'kapasitas' => 2, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A2', 'kapasitas' => 2, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A3', 'kapasitas' => 2, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'B1', 'kapasitas' => 2, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'B2', 'kapasitas' => 2, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'V1', 'kapasitas' => 2, 'status' => 'tersedia', 'lokasi' => 'VIP'],
        ];

        // Meja untuk 4 orang (8 meja)
        $mejaEmpat = [
            ['nomor_meja' => 'A4', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A5', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A6', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A7', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'B3', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'B4', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'B5', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'V2', 'kapasitas' => 4, 'status' => 'tersedia', 'lokasi' => 'VIP'],
        ];

        // Meja untuk 6-8 orang (6 meja)
        $mejaDelapan = [
            ['nomor_meja' => 'A8', 'kapasitas' => 6, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A9', 'kapasitas' => 6, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'A10', 'kapasitas' => 6, 'status' => 'tersedia', 'lokasi' => 'Indoor'],
            ['nomor_meja' => 'B6', 'kapasitas' => 6, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'B7', 'kapasitas' => 6, 'status' => 'tersedia', 'lokasi' => 'Outdoor'],
            ['nomor_meja' => 'V3', 'kapasitas' => 6, 'status' => 'tersedia', 'lokasi' => 'VIP'],
        ];

        // Gabungkan semua data dan insert
        $allMeja = array_merge($mejaDua, $mejaEmpat, $mejaDelapan);
        
        foreach ($allMeja as $meja) {
            Meja::create($meja);
        }
    }
}