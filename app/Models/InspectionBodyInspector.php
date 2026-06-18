<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyInspector extends Model
{
    protected $table = 'inspection_body_inspectors';
    protected $fillable = ['application_id','name','qualification','inspection_field','inspection_experience'];
}
