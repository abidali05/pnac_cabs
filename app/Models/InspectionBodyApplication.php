<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InspectionBodyApplication extends Model
{
    protected $fillable = [
        'application_no',
        'scheme_name',
        'application_type',
        'status',
        'created_by',
        'submitted_at',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function organization(): HasOne
    {
        return $this->hasOne(InspectionBodyOrganization::class, 'application_id');
    }

    public function staff(): HasMany
    {
        return $this->hasMany(InspectionBodyStaff::class, 'application_id');
    }

    public function inspectors(): HasMany
    {
        return $this->hasMany(InspectionBodyInspector::class, 'application_id');
    }

    public function scopes(): HasMany
    {
        return $this->hasMany(InspectionBodyScope::class, 'application_id');
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(InspectionBodyEquipment::class, 'application_id');
    }

    public function declaration(): HasOne
    {
        return $this->hasOne(InspectionBodyDeclaration::class, 'application_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(InspectionBodyDocument::class, 'application_id');
    }
}
