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
        Schema::table('application_for_labs', function (Blueprint $table) {
            if (! Schema::hasColumn('application_for_labs', 'calibration_compliance_comment')) {
                $table->text('calibration_compliance_comment')->nullable()->after('calibration_compliance');
            }

            if (! Schema::hasColumn('application_for_labs', 'calibration_non_compliance')) {
                $table->text('calibration_non_compliance')->nullable()->after('calibration_compliance_comment');
            }

            if (! Schema::hasColumn('application_for_labs', 'application_fee')) {
                $table->string('application_fee')->nullable()->after('declaration_test_lab');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_for_labs', function (Blueprint $table) {
            $columns = ['calibration_compliance_comment', 'calibration_non_compliance', 'application_fee'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('application_for_labs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
