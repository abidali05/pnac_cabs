<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbOtherApproval extends Model {
    protected $table = 'hcb_other_approvals';
    protected $fillable = ['application_id','approval_body_name','approval_body_address','scope','certificate_number','start_date','expiry_date'];
}
