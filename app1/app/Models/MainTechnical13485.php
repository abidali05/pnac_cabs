<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainTechnical13485 extends Model
{
    use HasFactory;

    public function technicalAreas()
    {
        return $this->hasMany(TechnicalArea::class, 'main_technical13485_id');
    }
}
