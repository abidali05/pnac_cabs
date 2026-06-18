<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationBodyApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'certification_general_id',
        'user_id',
        'approval_body_name_address',
        'scope_certificate_no',
        'start_date',
        'expiry_date',
    ];
}

