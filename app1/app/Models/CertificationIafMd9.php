<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationIafMd9 extends Model
{
    use HasFactory;

    protected $fillable = [
        'technical_area_id',
        'main_technical13485s_id',
        'description',
    ];
    public function technicalArea()
    {
        return $this->belongsTo(TechnicalArea::class, 'technical_area_id');
    }

    public function mainTechnical13485()
    {
        return $this->belongsTo(MainTechnical13485::class, 'main_technical13485s_id');
    }
}

