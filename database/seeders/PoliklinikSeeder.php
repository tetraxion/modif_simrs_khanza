<?php

namespace Database\Seeders;

use App\Models\Poliklinik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliklinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polikliniks = [
            [
                'kode_poli' => 'POLI-001',
                'nama_poli' => 'Poli Umum',
                'deskripsi' => 'Poliklinik untuk pemeriksaan kesehatan umum',
                'lokasi' => 'Lantai 1, Gedung A',
                'jam_buka' => '08:00',
                'jam_tutup' => '16:00',
                'is_active' => true,
            ],
            [
                'kode_poli' => 'POLI-002',
                'nama_poli' => 'Poli Anak',
                'deskripsi' => 'Poliklinik khusus untuk pemeriksaan anak',
                'lokasi' => 'Lantai 1, Gedung A',
                'jam_buka' => '08:00',
                'jam_tutup' => '16:00',
                'is_active' => true,
            ],
            [
                'kode_poli' => 'POLI-003',
                'nama_poli' => 'Poli Gigi',
                'deskripsi' => 'Poliklinik untuk pemeriksaan dan perawatan gigi',
                'lokasi' => 'Lantai 2, Gedung A',
                'jam_buka' => '08:00',
                'jam_tutup' => '15:00',
                'is_active' => true,
            ],
            [
                'kode_poli' => 'POLI-004',
                'nama_poli' => 'Poli Mata',
                'deskripsi' => 'Poliklinik untuk pemeriksaan mata',
                'lokasi' => 'Lantai 2, Gedung A',
                'jam_buka' => '09:00',
                'jam_tutup' => '15:00',
                'is_active' => true,
            ],
            [
                'kode_poli' => 'POLI-005',
                'nama_poli' => 'Poli Kandungan',
                'deskripsi' => 'Poliklinik untuk kesehatan ibu dan kandungan',
                'lokasi' => 'Lantai 3, Gedung B',
                'jam_buka' => '08:00',
                'jam_tutup' => '16:00',
                'is_active' => true,
            ],
            [
                'kode_poli' => 'POLI-006',
                'nama_poli' => 'Poli Jantung',
                'deskripsi' => 'Poliklinik spesialis jantung',
                'lokasi' => 'Lantai 3, Gedung B',
                'jam_buka' => '08:00',
                'jam_tutup' => '14:00',
                'is_active' => true,
            ],
        ];

        foreach ($polikliniks as $poli) {
            Poliklinik::create($poli);
        }
    }
}
