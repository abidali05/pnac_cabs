@php
    $currentEditSection = request('edit_section');
    $openSection = session('open_section') ?: request('open_section') ?: $currentEditSection ?: 'basic_info';
    $saved = $cbData['saved_sections'] ?? [];
    $isLocked = !empty($cbApplication) && $cbApplication->status === 'Submitted';

    $isSaved = fn(string $section) => (bool) ($saved[$section] ?? false);
    $isEditing = fn(string $section) => !$isLocked && ($currentEditSection === $section || !$isSaved($section));
    $sectionUrl = fn(string $section) => route('application.certification.save-section', [
        'cbApplication' => $cbApplication->id,
        'section' => $section,
        'scheme_name' => request('scheme_name'),
        'application' => request('application'),
    ]);
    $editUrl = fn(string $section) => route('application.create', [
        'scheme_name' => request('scheme_name'),
        'application' => request('application'),
        'edit_section' => $section,
    ]);
    $firstRow = fn($rows, $fallback = []) => $rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()
        ? $rows
        : collect([$fallback]);
    $value = fn($row, string $field) => is_array($row) ? $row[$field] ?? '' : $row->{$field} ?? '';

    $requiredDocuments = [
        'Quality Manual',
        'Quality Procedures',
        'Staff List',
        'Certified Organizations List',
        'Applicant Fee Evidence',
        'Legal Entity Proof',
        'F-02/29 Form',
    ];
    $documentsByType = ($cbData['documents'] ?? collect())->keyBy('document_type');
    $scopeGroups = [
        'qms_scopes' => [
            'title' => 'QMS ISO 9001',
            'target' => 'cbScopeQmsRows',
            'columns' => [
                'technical_cluster' => 'Technical Cluster',
                'iaf_code' => 'IAF Code',
                'description' => 'Description',
            ],
        ],
        'ems_scopes' => [
            'title' => 'EMS ISO 14001',
            'target' => 'cbScopeEmsRows',
            'columns' => [
                'technical_cluster' => 'Technical Cluster',
                'iaf_code' => 'IAF Code',
                'description' => 'Description',
            ],
        ],
        'ohs_scopes' => [
            'title' => 'OH&S ISO 45001',
            'target' => 'cbScopeOhsRows',
            'columns' => [
                'technical_cluster' => 'Technical Cluster',
                'iaf_code' => 'IAF Code',
                'description' => 'Description',
            ],
        ],
        'fsms_scopes' => [
            'title' => 'FSMS ISO 22000',
            'target' => 'cbScopeFsmsRows',
            'columns' => [
                'cluster' => 'Cluster',
                'category' => 'Category',
                'sub_category' => 'Sub Category',
                'activities' => 'Activities',
            ],
        ],
        'mdqms_scopes' => [
            'title' => 'MD-QMS ISO 13485',
            'target' => 'cbScopeMdqmsRows',
            'columns' => [
                'main_technical_area' => 'Main Technical Area',
                'technical_area' => 'Technical Area',
                'product_category' => 'Product Category',
            ],
        ],
        'isms_scopes' => [
            'title' => 'ISMS ISO 27001',
            'target' => 'cbScopeIsmsRows',
            'columns' => ['scope' => 'Scope', 'standard' => 'Standard'],
        ],
    ];

    $renderDetails = function (array $items) {
        echo '<div class="details-grid">
';
        foreach ($items as $label => $itemValue) {
            echo '<div class="detail-item"><span class="detail-label">' .
                e($label) .
                ':</span><span class="detail-value">' .
                e($itemValue ?: '-') .
                '</span></div>';
        }
        echo '</div>';
    };
    $renderTable = function ($rows, array $columns) use ($value) {
        echo '<div class="table-responsive"><table class="table table-bordered align-middle"><thead><tr>';
        foreach ($columns as $label) {
            echo '<th>' . e($label) . '</th>';
        }
        echo '</tr></thead><tbody>';
        if ($rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()) {
            foreach ($rows as $row) {
                echo '<tr>';
                foreach ($columns as $field => $label) {
                    echo '<td>' . e($value($row, $field) ?: '-') . '</td>';
                }
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="' . count($columns) . '" class="text-muted">No records saved.</td></tr>';
        }
        echo '</tbody></table></div>';
    };
@endphp

<div class="pnac-vertical-form cb-application-form w-100">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h4 class="mb-0 text-success">Certification Bodies Accreditation Application</h4>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success">{{ $cbApplication->status }}</span>
            {{-- <span class="badge bg-light text-dark">{{ $cbApplication->application_no ?: 'Draft' }}</span> --}}
        </div>
    </div>

    <div id="pnacVerticalForm">
        {{-- Step 1 --}}
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-basic-card" data-section="basic_info"
            data-open="{{ $openSection === 'basic_info' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 1: Basic Application Information</h5>
                    <p class="text-muted mb-0">Application identity and status.</p>
                </div>
                <span
                    class="badge {{ $isSaved('basic_info') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('basic_info') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('basic_info'))
                <form method="POST" action="{{ $sectionUrl('basic_info') }}" class="js-card-form cb-js-card-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Scheme Name</label><input class="form-control"
                                name="scheme_name" value="{{ old('scheme_name', $cbApplication->scheme_name) }}"
                                required></div>
                        <div class="col-md-4"><label class="form-label">Application Type</label><input
                                class="form-control" name="application_type"
                                value="{{ old('application_type', $cbApplication->application_type) }}" required></div>
                        <div class="col-md-4"><label class="form-label">Application Number</label><input
                                class="form-control" name="application_no"
                                value="{{ old('application_no', $cbApplication->application_no) }}" readonly></div>

                        <div class="col-md-4"><label class="form-label">Status</label><input class="form-control"
                                value="{{ $cbApplication->status }}" readonly></div>
                        <div class="col-md-4"><label class="form-label">Created By</label><input class="form-control"
                                value="{{ optional($cbApplication->creator)->name ?? auth()->user()->name }}" readonly>
                        </div>
                        <div class="col-md-4"><label class="form-label">Created Date</label><input class="form-control"
                                value="{{ optional($cbApplication->created_at)->format('Y-m-d') }}" readonly></div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success btn-sm" type="submit">Save Draft</button>
                    </div>
                </form>
            @else
                @php
                    $renderDetails([
                        'Scheme Name' => $cbApplication->scheme_name,
                        'Application Type' => $cbApplication->application_type,
                        'Application Number' => $cbApplication->application_no,
                        // 'Applicant Organization Name' => $cbApplication->organization_name,
                        // 'Accreditation Type' => $cbApplication->accreditation_type,
                        'Status' => $cbApplication->status,
                        'Created By' => optional($cbApplication->creator)->name ?? auth()->user()->name,
                        'Created Date' => optional($cbApplication->created_at)->format('Y-m-d'),
                    ]);
                @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('basic_info') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 2 --}}
        @php
            $authorized = $cbData['authorized_person'] ?? null;
            $parent = $cbData['parent_organization'] ?? null;
            $invoice = $cbData['invoice_address'] ?? null;
            $consultant = $cbData['consultant'] ?? null;
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="about_yourselves"
            data-open="{{ $openSection === 'about_yourselves' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 2: About Yourselves</h5>
                    <p class="text-muted mb-0">Authorized person, ownership, invoicing, and consultant details.</p>
                </div>
                <span
                    class="badge {{ $isSaved('about_yourselves') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('about_yourselves') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('about_yourselves'))
                <form method="POST" action="{{ $sectionUrl('about_yourselves') }}"
                    class="js-card-form cb-js-card-form">
                    @csrf
                    <div class="row g-3">
                        {{-- <div class="col-md-3"><label class="form-label">Title</label><input class="form-control" name="authorized_person[title]" value="{{ $authorized->title ?? '' }}"></div> --}}
                        <div class="col-md-5"><label class="form-label">Name</label><input class="form-control"
                                name="authorized_person[name]" value="{{ $authorized->name ?? '' }}" required></div>
                        <div class="col-md-4"><label class="form-label">Position</label><input class="form-control"
                                name="authorized_person[position]" value="{{ $authorized->position ?? '' }}"></div>
                        @foreach (['parent_organization' => 'Parent Organization', 'relationship' => 'Relationship', 'postcode' => 'Postcode', 'telephone' => 'Telephone', 'fax' => 'Fax'] as $field => $label)
                            <div class="col-md-4"><label class="form-label">{{ $label }}</label><input
                                    class="form-control" name="parent_organization[{{ $field }}]"
                                    value="{{ $parent->{$field} ?? '' }}"></div>
                        @endforeach
                        <div class="col-md-8"><label class="form-label">Parent Address</label><input
                                class="form-control" name="parent_organization[address]"
                                value="{{ $parent->address ?? '' }}"></div>
                        <div class="col-md-4"><label class="form-label">Ownership</label><select
                                class="form-control cb-ownership-select" name="parent_organization[ownership_type]">
                                <option value="">Select</option>
                                @foreach (['Individual', 'Public Limited Company', 'Private Company', 'Partnership', 'Learned Institution', 'Academic Institution', 'Public Body', 'Other'] as $type)
                                    <option value="{{ $type }}" @selected(($parent->ownership_type ?? '') === $type)>
                                        {{ $type }}</option>
                                @endforeach
                            </select></div>
                        <div class="col-md-8 cb-ownership-other"><label class="form-label">Other
                                Description</label><input class="form-control"
                                name="parent_organization[ownership_other_description]"
                                value="{{ $parent->ownership_other_description ?? '' }}"></div>
                        <div class="col-md-4"><label class="form-label">Main Activity?</label><select
                                class="form-control cb-main-activity-select" name="parent_organization[main_activity]">
                                <option value="">Select</option>
                                <option value="yes" @selected(($parent->main_activity ?? '') === 'yes')>Yes</option>
                                <option value="no" @selected(($parent->main_activity ?? '') === 'no')>No</option>
                            </select></div>
                        <div class="col-md-8 cb-main-activity-description"><label class="form-label">If No,
                                describe</label>
                            <textarea class="form-control" name="parent_organization[main_activity_description]">{{ $parent->main_activity_description ?? '' }}</textarea>
                        </div>
                        @foreach (['organization' => 'Invoice Organization', 'address' => 'Invoice Address', 'postcode' => 'Invoice Postcode', 'telephone' => 'Invoice Telephone', 'fax' => 'Invoice Fax'] as $field => $label)
                            <div class="col-md-4"><label class="form-label">{{ $label }}</label><input
                                    class="form-control" name="invoice_address[{{ $field }}]"
                                    value="{{ $invoice->{$field} ?? '' }}"></div>
                        @endforeach
                        @foreach (['consultant_name' => 'Consultant Name', 'organization' => 'Consultant Organization', 'address' => 'Consultant Address', 'postcode' => 'Consultant Postcode', 'telephone' => 'Consultant Telephone', 'fax' => 'Consultant Fax', 'email' => 'Consultant Email'] as $field => $label)
                            <div class="col-md-4"><label class="form-label">{{ $label }}</label><input
                                    class="form-control" name="consultant[{{ $field }}]"
                                    value="{{ $consultant->{$field} ?? '' }}"
                                    @if ($field === 'email') type="email" @endif></div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @php
                    $renderDetails([
                        'Authorized Person' => $authorized->name ?? '',
                        'Position' => $authorized->position ?? '',
                        'Parent Organization' => $parent->parent_organization ?? '',
                        'Relationship' => $parent->relationship ?? '',
                        'Parent Address' => $parent->address ?? '',
                        'Ownership' => $parent->ownership_type ?? '',
                        'Main Activity' => $parent->main_activity ?? '',
                        'Invoice Organization' => $invoice->organization ?? '',
                        'Invoice Address' => $invoice->address ?? '',
                        'Consultant Name' => $consultant->consultant_name ?? '',
                        'Consultant Email' => $consultant->email ?? '',
                    ]);
                @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('about_yourselves') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 3 --}}
        @php
            $staffRoles = ($cbData['staff_roles'] ?? collect())->groupBy('role');
            $staffColumns = [
                'name' => 'Name',
                'qualifications' => 'Qualifications',
                'relevant_experience' => 'Relevant Experience',
            ];
            $auditorColumns = [
                'name' => 'Name',
                'qualifications' => 'Qualifications',
                'auditing_field' => 'Auditing Field',
                'audit_experience' => 'Audit Experience',
            ];
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="staff_info"
            data-open="{{ $openSection === 'staff_info' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 3: Staff Information</h5>
                    <p class="text-muted mb-0">Executives, management, and auditors.</p>
                </div>
                <span
                    class="badge {{ $isSaved('staff_info') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('staff_info') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('staff_info'))
                <form method="POST" action="{{ $sectionUrl('staff_info') }}" class="js-card-form cb-js-card-form">
                    @csrf
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Chief Executive',
                        'target' => 'cbChiefRows',
                        'name' => 'chief_executive',
                        'rows' => $firstRow(
                            $staffRoles->get('Chief Executive', collect()),
                            array_fill_keys(array_keys($staffColumns), '')),
                        'columns' => $staffColumns,
                        'isLocked' => $isLocked,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Quality Management Representative',
                        'target' => 'cbQualityRows',
                        'name' => 'quality_representative',
                        'rows' => $firstRow(
                            $staffRoles->get('Quality Management Representative', collect()),
                            array_fill_keys(array_keys($staffColumns), '')),
                        'columns' => $staffColumns,
                        'isLocked' => $isLocked,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Management Members',
                        'target' => 'cbManagementRows',
                        'name' => 'management_members',
                        'rows' => $firstRow(
                            $cbData['management_members'] ?? collect(),
                            array_fill_keys(array_keys($staffColumns), '')),
                        'columns' => $staffColumns,
                        'isLocked' => $isLocked,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Permanent Auditors',
                        'target' => 'cbPermanentRows',
                        'name' => 'permanent_auditors',
                        'rows' => $firstRow(
                            $cbData['permanent_auditors'] ?? collect(),
                            array_fill_keys(array_keys($auditorColumns), '')),
                        'columns' => $auditorColumns,
                        'isLocked' => $isLocked,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Freelance/Subcontracted Auditors',
                        'target' => 'cbFreelanceRows',
                        'name' => 'freelance_auditors',
                        'rows' => $firstRow(
                            $cbData['freelance_auditors'] ?? collect(),
                            array_fill_keys(array_keys($auditorColumns), '')),
                        'columns' => $auditorColumns,
                        'isLocked' => $isLocked,
                    ])
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                <h6><strong>Chief Executive</strong></h6>
                @php $renderTable($staffRoles->get('Chief Executive', collect()), $staffColumns); @endphp
                <h6 class="mt-4"><strong>Quality Management Representative</strong></h6>
                @php $renderTable($staffRoles->get('Quality Management Representative', collect()), $staffColumns); @endphp
                <h6 class="mt-4"><strong>Management Members</strong></h6>
                @php $renderTable($cbData['management_members'] ?? collect(), $staffColumns); @endphp
                <h6 class="mt-4"><strong>Permanent Auditors</strong></h6>
                @php $renderTable($cbData['permanent_auditors'] ?? collect(), $auditorColumns); @endphp
                <h6 class="mt-4"><strong>Freelance/Subcontracted Auditors</strong></h6>
                @php $renderTable($cbData['freelance_auditors'] ?? collect(), $auditorColumns); @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('staff_info') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 4 --}}
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="scope_application"
            data-open="{{ $openSection === 'scope_application' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 4: Scope of Application</h5>
                    <p class="text-muted mb-0">Scope tables for all CB accreditation schemes.</p>
                </div>
                <span
                    class="badge {{ $isSaved('scope_application') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('scope_application') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('scope_application'))
                <form method="POST" action="{{ $sectionUrl('scope_application') }}"
                    class="js-card-form cb-js-card-form">
                    @csrf
                    @foreach ($scopeGroups as $name => $group)
                        @include('admin.application.certification_bodies._repeatable_table', [
                            'title' => $group['title'],
                            'target' => $group['target'],
                            'name' => $name,
                            'rows' => $firstRow(
                                $cbData[$name] ?? collect(),
                                array_fill_keys(array_keys($group['columns']), '')),
                            'columns' => $group['columns'],
                            'isLocked' => $isLocked,
                        ])
                    @endforeach
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @foreach ($scopeGroups as $name => $group)
                    <h6 class="mt-3"><strong>{{ $group['title'] }}</strong></h6>
                    @php $renderTable($cbData[$name] ?? collect(), $group['columns']); @endphp
                @endforeach
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('scope_application') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 5 --}}
        @php
            $nonComplianceRows = $cbData['non_compliance'] ?? collect();

            // Detect compliance from stored rows (not from an injected fallback row)
            $qualityComplies =
                optional(
                    $nonComplianceRows instanceof \Illuminate\Support\Collection
                        ? $nonComplianceRows->first()
                        : $nonComplianceRows,
                )->complies ?? 'yes';

            if ($nonComplianceRows instanceof \Illuminate\Support\Collection) {
                $qualityComplies =
                    optional($nonComplianceRows->firstWhere(fn($r) => !empty($r->complies)))->complies ?? 'yes';
            } else {
                $qualityComplies =
                    is_object($nonComplianceRows) && !empty($nonComplianceRows->complies)
                        ? $nonComplianceRows->complies
                        : 'yes';
            }

            // For edit UI, only show fields relevant to the selected compliance.
            $qualityRows =
                $qualityComplies === 'no'
                    ? ($nonComplianceRows instanceof \Illuminate\Support\Collection && $nonComplianceRows->isNotEmpty()
                        ? $nonComplianceRows
                        : collect([
                            (object) ['area_of_non_compliance' => '', 'rectification_date' => '', 'complies' => 'no'],
                        ]))
                    : collect([
                        (object) ['area_of_non_compliance' => '', 'rectification_date' => '', 'complies' => 'yes'],
                    ]);
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="quality_system"
            data-open="{{ $openSection === 'quality_system' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 5: About Your Quality System</h5>
                    <p class="text-muted mb-0">ISO/IEC 17021-1 and PNAC requirements.</p>
                </div>
                <span
                    class="badge {{ $isSaved('quality_system') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('quality_system') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('quality_system'))
                <form method="POST" action="{{ $sectionUrl('quality_system') }}"
                    class="js-card-form cb-js-card-form">
                    @csrf
                    <label class="fw-semibold">Does the Certification Body comply with ISO/IEC 17021-1 and PNAC
                        requirements?</label>
                    <div class="mb-3">
                        <label class="form-check form-check-inline"><input class="form-check-input cb-quality-toggle"
                                type="radio" name="complies" value="yes" @checked($qualityComplies === 'yes')>
                            Yes</label>
                        <label class="form-check form-check-inline"><input class="form-check-input cb-quality-toggle"
                                type="radio" name="complies" value="no" @checked($qualityComplies === 'no')>
                            No</label>
                    </div>
                    <div class="cb-non-compliance-wrap">
                        @include('admin.application.certification_bodies._repeatable_table', [
                            'title' => 'Non Compliance',
                            'target' => 'cbNonComplianceRows',
                            'name' => 'non_compliance',
                            'rows' => $qualityRows,
                            'columns' => [
                                'area_of_non_compliance' => 'Area of Non Compliance',
                                'rectification_date' => 'Rectification Date',
                            ],
                            'isLocked' => $isLocked,
                        ])
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @php
                    $renderDetails(['Compliance' => ucfirst($qualityComplies)]);
                    if ($qualityComplies === 'no') {
                        echo '<h6 class="mt-4"><strong>Non Compliance</strong></h6>';
                        $renderTable($cbData['non_compliance'] ?? collect(), [
                            'area_of_non_compliance' => 'Area of Non Compliance',
                            'rectification_date' => 'Rectification Date',
                        ]);
                    }
                @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('quality_system') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 6 --}}
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="other_approvals"
            data-open="{{ $openSection === 'other_approvals' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 6: Other Approvals</h5>
                    <p class="text-muted mb-0">Existing approvals and certificates.</p>
                </div>
                <span
                    class="badge {{ $isSaved('other_approvals') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('other_approvals') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('other_approvals'))
                <form method="POST" action="{{ $sectionUrl('other_approvals') }}"
                    class="js-card-form cb-js-card-form">
                    @csrf
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Other Approvals',
                        'target' => 'cbApprovalRows',
                        'name' => 'other_approvals',
                        'rows' => $firstRow($cbData['other_approvals'] ?? collect(), [
                            'approval_body_name' => '',
                            'address' => '',
                            'scope' => '',
                            'certificate_number' => '',
                            'start_date' => '',
                            'expiry_date' => '',
                        ]),
                        'columns' => [
                            'approval_body_name' => 'Approval Body Name',
                            'address' => 'Address',
                            'scope' => 'Scope',
                            'certificate_number' => 'Certificate Number',
                            'start_date' => 'Start Date',
                            'expiry_date' => 'Expiry Date',
                        ],
                        'isLocked' => $isLocked,
                    ])
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @php $renderTable($cbData['other_approvals'] ?? collect(), ['approval_body_name' => 'Approval Body Name', 'address' => 'Address', 'scope' => 'Scope', 'certificate_number' => 'Certificate Number', 'start_date' => 'Start Date', 'expiry_date' => 'Expiry Date']); @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('other_approvals') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 6 --}}
        @php $declaration = $cbData['declaration'] ?? null; @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="declaration"
            data-open="{{ $openSection === 'declaration' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 6: Declaration</h5>
                    <p class="text-muted mb-0">Applicant fee, digital signature, and final submission.</p>
                </div>
                <span
                    class="badge {{ $isSaved('declaration') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('declaration') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('declaration'))
                <form method="POST" action="{{ $sectionUrl('declaration') }}" class="js-card-form cb-js-card-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-check"><input class="form-check-input"
                                    type="checkbox" name="declaration_accepted" value="1"
                                    @checked($declaration->declaration_accepted ?? false) required> <span class="form-check-label">I declare
                                    that the information given in this form is correct to the best of my knowledge and
                                    belief.</span></label></div>
                        <div class="col-md-4"><label class="form-label">Applicant Fee Amount</label><input
                                class="form-control" name="applicant_fee_amount"
                                value="{{ $declaration->applicant_fee_amount ?? '' }}" required></div>
                        <div class="col-md-4"><label class="form-label">Digital Signature Name</label><input
                                class="form-control" name="digital_signature_name"
                                value="{{ $declaration->digital_signature_name ?? '' }}" required></div>
                        <div class="col-md-4"><label class="form-label">Signed Date</label><input type="date"
                                class="form-control" name="signed_date"
                                value="{{ optional($declaration)->signed_date ?? now()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button class="btn btn-success btn-sm">Save Draft</button>
                        <button class="btn btn-primary btn-sm" name="final_submit" value="1">Final
                            Submit</button>
                    </div>
                </form>
            @else
                @php
                    $renderDetails([
                        'Declaration Accepted' => $declaration->declaration_accepted ?? false ? 'Yes' : 'No',
                        'Applicant Fee Amount' => $declaration->applicant_fee_amount ?? '',
                        'Digital Signature Name' => $declaration->digital_signature_name ?? '',
                        'Signed Date' => optional($declaration)->signed_date,
                    ]);
                @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('declaration') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>
    </div>
</div>
