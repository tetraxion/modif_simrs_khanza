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
        // Extend rawat_jalans table with SOAP fields and indices
        Schema::table('rawat_jalans', function (Blueprint $table) {
            if (!Schema::hasColumn('rawat_jalans', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('rawat_jalans', 'soap_subjective')) {
                $table->text('soap_subjective')->nullable()->after('keluhan');
                $table->text('soap_objective')->nullable()->after('soap_subjective');
                $table->text('soap_assessment')->nullable()->after('soap_objective');
                $table->text('soap_plan')->nullable()->after('soap_assessment');
            }
        });
        
        // Add indices separately to handle existing indices gracefully
        try {
            Schema::table('rawat_jalans', function (Blueprint $table) {
                $table->index('tanggal_kunjungan', 'idx_tanggal_kunjungan');
                $table->index('status', 'idx_status');
                $table->index(['pasien_id', 'tanggal_kunjungan'], 'idx_pasien_tanggal');
                $table->index(['dokter_id', 'tanggal_kunjungan'], 'idx_dokter_tanggal');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }

        // Extend beds table with bed_type and equipment_available fields
        Schema::table('beds', function (Blueprint $table) {
            if (!Schema::hasColumn('beds', 'bed_type')) {
                $table->enum('bed_type', ['regular', 'icu', 'nicu', 'isolation'])
                    ->default('regular')
                    ->after('nomor_bed');
                $table->json('equipment_available')->nullable()->after('bed_type');
            }
        });
        
        try {
            Schema::table('beds', function (Blueprint $table) {
                $table->index('bed_type', 'idx_bed_type');
                $table->index(['kamar_id', 'status'], 'idx_kamar_status');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }

        // Extend obats table with BPJS formulary flags
        Schema::table('obats', function (Blueprint $table) {
            if (!Schema::hasColumn('obats', 'is_bpjs_formulary')) {
                $table->boolean('is_bpjs_formulary')->default(false)->after('is_active');
                $table->boolean('is_high_alert')->default(false)->after('is_bpjs_formulary');
                $table->string('therapeutic_class')->nullable()->after('is_high_alert');
                $table->boolean('requires_approval')->default(false)->after('therapeutic_class');
            }
        });
        
        try {
            Schema::table('obats', function (Blueprint $table) {
                $table->index('is_bpjs_formulary', 'idx_bpjs_formulary');
                $table->index('is_high_alert', 'idx_high_alert');
                $table->index('therapeutic_class', 'idx_therapeutic_class');
                $table->index(['is_active', 'is_bpjs_formulary'], 'idx_active_bpjs');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }

        // Extend billing table with insurance class and detailed amounts
        Schema::table('billing', function (Blueprint $table) {
            if (!Schema::hasColumn('billing', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
                $table->string('invoice_number')->nullable()->unique()->after('uuid');
                $table->enum('insurance_class', ['Umum', 'BPJS Kelas 1', 'BPJS Kelas 2', 'BPJS Kelas 3', 'Asuransi Swasta'])
                    ->default('Umum')
                    ->after('invoice_number');
                $table->decimal('discount_amount', 12, 2)->default(0)->after('diskon');
                $table->decimal('tax_amount', 12, 2)->default(0)->after('discount_amount');
                $table->decimal('total_amount', 12, 2)->default(0)->after('tax_amount');
                $table->decimal('paid_amount', 12, 2)->default(0)->after('total_amount');
            }
        });
        
        try {
            Schema::table('billing', function (Blueprint $table) {
                $table->index('tanggal_invoice', 'idx_tanggal_invoice');
                $table->index('status', 'idx_billing_status');
                $table->index(['pasien_id', 'tanggal_invoice'], 'idx_pasien_invoice');
                $table->index('insurance_class', 'idx_insurance_class');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }

        // Add UUID columns to pasiens table
        Schema::table('pasiens', function (Blueprint $table) {
            if (!Schema::hasColumn('pasiens', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            }
        });
        
        try {
            Schema::table('pasiens', function (Blueprint $table) {
                $table->index('no_rm', 'idx_no_rm');
                $table->index('nik', 'idx_nik');
                $table->index('no_bpjs', 'idx_no_bpjs');
                $table->index(['nama_lengkap', 'tanggal_lahir'], 'idx_nama_lahir');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }

        // Add UUID columns to rawat_inaps table
        Schema::table('rawat_inaps', function (Blueprint $table) {
            if (!Schema::hasColumn('rawat_inaps', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            }
        });
        
        try {
            Schema::table('rawat_inaps', function (Blueprint $table) {
                $table->index('tanggal_masuk', 'idx_tanggal_masuk');
                $table->index('tanggal_keluar', 'idx_tanggal_keluar');
                $table->index('status', 'idx_rawat_inap_status');
                $table->index(['pasien_id', 'status'], 'idx_pasien_status');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }

        // Add UUID columns to reseps table
        Schema::table('reseps', function (Blueprint $table) {
            if (!Schema::hasColumn('reseps', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            }
        });
        
        try {
            Schema::table('reseps', function (Blueprint $table) {
                $table->index('tanggal_resep', 'idx_tanggal_resep');
                $table->index('status', 'idx_resep_status');
                $table->index(['pasien_id', 'tanggal_resep'], 'idx_pasien_resep');
                $table->index(['dokter_id', 'tanggal_resep'], 'idx_dokter_resep');
            });
        } catch (\Exception $e) {
            // Indices may already exist, continue
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indices and columns from rawat_jalans
        // Note: Some composite indices with foreign keys may not be droppable due to MySQL constraints
        try {
            Schema::table('rawat_jalans', function (Blueprint $table) {
                $table->dropIndex('idx_tanggal_kunjungan');
            });
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }
        
        try {
            Schema::table('rawat_jalans', function (Blueprint $table) {
                $table->dropIndex('idx_status');
            });
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }
        
        try {
            Schema::table('rawat_jalans', function (Blueprint $table) {
                $table->dropIndex('idx_pasien_tanggal');
            });
        } catch (\Exception $e) {
            // Ignore if index is needed for foreign key constraint
        }
        
        try {
            Schema::table('rawat_jalans', function (Blueprint $table) {
                $table->dropIndex('idx_dokter_tanggal');
            });
        } catch (\Exception $e) {
            // Ignore if index is needed for foreign key constraint
        }
        
        Schema::table('rawat_jalans', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'soap_subjective', 'soap_objective', 'soap_assessment', 'soap_plan']);
        });

        // Drop indices and columns from beds
        try {
            Schema::table('beds', function (Blueprint $table) {
                $table->dropIndex('idx_bed_type');
            });
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }
        
        try {
            Schema::table('beds', function (Blueprint $table) {
                $table->dropIndex('idx_kamar_status');
            });
        } catch (\Exception $e) {
            // Ignore if index is needed for foreign key constraint
        }
        
        Schema::table('beds', function (Blueprint $table) {
            $table->dropColumn(['bed_type', 'equipment_available']);
        });

        // Drop indices and columns from obats
        try {
            Schema::table('obats', function (Blueprint $table) {
                $table->dropIndex('idx_bpjs_formulary');
                $table->dropIndex('idx_high_alert');
                $table->dropIndex('idx_therapeutic_class');
                $table->dropIndex('idx_active_bpjs');
            });
        } catch (\Exception $e) {
            // Ignore if indices don't exist
        }
        
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn(['is_bpjs_formulary', 'is_high_alert', 'therapeutic_class', 'requires_approval']);
        });

        // Drop indices and columns from billing
        try {
            Schema::table('billing', function (Blueprint $table) {
                $table->dropIndex('idx_tanggal_invoice');
                $table->dropIndex('idx_billing_status');
                $table->dropIndex('idx_insurance_class');
            });
        } catch (\Exception $e) {
            // Ignore if indices don't exist
        }
        
        try {
            Schema::table('billing', function (Blueprint $table) {
                $table->dropIndex('idx_pasien_invoice');
            });
        } catch (\Exception $e) {
            // Ignore if index is needed for foreign key constraint
        }
        
        Schema::table('billing', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'invoice_number', 'insurance_class', 'discount_amount', 'tax_amount', 'total_amount', 'paid_amount']);
        });

        // Drop indices and UUID from pasiens
        try {
            Schema::table('pasiens', function (Blueprint $table) {
                $table->dropIndex('idx_no_rm');
                $table->dropIndex('idx_nik');
                $table->dropIndex('idx_no_bpjs');
                $table->dropIndex('idx_nama_lahir');
            });
        } catch (\Exception $e) {
            // Ignore if indices don't exist
        }
        
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        // Drop indices and UUID from rawat_inaps
        try {
            Schema::table('rawat_inaps', function (Blueprint $table) {
                $table->dropIndex('idx_tanggal_masuk');
                $table->dropIndex('idx_tanggal_keluar');
                $table->dropIndex('idx_rawat_inap_status');
            });
        } catch (\Exception $e) {
            // Ignore if indices don't exist
        }
        
        try {
            Schema::table('rawat_inaps', function (Blueprint $table) {
                $table->dropIndex('idx_pasien_status');
            });
        } catch (\Exception $e) {
            // Ignore if index is needed for foreign key constraint
        }
        
        Schema::table('rawat_inaps', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        // Drop indices and UUID from reseps
        try {
            Schema::table('reseps', function (Blueprint $table) {
                $table->dropIndex('idx_tanggal_resep');
                $table->dropIndex('idx_resep_status');
            });
        } catch (\Exception $e) {
            // Ignore if indices don't exist
        }
        
        try {
            Schema::table('reseps', function (Blueprint $table) {
                $table->dropIndex('idx_pasien_resep');
                $table->dropIndex('idx_dokter_resep');
            });
        } catch (\Exception $e) {
            // Ignore if indices are needed for foreign key constraints
        }
        
        Schema::table('reseps', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
