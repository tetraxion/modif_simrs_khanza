<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resep extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_resep',
        'rawat_jalan_id',
        'rawat_inap_id',
        'pasien_id',
        'dokter_id',
        'tanggal_resep',
        'total_harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_resep' => 'date',
        'total_harga' => 'decimal:2',
    ];

    // Relasi dengan Rawat Jalan
    public function rawatJalan()
    {
        return $this->belongsTo(RawatJalan::class);
    }

    // Relasi dengan Rawat Inap
    public function rawatInap()
    {
        return $this->belongsTo(RawatInap::class);
    }

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

    // Relasi dengan Resep Detail
    public function resepDetails()
    {
        return $this->hasMany(ResepDetail::class);
    }
}
