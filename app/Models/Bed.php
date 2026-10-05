<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'kamar_id',
        'nomor_bed',
        'status',
    ];

    // Relasi dengan Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    // Relasi dengan Rawat Inap
    public function rawatInaps()
    {
        return $this->hasMany(RawatInap::class);
    }
}
