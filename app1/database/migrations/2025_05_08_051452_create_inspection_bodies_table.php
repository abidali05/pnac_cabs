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
        Schema::create('inspection_bodies', function (Blueprint $table) {
            $table->id();
            $table->text('inspection_body')->nullable();
            $table->text('general_address')->nullable();
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
            $table->text('sub_offices')->nullable();
            $table->text('offices_cities')->nullable();
            $table->text('new_accreditation')->nullable();
            $table->text('extension_scope')->nullable();
            $table->text('chack_quality_manual')->nullable();
            $table->text('chack_applicant')->nullable();
            $table->text('chack_Completely')->nullable();
            $table->text('chack_calibration')->nullable();
            $table->text('chack_copies')->nullable();
            $table->text('chack_internal')->nullable();
            $table->text('chack_vitae')->nullable();
            $table->text('chack_performed')->nullable();
            $table->text('chack_filled_form')->nullable();
            $table->text('organized_title')->nullable();
            $table->text('organized_name')->nullable();
            $table->text('organized_position')->nullable();
            $table->text('organized_parent_organization')->nullable();
            $table->text('organized_parent_relationship')->nullable();
            $table->text('organized_parent_address')->nullable();
            $table->text('organized_parent_postcode')->nullable();
            $table->text('organized_parent_tel')->nullable();
            $table->text('organized_parent_fax')->nullable();
            $table->text('organized_invoicing_organization')->nullable();
            $table->text('organized_invoicing_address')->nullable();
            $table->text('organized_invoicing_postcode')->nullable();
            $table->text('organized_invoicing_tel')->nullable();
            $table->text('organized_invoicing_fax')->nullable();
            $table->text('organized_legal_status')->nullable();
            $table->text('organized_inspection')->nullable();
            $table->text('organized_specify')->nullable();
            $table->text('organized_activity')->nullable();
            $table->text('organized_describe')->nullable();
            $table->text('organized_body_type')->nullable();
            $table->text('organized_other_name')->nullable();
            $table->text('organized_other_scope')->nullable();
            $table->text('organized_other_period')->nullable();
            $table->text('organized_consult_name')->nullable();
            $table->text('organized_consult_Org')->nullable();
            $table->text('organized_consult_address')->nullable();
            $table->text('organized_consult_postcode')->nullable();
            $table->text('organized_consult_tel')->nullable();
            $table->text('organized_consult_fax')->nullable();
            $table->text('organized_consult_email')->nullable();
            $table->text('staff_chief_name')->nullable();
            $table->text('staff_chief_qualifications')->nullable();
            $table->text('staff_chief_relevant')->nullable();
            $table->text('staff_chief_exp')->nullable();
            $table->text('staff_quality_name')->nullable();
            $table->text('staff_quality_qualifications')->nullable();
            $table->text('staff_quality_relevant')->nullable();
            $table->text('staff_quality_exp')->nullable();
            $table->text('staff_manag_name')->nullable();
            $table->text('staff_manag_qualifications')->nullable();
            $table->text('staff_manag_relevant')->nullable();
            $table->text('staff_manag_exp')->nullable();
            $table->text('staff_inspect_name')->nullable();
            $table->text('staff_inspect_qualifications')->nullable();
            $table->text('staff_inspect_auditing')->nullable();
            $table->text('staff_inspect_exp')->nullable();
            $table->text('staff_sub_name')->nullable();
            $table->text('staff_sub_qualifications')->nullable();
            $table->text('staff_sub_auditing')->nullable();
            $table->text('staff_sub_exp')->nullable();
            $table->text('scop_inspect_des')->nullable();
            $table->text('scop_range')->nullable();
            $table->text('scop_method')->nullable();
            $table->text('scop_equipment')->nullable();
            $table->text('scop_calibration')->nullable();
            $table->text('scop_economic_b')->nullable();
            $table->text('scop_last_calib')->nullable();
            $table->text('declaration_type_a')->nullable();
            $table->text('declaration_type_b')->nullable();
            $table->text('declaration_type_c')->nullable();
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
        Schema::dropIfExists('inspection_bodies');
    }
};
