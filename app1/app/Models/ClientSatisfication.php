<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSatisfication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organization',
        'accredited',
        'government_req',
        'customer_demand',
        'purpose',
        'business_purpose',
        'accredited_general',
        'other_reason',
        'reports',
        'excepted',
        'outcome',
        'system_improved',
        'clientage',
        'government_regarding',
        'suggestion',
        'date',
        'extended_scope',
        'aproximately',
        'scope_reason',
        'suspended',
        'performance',
        'status_pnac',
        'disciplines',
        'user_id',
    ];

    protected $casts = [
        'government_req' => 'array',
        'customer_demand' => 'array',
        'scope_reason' => 'array',
    ];
}
