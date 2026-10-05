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
        Schema::create('pemeriksaan_radiologis', function (Blueprint $table) {
            $table->id();
            $table->string('no_radiologi')->unique();
            $table->foreignId('rawat_jalan_id')->nullable()->constrained('rawat_jalans')->onDelete('cascade');
            $table->foreignId('rawat_inap_id')->nullable()->constrained('rawat_inaps')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_pemeriksaan')->nullable();
            $table->string('jenis_pemeriksaan'); // Rontgen, CT Scan, MRI, USG, dll
            $table->text('hasil')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->text('catatan_radiologi')->nullable();
            $table->string('file_gambar')->nullable();
            $table->decimal('tarif', 12, 2)->default(0);
            $table->enum('status', ['Permintaan', 'Dijadwalkan', 'Selesai', 'Batal'])->default('Permintaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_radiologis');
    }
};
