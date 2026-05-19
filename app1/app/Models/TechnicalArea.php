<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_technical13485_id',
        'technical_area',
    ];
    public function mainTechnical13485()
    {
        return $this->belongsTo(MainTechnical13485::class, 'main_technical13485_id');
    }
}
