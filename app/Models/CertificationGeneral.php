<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationGeneral extends Model
{
    use HasFactory;
    protected $fillable = [
        'application',
        'scheme',
        'cab_name',
        'address',
        'telephone',
        'email',
        'ntn_ftn',
        'website',
        'city',
        'country',
        'postal_code',
        'category',
        'user_id',
        'reference_no',
    ];

    public function declaration()
    {
        return $this->hasOne(CertificationDeclaration::class, 'certification_general_id');
    }

    public function application_statuses()
    {
        return $this->hasOne(ApplicationStatus::class, 'certification_general_id');
    }

    public function certificationBodyApplication()
    {
        return $this->hasOne(CbApplication::class, 'certification_general_id');
    }

    public function certificationBodyStaff()
    {
        return $this->hasMany(CertificationBodyStaff::class, 'certification_general_id');
    }

    public function certificationBodyApprovals()
    {
        return $this->hasMany(CertificationBodyApproval::class, 'certification_general_id');
    }

    public function certificationScopes()
    {
        return $this->hasMany(CertificationScope::class, 'certification_general_id');
    }
}
