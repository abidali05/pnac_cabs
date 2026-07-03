<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpScope extends Model
{
    use HasFactory;

    protected $table = 'ptp_scope_of_proficiency_testing';

    protected $fillable = [
        'application_id',
        'item_material_matrix_product',
        'scheme_test_properties',
        'protocol_procedure_technique',
    ];

    public function application()
    {
        return $this->belongsTo(ApplicationForLab::class, 'application_id');
    }

    // Legacy accessors to support view_submited.blade.php seamlessly
    public function getItemMaterialsAttribute()
    {
        return $this->item_material_matrix_product;
    }

    public function getTypeSchemeAttribute()
    {
        return $this->scheme_test_properties;
    }

    public function getSchemeProtocolAttribute()
    {
        return $this->protocol_procedure_technique;
    }
}
