<form method="POST" action="{{ route('inspection-body.step2.save', ['application' => $application->id]) }}"
      class="js-card-form ib-js-card-form">
    @csrf

    {{-- Chief Executive --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Chief Executive',
        'target'   => 'ibChiefRows',
        'name'     => 'chief_executive',
        'rows'     => $firstRow($staffRoles->get('Chief Executive', collect()), array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
        'allowAdd' => false,
    ])

    {{-- Quality Management Representative --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Quality Management Representative',
        'target'   => 'ibQualityRows',
        'name'     => 'quality_representative',
        'rows'     => $firstRow($staffRoles->get('Quality Management Representative', collect()), array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
        'allowAdd' => false,
    ])

    {{-- Management Members --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Management Members',
        'target'   => 'ibMgmtRows',
        'name'     => 'management_members',
        'rows'     => $firstRow($mgmtMembers, array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
    ])

    {{-- Permanent Inspectors --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Permanent Inspectors',
        'target'   => 'ibPermInspRows',
        'name'     => 'permanent_inspectors',
        'rows'     => $firstRow($inspectors, array_fill_keys(array_keys($inspCols), '')),
        'columns'  => $inspCols,
        'isLocked' => $isLocked,
    ])

    {{-- Freelance Inspectors --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => 'Freelance / Subcontracted Inspectors',
        'target'   => 'ibFreelanceRows',
        'name'     => 'freelance_inspectors',
        'rows'     => $firstRow($freelance, array_fill_keys(array_keys($inspCols), '')),
        'columns'  => $inspCols,
        'isLocked' => $isLocked,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
