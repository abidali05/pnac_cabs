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
        // Remove old columns first (if they exist) to avoid duplication
        Schema::table('mlab_calibration_system', function (Blueprint $table) {
            $oldColumns = [
                'program_exists',
                'records_maintained',
                'environment_adequate',
                'internal_procedure_exists',
                'traceability_exists',
                'in_house_calibration',
                'calibration_program_exists',
                'calibration_program_comment',
                'record_maintained',
                'record_maintained_comment',
                'facilities_adequate',
                'facilities_adequate_comment',
                'internal_procedure_comment',
                'traceability_pnac',
                'traceability_pnac_comment',
                'traceability_other',
                'in_house_uncertainty_identified',
                'in_house_uncertainty_incorporated',
            ];

            foreach ($oldColumns as $column) {
                if (Schema::hasColumn('mlab_calibration_system', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Add fresh columns
        Schema::table('mlab_calibration_system', function (Blueprint $table) {
            $table->enum('calibration_program_exists', ['yes', 'no'])->nullable();
            $table->text('calibration_program_comment')->nullable();
            $table->enum('record_maintained', ['yes', 'no'])->nullable();
            $table->text('record_maintained_comment')->nullable();
            $table->enum('facilities_adequate', ['yes', 'no'])->nullable();
            $table->text('facilities_adequate_comment')->nullable();
            $table->enum('internal_procedure_exists', ['yes', 'no'])->nullable();
            $table->text('internal_procedure_comment')->nullable();
            $table->enum('traceability_pnac', ['yes', 'no'])->nullable();
            $table->text('traceability_pnac_comment')->nullable();
            $table->text('traceability_other')->nullable();
            $table->enum('in_house_calibration', ['yes', 'no'])->nullable();
            $table->enum('in_house_uncertainty_identified', ['yes', 'no'])->nullable();
            $table->enum('in_house_uncertainty_incorporated', ['yes', 'no'])->nullable();
        });

        // Handle mlab_iso_compliance
        Schema::table('mlab_iso_compliance', function (Blueprint $table) {
            if (! Schema::hasColumn('mlab_iso_compliance', 'non_compliance_areas')) {
                $table->json('non_compliance_areas')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
