<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationDeclaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'upload_file',
        'application_fee',
        'testing_select',
        'medical_select',
        'other_describe',
        'halal_select',
        'inspection_select',
        'product_select',
        'proficiency_select',
        'category',
        'status',
        'user_id',
        'certification_general_id',
    ];
}
