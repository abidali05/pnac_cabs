<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory22000 extends Model
{
    use HasFactory;

    protected $fillable = ['sub_name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category22000::class, 'category_id');
    }
}
