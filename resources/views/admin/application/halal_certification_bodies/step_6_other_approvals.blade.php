<form method="POST" action="{{ $stepUrl('step6') }}" class="js-card-form hcb-js-card-form">
    @csrf

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => $otherTitle,
        'target'   => 'hcbApprovalRows',
        'name'     => 'other_approvals',
        'rows'     => $firstRow($approvals, array_fill_keys(array_keys($otherCols), '')),
        'columns'  => $otherCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
