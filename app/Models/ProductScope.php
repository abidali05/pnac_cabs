<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'product',
        'standard',
        'type_scheme',
        'countries',
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
