<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbChiefExecutive extends Model {
    protected $table = 'hcb_chief_executives';
    protected $fillable = ['application_id','name','religion','qualification','experience'];
}
