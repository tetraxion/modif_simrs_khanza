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
        Schema::create('rawat_inaps', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table->foreignId('bed_id')->constrained('beds')->onDelete('cascade');
            $table->dateTime('tanggal_masuk');
            $table->dateTime('tanggal_keluar')->nullable();
            $table->text('diagnosis_awal')->nullable();
            $table->text('diagnosis_akhir')->nullable();
            $table->text('catatan_masuk')->nullable();
            $table->text('catatan_keluar')->nullable();
            $table->enum('kondisi_keluar', ['Sembuh', 'Membaik', 'Belum Sembuh', 'Meninggal', 'Pulang Paksa'])->nullable();
            $table->enum('status', ['Aktif', 'Selesai', 'Pindah Kamar'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_inaps');
    }
};
