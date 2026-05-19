<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAboutScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_general_id',
        'scop_materials',
        'scop_types',
        'scop_range',
        'scop_detection',
        'scop_uncertainty',
        'scop_standard',
        'scop_description',
        'scop_working',
        'scop_limit',
    ];



    public function general()
    {
        return $this->belongsTo(ApplicationGeneral::class, 'application_general_id');
    }
}
