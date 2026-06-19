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
        Schema::table('mlab_step1_organisation', function (Blueprint $table) {
            $table->string('title')->nullable();
            // 1.2
            $table->string('parent_organisation')->nullable();
            $table->string('parent_relationship')->nullable();
            $table->text('parent_address')->nullable();
            $table->string('parent_postcode')->nullable();
            $table->string('parent_tel')->nullable();
            $table->string('parent_fax')->nullable();
            // 1.3
            $table->string('invoice_organisation')->nullable();
            $table->text('invoice_address')->nullable();
            $table->string('invoice_postcode')->nullable();
            $table->string('invoice_tel')->nullable();
            $table->string('invoice_fax')->nullable();
            // 1.4
            $table->string('ownership_type')->nullable();
            $table->string('registration_no')->nullable();
            $table->text('ownership_other_description')->nullable();
            // 1.5
            $table->enum('testing_main_activity', ['yes', 'no'])->nullable();
            $table->text('main_activity_description')->nullable();
            // 1.6
            $table->string('consultant_name')->nullable();
            $table->string('consultant_organisation')->nullable();
            $table->text('consultant_address')->nullable();
            $table->string('consultant_postcode')->nullable();
            $table->string('consultant_tel')->nullable();
            $table->string('consultant_fax')->nullable();
            $table->string('consultant_email')->nullable();
            // 1.7
            $table->enum('facility_permanent', ['yes', 'no'])->nullable();
            $table->enum('facility_sample_collection', ['yes', 'no'])->nullable();
            $table->enum('facility_temporary', ['yes', 'no'])->nullable();
            $table->enum('facility_mobile', ['yes', 'no'])->nullable();
            // file path for sample collection list (upload later)
            $table->string('sample_collection_list')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mlab_step1_organisation', function (Blueprint $table) {
            //
        });
    }
};
