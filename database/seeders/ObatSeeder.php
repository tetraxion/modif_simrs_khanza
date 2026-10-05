<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'kode_obat' => 'OBT-001',
                'nama_obat' => 'Paracetamol 500mg',
                'nama_generik' => 'Paracetamol',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'stok' => 100,
                'stok_minimum' => 20,
                'harga_beli' => 3000,
                'harga_jual' => 5000,
                'tanggal_kadaluarsa' => '2027-12-31',
                'pabrik' => 'Kimia Farma',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-002',
                'nama_obat' => 'Amoxicillin 500mg',
                'nama_generik' => 'Amoxicillin',
                'jenis' => 'Kapsul',
                'satuan' => 'Strip',
                'stok' => 80,
                'stok_minimum' => 15,
                'harga_beli' => 8000,
                'harga_jual' => 12000,
                'tanggal_kadaluarsa' => '2027-06-30',
                'pabrik' => 'Indofarma',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-003',
                'nama_obat' => 'OBH Sirup',
                'nama_generik' => 'Obat Batuk Hitam',
                'jenis' => 'Sirup',
                'satuan' => 'Botol',
                'stok' => 50,
                'stok_minimum' => 10,
                'harga_beli' => 15000,
                'harga_jual' => 20000,
                'tanggal_kadaluarsa' => '2026-12-31',
                'pabrik' => 'Kalbe Farma',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-004',
                'nama_obat' => 'Antasida DOEN',
                'nama_generik' => 'Antasida',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'stok' => 60,
                'stok_minimum' => 15,
                'harga_beli' => 2500,
                'harga_jual' => 4000,
                'tanggal_kadaluarsa' => '2027-03-31',
                'pabrik' => 'Sanbe',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-005',
                'nama_obat' => 'Vitamin C 500mg',
                'nama_generik' => 'Ascorbic Acid',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'stok' => 120,
                'stok_minimum' => 25,
                'harga_beli' => 5000,
                'harga_jual' => 8000,
                'tanggal_kadaluarsa' => '2028-01-31',
                'pabrik' => 'Kalbe Farma',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-006',
                'nama_obat' => 'Ibuprofen 400mg',
                'nama_generik' => 'Ibuprofen',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'stok' => 90,
                'stok_minimum' => 20,
                'harga_beli' => 6000,
                'harga_jual' => 9000,
                'tanggal_kadaluarsa' => '2027-08-31',
                'pabrik' => 'Dexa Medica',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-007',
                'nama_obat' => 'Cetirizine 10mg',
                'nama_generik' => 'Cetirizine',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'stok' => 70,
                'stok_minimum' => 15,
                'harga_beli' => 4000,
                'harga_jual' => 7000,
                'tanggal_kadaluarsa' => '2027-10-31',
                'pabrik' => 'Kalbe Farma',
                'is_active' => true,
            ],
            [
                'kode_obat' => 'OBT-008',
                'nama_obat' => 'Salep Bioplacenton',
                'nama_generik' => 'Bioplacenton',
                'jenis' => 'Salep',
                'satuan' => 'Tube',
                'stok' => 40,
                'stok_minimum' => 10,
                'harga_beli' => 12000,
                'harga_jual' => 18000,
                'tanggal_kadaluarsa' => '2026-09-30',
                'pabrik' => 'Bintang Toedjoe',
                'is_active' => true,
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
