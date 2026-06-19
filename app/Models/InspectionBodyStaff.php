<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyStaff extends Model
{
    protected $table = 'inspection_body_staff';
    protected $fillable = ['application_id','role','name','qualifications','experience'];
}
