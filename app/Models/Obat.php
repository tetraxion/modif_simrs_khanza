<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'nama_generik',
        'jenis',
        'satuan',
        'stok',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
        'tanggal_kadaluarsa',
        'pabrik',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi dengan Resep Detail
    public function resepDetails()
    {
        return $this->hasMany(ResepDetail::class);
    }

    // Helper method untuk cek stok hampir habis
    public function isStokRendah()
    {
        return $this->stok <= $this->stok_minimum;
    }

    // Helper method untuk cek obat kadaluarsa
    public function isKadaluarsa()
    {
        return $this->tanggal_kadaluarsa && $this->tanggal_kadaluarsa->isPast();
    }
}
