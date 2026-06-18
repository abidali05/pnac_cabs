<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certification_body_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_general_id')->constrained('certification_generals')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->string('contact_name')->nullable();
            $table->string('contact_designation')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('contact_postcode')->nullable();
            $table->string('contact_tel')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('sub_offices_details')->nullable();

            $table->boolean('is_new_accreditation')->default(false);
            $table->boolean('is_extension_scope')->default(false);
            $table->boolean('qms')->default(false);
            $table->boolean('ems')->default(false);
            $table->boolean('fsms')->default(false);
            $table->boolean('iso_45001')->default(false);
            $table->boolean('iso_13485')->default(false);
            $table->boolean('other_management_system')->default(false);
            $table->string('other_management_system_detail')->nullable();

            $table->boolean('enclosed_quality_manual')->default(false);
            $table->boolean('enclosed_quality_procedures')->default(false);
            $table->boolean('enclosed_staff_list')->default(false);
            $table->boolean('enclosed_certified_organizations')->default(false);
            $table->boolean('enclosed_applicant_fee')->default(false);
            $table->boolean('enclosed_legal_entity')->default(false);
            $table->boolean('enclosed_f0229_document_review')->default(false);

            $table->string('director_title')->nullable();
            $table->string('director_name')->nullable();
            $table->string('director_position')->nullable();
            $table->string('parent_organization')->nullable();
            $table->string('parent_relationship')->nullable();
            $table->text('parent_address')->nullable();
            $table->string('parent_postcode')->nullable();
            $table->string('parent_tel')->nullable();
            $table->string('parent_fax')->nullable();
            $table->string('invoice_organisation')->nullable();
            $table->text('invoice_address')->nullable();
            $table->string('invoice_postcode')->nullable();
            $table->string('invoice_tel')->nullable();
            $table->string('invoice_fax')->nullable();
            $table->string('ownership_type')->nullable();
            $table->text('ownership_other')->nullable();
            $table->string('certification_main_activity')->nullable();
            $table->text('main_activity_description')->nullable();
            $table->string('consultant_name')->nullable();
            $table->string('consultant_organisation')->nullable();
            $table->text('consultant_address')->nullable();
            $table->string('consultant_postcode')->nullable();
            $table->string('consultant_tel')->nullable();
            $table->string('consultant_fax')->nullable();
            $table->string('consultant_email')->nullable();

            $table->string('quality_system_complies')->nullable();
            $table->text('non_compliance_area')->nullable();
            $table->date('rectified_by_date')->nullable();

            $table->text('declaration_scope_applied')->nullable();
            $table->text('declaration_agreement')->nullable();
            $table->text('declaration_documents_enclosed')->nullable();
            $table->text('declaration_fee_enclosed')->nullable();
            $table->text('declaration_understands_system')->nullable();
            $table->text('declaration_information_correct')->nullable();
            $table->string('application_fee')->nullable();
            $table->string('signed')->nullable();
            $table->date('signed_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_body_applications');
    }
};

