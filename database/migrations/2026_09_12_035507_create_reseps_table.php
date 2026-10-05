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
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->string('no_resep')->unique();
            $table->foreignId('rawat_jalan_id')->nullable()->constrained('rawat_jalans')->onDelete('cascade');
            $table->foreignId('rawat_inap_id')->nullable()->constrained('rawat_inaps')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->date('tanggal_resep');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->enum('status', ['Pending', 'Diproses', 'Selesai', 'Batal'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
