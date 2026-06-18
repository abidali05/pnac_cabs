<form method="POST" action="{{ $stepUrl('step3') }}" class="js-card-form hcb-js-card-form">
    @csrf

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => '3.1 Chief Executive(s)',
        'target'   => 'hcbChiefExecRows',
        'name'     => 'chief_executives',
        'rows'     => $firstRow($chiefExecs, array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => '3.2 Shariah Expert(s)',
        'target'   => 'hcbShariahRows',
        'name'     => 'shariah_experts',
        'rows'     => $firstRow($shariahExp, array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => '3.3 Quality Management Representative(s)',
        'target'   => 'hcbQualityRepRows',
        'name'     => 'quality_reps',
        'rows'     => $firstRow($qualityReps, array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => '3.4 Management Members',
        'target'   => 'hcbMgmtMemberRows',
        'name'     => 'management_members',
        'rows'     => $firstRow($mgmtMembers, array_fill_keys(array_keys($staffCols), '')),
        'columns'  => $staffCols,
        'isLocked' => $isLocked,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => '3.5 Permanent Auditors',
        'target'   => 'hcbPermAuditorRows',
        'name'     => 'permanent_auditors',
        'rows'     => $firstRow($permAuditors, array_fill_keys(array_keys($auditorCols), '')),
        'columns'  => $auditorCols,
        'isLocked' => $isLocked,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => '3.6 External / Subcontracted Auditors',
        'target'   => 'hcbExtAuditorRows',
        'name'     => 'external_auditors',
        'rows'     => $firstRow($extAuditors, array_fill_keys(array_keys($auditorCols), '')),
        'columns'  => $auditorCols,
        'isLocked' => $isLocked,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
