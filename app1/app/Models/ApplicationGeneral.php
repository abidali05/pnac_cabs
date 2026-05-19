<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisation', 'address_laboratory', 'postcode', 'tel', 'fax', 'contact_name', 'designation',
        'person_address', 'person_postcode', 'person_tel', 'person_fax', 'person_email',
        'chack_calibration', 'chack_laboratory', 'chack_extension', 'chack_permanent',
        'chack_mobile', 'chack_renewal', 'chack_quality', 'chack_participation',
        'chack_plan', 'chack_agreement', 'chack_filled', 'chack_staff', 'chack_applicant',
    ];

    public function Selves()
    {
        return $this->hasOne(ApplicationAboutSelves::class);
    }

    public function Staff()
    {
        return $this->hasOne(ApplicationAboutStaff::class);
    }
    public function Approval()
    {
        return $this->hasOne(ApplicationApproval::class);
    }
    public function Scope()
    {
        return $this->hasOne(ApplicationAboutScope::class);
    }
    public function Declaration()
    {
        return $this->hasOne(ApplicationDeclaration::class);
    }
    public function calibrationFacility()
    {
        return $this->hasOne(ApplicationCalibrationFacility::class);
    }
    public function applicationStatus()
    {
        return $this->hasOne(ApplicationStatus::class);
    }
}
