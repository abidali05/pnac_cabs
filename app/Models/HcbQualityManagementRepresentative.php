<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbQualityManagementRepresentative extends Model {
    protected $table = 'hcb_quality_management_representatives';
    protected $fillable = ['application_id','name','religion','qualification','experience'];
}
