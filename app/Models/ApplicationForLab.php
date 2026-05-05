<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForLab extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisation', 'address_laboratory', 'postcode', 'tel', 'fax', 'contact_name', 'designation',
        'person_address', 'person_postcode', 'person_tel', 'person_fax', 'person_email',
        'chack_calibration', 'chack_laboratory', 'chack_extension', 'chack_permanent',
        'chack_mobile', 'chack_renewal', 'chack_quality', 'chack_participation',
        'chack_plan', 'chack_agreement', 'chack_filled', 'chack_staff', 'chack_applicant',

        // About YourSelves
        'about', 'selves_title', 'selves_name', 'selves_position', 'selves_parent',
        'selves_parent_organization', 'selves_relationship', 'selves_with_parent',
        'selves_address', 'selves_postcode', 'selves_tel', 'selves_fax',
        'selves_organization_three', 'selves_address_three', 'selves_postcode_three',
        'selves_tel_three', 'selves_fax_three', 'selves_individual', 'selves_public',
        'selves_private', 'selves_learned', 'selves_industry', 'selves_academic',
        'selves_other_describe', 'selves_activities', 'selves_own_organisation',
        'selves_other_organisation', 'selves_name_seven', 'selves_organisation_any',
        'selves_address_seven', 'selves_postcode_seven', 'selves_tel_seven',
        'selves_fax_seven', 'selves_email_seven',

        // About Your Staff
        // 'application_general_id',
        'staff_name',
        'staff_qualifications',
        'staff_relevant',
        'staff_experience',
        'staff_quality_name',
        'staff_quality_qualifications',
        'staff_quality_relevant',
        'staff_quality_experience',
        'staff_measured',
        'staff_range',
        'staff_expanded',
        'staff_technique',

        // Scope Of calibration
        'scop_calib_measurement',
        'scop_calib_range',
        'scop_calib_expanded',
        'scop_calib_technique',



        // Scope Of Application
        // 'application_general_id',
        'scop_materials',
        'scop_types',
        'scop_range',
        'scop_detection',
        'scop_uncertainty',
        'scop_standard',
        'scop_description',
        'scop_working',
        'scop_limit',

        // Approvales
        // 'application_general_id',
        'approvals_name',
        'approvals_scope',
        'approvals_start_date',
        'approvals_end_date',

        // Calibration
        'calibration_fully',
        'calibration_fully_comment',
        'calibration_record',
        'calibration_record_comment',
        'calibration_adequate',
        'calibration_adequate_comment',
        'calibration_procedures',
        'calibration_procedures_comment',
        'calibration_internal',
        'calibration_internal_comment',
        'calibration_pnac',
        'calibration_pnac_comment',
        'calibration_other_comment',
        'calibration_lab_comment',
        'calibration_consider',
        'calibration_compliance',
        'calibration_rectified',

        // Declaration
        'declaration_calibration',
        'declaration_testing',
        'declaration_extension',
        'declaration_laboratory',
        'declaration_test_lab',
        'signed',
        'date',
        'category',
        'user_id',
    ];
}
