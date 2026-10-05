<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawatJalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_registrasi',
        'pasien_id',
        'poliklinik_id',
        'dokter_id',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'jenis_kunjungan',
        'jenis_penjamin',
        'no_antrian',
        'keluhan',
        'anamnesis',
        'tekanan_darah',
        'suhu_tubuh',
        'nadi',
        'pernapasan',
        'tinggi_badan',
        'berat_badan',
        'pemeriksaan_fisik',
        'diagnosis',
        'terapi',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'suhu_tubuh' => 'decimal:1',
        'tinggi_badan' => 'decimal:2',
        'berat_badan' => 'decimal:2',
    ];

    // Relasi dengan Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi dengan Poliklinik
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class);
    }

    // Relasi dengan Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
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
    public function billing()
    {
        return $this->hasOne(Billing::class);
    }
}
