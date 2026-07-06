<form method="POST" action="{{ $stepUrl('step4') }}" class="js-card-form hcb-js-card-form">
    @csrf

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => $scopeTitle,
        'target'   => 'hcbScopeRows',
        'name'     => 'scopes',
        'rows'     => $firstRow($scopes, array_fill_keys(array_keys($scopeCols), '')),
        'columns'  => $scopeCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
