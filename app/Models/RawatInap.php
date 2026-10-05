<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawatInap extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_registrasi',
        'pasien_id',
        'dokter_id',
        'kamar_id',
        'bed_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'diagnosis_awal',
        'diagnosis_akhir',
        'catatan_masuk',
        'catatan_keluar',
        'kondisi_keluar',
        'status',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
    ];

    // Relasi dengan Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi dengan Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    // Relasi dengan Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    // Relasi dengan Bed
    public function bed()
    {
        return $this->belongsTo(Bed::class);
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

    // Helper method untuk menghitung lama rawat
    public function getLamaRawatAttribute()
    {
        if ($this->tanggal_keluar) {
            return $this->tanggal_masuk->diffInDays($this->tanggal_keluar);
        }
        return $this->tanggal_masuk->diffInDays(now());
    }
}
