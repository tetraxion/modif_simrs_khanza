<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResepDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'resep_id',
        'obat_id',
        'jumlah',
        'aturan_pakai',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi dengan Resep
    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }

    // Relasi dengan Obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
