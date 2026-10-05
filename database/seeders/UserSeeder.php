<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Perawat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Dokter
        $userDokter1 = User::create([
            'name' => 'Dr. Ahmad Hidayat, Sp.PD',
            'email' => 'dr.ahmad@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'is_active' => true,
        ]);

        Dokter::create([
            'user_id' => $userDokter1->id,
            'poliklinik_id' => 1, // Poli Umum
            'nip' => 'DKT001',
            'nama_lengkap' => 'Dr. Ahmad Hidayat, Sp.PD',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1980-05-15',
            'alamat' => 'Jl. Dokter No. 1',
            'no_telepon' => '081234567890',
            'spesialisasi' => 'Penyakit Dalam',
            'no_str' => 'STR001',
            'no_sip' => 'SIP001',
            'is_active' => true,
        ]);

        $userDokter2 = User::create([
            'name' => 'Dr. Siti Nurhaliza, Sp.A',
            'email' => 'dr.siti@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'is_active' => true,
        ]);

        Dokter::create([
            'user_id' => $userDokter2->id,
            'poliklinik_id' => 2, // Poli Anak
            'nip' => 'DKT002',
            'nama_lengkap' => 'Dr. Siti Nurhaliza, Sp.A',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1985-08-20',
            'alamat' => 'Jl. Dokter No. 2',
            'no_telepon' => '081234567891',
            'spesialisasi' => 'Anak',
            'no_str' => 'STR002',
            'no_sip' => 'SIP002',
            'is_active' => true,
        ]);

        // Perawat
        $userPerawat = User::create([
            'name' => 'Ns. Budi Santoso, S.Kep',
            'email' => 'perawat.budi@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'perawat',
            'is_active' => true,
        ]);

        Perawat::create([
            'user_id' => $userPerawat->id,
            'nip' => 'PWT001',
            'nama_lengkap' => 'Ns. Budi Santoso, S.Kep',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-03-10',
            'alamat' => 'Jl. Perawat No. 1',
            'no_telepon' => '081234567892',
            'no_str' => 'STR-PWT001',
            'is_active' => true,
        ]);

        // Kasir
        User::create([
            'name' => 'Ani Kasir',
            'email' => 'kasir@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'is_active' => true,
        ]);

        // Farmasi
        User::create([
            'name' => 'Apt. Dina Apoteker',
            'email' => 'farmasi@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'farmasi',
            'is_active' => true,
        ]);

        // Laboratorium
        User::create([
            'name' => 'Eko Lab',
            'email' => 'lab@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'laboratorium',
            'is_active' => true,
        ]);

        // Radiologi
        User::create([
            'name' => 'Fani Radiologi',
            'email' => 'radiologi@simrs.com',
            'password' => Hash::make('password'),
            'role' => 'radiologi',
            'is_active' => true,
        ]);
    }
}
