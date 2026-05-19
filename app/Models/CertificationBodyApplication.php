<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationBodyApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'certification_general_id',
        'user_id',
        'contact_name',
        'contact_designation',
        'contact_address',
        'contact_postcode',
        'contact_tel',
        'contact_fax',
        'contact_email',
        'sub_offices_details',
        'is_new_accreditation',
        'is_extension_scope',
        'qms',
        'ems',
        'fsms',
        'iso_45001',
        'iso_13485',
        'other_management_system',
        'other_management_system_detail',
        'enclosed_quality_manual',
        'enclosed_quality_procedures',
        'enclosed_staff_list',
        'enclosed_certified_organizations',
        'enclosed_applicant_fee',
        'enclosed_legal_entity',
        'enclosed_f0229_document_review',
        'director_title',
        'director_name',
        'director_position',
        'parent_organization',
        'parent_relationship',
        'parent_address',
        'parent_postcode',
        'parent_tel',
        'parent_fax',
        'invoice_organisation',
        'invoice_address',
        'invoice_postcode',
        'invoice_tel',
        'invoice_fax',
        'ownership_type',
        'ownership_other',
        'certification_main_activity',
        'main_activity_description',
        'consultant_name',
        'consultant_organisation',
        'consultant_address',
        'consultant_postcode',
        'consultant_tel',
        'consultant_fax',
        'consultant_email',
        'quality_system_complies',
        'non_compliance_area',
        'rectified_by_date',
        'declaration_scope_applied',
        'declaration_agreement',
        'declaration_documents_enclosed',
        'declaration_fee_enclosed',
        'declaration_understands_system',
        'declaration_information_correct',
        'application_fee',
        'signed',
        'signed_date',
    ];
}

