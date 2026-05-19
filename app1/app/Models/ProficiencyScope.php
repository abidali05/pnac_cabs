<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_materials',
        'type_scheme',
        'scheme_protocol',
        'category',
        'type',
        'user_id',
        'certification_general_id',
    ];

    public function general()
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
}
