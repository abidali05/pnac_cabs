<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationBodyStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'certification_general_id',
        'user_id',
        'staff_type',
        'name',
        'qualifications',
        'relevant_experience',
        'auditing_field',
        'audit_experience',
        'sort_order',
    ];
}

