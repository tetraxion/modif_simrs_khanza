<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'poliklinik_id',
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'spesialisasi',
        'no_str',
        'no_sip',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Poliklinik
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class);
    }

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
}
