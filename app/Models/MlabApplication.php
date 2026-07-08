<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlabApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_no',
        'scheme_name',
        'organisation_name',
        'lab_address',
        'status',
        'created_by',
        'submitted_at',
        'certification_general_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function certificationGeneral(): BelongsTo
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
}
