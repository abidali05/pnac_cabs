<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbExternalAuditor extends Model {
    protected $table = 'hcb_external_auditors';
    protected $fillable = ['application_id','name','religion','qualification','auditing_field','audit_experience'];
}
