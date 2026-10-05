<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates new clinical tables for SIMRS Khanza system:
     * - vital_signs: Patient vital signs with polymorphic visit relationships
     * - diagnoses: ICD-10 diagnosis codes with polymorphic visit relationships
     * - procedures: ICD-9-CM procedure codes with billing integration
     * - cppt_entries: Integrated progress notes for all healthcare providers
     * - nursing_assessments: Nursing assessments with risk scoring
     * - fluid_balance_records: Fluid intake/output tracking with calculated balance
     */
    public function up(): void
    {
        // Vital Signs Table
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('visit_id');
            $table->enum('visit_type', ['outpatient', 'inpatient', 'emergency']);
            $table->integer('blood_pressure_systolic')->nullable();
            $table->integer('blood_pressure_diastolic')->nullable();
            $table->decimal('temperature', 4, 1)->nullable()->comment('Celsius');
            $table->integer('pulse')->nullable()->comment('beats per minute');
            $table->integer('respiratory_rate')->nullable()->comment('breaths per minute');
            $table->decimal('oxygen_saturation', 5, 2)->nullable()->comment('percentage');
            $table->decimal('height', 5, 2)->nullable()->comment('centimeters');
            $table->decimal('weight', 5, 2)->nullable()->comment('kilograms');
            $table->decimal('bmi', 5, 2)->nullable()->comment('Body Mass Index');
            $table->timestamp('recorded_at');
            $table->unsignedBigInteger('recorded_by');
            $table->timestamps();

            // Indices for performance
            $table->index('patient_id', 'idx_patient');
            $table->index(['visit_id', 'visit_type'], 'idx_visit');
            $table->index('recorded_at', 'idx_recorded_at');
            
            // Foreign key constraints
            $table->foreign('patient_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('restrict');
        });

        // Diagnoses Table (ICD-10)
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->enum('visit_type', ['outpatient', 'inpatient', 'emergency']);
            $table->string('icd10_code', 10);
            $table->text('icd10_description');
            $table->boolean('is_primary')->default(false)->comment('Primary diagnosis flag');
            $table->timestamp('created_at');

            // Indices for performance
            $table->index(['visit_id', 'visit_type'], 'idx_visit');
            $table->index('icd10_code', 'idx_icd10_code');
            $table->index('is_primary', 'idx_is_primary');
        });

        // Procedures Table (ICD-9-CM)
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->enum('visit_type', ['outpatient', 'inpatient', 'emergency']);
            $table->string('icd9cm_code', 10);
            $table->text('icd9cm_description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->timestamp('created_at');

            // Indices for performance
            $table->index(['visit_id', 'visit_type'], 'idx_visit');
            $table->index('icd9cm_code', 'idx_icd9cm_code');
        });

        // CPPT Entries Table (Integrated Patient Progress Notes)
        Schema::create('cppt_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id')->comment('Reference to rawat_inaps table');
            $table->enum('entry_type', ['physician', 'nurse', 'nutritionist', 'pharmacist', 'therapist']);
            $table->date('entry_date');
            $table->time('entry_time');
            $table->text('subjective')->nullable();
            $table->text('objective')->nullable();
            $table->text('assessment')->nullable();
            $table->text('plan')->nullable();
            $table->unsignedBigInteger('provider_id')->comment('User ID of the provider');
            $table->string('provider_type', 50)->comment('dokter, perawat, etc');
            $table->enum('shift', ['morning', 'afternoon', 'night'])->nullable()->comment('For nursing entries');
            $table->timestamps();

            // Indices for performance
            $table->index('admission_id', 'idx_admission');
            $table->index('entry_date', 'idx_entry_date');
            $table->index('entry_type', 'idx_entry_type');
            
            // Foreign key constraints
            $table->foreign('admission_id')->references('id')->on('rawat_inaps')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('restrict');
        });

        // Nursing Assessments Table
        Schema::create('nursing_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id')->comment('Reference to rawat_inaps table');
            $table->enum('assessment_type', ['initial', 'shift', 'discharge']);
            $table->string('consciousness_level', 50)->nullable()->comment('Alert, Drowsy, Stupor, Coma');
            $table->integer('pain_score')->nullable()->comment('Pain scale 0-10');
            $table->integer('fall_risk_score')->nullable()->comment('Fall risk assessment score');
            $table->integer('pressure_ulcer_risk_score')->nullable()->comment('Braden scale or similar');
            $table->boolean('suicide_risk')->default(false)->comment('Suicide risk flag');
            $table->text('assessment_notes')->nullable();
            $table->unsignedBigInteger('assessed_by');
            $table->timestamp('assessed_at');
            $table->timestamps();

            // Indices for performance
            $table->index('admission_id', 'idx_admission');
            $table->index('assessment_type', 'idx_assessment_type');
            $table->index('assessed_at', 'idx_assessed_at');
            
            // Foreign key constraints
            $table->foreign('admission_id')->references('id')->on('rawat_inaps')->onDelete('cascade');
            $table->foreign('assessed_by')->references('id')->on('users')->onDelete('restrict');
        });

        // Fluid Balance Records Table
        Schema::create('fluid_balance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id')->comment('Reference to rawat_inaps table');
            $table->date('record_date');
            $table->enum('record_shift', ['morning', 'afternoon', 'night']);
            
            // Intake columns (in milliliters)
            $table->decimal('intake_oral', 10, 2)->default(0)->comment('Oral intake in ml');
            $table->decimal('intake_iv', 10, 2)->default(0)->comment('IV intake in ml');
            $table->decimal('intake_blood', 10, 2)->default(0)->comment('Blood products in ml');
            $table->decimal('intake_other', 10, 2)->default(0)->comment('Other intake in ml');
            
            // Output columns (in milliliters)
            $table->decimal('output_urine', 10, 2)->default(0)->comment('Urine output in ml');
            $table->decimal('output_drain', 10, 2)->default(0)->comment('Drain output in ml');
            $table->decimal('output_vomit', 10, 2)->default(0)->comment('Vomit output in ml');
            $table->decimal('output_other', 10, 2)->default(0)->comment('Other output in ml');
            
            // Calculated balance column - MySQL 5.7+ generated column
            $table->decimal('balance', 10, 2)->nullable()->storedAs(
                '(intake_oral + intake_iv + intake_blood + intake_other) - ' .
                '(output_urine + output_drain + output_vomit + output_other)'
            )->comment('Calculated fluid balance in ml');
            
            $table->unsignedBigInteger('recorded_by');
            $table->timestamps();

            // Indices for performance
            $table->index('admission_id', 'idx_admission');
            $table->index('record_date', 'idx_date');
            $table->index(['admission_id', 'record_date'], 'idx_admission_date');
            
            // Foreign key constraints
            $table->foreign('admission_id')->references('id')->on('rawat_inaps')->onDelete('cascade');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fluid_balance_records');
        Schema::dropIfExists('nursing_assessments');
        Schema::dropIfExists('cppt_entries');
        Schema::dropIfExists('procedures');
        Schema::dropIfExists('diagnoses');
        Schema::dropIfExists('vital_signs');
    }
};
