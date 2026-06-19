<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbPermanentAuditor extends Model {
    protected $table = 'hcb_permanent_auditors';
    protected $fillable = ['application_id','name','religion','qualification','auditing_field','audit_experience'];
}
