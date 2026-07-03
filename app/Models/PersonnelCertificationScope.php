<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelCertificationScope extends Model
{
    use HasFactory;

    protected $table = 'personnel_certification_scopes';

    protected $fillable = [
        'application_id',
        'technical_cluster',
        'description_iaf',
    ];

    public function application()
    {
        return $this->belongsTo(ApplicationForLab::class, 'application_id');
    }
}
