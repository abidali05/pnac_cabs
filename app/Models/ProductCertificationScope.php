<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCertificationScope extends Model
{
    use HasFactory;

    protected $table = 'pcb_scope_of_certification';

    protected $fillable = [
        'application_id',
        'product',
        'standard',
        'countries',
    ];

    public function application()
    {
        return $this->belongsTo(ApplicationForLab::class, 'application_id');
    }

    // Legacy accessor to support view_submited.blade.php seamlessly
    public function getTypeSchemeAttribute()
    {
        return '-';
    }
}
