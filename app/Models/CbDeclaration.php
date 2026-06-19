<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbDeclaration extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'declaration_accepted' => 'boolean',
        'signed_date' => 'date',
    ];
}
