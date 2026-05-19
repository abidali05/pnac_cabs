<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TechnicalCluster;

class FirstIafCode extends Model
{
    use HasFactory;

    public function technicalCluster()
    {
        return $this->belongsTo(TechnicalCluster::class, 'technical_cluster');
    }
}
