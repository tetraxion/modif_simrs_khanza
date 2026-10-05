<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rawat_jalans', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('poliklinik_id')->constrained('polikliniks')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->enum('jenis_kunjungan', ['Baru', 'Lama'])->default('Baru');
            $table->enum('jenis_penjamin', ['Umum', 'BPJS', 'Asuransi'])->default('Umum');
            $table->string('no_antrian')->nullable();
            $table->text('keluhan')->nullable();
            $table->text('anamnesis')->nullable();
            $table->string('tekanan_darah')->nullable(); // e.g., "120/80"
            $table->decimal('suhu_tubuh', 4, 1)->nullable(); // Celcius
            $table->integer('nadi')->nullable(); // per menit
            $table->integer('pernapasan')->nullable(); // per menit
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->decimal('berat_badan', 5, 2)->nullable(); // kg
            $table->text('pemeriksaan_fisik')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('terapi')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['Menunggu', 'Diperiksa', 'Selesai', 'Batal'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_jalans');
    }
};
