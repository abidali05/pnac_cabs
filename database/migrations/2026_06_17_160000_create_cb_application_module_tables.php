<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cb_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->nullable()->unique();
            $table->string('scheme_name')->default('Certification Bodies');
            $table->string('application_type')->default('New Application');
            $table->string('organization_name')->nullable();
            $table->string('accreditation_type')->nullable();
            $table->string('status')->default('Draft');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['created_by', 'scheme_name', 'application_type', 'status'], 'cb_app_lookup_idx');
        });

        Schema::create('cb_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('certification_body_name')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('designation')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('contact_postcode')->nullable();
            $table->string('contact_telephone')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_sub_offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('office_name')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_requested_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('scope_type');
            $table->string('scope_name');
            $table->string('other_management_system')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('document_type');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('cb_authorized_persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_parent_organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('parent_organization')->nullable();
            $table->string('relationship')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('ownership_type')->nullable();
            $table->text('ownership_other_description')->nullable();
            $table->string('main_activity')->nullable();
            $table->text('main_activity_description')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_invoice_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('organization')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_consultants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('consultant_name')->nullable();
            $table->string('organization')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        foreach (['cb_management_members', 'cb_permanent_auditors', 'cb_freelance_auditors'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) use ($tableName) {
                $table->id();
                $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
                $table->string('name')->nullable();
                $table->text('qualifications')->nullable();
                if ($tableName === 'cb_management_members') {
                    $table->text('relevant_experience')->nullable();
                } else {
                    $table->string('auditing_field')->nullable();
                    $table->text('audit_experience')->nullable();
                }
                $table->timestamps();
            });
        }

        Schema::create('cb_staff_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('role');
            $table->string('name')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('relevant_experience')->nullable();
            $table->timestamps();
        });

        foreach (['cb_qms_scopes', 'cb_ems_scopes', 'cb_ohs_scopes'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
                $table->string('technical_cluster')->nullable();
                $table->string('iaf_code')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        Schema::create('cb_fsms_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('cluster')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->text('activities')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_mdqms_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('main_technical_area')->nullable();
            $table->string('technical_area')->nullable();
            $table->string('product_category')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_isms_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->text('scope')->nullable();
            $table->string('standard')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_non_compliance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('complies')->nullable();
            $table->text('area_of_non_compliance')->nullable();
            $table->date('rectification_date')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_other_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->string('approval_body_name')->nullable();
            $table->text('address')->nullable();
            $table->text('scope')->nullable();
            $table->string('certificate_number')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });

        Schema::create('cb_declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cb_applications')->cascadeOnDelete();
            $table->boolean('declaration_accepted')->default(false);
            $table->string('applicant_fee_amount')->nullable();
            $table->string('digital_signature_name')->nullable();
            $table->date('signed_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'cb_declarations',
            'cb_other_approvals',
            'cb_non_compliance',
            'cb_isms_scopes',
            'cb_mdqms_scopes',
            'cb_fsms_scopes',
            'cb_ohs_scopes',
            'cb_ems_scopes',
            'cb_qms_scopes',
            'cb_staff_roles',
            'cb_freelance_auditors',
            'cb_permanent_auditors',
            'cb_management_members',
            'cb_consultants',
            'cb_invoice_addresses',
            'cb_parent_organizations',
            'cb_authorized_persons',
            'cb_documents',
            'cb_requested_scopes',
            'cb_sub_offices',
            'cb_contacts',
            'cb_applications',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
