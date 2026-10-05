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
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('rawat_jalan_id')->nullable()->constrained('rawat_jalans')->onDelete('set null');
            $table->foreignId('rawat_inap_id')->nullable()->constrained('rawat_inaps')->onDelete('set null');
            $table->date('tanggal_invoice');
            $table->decimal('biaya_konsultasi', 12, 2)->default(0);
            $table->decimal('biaya_tindakan', 12, 2)->default(0);
            $table->decimal('biaya_obat', 12, 2)->default(0);
            $table->decimal('biaya_lab', 12, 2)->default(0);
            $table->decimal('biaya_radiologi', 12, 2)->default(0);
            $table->decimal('biaya_kamar', 12, 2)->default(0);
            $table->decimal('biaya_lainnya', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('dibayar', 12, 2)->default(0);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('metode_pembayaran', ['Tunai', 'Transfer', 'Kartu Debit', 'Kartu Kredit', 'BPJS', 'Asuransi'])->nullable();
            $table->enum('status', ['Belum Dibayar', 'Dibayar Sebagian', 'Lunas'])->default('Belum Dibayar');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing');
    }
};
