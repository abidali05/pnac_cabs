<form method="POST" action="{{ route('inspection-body.step3.save', ['application' => $application->id]) }}"
      class="js-card-form ib-js-card-form">
    @csrf

    {{-- Scope of Inspection --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => $scopeTitle,
        'target'   => 'ibScopeRows',
        'name'     => 'scopes',
        'rows'     => $firstRow($scopes, array_fill_keys(array_keys($scopeCols), '')),
        'columns'  => $scopeCols,
        'isLocked' => $isLocked,
    ])

    {{-- Equipment --}}
    @include('application.certification_bodies.inspection_body._repeatable_table', [
        'title'    => $equipTitle,
        'target'   => 'ibEquipRows',
        'name'     => 'equipment',
        'rows'     => $firstRow($equipment, array_fill_keys(array_keys($equipCols), '')),
        'columns'  => $equipCols,
        'isLocked' => $isLocked,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
