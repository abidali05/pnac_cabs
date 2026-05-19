<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationCalibrationFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_general_id',
        'calibration_fully',
        'calibration_fully_comment',
        'calibration_record',
        'calibration_record_comment',
        'calibration_adequate',
        'calibration_adequate_comment',
        'calibration_procedures',
        'calibration_procedures_comment',
        'calibration_internal',
        'calibration_internal_comment',
        'calibration_pnac',
        'calibration_pnac_comment',
        'calibration_other_comment',
        'calibration_lab_comment',
        'calibration_consider',
        'calibration_compliance',
        'calibration_rectified',
    ];


    public function general()
    {
        return $this->belongsTo(ApplicationGeneral::class, 'application_general_id');
    }
}
