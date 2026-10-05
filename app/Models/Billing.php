<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'pasien_id',
        'rawat_jalan_id',
        'rawat_inap_id',
        'tanggal_invoice',
        'biaya_konsultasi',
        'biaya_tindakan',
        'biaya_obat',
        'biaya_lab',
        'biaya_radiologi',
        'biaya_kamar',
        'biaya_lainnya',
        'subtotal',
        'diskon',
        'total',
        'dibayar',
        'kembalian',
        'metode_pembayaran',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date',
        'biaya_konsultasi' => 'decimal:2',
        'biaya_tindakan' => 'decimal:2',
        'biaya_obat' => 'decimal:2',
        'biaya_lab' => 'decimal:2',
        'biaya_radiologi' => 'decimal:2',
        'biaya_kamar' => 'decimal:2',
        'biaya_lainnya' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
        'dibayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    // Relasi dengan Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

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

    // Helper method untuk menghitung sisa pembayaran
    public function getSisaPembayaranAttribute()
    {
        return $this->total - $this->dibayar;
    }
}
