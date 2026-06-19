<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbScope extends Model {
    protected $table = 'hcb_scopes';
    protected $fillable = ['application_id','category_code','category','subcategory','included_activities'];
}
