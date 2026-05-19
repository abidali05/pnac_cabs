<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAboutStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_general_id',
        'staff_name',
        'staff_qualifications',
        'staff_relevant',
        'staff_experience',
        'staff_quality_name',
        'staff_quality_qualifications',
        'staff_quality_relevant',
        'staff_quality_experience',
        'staff_measured',
        'staff_range',
        'staff_expanded',
        'staff_technique',
    ];

    public function general()
    {
        return $this->belongsTo(ApplicationGeneral::class, 'application_general_id');
    }
}
