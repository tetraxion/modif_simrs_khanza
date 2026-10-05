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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->string('nama_kamar');
            $table->enum('kelas', ['VIP', 'Kelas 1', 'Kelas 2', 'Kelas 3', 'ICU', 'NICU', 'PICU'])->default('Kelas 3');
            $table->string('gedung')->nullable();
            $table->string('lantai')->nullable();
            $table->integer('kapasitas_bed')->default(1);
            $table->decimal('tarif_per_hari', 12, 2)->default(0);
            $table->text('fasilitas')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
