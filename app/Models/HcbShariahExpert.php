<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbShariahExpert extends Model {
    protected $table = 'hcb_shariah_experts';
    protected $fillable = ['application_id','name','religion','qualification','experience'];
}
