<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationEmployee extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_name',
        'designation',
        'address',
        'telephone',
        'email',
        'employee_type',
        'category',
        'user_id',
        'certification_general_id',
    ];

    public function general()
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
}
