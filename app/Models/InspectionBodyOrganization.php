<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyOrganization extends Model
{
    protected $table = 'inspection_body_organizations';
    protected $fillable = [
        'application_id','inspection_body_name','address','postcode','telephone','fax',
        'contact_name','designation','contact_address','contact_postcode','contact_tel','contact_fax','contact_email',
        'office_details','new_accreditation','extension_scope',
        'parent_organization','relationship','parent_address','parent_postcode','parent_tel','parent_fax',
        'invoice_organization','invoice_address','invoice_postcode','invoice_tel','invoice_fax',
        'date_of_establishment','legal_status','outside_pakistan','countries_description',
        'inspection_main_activity','activity_description','body_type',
        'consultant_name','consultant_organization','consultant_address','consultant_postcode',
        'consultant_tel','consultant_fax','consultant_email',
    ];
}
