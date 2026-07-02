<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyEquipment extends Model
{
    protected $table = 'inspection_body_equipment';
    protected $fillable = ['application_id','equipment_name','calibration_organization','calibration_frequency','last_calibration_date'];
}
