<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'nama_kamar',
        'kelas',
        'gedung',
        'lantai',
        'kapasitas_bed',
        'tarif_per_hari',
        'fasilitas',
        'is_active',
    ];

    protected $casts = [
        'tarif_per_hari' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relasi dengan Bed
    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    // Relasi dengan Rawat Inap
    public function rawatInaps()
    {
        return $this->hasMany(RawatInap::class);
    }

    // Helper method untuk cek ketersediaan bed
    public function bedTersedia()
    {
        return $this->beds()->where('status', 'Tersedia')->count();
    }
}
