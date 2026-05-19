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
        Schema::create('proficiency_testings', function (Blueprint $table) {
            $table->id();
            $table->text('organisation')->nullable();
            $table->text('address')->nullable();
            $table->text('postcode')->nullable();
            $table->text('tel')->nullable();
            $table->text('fax')->nullable();
            $table->text('contact_name')->nullable();
            $table->text('designation')->nullable();
            $table->text('person_address')->nullable();
            $table->text('person_postcode')->nullable();
            $table->text('person_tel')->nullable();
            $table->text('person_fax')->nullable();
            $table->text('person_email')->nullable();
            $table->text('chack_accreditation')->nullable();
            $table->text('chack_extension')->nullable();
            $table->text('chack_chemical')->nullable();
            $table->text('chack_textile')->nullable();
            $table->text('chack_environment')->nullable();
            $table->text('chack_biological')->nullable();
            $table->text('chack_clinical')->nullable();
            $table->text('chack_dimensional')->nullable();
            $table->text('chack_mechanical')->nullable();
            $table->text('chack_materials')->nullable();
            $table->text('chack_metallurgical')->nullable();
            $table->text('chack_others')->nullable();
            $table->text('chack_manual')->nullable();
            $table->text('chack_procedures')->nullable();
            $table->text('chack_technical')->nullable();
            $table->text('chack_testing')->nullable();
            $table->text('chack_complete')->nullable();
            $table->text('chack_staff')->nullable();
            $table->text('chack_relevant')->nullable();
            $table->text('chack_suppliers')->nullable();
            $table->text('chack_calibration')->nullable();
            $table->text('chack_report')->nullable();
            $table->text('selves_title')->nullable();
            $table->text('selves_name')->nullable();
            $table->text('selves_position')->nullable();
            $table->text('selves_parent_organization')->nullable();
            $table->text('selves_address')->nullable();
            $table->text('selves_postcode')->nullable();
            $table->text('selves_tel')->nullable();
            $table->text('selves_fax')->nullable();
            $table->text('selves_invoicing_organization')->nullable();
            $table->text('selves_invoicing_address')->nullable();
            $table->text('selves_invoicing_postcode')->nullable();
            $table->text('selves_invoicing_tel')->nullable();
            $table->text('selves_invoicing_fax')->nullable();
            $table->text('selves_individual')->nullable();
            $table->text('selves_public')->nullable();
            $table->text('selves_private')->nullable();
            $table->text('selves_learned')->nullable();
            $table->text('selves_industry')->nullable();
            $table->text('selves_academic')->nullable();
            $table->text('selves_other_describe')->nullable();
            $table->text('selves_activity')->nullable();
            $table->text('selves_cab_activity')->nullable();
            $table->text('selves_own_org')->nullable();
            $table->text('selves_other_org')->nullable();
            $table->text('staff_name')->nullable();
            $table->text('staff_qualifications')->nullable();
            $table->text('staff_relevant')->nullable();
            $table->text('staff_exp')->nullable();
            $table->text('staff_quality_name')->nullable();
            $table->text('staff_quality_qualifications')->nullable();
            $table->text('staff_quality_relevant')->nullable();
            $table->text('staff_quality_exp')->nullable();
            $table->text('staff_coordinator_name')->nullable();
            $table->text('staff_coordinator_qualifications')->nullable();
            $table->text('staff_coordinator_relevant')->nullable();
            $table->text('staff_coordinator_exp')->nullable();
            $table->text('staff_statistian_name')->nullable();
            $table->text('staff_statistian_qualifications')->nullable();
            $table->text('staff_statistian_relevant')->nullable();
            $table->text('staff_statistian_exp')->nullable();
            $table->text('scop_parameter')->nullable();
            $table->text('scop_testing')->nullable();
            $table->text('scop_round')->nullable();
            $table->text('scop_equipment')->nullable();
            $table->text('scop_last_date')->nullable();
            $table->text('scop_next_date')->nullable();
            $table->text('scop_calibration')->nullable();
            $table->text('scop_details')->nullable();
            $table->text('scop_comments')->nullable();
            $table->text('approvals_name')->nullable();
            $table->text('approvals_scope')->nullable();
            $table->text('approvals_start_date')->nullable();
            $table->text('approvals_end_date')->nullable();
            $table->text('declaration_applicant')->nullable();
            $table->text('declaration_extension')->nullable();
            $table->text('declaration_signed')->nullable();
            $table->text('declaration_date')->nullable();

            $table->text('category')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proficiency_testings');
    }
};
