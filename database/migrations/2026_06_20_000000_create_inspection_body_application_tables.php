<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_body_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->nullable()->unique();
            $table->string('scheme_name')->default('Inspection Bodies');
            $table->string('application_type')->default('New Application');
            $table->string('status')->default('Draft');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('inspection_body_organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
            $table->string('inspection_body_name')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('designation')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('contact_postcode')->nullable();
            $table->string('contact_tel')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('office_details')->nullable();
            $table->boolean('new_accreditation')->default(false);
            $table->boolean('extension_scope')->default(false);
            $table->string('parent_organization')->nullable();
            $table->string('relationship')->nullable();
            $table->text('parent_address')->nullable();
            $table->string('parent_postcode')->nullable();
            $table->string('parent_tel')->nullable();
            $table->string('parent_fax')->nullable();
            $table->string('invoice_organization')->nullable();
            $table->text('invoice_address')->nullable();
            $table->string('invoice_postcode')->nullable();
            $table->string('invoice_tel')->nullable();
            $table->string('invoice_fax')->nullable();
            $table->date('date_of_establishment')->nullable();
            $table->string('legal_status')->nullable();
            $table->string('outside_pakistan')->nullable();
            $table->text('countries_description')->nullable();
            $table->string('inspection_main_activity')->nullable();
            $table->text('activity_description')->nullable();
            $table->string('body_type')->nullable(); // Type A, B, C
            $table->string('consultant_name')->nullable();
            $table->string('consultant_organization')->nullable();
            $table->text('consultant_address')->nullable();
            $table->string('consultant_postcode')->nullable();
            $table->string('consultant_tel')->nullable();
            $table->string('consultant_fax')->nullable();
            $table->string('consultant_email')->nullable();
            $table->timestamps();
        });

        Schema::create('inspection_body_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
            $table->string('role'); // chief_executive, quality_representative, management_member
            $table->string('name')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('experience')->nullable();
            $table->timestamps();
        });

        foreach (['inspection_body_inspectors', 'inspection_body_freelance_inspectors'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
                $table->string('name')->nullable();
                $table->string('qualification')->nullable();
                $table->string('inspection_field')->nullable();
                $table->text('inspection_experience')->nullable();
                $table->timestamps();
            });
        }

        Schema::create('inspection_body_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
            $table->text('description_of_inspection')->nullable();
            $table->text('type_and_range')->nullable();
            $table->text('methods_and_procedures')->nullable();
            $table->timestamps();
        });

        Schema::create('inspection_body_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
            $table->string('equipment_name')->nullable();
            $table->string('calibration_organization')->nullable();
            $table->string('calibration_frequency')->nullable();
            $table->date('last_calibration_date')->nullable();
            $table->timestamps();
        });

        Schema::create('inspection_body_declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
            $table->boolean('type_a')->default(false);
            $table->boolean('type_b')->default(false);
            $table->boolean('type_c')->default(false);
            $table->boolean('iso17020_compliance')->default(false);
            $table->boolean('assessment_understanding')->default(false);
            $table->boolean('agreement_acceptance')->default(false);
            $table->boolean('quality_manual_attached')->default(false);
            $table->boolean('document_review_attached')->default(false);
            $table->string('applicant_fee')->nullable();
            $table->string('declaration_name')->nullable();
            $table->date('declaration_date')->nullable();
            $table->timestamps();
        });

        Schema::create('inspection_body_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('inspection_body_applications')->cascadeOnDelete();
            $table->string('document_type');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'inspection_body_documents',
            'inspection_body_declarations',
            'inspection_body_equipment',
            'inspection_body_scopes',
            'inspection_body_freelance_inspectors',
            'inspection_body_inspectors',
            'inspection_body_staff',
            'inspection_body_organizations',
            'inspection_body_applications',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
