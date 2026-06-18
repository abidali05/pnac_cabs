<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hcb_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->nullable()->unique();
            $table->string('scheme_name')->default('Halal Certification Bodies');
            $table->string('application_type')->default('New Application');
            $table->string('organization_name')->nullable();
            $table->string('status')->default('Draft');
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('hcb_basic_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->string('organization_name')->nullable();
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
            $table->boolean('new_accreditation')->default(false);
            $table->boolean('extension_scope')->default(false);
            $table->text('halal_scope')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_sub_offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->string('office_name')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_about_hcb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('parent_organization')->nullable();
            $table->string('relationship')->nullable();
            $table->text('parent_address')->nullable();
            $table->string('parent_postcode')->nullable();
            $table->string('parent_telephone')->nullable();
            $table->string('parent_fax')->nullable();
            $table->string('invoice_organization')->nullable();
            $table->text('invoice_address')->nullable();
            $table->string('invoice_postcode')->nullable();
            $table->string('invoice_telephone')->nullable();
            $table->string('invoice_fax')->nullable();
            $table->string('ownership_type')->nullable();
            $table->text('other_description')->nullable();
            $table->string('is_halal_main_activity')->nullable();
            $table->text('activity_description')->nullable();
            $table->string('consultant_name')->nullable();
            $table->string('consultant_organization')->nullable();
            $table->text('consultant_address')->nullable();
            $table->string('consultant_postcode')->nullable();
            $table->string('consultant_tel')->nullable();
            $table->string('consultant_fax')->nullable();
            $table->string('consultant_email')->nullable();
            $table->timestamps();
        });

        foreach (['hcb_chief_executives','hcb_shariah_experts','hcb_quality_management_representatives','hcb_management_members'] as $t) {
            Schema::create($t, function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
                $table->string('name')->nullable();
                $table->string('religion')->nullable();
                $table->text('qualification')->nullable();
                $table->text('experience')->nullable();
                $table->timestamps();
            });
        }

        foreach (['hcb_permanent_auditors','hcb_external_auditors'] as $t) {
            Schema::create($t, function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
                $table->string('name')->nullable();
                $table->string('religion')->nullable();
                $table->text('qualification')->nullable();
                $table->string('auditing_field')->nullable();
                $table->text('audit_experience')->nullable();
                $table->timestamps();
            });
        }

        Schema::create('hcb_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->string('category_code')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->text('included_activities')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_quality_system', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->string('question_code');
            $table->string('answer')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_non_compliances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->text('area_of_non_compliance')->nullable();
            $table->date('rectified_by_date')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_other_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->string('approval_body_name')->nullable();
            $table->text('approval_body_address')->nullable();
            $table->text('scope')->nullable();
            $table->string('certificate_number')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
            $table->boolean('halal_scope')->default(false);
            $table->boolean('extension_scope')->default(false);
            $table->boolean('quality_manual_confirmed')->default(false);
            $table->string('applicant_fee_amount')->nullable();
            $table->boolean('declaration_accepted')->default(false);
            $table->string('signed_by')->nullable();
            $table->date('signed_date')->nullable();
            $table->timestamps();
        });

        Schema::create('hcb_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('hcb_applications')->cascadeOnDelete();
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
            'hcb_documents','hcb_declarations','hcb_other_approvals',
            'hcb_non_compliances','hcb_quality_system','hcb_scopes',
            'hcb_external_auditors','hcb_permanent_auditors',
            'hcb_management_members','hcb_quality_management_representatives',
            'hcb_shariah_experts','hcb_chief_executives',
            'hcb_about_hcb','hcb_sub_offices','hcb_basic_information',
            'hcb_applications',
        ] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
