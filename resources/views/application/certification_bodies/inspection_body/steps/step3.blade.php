<form method="POST" action="{{ route('inspection-body.step3.save', ['application' => $application->id]) }}"
      class="js-card-form ib-js-card-form">
    @csrf

    {{-- Scope of Inspection --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Scope of Inspection',
        'target'   => 'ibScopeRows',
        'name'     => 'scopes',
        'rows'     => $firstRow($scopes, ['description_of_inspection' => '', 'type_and_range' => '', 'methods_and_procedures' => '']),
        'columns'  => [
            'description_of_inspection' => 'Description of Inspection',
            'type_and_range'            => 'Type and Range',
            'methods_and_procedures'    => 'Methods and Procedures',
        ],
        'isLocked' => $isLocked,
    ])

    {{-- Equipment --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Equipment',
        'target'   => 'ibEquipRows',
        'name'     => 'equipment',
        'rows'     => $firstRow($equipment, ['equipment_name' => '', 'calibration_organization' => '', 'calibration_frequency' => '', 'last_calibration_date' => '']),
        'columns'  => [
            'equipment_name'          => 'Equipment Name',
            'calibration_organization'=> 'Calibration Organization',
            'calibration_frequency'   => 'Calibration Frequency',
            'last_calibration_date'   => 'Last Calibration Date',
        ],
        'isLocked' => $isLocked,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
