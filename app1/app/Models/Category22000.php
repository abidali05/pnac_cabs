<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category22000 extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'cluster_id',
    ];
    public function cluster()
    {
        return $this->belongsTo(Cluster22000::class, 'cluster_id');
    }
}
