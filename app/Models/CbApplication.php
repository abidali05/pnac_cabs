<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CbApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_no',
        'scheme_name',
        'application_type',
        'organization_name',
        'accreditation_type',
        'status',
        'submitted_at',
        'created_by',
        'certification_general_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function certificationGeneral(): BelongsTo
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contact(): HasOne
    {
        return $this->hasOne(CbContact::class, 'application_id');
    }

    public function subOffices(): HasMany
    {
        return $this->hasMany(CbSubOffice::class, 'application_id');
    }

    public function requestedScopes(): HasMany
    {
        return $this->hasMany(CbRequestedScope::class, 'application_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CbDocument::class, 'application_id');
    }

    public function declaration(): HasOne
    {
        return $this->hasOne(CbDeclaration::class, 'application_id');
    }
}
