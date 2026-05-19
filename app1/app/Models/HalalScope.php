<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalalScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_code',
        'scope_category',
        'subcategory',
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
