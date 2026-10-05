<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemeriksaanRadiologi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_radiologi',
        'rawat_jalan_id',
        'rawat_inap_id',
        'pasien_id',
        'dokter_id',
        'tanggal_permintaan',
        'tanggal_pemeriksaan',
        'jenis_pemeriksaan',
        'hasil',
        'catatan_dokter',
        'catatan_radiologi',
        'file_gambar',
        'tarif',
        'status',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'tanggal_pemeriksaan' => 'date',
        'tarif' => 'decimal:2',
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
}
