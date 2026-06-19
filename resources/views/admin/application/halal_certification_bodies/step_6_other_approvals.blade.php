<form method="POST" action="{{ $stepUrl('step6') }}" class="js-card-form hcb-js-card-form">
    @csrf

    @include('admin.application.certification_bodies._repeatable_table', [
        'title'    => 'Other Approvals / Existing Certificates',
        'target'   => 'hcbApprovalRows',
        'name'     => 'other_approvals',
        'rows'     => $firstRow($approvals, [
            'approval_body_name'    => '',
            'approval_body_address' => '',
            'scope'                 => '',
            'certificate_number'    => '',
            'start_date'            => '',
            'expiry_date'           => '',
        ]),
        'columns'  => [
            'approval_body_name'    => 'Approval Body Name',
            'approval_body_address' => 'Address',
            'scope'                 => 'Scope',
            'certificate_number'    => 'Certificate No.',
            'start_date'            => 'Start Date',
            'expiry_date'           => 'Expiry Date',
        ],
        'isLocked' => $isLocked,
    ])

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
