<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbManagementMember extends Model {
    protected $table = 'hcb_management_members';
    protected $fillable = ['application_id','name','religion','qualification','experience'];
}
