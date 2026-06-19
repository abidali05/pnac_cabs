<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbDeclaration extends Model {
    protected $table = 'hcb_declarations';
    protected $fillable = ['application_id','halal_scope','extension_scope','quality_manual_confirmed','applicant_fee_amount','declaration_accepted','signed_by','signed_date'];
    protected $casts = ['halal_scope'=>'boolean','extension_scope'=>'boolean','quality_manual_confirmed'=>'boolean','declaration_accepted'=>'boolean'];
}
