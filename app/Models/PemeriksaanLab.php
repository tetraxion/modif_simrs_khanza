<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemeriksaanLab extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_lab',
        'rawat_jalan_id',
        'rawat_inap_id',
        'pasien_id',
        'dokter_id',
        'tanggal_permintaan',
        'tanggal_pengambilan_sampel',
        'tanggal_hasil',
        'jenis_pemeriksaan',
        'hasil',
        'catatan_dokter',
        'catatan_lab',
        'tarif',
        'status',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'tanggal_pengambilan_sampel' => 'date',
        'tanggal_hasil' => 'date',
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
