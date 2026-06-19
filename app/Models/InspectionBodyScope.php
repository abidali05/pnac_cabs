<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyScope extends Model
{
    protected $table = 'inspection_body_scopes';
    protected $fillable = ['application_id','description_of_inspection','type_and_range','methods_and_procedures'];
}
