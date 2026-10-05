<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poliklinik extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_poli',
        'nama_poli',
        'deskripsi',
        'lokasi',
        'jam_buka',
        'jam_tutup',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi dengan Dokter
    public function dokters()
    {
        return $this->hasMany(Dokter::class);
    }

    // Relasi dengan Rawat Jalan
    public function rawatJalans()
    {
        return $this->hasMany(RawatJalan::class);
    }
}
