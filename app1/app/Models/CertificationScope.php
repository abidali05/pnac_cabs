<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'technical_cluster_id',
        'iaf_code',
        'description',
        'main_technical_id',
        'technical_area',
        'cluster_id',
        'cluster_cat',
        'cluster_sub_cat',
        'category',
        'scope_type',
        'user_id',
        'certification_general_id',
        // ISO 9001
        // 'scop_technical_a',
        // 'scop_iaf_a',
        // 'scop_economic_a',

        // // ISO 14001
        // 'scop_technical_b',
        // 'scop_iaf_b',
        // 'scop_economic_b',

        // // ISO 45001
        // 'scop_technical_c',
        // 'scop_iaf_c',
        // 'scop_economic_c',

        // // ISO 13485
        // 'scop_main_tech',
        // 'scop_areas',
        // 'scop_product',

        // // ISO 22000
        // 'scop_cluster',
        // 'scop_category',
        // 'scop_subcategory',
        // 'scop_activity',
        // 'category',
        // 'scope_type',
        // 'user_id',
        // 'certification_general_id',
    ];

    public function general()
    {
        return $this->belongsTo(CertificationGeneral::class, 'certification_general_id');
    }
    public function technicalCluster()
    {
        return $this->belongsTo(TechnicalCluster::class, 'technical_cluster_id');
    }

    public function mainTechnical()
    {
        return $this->belongsTo(MainTechnical13485::class, 'main_technical_id');
    }
    public function technicalArea()
    {
        return $this->belongsTo(TechnicalArea::class, 'technical_area');
    }
    public function cluster()
    {
        return $this->belongsTo(Cluster22000::class, 'cluster_id');
    }
    public function category()
    {
        return $this->belongsTo(Category22000::class, 'cluster_cat');
    }

}
