<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentPlan extends Model
{
    use HasFactory;

    public function general()
    {
        // return $this->belongsTo(CertificationGeneral::class);
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id', 'id');
    }
    public function cabCycle()
    {
        return $this->belongsTo(CabCycle::class);
    }
    public function assessmentType()
    {
        return $this->belongsTo(AssessmentType::class);
    }
}
