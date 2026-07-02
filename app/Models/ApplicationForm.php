<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $table = 'application_forms';

    protected $fillable = [
        'application_name',
        'slug',
        'description',
        'status',
        'form_schema',
    ];

    protected $casts = [
        'form_schema' => 'array',
    ];
}
