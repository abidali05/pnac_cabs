<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Master application table
        Schema::create('mlab_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->unique()->nullable();
            $table->string('scheme_name')->default('Certification Bodies');
            $table->string('organisation_name');
            $table->text('lab_address');
            $table->string('postcode')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->enum('status', ['draft', 'submitted'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        // 2. Step 1 – Organisation & Contact
        Schema::create('mlab_step1_organisation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            // Contact person
            $table->string('contact_name');
            $table->string('contact_designation');
            $table->text('contact_address')->nullable();
            $table->string('contact_tel')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_mobile')->nullable();
            // Fields of testing (checkbox values stored as JSON)
            $table->json('fields_of_testing')->nullable(); // ['Clinical Chemistry', 'Haematology', ...]
            $table->text('other_field')->nullable();
            // Facility type
            $table->enum('facility_type', ['Permanent Facility', 'Sample Collection Centre', 'Temporary Facility', 'Mobile Laboratory'])->nullable();
            $table->timestamps();
        });

        // 3. Step 2 – Staff (technical management, quality manager, lab staff)
        Schema::create('mlab_technical_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('department');
            $table->string('name_designation');
            $table->string('qualification');
            $table->string('experience');
            $table->string('training');
            $table->string('authorized_area');
            $table->string('signature')->nullable();
            $table->timestamps();
        });

        Schema::create('mlab_quality_manager', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('qualification');
            $table->string('experience');
            $table->string('training');
            $table->string('signature')->nullable();
            $table->timestamps();
        });

        Schema::create('mlab_lab_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('section_name');
            $table->string('section_leader');
            $table->string('qualification');
            $table->string('experience');
            $table->string('training');
            $table->string('authorized_area');
            $table->timestamps();
        });

        // 4. Step 3 – Scope (tests, equipment, reference materials, PT)
        Schema::create('mlab_scope_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('sample_type');
            $table->string('test_type');
            $table->string('range');
            $table->string('detection_limit');
            $table->string('uncertainty');
            $table->text('standard_method');
            $table->text('equipment_used');
            $table->json('qc_measures'); // ['PT', 'Interlab Comparison', ...]
            $table->timestamps();
        });

        Schema::create('mlab_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('equipment_name');
            $table->string('model');
            $table->string('capacity');
            $table->string('detection_limit');
            $table->date('calibration_date');
            $table->date('next_calibration');
            $table->string('usage');
            $table->timestamps();
        });

        Schema::create('mlab_reference_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('supplier');
            $table->date('expiry');
            $table->string('traceability');
            $table->string('purpose');
            $table->timestamps();
        });

        Schema::create('mlab_proficiency_testing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('sample_type');
            $table->string('test');
            $table->date('date');
            $table->string('organizing_body');
            $table->string('z_score');
            $table->text('corrective_action')->nullable();
            $table->timestamps();
        });

        // 5. Step 4 – Quality System
        Schema::create('mlab_calibration_system', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->boolean('program_exists')->default(false);
            $table->boolean('records_maintained')->default(false);
            $table->boolean('environment_adequate')->default(false);
            $table->boolean('internal_procedure_exists')->default(false);
            $table->boolean('traceability_exists')->default(false);
            $table->boolean('in_house_calibration')->default(false);
            $table->timestamps();
        });

        Schema::create('mlab_iso_compliance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->enum('complies', ['yes', 'no'])->nullable();
            $table->json('non_compliance_areas')->nullable(); // array of {area, rectification_date}
            $table->timestamps();
        });

        // 6. Step 5 – Other Approvals
        Schema::create('mlab_other_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->string('body_name');
            $table->string('scope');
            $table->string('certificate_no');
            $table->date('start_date');
            $table->date('expiry_date');
            $table->timestamps();
        });

        // 7. Step 6 – Declaration
        Schema::create('mlab_declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mlab_application_id')->constrained()->onDelete('cascade');
            $table->json('application_types'); // checkboxes
            $table->text('other_type')->nullable();
            $table->boolean('agreement_accepted')->default(false);
            $table->decimal('fee', 10, 2)->nullable();
            $table->string('signed_by')->nullable();
            $table->date('signed_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mlab_declarations');
        Schema::dropIfExists('mlab_other_approvals');
        Schema::dropIfExists('mlab_iso_compliance');
        Schema::dropIfExists('mlab_calibration_system');
        Schema::dropIfExists('mlab_proficiency_testing');
        Schema::dropIfExists('mlab_reference_materials');
        Schema::dropIfExists('mlab_equipment');
        Schema::dropIfExists('mlab_scope_tests');
        Schema::dropIfExists('mlab_lab_staff');
        Schema::dropIfExists('mlab_quality_manager');
        Schema::dropIfExists('mlab_technical_management');
        Schema::dropIfExists('mlab_step1_organisation');
        Schema::dropIfExists('mlab_applications');
    }
};
