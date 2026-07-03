<?php

namespace App\Factories;

use App\Models\CalibrationScope;
use App\Models\CertificationScope;
use App\Models\HalalScope;
use App\Models\MedicalScope;
use App\Models\InspectionScope;
use App\Models\PersonnelCertificationScope;
use App\Models\PersonnelScope;
use App\Models\ProductScope;
use App\Models\ProficiencyScope;
use App\Models\TestingScope;

// Add all other scope models as needed

class ScopeFactory
{
    public static function getScopes($category, $general_id, $scopeType = null)
    {
        // dd($general_id);
        switch ($category) {


            case 'Certification Bodies':
                return CertificationScope::with('technicalCluster', 'mainTechnical', 'technicalArea', 'cluster', 'category')->get();

            case 'Testing':
                return TestingScope::where('certification_general_id', $general_id)->get();

            case 'Calibration':
            return CalibrationScope::where('certification_general_id', $general_id)->get();

            case 'Medical Laboratories':
            return MedicalScope::where('certification_general_id', $general_id)->get();

            case 'Inspection Bodies':
            return InspectionScope::where('certification_general_id', $general_id)->get();

            case 'Halal Certification Bodies':
            return HalalScope::where('certification_general_id', $general_id)->get();

            case 'Proficiency Testing Provider':
            return ProficiencyScope::where('certification_general_id', $general_id)->get();

            case 'Product Certification Bodies':
            return ProductScope::where('certification_general_id', $general_id)->get();

            case 'Personnel Certification Bodies':
            return PersonnelScope::where('certification_general_id', $general_id)->where('scope_type', $scopeType)->get();

            default:
                return collect(); // return empty collection for unknown categories
        }
    }
}
