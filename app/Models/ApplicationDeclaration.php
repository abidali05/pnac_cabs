<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDeclaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_general_id',
        'declaration_calibration',
        'declaration_testing',
        'declaration_extension',
        'declaration_laboratory',
        'declaration_test_lab',
        'signed',
        'date',
    ];

    public function general()
    {
        return $this->belongsTo(ApplicationGeneral::class, 'application_general_id');
    }
}
