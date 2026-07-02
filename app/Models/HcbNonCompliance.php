<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbNonCompliance extends Model {
    protected $table = 'hcb_non_compliances';
    protected $fillable = ['application_id','area_of_non_compliance','rectified_by_date'];
}
