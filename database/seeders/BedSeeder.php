<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kamars = Kamar::all();

        foreach ($kamars as $kamar) {
            for ($i = 1; $i <= $kamar->kapasitas_bed; $i++) {
                Bed::create([
                    'kamar_id' => $kamar->id,
                    'nomor_bed' => 'BED-' . $i,
                    'status' => 'Tersedia',
                ]);
            }
        }
    }
}
