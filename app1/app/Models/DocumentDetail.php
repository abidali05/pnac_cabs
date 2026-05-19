<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentDetail extends Model
{
    use HasFactory;

    // protected $guarded = [];
     protected $fillable = [
        'user_id',
        'category',
        'upload_doc',
        'name',
        'number',
        'document_id',
        'certification_general_id',
     ];

     public function general()
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
}
