<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesssorUser extends Model
{
    use HasFactory;

    public function assessmentPlan()
    {
        return $this->belongsTo(AssessmentPlan::class);
    }
}
