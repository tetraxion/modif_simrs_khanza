<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates laboratory management tables for SIMRS Khanza system:
     * - lab_orders: Laboratory test orders with status tracking
     * - lab_order_items: Individual tests within each order
     * - lab_results: Test results with normal range flagging
     * - lab_test_catalog: Available tests with pricing and specifications
     * - lab_test_templates: Predefined test panels for quick ordering
     * - lab_test_template_items: Tests included in each template
     * 
     * Requirements: Req 6 (Lab Orders), Req 7 (Lab Results), Req 8 (Lab Reports)
     */
    public function up(): void
    {
        // Laboratory Orders Table
        Schema::create('lab_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique()->comment('Unique laboratory request number');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('visit_id');
            $table->enum('visit_type', ['outpatient', 'inpatient', 'emergency']);
            $table->unsignedBigInteger('ordering_physician_id');
            $table->text('clinical_indication')->nullable()->comment('Clinical indication and relevant patient history');
            $table->enum('status', ['pending', 'collected', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('ordered_at');
            $table->timestamp('collected_at')->nullable()->comment('Specimen collection timestamp');
            $table->timestamp('completed_at')->nullable()->comment('Results finalization timestamp');
            $table->timestamps();

            // Indices for performance
            $table->index('patient_id', 'idx_patient');
            $table->index(['visit_id', 'visit_type'], 'idx_visit');
            $table->index('ordering_physician_id', 'idx_physician');
            $table->index('status', 'idx_status');
            $table->index('ordered_at', 'idx_ordered_at');
            $table->index('collected_at', 'idx_collected_at');
            
            // Foreign key constraints
            $table->foreign('patient_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->foreign('ordering_physician_id')->references('id')->on('dokters')->onDelete('restrict');
        });

        // Laboratory Order Items Table
        Schema::create('lab_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_order_id');
            $table->string('test_code', 20)->comment('Reference to lab_test_catalog.test_code');
            $table->string('test_name', 255);
            $table->string('specimen_type', 50)->comment('Blood, Urine, Stool, etc.');
            $table->enum('urgency', ['routine', 'urgent', 'stat'])->default('routine');
            $table->string('barcode', 100)->nullable()->comment('Specimen barcode for tracking');
            $table->timestamps();

            // Indices for performance
            $table->index('lab_order_id', 'idx_order');
            $table->index('test_code', 'idx_test_code');
            $table->index('urgency', 'idx_urgency');
            $table->index('barcode', 'idx_barcode');
            
            // Foreign key constraints
            $table->foreign('lab_order_id')->references('id')->on('lab_orders')->onDelete('cascade');
        });

        // Laboratory Results Table
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_order_item_id');
            $table->string('result_value', 500)->comment('Test result value - numeric or text');
            $table->enum('result_type', ['numeric', 'text', 'dropdown']);
            $table->string('unit', 50)->nullable()->comment('Unit of measurement');
            $table->string('normal_range', 100)->nullable()->comment('Normal reference range');
            $table->enum('flag', ['normal', 'high', 'low', 'critical_high', 'critical_low', 'abnormal'])->default('normal');
            $table->text('result_notes')->nullable()->comment('Additional comments or interpretation');
            $table->unsignedBigInteger('verified_by')->nullable()->comment('Analyst who verified the result');
            $table->timestamp('verified_at')->nullable()->comment('Result verification timestamp');
            $table->timestamps();

            // Indices for performance
            $table->index('lab_order_item_id', 'idx_order_item');
            $table->index('flag', 'idx_flag');
            $table->index('verified_at', 'idx_verified_at');
            
            // Foreign key constraints
            $table->foreign('lab_order_item_id')->references('id')->on('lab_order_items')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('restrict');
        });

        // Laboratory Test Catalog Table
        Schema::create('lab_test_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('test_code', 20)->unique()->comment('Unique test identifier');
            $table->string('test_name', 255);
            $table->string('test_category', 100)->comment('Hematology, Chemistry, Microbiology, etc.');
            $table->string('specimen_type', 50)->comment('Required specimen type');
            $table->enum('result_type', ['numeric', 'text', 'dropdown']);
            $table->string('unit', 50)->nullable()->comment('Default unit of measurement');
            $table->string('normal_range_male', 100)->nullable()->comment('Normal range for male patients');
            $table->string('normal_range_female', 100)->nullable()->comment('Normal range for female patients');
            $table->decimal('critical_low', 10, 2)->nullable()->comment('Critical low threshold');
            $table->decimal('critical_high', 10, 2)->nullable()->comment('Critical high threshold');
            $table->integer('turnaround_time_hours')->nullable()->comment('Expected turnaround time in hours');
            $table->decimal('price', 15, 2)->default(0)->comment('Test price');
            $table->boolean('is_active')->default(true)->comment('Active status flag');
            $table->text('test_description')->nullable()->comment('Test description and preparation instructions');
            $table->timestamps();

            // Indices for performance
            $table->index('test_category', 'idx_category');
            $table->index('is_active', 'idx_active');
            $table->index('test_name', 'idx_test_name');
        });

        // Laboratory Test Templates Table (Predefined Panels)
        Schema::create('lab_test_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name', 255)->comment('E.g., Pre-operative, Diabetes, Lipid Panel');
            $table->string('clinical_indication', 255)->nullable()->comment('When to use this panel');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indices for performance
            $table->index('is_active', 'idx_active');
            $table->index('template_name', 'idx_template_name');
        });

        // Laboratory Test Template Items Table
        Schema::create('lab_test_template_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->string('test_code', 20)->comment('Reference to lab_test_catalog.test_code');
            $table->integer('sequence')->default(0)->comment('Display order');
            $table->timestamps();

            // Indices for performance
            $table->index('template_id', 'idx_template');
            $table->index('test_code', 'idx_test_code');
            $table->index(['template_id', 'sequence'], 'idx_template_sequence');
            
            // Foreign key constraints
            $table->foreign('template_id')->references('id')->on('lab_test_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_template_items');
        Schema::dropIfExists('lab_test_templates');
        Schema::dropIfExists('lab_test_catalog');
        Schema::dropIfExists('lab_results');
        Schema::dropIfExists('lab_order_items');
        Schema::dropIfExists('lab_orders');
    }
};
