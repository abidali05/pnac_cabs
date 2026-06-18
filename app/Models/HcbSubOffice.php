<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HcbSubOffice extends Model {
    protected $table = 'hcb_sub_offices';
    protected $fillable = ['application_id','office_name','city','address'];
}
