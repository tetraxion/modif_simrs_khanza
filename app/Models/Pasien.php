<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rm',
        'nik',
        'no_bpjs',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'no_telepon',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'pendidikan',
        'nama_keluarga',
        'hubungan_keluarga',
        'no_telepon_keluarga',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi dengan Rawat Jalan
    public function rawatJalans()
    {
        return $this->hasMany(RawatJalan::class);
    }

    // Relasi dengan Rawat Inap
    public function rawatInaps()
    {
        return $this->hasMany(RawatInap::class);
    }

    // Relasi dengan Resep
    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }

    // Relasi dengan Pemeriksaan Lab
    public function pemeriksaanLabs()
    {
        return $this->hasMany(PemeriksaanLab::class);
    }

    // Relasi dengan Pemeriksaan Radiologi
    public function pemeriksaanRadiologis()
    {
        return $this->hasMany(PemeriksaanRadiologi::class);
    }

    // Relasi dengan Billing
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    // Helper method untuk mendapatkan umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }
}
