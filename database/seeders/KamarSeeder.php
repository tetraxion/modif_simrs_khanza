<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kamars = [
            // VIP
            [
                'nomor_kamar' => '101',
                'nama_kamar' => 'VIP Suite 101',
                'kelas' => 'VIP',
                'gedung' => 'Gedung C',
                'lantai' => '1',
                'kapasitas_bed' => 1,
                'tarif_per_hari' => 500000,
                'fasilitas' => 'AC, TV, Sofa, Kamar Mandi Dalam',
                'is_active' => true,
            ],
            [
                'nomor_kamar' => '102',
                'nama_kamar' => 'VIP Suite 102',
                'kelas' => 'VIP',
                'gedung' => 'Gedung C',
                'lantai' => '1',
                'kapasitas_bed' => 1,
                'tarif_per_hari' => 500000,
                'fasilitas' => 'AC, TV, Sofa, Kamar Mandi Dalam',
                'is_active' => true,
            ],
            // Kelas 1
            [
                'nomor_kamar' => '201',
                'nama_kamar' => 'Kelas 1 - 201',
                'kelas' => 'Kelas 1',
                'gedung' => 'Gedung C',
                'lantai' => '2',
                'kapasitas_bed' => 2,
                'tarif_per_hari' => 300000,
                'fasilitas' => 'AC, TV, Kamar Mandi Dalam',
                'is_active' => true,
            ],
            [
                'nomor_kamar' => '202',
                'nama_kamar' => 'Kelas 1 - 202',
                'kelas' => 'Kelas 1',
                'gedung' => 'Gedung C',
                'lantai' => '2',
                'kapasitas_bed' => 2,
                'tarif_per_hari' => 300000,
                'fasilitas' => 'AC, TV, Kamar Mandi Dalam',
                'is_active' => true,
            ],
            // Kelas 2
            [
                'nomor_kamar' => '301',
                'nama_kamar' => 'Kelas 2 - 301',
                'kelas' => 'Kelas 2',
                'gedung' => 'Gedung C',
                'lantai' => '3',
                'kapasitas_bed' => 3,
                'tarif_per_hari' => 200000,
                'fasilitas' => 'AC, Kipas Angin',
                'is_active' => true,
            ],
            [
                'nomor_kamar' => '302',
                'nama_kamar' => 'Kelas 2 - 302',
                'kelas' => 'Kelas 2',
                'gedung' => 'Gedung C',
                'lantai' => '3',
                'kapasitas_bed' => 3,
                'tarif_per_hari' => 200000,
                'fasilitas' => 'AC, Kipas Angin',
                'is_active' => true,
            ],
            // Kelas 3
            [
                'nomor_kamar' => '401',
                'nama_kamar' => 'Kelas 3 - 401',
                'kelas' => 'Kelas 3',
                'gedung' => 'Gedung C',
                'lantai' => '4',
                'kapasitas_bed' => 4,
                'tarif_per_hari' => 100000,
                'fasilitas' => 'Kipas Angin',
                'is_active' => true,
            ],
            [
                'nomor_kamar' => '402',
                'nama_kamar' => 'Kelas 3 - 402',
                'kelas' => 'Kelas 3',
                'gedung' => 'Gedung C',
                'lantai' => '4',
                'kapasitas_bed' => 4,
                'tarif_per_hari' => 100000,
                'fasilitas' => 'Kipas Angin',
                'is_active' => true,
            ],
            // ICU
            [
                'nomor_kamar' => 'ICU-01',
                'nama_kamar' => 'ICU Room 1',
                'kelas' => 'ICU',
                'gedung' => 'Gedung B',
                'lantai' => '2',
                'kapasitas_bed' => 1,
                'tarif_per_hari' => 1000000,
                'fasilitas' => 'Ventilator, Monitor Vital Sign, AC',
                'is_active' => true,
            ],
            [
                'nomor_kamar' => 'ICU-02',
                'nama_kamar' => 'ICU Room 2',
                'kelas' => 'ICU',
                'gedung' => 'Gedung B',
                'lantai' => '2',
                'kapasitas_bed' => 1,
                'tarif_per_hari' => 1000000,
                'fasilitas' => 'Ventilator, Monitor Vital Sign, AC',
                'is_active' => true,
            ],
        ];

        foreach ($kamars as $kamar) {
            Kamar::create($kamar);
        }
    }
}
