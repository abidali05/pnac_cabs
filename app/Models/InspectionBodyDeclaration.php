<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyDeclaration extends Model
{
    protected $table = 'inspection_body_declarations';
    protected $fillable = [
        'application_id','type_a','type_b','type_c','iso17020_compliance',
        'assessment_understanding','agreement_acceptance','quality_manual_attached',
        'document_review_attached','applicant_fee','declaration_name','declaration_date',
    ];
    protected $casts = [
        'type_a'=>'boolean','type_b'=>'boolean','type_c'=>'boolean',
        'iso17020_compliance'=>'boolean','assessment_understanding'=>'boolean',
        'agreement_acceptance'=>'boolean','quality_manual_attached'=>'boolean',
        'document_review_attached'=>'boolean',
    ];
}
