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
        Schema::create('application_for_labs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certification_general_id')->nullable();
            // Basic / contact
            // $table->string('organisation')->nullable();
            // $table->string('fax')->nullable();
            // $table->string('contact_name')->nullable();
            // $table->string('designation')->nullable();
            // $table->string('person_address')->nullable();
            // $table->string('person_postcode')->nullable();
            // $table->string('person_tel')->nullable();
            // $table->string('person_fax')->nullable();

            // // Checkboxes / declarations
            // $table->string('chack_calibration')->nullable();
            // $table->string('chack_laboratory')->nullable();
            // $table->string('chack_extension')->nullable();
            // $table->string('chack_permanent')->nullable();
            // $table->string('chack_mobile')->nullable();
            // $table->string('chack_renewal')->nullable();
            // $table->string('chack_quality')->nullable();
            // $table->string('chack_participation')->nullable();
            // $table->string('chack_plan')->nullable();
            // $table->string('chack_agreement')->nullable();
            // $table->string('chack_filled')->nullable();
            // $table->string('chack_staff')->nullable();
            // $table->string('chack_applicant')->nullable();

            // // About yourselves
            // $table->text('about')->nullable();
            $table->text('selves_title')->nullable();
            $table->text('selves_name')->nullable();
            $table->text('selves_position')->nullable();
            $table->text('selves_parent')->nullable();
            $table->text('selves_parent_organization')->nullable();
            $table->text('selves_relationship')->nullable();
            $table->text('selves_with_parent')->nullable();
            $table->text('selves_address')->nullable();
            $table->text('selves_postcode')->nullable();
            $table->text('selves_tel')->nullable();
            $table->text('selves_fax')->nullable();
            // $table->text('selves_organization_three')->nullable();
            // $table->text('selves_address_three')->nullable();
            // $table->text('selves_postcode_three')->nullable();
            // $table->text('selves_tel_three')->nullable();
            // $table->text('selves_fax_three')->nullable();
            $table->text('selves_individual')->nullable();
            $table->text('selves_public')->nullable();
            $table->text('selves_private')->nullable();
            $table->text('selves_learned')->nullable();
            $table->text('selves_industry')->nullable();
            $table->text('selves_academic')->nullable();
            $table->text('selves_other_describe')->nullable();
            $table->text('selves_activities')->nullable();
            $table->text('selves_own_organisation')->nullable();
            $table->text('selves_other_organisation')->nullable();
            $table->text('selves_name_seven')->nullable();
            $table->text('selves_organisation_any')->nullable();
            $table->text('selves_address_seven')->nullable();
            $table->text('selves_postcode_seven')->nullable();
            $table->text('selves_tel_seven')->nullable();
            $table->text('selves_fax_seven')->nullable();
            $table->text('selves_email_seven')->nullable();

            // About your staff
            $table->text('staff_name')->nullable();
            $table->text('staff_qualifications')->nullable();
            $table->text('staff_relevant')->nullable();
            $table->text('staff_experience')->nullable();
            $table->text('staff_quality_name')->nullable();
            $table->text('staff_quality_qualifications')->nullable();
            $table->text('staff_quality_relevant')->nullable();
            $table->text('staff_quality_experience')->nullable();
            $table->text('staff_measured')->nullable();
            $table->text('staff_range')->nullable();
            $table->text('staff_expanded')->nullable();
            $table->text('staff_technique')->nullable();

            // Scope of Application
            $table->text('scop_materials')->nullable();
            $table->text('scop_types')->nullable();
            $table->text('scop_range')->nullable();
            $table->text('scop_detection')->nullable();
            $table->text('scop_uncertainty')->nullable();
            $table->text('scop_standard')->nullable();
            $table->text('scop_description')->nullable();
            $table->text('scop_working')->nullable();
            $table->text('scop_limit')->nullable();

            // Scope of calibration
            $table->text('scop_calib_measurement')->nullable();
            $table->text('scop_calib_range')->nullable();
            $table->text('scop_calib_expanded')->nullable();
            $table->text('scop_calib_technique')->nullable();

            // Calibration Facility
            $table->string('calibration_fully')->nullable();
            $table->text('calibration_fully_comment')->nullable();
            $table->string('calibration_record')->nullable();
            $table->text('calibration_record_comment')->nullable();
            $table->string('calibration_adequate')->nullable();
            $table->text('calibration_adequate_comment')->nullable();
            $table->string('calibration_procedures')->nullable();
            $table->text('calibration_procedures_comment')->nullable();
            $table->string('calibration_internal')->nullable();
            $table->text('calibration_internal_comment')->nullable();
            $table->string('calibration_pnac')->nullable();
            $table->text('calibration_pnac_comment')->nullable();
            $table->text('calibration_other_comment')->nullable();
            $table->text('calibration_lab_comment')->nullable();
            $table->string('calibration_consider')->nullable();
            $table->string('calibration_compliance')->nullable();
            $table->string('calibration_rectified')->nullable();

            // Other approvals
            $table->string('approvals_name')->nullable();
            $table->string('approvals_scope')->nullable();
            $table->date('approvals_start_date')->nullable();
            $table->date('approvals_end_date')->nullable();

            // Declaration
            $table->string('declaration_calibration')->nullable();
            $table->string('declaration_testing')->nullable();
            $table->string('declaration_extension')->nullable();
            $table->string('declaration_laboratory')->nullable();
            $table->string('declaration_test_lab')->nullable();
            $table->string('signed')->nullable();
            $table->date('date')->nullable();
            $table->text('category')->nullable();

            $table->foreign('certification_general_id')
                ->references('id')
                ->on('certification_generals')
                ->onDelete('cascade');

            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_for_labs');
    }
};
