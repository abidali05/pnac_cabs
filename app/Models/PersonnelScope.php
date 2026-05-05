<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'technical_cluster',
        'iaf_code',
        'description_iaf',
        'main_technical',
        'technical_area',
        'product_category',
        'category',
        'scope_type',
        'user_id',
        'certification_general_id',
    ];

    public function general()
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
}
