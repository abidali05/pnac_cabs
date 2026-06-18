<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbQualitySystem extends Model {
    protected $table = 'hcb_quality_system';
    protected $fillable = ['application_id','question_code','answer','comments'];
}
