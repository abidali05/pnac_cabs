<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbAboutHcb extends Model { protected $table='hcb_about_hcb'; protected $fillable=['application_id','title','name','position','parent_organization','relationship','parent_address','parent_postcode','parent_telephone','parent_fax','invoice_organization','invoice_address','invoice_postcode','invoice_telephone','invoice_fax','ownership_type','other_description','is_halal_main_activity','activity_description','consultant_name','consultant_organization','consultant_address','consultant_postcode','consultant_tel','consultant_fax','consultant_email']; }
class HcbChiefExecutive extends Model { protected $table='hcb_chief_executives'; protected $fillable=['application_id','name','religion','qualification','experience']; }
class HcbShariahExpert extends Model { protected $table='hcb_shariah_experts'; protected $fillable=['application_id','name','religion','qualification','experience']; }
class HcbQualityManagementRepresentative extends Model { protected $table='hcb_quality_management_representatives'; protected $fillable=['application_id','name','religion','qualification','experience']; }
class HcbManagementMember extends Model { protected $table='hcb_management_members'; protected $fillable=['application_id','name','religion','qualification','experience']; }
class HcbPermanentAuditor extends Model { protected $table='hcb_permanent_auditors'; protected $fillable=['application_id','name','religion','qualification','auditing_field','audit_experience']; }
class HcbExternalAuditor extends Model { protected $table='hcb_external_auditors'; protected $fillable=['application_id','name','religion','qualification','auditing_field','audit_experience']; }
class HcbScope extends Model { protected $table='hcb_scopes'; protected $fillable=['application_id','category_code','category','subcategory','included_activities']; }
class HcbQualitySystem extends Model { protected $table='hcb_quality_system'; protected $fillable=['application_id','question_code','answer','comments']; }
class HcbNonCompliance extends Model { protected $table='hcb_non_compliances'; protected $fillable=['application_id','area_of_non_compliance','rectified_by_date']; }
class HcbOtherApproval extends Model { protected $table='hcb_other_approvals'; protected $fillable=['application_id','approval_body_name','approval_body_address','scope','certificate_number','start_date','expiry_date']; }
class HcbDeclaration extends Model { protected $table='hcb_declarations'; protected $casts=['halal_scope'=>'boolean','extension_scope'=>'boolean','quality_manual_confirmed'=>'boolean','declaration_accepted'=>'boolean']; protected $fillable=['application_id','halal_scope','extension_scope','quality_manual_confirmed','applicant_fee_amount','declaration_accepted','signed_by','signed_date']; }
class HcbDocument extends Model { protected $table='hcb_documents'; protected $fillable=['application_id','document_type','file_name','original_name','file_path','mime_type','uploaded_by']; }
