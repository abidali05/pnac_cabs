<?php

namespace App\Factories;

use App\Models\CertificationEmployee;
use App\Models\DocumentDetail;
use App\Models\CertificationScope;
use App\Models\TestingScope;
use App\Models\CalibrationScope;
use App\Models\MedicalScope;
use App\Models\HalalScope;
use App\Models\InspectionScope;
use App\Models\ProductScope;
use App\Models\ProficiencyScope;

class ScopeFetcher
{
    public static function getAllByGeneralId($generalId)
    {
        return [
            'employees'    => CertificationEmployee::where('certification_general_id', $generalId)->get(),
            'documents'    => DocumentDetail::where('certification_general_id', $generalId)->get(),

            // ISO Scopes
            'ISO9001'      => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO9001')->get(),
            'ISO14001'     => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO14001')->get(),
            'ISO45001'     => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO45001')->get(),
            'ISO13485'     => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO13485')->get(),
            'ISO22000'     => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO22000')->get(),

            // Other scope types
            'testing'      => TestingScope::where('certification_general_id', $generalId)->get(),
            'calibration'  => CalibrationScope::where('certification_general_id', $generalId)->get(),
            'medical'      => MedicalScope::where('certification_general_id', $generalId)->get(),
            'halal'        => HalalScope::where('certification_general_id', $generalId)->get(),
            'inspection'   => InspectionScope::where('certification_general_id', $generalId)->get(),
            'product'      => ProductScope::where('certification_general_id', $generalId)->get(),
            'proficiency'  => ProficiencyScope::where('certification_general_id', $generalId)->get(),
        ];
    }


    public static function getScopesByCategory($category, $generalId)
{
    switch ($category) {
        case 'Certification Bodies':
            return [
                'ISO9001'  => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO9001')->get(),
                'ISO14001' => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO14001')->get(),
                'ISO45001' => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO45001')->get(),
                'ISO13485' => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO13485')->get(),
                'ISO22000' => CertificationScope::where('certification_general_id', $generalId)->where('scope_type', 'ISO22000')->get(),
            ];

        case 'Halal Certification Bodies':
            return [
                'halal' => HalalScope::where('certification_general_id', $generalId)->get(),
            ];

        case 'Testing Calibration Laboratories':
            return [
                'testing' => TestingScope::where('certification_general_id', $generalId)->get(),
                'calibration' => CalibrationScope::where('certification_general_id', $generalId)->get(),
                'testing_calibration' => TestingScope::where('certification_general_id', $generalId)->get()
                    ->merge(CalibrationScope::where('certification_general_id', $generalId)->get()),
            ];

        case 'Testing':
            return [
                'testing' => TestingScope::where('certification_general_id', $generalId)->get(),
            ];

        case 'Calibration':
            return [
                'calibration' => CalibrationScope::where('certification_general_id', $generalId)->get(),
            ];
        // case 'Calibration':
        // case 'Testing Calibration Laboratories':
        //     return [
        //         'calibration' => CalibrationScope::where('certification_general_id', $generalId)->get(),
        //         'testing_calibration' => CalibrationScope::where('certification_general_id', $generalId)->get(),
        //     ];

        // case 'Testing':
        // case 'Testing Calibration Laboratories':
        //     return [
        //         'testing' => TestingScope::where('certification_general_id', $generalId)->get(),
        //         'testing_calibration' => TestingScope::where('certification_general_id', $generalId)->get(),
        //     ];


        case 'Medical Laboratories':
            return [
                'medical' => MedicalScope::where('certification_general_id', $generalId)->get(),
            ];

        case 'Inspection Bodies':
            return [
                'inspection' => InspectionScope::where('certification_general_id', $generalId)->get(),
            ];

        case 'Product Certification Bodies':
            return [
                'product' => ProductScope::where('certification_general_id', $generalId)->get(),
            ];

        case 'Proficiency Testing Provider':
            return [
                'proficiency' => ProficiencyScope::where('certification_general_id', $generalId)->get(),
            ];

        default:
            return [];
    }
}

}
