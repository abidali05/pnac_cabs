<form method="POST" action="{{ $stepUrl('step3') }}" class="js-card-form hcb-js-card-form">
    @csrf

    @include('admin.application.certification_bodies._repeatable_table', [
        'title' => $ceTitle,
        'target' => 'hcbChiefExecRows',
        'name' => 'chief_executives',
        'rows' => $firstRow($chiefExecs, array_fill_keys(array_keys($ceCols), '')),
        'columns' => $ceCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title' => $seTitle,
        'target' => 'hcbShariahRows',
        'name' => 'shariah_experts',
        'rows' => $firstRow($shariahExp, array_fill_keys(array_keys($seCols), '')),
        'columns' => $seCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title' => $qmrTitle,
        'target' => 'hcbQualityRepRows',
        'name' => 'quality_reps',
        'rows' => $firstRow($qualityReps, array_fill_keys(array_keys($qmrCols), '')),
        'columns' => $qmrCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title' => $mgmtTitle,
        'target' => 'hcbMgmtMemberRows',
        'name' => 'management_members',
        'rows' => $firstRow($mgmtMembers, array_fill_keys(array_keys($mgmtCols), '')),
        'columns' => $mgmtCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title' => $permTitle,
        'target' => 'hcbPermAuditorRows',
        'name' => 'permanent_auditors',
        'rows' => $firstRow($permAuditors, array_fill_keys(array_keys($permCols), '')),
        'columns' => $permCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    @include('admin.application.certification_bodies._repeatable_table', [
        'title' => $extTitle,
        'target' => 'hcbExtAuditorRows',
        'name' => 'external_auditors',
        'rows' => $firstRow($extAuditors, array_fill_keys(array_keys($extCols), '')),
        'columns' => $extCols,
        'isLocked' => $isLocked,
        'allowMultiple' => true,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
