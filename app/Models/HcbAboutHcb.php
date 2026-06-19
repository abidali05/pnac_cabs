<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbAboutHcb extends Model {
    protected $table = 'hcb_about_hcb';
    protected $fillable = ['application_id','title','name','position','parent_organization','relationship','parent_address','parent_postcode','parent_telephone','parent_fax','invoice_organization','invoice_address','invoice_postcode','invoice_telephone','invoice_fax','ownership_type','other_description','is_halal_main_activity','activity_description','consultant_name','consultant_organization','consultant_address','consultant_postcode','consultant_tel','consultant_fax','consultant_email'];
}
