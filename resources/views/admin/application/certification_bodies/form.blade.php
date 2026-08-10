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

    // Load existing form schema dynamically
    $schema = $form?->form_schema;

    $getSection = function ($titleOrIndex) use ($schema) {
        if (!$schema || !isset($schema['sections'])) {
            return null;
        }
        if (is_int($titleOrIndex)) {
            return $schema['sections'][$titleOrIndex] ?? null;
        }
        foreach ($schema['sections'] as $sec) {
            if (strcasecmp($sec['title'] ?? '', $titleOrIndex) === 0) {
                return $sec;
            }
        }
        return null;
    };

    // Pre-mapped lookup indexes to decouple DB field name changes from rendering layout
    $fieldIndexMap = [
        'Basic Application Information' => [
            'scheme_name' => 0,
            'application_type' => 1,
            'application_no' => 2,
            'application_number' => 2,
            'status' => 3,
            'created_by' => 4,
            'created_date' => 5,
        ],
        'About Yourselves' => [
            'name' => 0,
            'position' => 1,
            'parent_organization' => 2,
            'relationship' => 3,
            'postcode' => 4,
            'telephone' => 5,
            'fax' => 6,
            'parent_address' => 7,
            'ownership' => 8,
            'main_activity' => 9,
            'invoice_organization' => 10,
            'invoice_address' => 11,
            'invoice_postcode' => 12,
            'invoice_telephone' => 13,
            'invoice_fax' => 14,
            'consultant_name' => 15,
            'consultant_organization' => 16,
            'consultant_address' => 17,
            'consultant_postcode' => 18,
            'consultant_telephone' => 19,
            'consultant_fax' => 20,
            'consultant_email' => 21,
        ],
        'Staff Information' => [
            'chief_executive_name' => 0,
            'chief_executive_qualifications' => 1,
            'chief_executive_relevant_experience' => 2,
            'quality_management_representative_name' => 3,
            'quality_management_representative_qualifications' => 4,
            'quality_management_representative_relevant_experience' => 5,
        ],
        'Management Members' => [
            'name' => 0,
            'qualifications' => 1,
            'relevant_experience' => 2,
        ],
        'Permanent Auditors' => [
            'name' => 0,
            'qualifications' => 1,
            'auditing_field' => 2,
            'audit_experience' => 3,
        ],
        'Freelance/Subcontracted Auditors' => [
            'name' => 0,
            'qualifications' => 1,
            'auditing_field' => 2,
            'audit_experience' => 3,
        ],
        'Scope of Application - QMS ISO 9001' => [
            'technical_cluster' => 0,
            'iaf_code' => 1,
            'description' => 2,
        ],
        'Scope of Application - EMS ISO 14001' => [
            'technical_cluster' => 0,
            'iaf_code' => 1,
            'description' => 2,
        ],
        'Scope of Application - OH&S ISO 45001' => [
            'technical_cluster' => 0,
            'iaf_code' => 1,
            'description' => 2,
        ],
        'Scope of Application - FSMS ISO 22000' => [
            'cluster' => 0,
            'category' => 1,
            'sub_category' => 2,
            'activities' => 3,
        ],
        'Scope of Application - MD-QMS ISO 13485' => [
            'main_technical_area' => 0,
            'technical_area' => 1,
            'product_category' => 2,
        ],
        'Scope of Application - ISMS ISO 27001' => [
            'scope' => 0,
            'standard' => 1,
        ],
        'About Your Quality System' => [
            'does_the_certification_body_comply_with_iso_iec_17021_1_and_pnac_requirements' => 0,
        ],
        'Non Compliance' => [
            'area_of_non_compliance' => 0,
            'rectification_date' => 1,
        ],
        'Other Approvals' => [
            'approval_body_name' => 0,
            'address' => 1,
            'scope' => 2,
            'certificate_number' => 3,
            'start_date' => 4,
            'expiry_date' => 5,
        ],
        'Declaration' => [
            'declaration_accepted' => 0,
            'applicant_fee_amount' => 1,
            'digital_signature_name' => 2,
            'signed_date' => 3,
        ],
    ];

    $getLabel = function ($sectionTitleOrIndex, $fieldIndexOrName, $fallback = '') use ($getSection, $fieldIndexMap) {
        $sec = $getSection($sectionTitleOrIndex);
        if (!$sec || !isset($sec['fields'])) {
            return $fallback;
        }
        if (is_int($fieldIndexOrName)) {
            return $sec['fields'][$fieldIndexOrName]['label'] ?? $fallback;
        }

        $secTitle = $sec['title'] ?? '';
        if (isset($fieldIndexMap[$secTitle][$fieldIndexOrName])) {
            $idx = $fieldIndexMap[$secTitle][$fieldIndexOrName];
            if (isset($sec['fields'][$idx]['label'])) {
                return $sec['fields'][$idx]['label'];
            }
        }

        foreach ($sec['fields'] as $fld) {
            if (strcasecmp($fld['name'] ?? '', $fieldIndexOrName) === 0) {
                return $fld['label'] ?? $fallback;
            }
        }
        return $fallback;
    };

    $getColumns = function ($sectionTitleOrIndex, $fallbackColumns) use ($getSection, $fieldIndexMap) {
        $sec = $getSection($sectionTitleOrIndex);
        if (!$sec || !isset($sec['fields'])) {
            return $fallbackColumns;
        }
        $cols = [];
        $secTitle = $sec['title'] ?? '';
        foreach ($fallbackColumns as $field => $fallbackLabel) {
            $label = $fallbackLabel;
            if (isset($fieldIndexMap[$secTitle][$field])) {
                $idx = $fieldIndexMap[$secTitle][$field];
                if (isset($sec['fields'][$idx]['label'])) {
                    $cols[$field] = $sec['fields'][$idx]['label'];
                    continue;
                }
            }
            foreach ($sec['fields'] as $fld) {
                if (strcasecmp($fld['name'] ?? '', $field) === 0) {
                    $label = $fld['label'] ?? $fallbackLabel;
                    break;
                }
            }
            $cols[$field] = $label;
        }
        return $cols;
    };

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

    $dynamicScopeGroups = [];
    foreach ($scopeGroups as $key => $group) {
        $secTitle = 'Scope of Application - ' . $group['title'];
        $sec = $getSection($secTitle);
        $title = $sec ? $sec['title'] : $group['title'];
        $displayTitle = str_replace('Scope of Application - ', '', $title);
        $cols = $getColumns($secTitle, $group['columns']);

        $dynamicScopeGroups[$key] = [
            'title' => $displayTitle,
            'target' => $group['target'],
            'columns' => $cols,
        ];
    }

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
    {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}
    {{-- @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif --}}

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
                    <h5 class="mb-1">Step 1:
                        {{ $getSection('Basic Application Information') ? $getSection('Basic Application Information')['title'] : 'Basic Application Information' }}
                    </h5>
                    <p class="text-muted mb-0">Application identity and status.</p>
                </div>
                <span
                    class="badge {{ $isSaved('basic_info') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('basic_info') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('basic_info'))
                <form method="POST" action="{{ $sectionUrl('basic_info') }}" class="js-card-form cb-js-card-form"
                    novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Basic Application Information', 'scheme_name', 'Scheme Name') }}
                                <span class="text-danger">*</span></label><input class="form-control" name="scheme_name"
                                value="{{ old('scheme_name', $cbApplication->scheme_name) }}" readonly></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Basic Application Information', 'application_type', 'Application Type') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                name="application_type"
                                value="{{ old('application_type', $cbApplication->application_type) }}" readonly></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Basic Application Information', 'application_no', 'Application Number') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                name="application_no"
                                value="{{ old('application_no', $cbApplication->application_no) }}" readonly></div>

                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Basic Application Information', 'status', 'Status') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                value="{{ $cbApplication->status }}" readonly></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Basic Application Information', 'created_by', 'Created By') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                value="{{ optional($cbApplication->creator)->name ?? auth()->user()->name }}" readonly>
                        </div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Basic Application Information', 'created_date', 'Created Date') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                value="{{ optional($cbApplication->created_at)->format('Y-m-d') }}" readonly></div>

                        <!-- Basic Information Fields -->
                        <div class="col-md-6">
                            <label class="form-label">CAB Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="cab_name"
                                value="{{ old('cab_name', $general->cab_name ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" rows="2" required>{{ old('address', $general->address ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Postcode</label>
                            <input class="form-control" name="postcode"
                                value="{{ old('postcode', $general->postal_code ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Telephone</label>
                            <input class="form-control" name="telephone"
                                value="{{ old('telephone', $general->telephone ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $general->email ?? '') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">NTN/FTN</label>
                            <input class="form-control" name="ntn_ftn"
                                value="{{ old('ntn_ftn', $general->ntn_ftn ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" name="website"
                                value="{{ old('website', $general->website ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">City</label>
                            <input class="form-control" name="city" value="{{ old('city', $general->city ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Country</label>
                            <input class="form-control" name="country"
                                value="{{ old('country', $general->country ?? '') }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success btn-sm" type="submit">Save Draft</button>
                    </div>
                </form>
            @else
                @php
                    $renderDetails([
                        $getLabel(
                            'Basic Application Information',
                            'scheme_name',
                            'Scheme Name',
                        ) => $cbApplication->scheme_name,
                        $getLabel(
                            'Basic Application Information',
                            'application_type',
                            'Application Type',
                        ) => $cbApplication->application_type,
                        $getLabel(
                            'Basic Application Information',
                            'application_no',
                            'Application Number',
                        ) => $cbApplication->application_no,
                        $getLabel('Basic Application Information', 'status', 'Status') => $cbApplication->status,
                        $getLabel('Basic Application Information', 'created_by', 'Created By') =>
                            optional($cbApplication->creator)->name ?? auth()->user()->name,
                        $getLabel('Basic Application Information', 'created_date', 'Created Date') => optional(
                            $cbApplication->created_at,
                        )->format('Y-m-d'),
                        'CAB Name' => $general->cab_name ?? '-',
                        'Address' => $general->address ?? '-',
                        'Postcode' => $general->postal_code ?? '-',
                        'Telephone' => $general->telephone ?? '-',
                        'Email' => $general->email ?? '-',
                        'NTN/FTN' => $general->ntn_ftn ?? '-',
                        'Website' => $general->website ?? '-',
                        'City' => $general->city ?? '-',
                        'Country' => $general->country ?? '-',
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
                    <h5 class="mb-1">Step 2:
                        {{ $getSection('About Yourselves') ? $getSection('About Yourselves')['title'] : 'About Yourselves' }}
                    </h5>
                    <p class="text-muted mb-0">Authorized person, ownership, invoicing, and consultant details.</p>
                </div>
                <span
                    class="badge {{ $isSaved('about_yourselves') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('about_yourselves') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('about_yourselves'))
                <form method="POST" action="{{ $sectionUrl('about_yourselves') }}"
                    class="js-card-form cb-js-card-form" novalidate>
                    @csrf
                    <div class="row g-3">
                        {{-- <div class="col-md-3"><label class="form-label">Title</label><input class="form-control" name="authorized_person[title]" value="{{ $authorized->title ?? '' }}"></div> --}}
                        <div class="col-md-5"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'name', 'Name') }} <span
                                    class="text-danger">*</span></label><input class="form-control"
                                name="authorized_person[name]" value="{{ $authorized->name ?? '' }}" required></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'position', 'Position') }} <span
                                    class="text-danger">*</span></label><input class="form-control"
                                name="authorized_person[position]" value="{{ $authorized->position ?? '' }}"
                                required>
                        </div>
                        @foreach (['parent_organization' => 'Parent Organization', 'relationship' => 'Relationship', 'postcode' => 'Postcode', 'telephone' => 'Telephone', 'fax' => 'Fax'] as $field => $fallbackLabel)
                            <div class="col-md-4"><label
                                    class="form-label">{{ $getLabel('About Yourselves', $field, $fallbackLabel) }}
                                    <span class="text-danger">*</span></label><input class="form-control"
                                    name="parent_organization[{{ $field }}]"
                                    value="{{ $parent->{$field} ?? '' }}" required></div>
                        @endforeach
                        <div class="col-md-8"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'parent_address', 'Parent Address') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                name="parent_organization[address]" value="{{ $parent->address ?? '' }}" required>
                        </div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'ownership', 'Ownership') }} <span
                                    class="text-danger">*</span></label><select
                                class="form-control cb-ownership-select" name="parent_organization[ownership_type]"
                                required>
                                <option value="">Select</option>
                                @foreach (['Individual', 'Public Limited Company', 'Private Company', 'Partnership', 'Learned Institution', 'Academic Institution', 'Public Body', 'Other'] as $type)
                                    <option value="{{ $type }}" @selected(($parent->ownership_type ?? '') === $type)>
                                        {{ $type }}</option>
                                @endforeach
                            </select></div>
                        <div class="col-md-8 cb-ownership-other"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'ownership_other_description', 'Other Description') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                name="parent_organization[ownership_other_description]"
                                value="{{ $parent->ownership_other_description ?? '' }}" required></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'main_activity', 'Main Activity?') }}
                                <span class="text-danger">*</span></label><select
                                class="form-control cb-main-activity-select"
                                name="parent_organization[main_activity]">
                                <option value="">Select</option>
                                <option value="yes" @selected(($parent->main_activity ?? '') === 'yes')>Yes</option>
                                <option value="no" @selected(($parent->main_activity ?? '') === 'no')>No</option>
                            </select></div>
                        <div class="col-md-8 cb-main-activity-description"><label
                                class="form-label">{{ $getLabel('About Yourselves', 'main_activity_description', 'If No, describe') }}
                                <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="parent_organization[main_activity_description]">{{ $parent->main_activity_description ?? '' }}</textarea>
                        </div>
                        @foreach (['organization' => 'Invoice Organization', 'address' => 'Invoice Address', 'postcode' => 'Invoice Postcode', 'telephone' => 'Invoice Telephone', 'fax' => 'Invoice Fax'] as $field => $fallbackLabel)
                            <div class="col-md-4"><label
                                    class="form-label">{{ $getLabel('About Yourselves', 'invoice_' . $field, $fallbackLabel) }}
                                    <span class="text-danger">*</span></label><input class="form-control"
                                    name="invoice_address[{{ $field }}]"
                                    value="{{ $invoice->{$field} ?? '' }}" required></div>
                        @endforeach
                        @foreach (['consultant_name' => 'Consultant Name', 'organization' => 'Consultant Organization', 'address' => 'Consultant Address', 'postcode' => 'Consultant Postcode', 'telephone' => 'Consultant Telephone', 'fax' => 'Consultant Fax', 'email' => 'Consultant Email'] as $field => $fallbackLabel)
                            @php
                                $schemaFieldName = str_starts_with($field, 'consultant_')
                                    ? $field
                                    : 'consultant_' . $field;
                            @endphp
                            <div class="col-md-4"><label
                                    class="form-label">{{ $getLabel('About Yourselves', $schemaFieldName, $fallbackLabel) }}</label><input
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
                        $getLabel('About Yourselves', 'name', 'Authorized Person') => $authorized->name ?? '',
                        $getLabel('About Yourselves', 'position', 'Position') => $authorized->position ?? '',
                        $getLabel('About Yourselves', 'parent_organization', 'Parent Organization') =>
                            $parent->parent_organization ?? '',
                        $getLabel('About Yourselves', 'relationship', 'Relationship') => $parent->relationship ?? '',
                        $getLabel('About Yourselves', 'parent_address', 'Parent Address') => $parent->address ?? '',
                        $getLabel('About Yourselves', 'ownership', 'Ownership') => $parent->ownership_type ?? '',
                        $getLabel('About Yourselves', 'main_activity', 'Main Activity') => $parent->main_activity ?? '',
                        $getLabel('About Yourselves', 'invoice_organization', 'Invoice Organization') =>
                            $invoice->organization ?? '',
                        $getLabel('About Yourselves', 'invoice_address', 'Invoice Address') => $invoice->address ?? '',
                        $getLabel('About Yourselves', 'consultant_name', 'Consultant Name') =>
                            $consultant->consultant_name ?? '',
                        $getLabel('About Yourselves', 'consultant_email', 'Consultant Email') =>
                            $consultant->email ?? '',
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
        @php
            $chiefColumns = [
                'name' => $getLabel('Staff Information', 'chief_executive_name', 'Name'),
                'qualifications' => $getLabel('Staff Information', 'chief_executive_qualifications', 'Qualifications'),
                'relevant_experience' => $getLabel(
                    'Staff Information',
                    'chief_executive_relevant_experience',
                    'Relevant Experience',
                ),
            ];
            $qualityColumns = [
                'name' => $getLabel('Staff Information', 'quality_management_representative_name', 'Name'),
                'qualifications' => $getLabel(
                    'Staff Information',
                    'quality_management_representative_qualifications',
                    'Qualifications',
                ),
                'relevant_experience' => $getLabel(
                    'Staff Information',
                    'quality_management_representative_relevant_experience',
                    'Relevant Experience',
                ),
            ];
            $managementTitle = $getSection('Management Members')
                ? $getSection('Management Members')['title']
                : 'Management Members';
            $managementCols = $getColumns('Management Members', $staffColumns);

            $permanentTitle = $getSection('Permanent Auditors')
                ? $getSection('Permanent Auditors')['title']
                : 'Permanent Auditors';
            $permanentCols = $getColumns('Permanent Auditors', $auditorColumns);

            $freelanceTitle = $getSection('Freelance/Subcontracted Auditors')
                ? $getSection('Freelance/Subcontracted Auditors')['title']
                : 'Freelance/Subcontracted Auditors';
            $freelanceCols = $getColumns('Freelance/Subcontracted Auditors', $auditorColumns);
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="staff_info"
            data-open="{{ $openSection === 'staff_info' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 3:
                        {{ $getSection('Staff Information') ? $getSection('Staff Information')['title'] : 'Staff Information' }}
                    </h5>
                    <p class="text-muted mb-0">Executives, management, and auditors.</p>
                </div>
                <span
                    class="badge {{ $isSaved('staff_info') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('staff_info') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('staff_info'))
                <form method="POST" action="{{ $sectionUrl('staff_info') }}" class="js-card-form cb-js-card-form"
                    novalidate>
                    @csrf
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Chief Executive',
                        'target' => 'cbChiefRows',
                        'name' => 'chief_executive',
                        'rows' => $firstRow(
                            $staffRoles->get('Chief Executive', collect()),
                            array_fill_keys(array_keys($chiefColumns), '')),
                        'columns' => $chiefColumns,
                        'isLocked' => $isLocked,
                        'allowMultiple' => true,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => 'Quality Management Representative',
                        'target' => 'cbQualityRows',
                        'name' => 'quality_representative',
                        'rows' => $firstRow(
                            $staffRoles->get('Quality Management Representative', collect()),
                            array_fill_keys(array_keys($qualityColumns), '')),
                        'columns' => $qualityColumns,
                        'isLocked' => $isLocked,
                        'allowMultiple' => true,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => $managementTitle,
                        'target' => 'cbManagementRows',
                        'name' => 'management_members',
                        'rows' => $firstRow(
                            $cbData['management_members'] ?? collect(),
                            array_fill_keys(array_keys($managementCols), '')),
                        'columns' => $managementCols,
                        'isLocked' => $isLocked,
                        'allowMultiple' => true,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => $permanentTitle,
                        'target' => 'cbPermanentRows',
                        'name' => 'permanent_auditors',
                        'rows' => $firstRow(
                            $cbData['permanent_auditors'] ?? collect(),
                            array_fill_keys(array_keys($permanentCols), '')),
                        'columns' => $permanentCols,
                        'isLocked' => $isLocked,
                        'allowMultiple' => true,
                    ])
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => $freelanceTitle,
                        'target' => 'cbFreelanceRows',
                        'name' => 'freelance_auditors',
                        'rows' => $firstRow(
                            $cbData['freelance_auditors'] ?? collect(),
                            array_fill_keys(array_keys($freelanceCols), '')),
                        'columns' => $freelanceCols,
                        'isLocked' => $isLocked,
                        'allowMultiple' => true,
                    ])
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                <h6><strong>Chief Executive</strong></h6>
                @php $renderTable($staffRoles->get('Chief Executive', collect()), $chiefColumns); @endphp
                <h6 class="mt-4"><strong>Quality Management Representative</strong></h6>
                @php $renderTable($staffRoles->get('Quality Management Representative', collect()), $qualityColumns); @endphp
                <h6 class="mt-4"><strong>{{ $managementTitle }}</strong></h6>
                @php $renderTable($cbData['management_members'] ?? collect(), $managementCols); @endphp
                <h6 class="mt-4"><strong>{{ $permanentTitle }}</strong></h6>
                @php $renderTable($cbData['permanent_auditors'] ?? collect(), $permanentCols); @endphp
                <h6 class="mt-4"><strong>{{ $freelanceTitle }}</strong></h6>
                @php $renderTable($cbData['freelance_auditors'] ?? collect(), $freelanceCols); @endphp
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
                    class="js-card-form cb-js-card-form" novalidate>
                    @csrf
                    @foreach ($dynamicScopeGroups as $name => $group)
                        @include('admin.application.certification_bodies._repeatable_table', [
                            'title' => $group['title'],
                            'target' => $group['target'],
                            'name' => $name,
                            'rows' => $firstRow(
                                $cbData[$name] ?? collect(),
                                array_fill_keys(array_keys($group['columns']), '')),
                            'columns' => $group['columns'],
                            'isLocked' => $isLocked,
                            'allowMultiple' => true,
                        ])
                    @endforeach
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @foreach ($dynamicScopeGroups as $name => $group)
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
        @php
            $nonComplianceTitle = $getSection('Non Compliance')
                ? $getSection('Non Compliance')['title']
                : 'Non Compliance';
            $nonComplianceCols = $getColumns('Non Compliance', [
                'area_of_non_compliance' => 'Area of Non Compliance',
                'rectification_date' => 'Rectification Date',
            ]);
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="quality_system"
            data-open="{{ $openSection === 'quality_system' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 5:
                        {{ $getSection('About Your Quality System') ? $getSection('About Your Quality System')['title'] : 'About Your Quality System' }}
                    </h5>
                    <p class="text-muted mb-0">ISO/IEC 17021-1 and PNAC requirements.</p>
                </div>
                <span
                    class="badge {{ $isSaved('quality_system') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('quality_system') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('quality_system'))
                <form method="POST" action="{{ $sectionUrl('quality_system') }}"
                    class="js-card-form cb-js-card-form" novalidate>
                    @csrf
                    <label
                        class="fw-semibold">{{ $getLabel('About Your Quality System', 'does_the_certification_body_comply_with_iso_iec_17021_1_and_pnac_requirements', 'Does the Certification Body comply with ISO/IEC 17021-1 and PNAC requirements?') }}
                        <span class="text-danger">*</span></label>
                    <div class="mb-3">
                        <label class="form-check form-check-inline"><input class="form-check-input cb-quality-toggle"
                                type="radio" name="complies" value="yes" required @checked($qualityComplies === 'yes')>
                            Yes</label>
                        <label class="form-check form-check-inline"><input class="form-check-input cb-quality-toggle"
                                type="radio" name="complies" value="no" required @checked($qualityComplies === 'no')>
                            No</label>
                    </div>
                    <div class="cb-non-compliance-wrap">
                        @include('admin.application.certification_bodies._repeatable_table', [
                            'title' => $nonComplianceTitle,
                            'target' => 'cbNonComplianceRows',
                            'name' => 'non_compliance',
                            'rows' => $qualityRows,
                            'columns' => $nonComplianceCols,
                            'isLocked' => $isLocked,
                            'allowMultiple' => true,
                        ])
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @php
                    $renderDetails(['Compliance' => ucfirst($qualityComplies)]);
                    if ($qualityComplies === 'no') {
                        echo '<h6 class="mt-4"><strong>' . e($nonComplianceTitle) . '</strong></h6>';
                        $renderTable($cbData['non_compliance'] ?? collect(), $nonComplianceCols);
                    }
                @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('quality_system') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        {{-- Step 6 --}}
        @php
            $otherApprovalsTitle = $getSection('Other Approvals')
                ? $getSection('Other Approvals')['title']
                : 'Other Approvals';
            $otherApprovalsCols = $getColumns('Other Approvals', [
                'approval_body_name' => 'Approval Body Name',
                'address' => 'Address',
                'scope' => 'Scope',
                'certificate_number' => 'Certificate Number',
                'start_date' => 'Start Date',
                'expiry_date' => 'Expiry Date',
            ]);
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="other_approvals"
            data-open="{{ $openSection === 'other_approvals' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 6:
                        {{ $getSection('Other Approvals') ? $getSection('Other Approvals')['title'] : 'Other Approvals' }}
                    </h5>
                    <p class="text-muted mb-0">Existing approvals and certificates.</p>
                </div>
                <span
                    class="badge {{ $isSaved('other_approvals') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('other_approvals') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('other_approvals'))
                <form method="POST" action="{{ $sectionUrl('other_approvals') }}"
                    class="js-card-form cb-js-card-form" novalidate>
                    @csrf
                    @include('admin.application.certification_bodies._repeatable_table', [
                        'title' => $otherApprovalsTitle,
                        'target' => 'cbApprovalRows',
                        'name' => 'other_approvals',
                        'rows' => $firstRow(
                            $cbData['other_approvals'] ?? collect(),
                            array_fill_keys(array_keys($otherApprovalsCols), '')),
                        'columns' => $otherApprovalsCols,
                        'isLocked' => $isLocked,
                        'allowMultiple' => true,
                    ])
                    <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                            Draft</button></div>
                </form>
            @else
                @php $renderTable($cbData['other_approvals'] ?? collect(), $otherApprovalsCols); @endphp
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
                    <h5 class="mb-1">Step 6:
                        {{ $getSection('Declaration') ? $getSection('Declaration')['title'] : 'Declaration' }}</h5>
                    <p class="text-muted mb-0">Applicant fee, digital signature, and final submission.</p>
                </div>
                <span
                    class="badge {{ $isSaved('declaration') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('declaration') ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($isEditing('declaration'))
                <form method="POST" action="{{ $sectionUrl('declaration') }}" class="js-card-form cb-js-card-form"
                    novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-check"><input class="form-check-input"
                                    type="checkbox" name="declaration_accepted" value="1"
                                    @checked($declaration->declaration_accepted ?? false) required> <span
                                    class="form-check-label">{{ $getLabel('Declaration', 'i_declare_that_the_information_given_in_this_form_is_correct_to_the_best_of_my_knowledge_and_belief', 'I declare that the information given in this form is correct to the best of my knowledge and belief.') }}
                                    <span class="text-danger">*</span></span></label></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Declaration', 'applicant_fee_amount', 'Applicant Fee Amount') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                name="applicant_fee_amount" value="{{ $declaration->applicant_fee_amount ?? '' }}"
                                required></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Declaration', 'digital_signature_name', 'Digital Signature Name') }}
                                <span class="text-danger">*</span></label><input class="form-control"
                                name="digital_signature_name"
                                value="{{ $declaration->digital_signature_name ?? '' }}" required></div>
                        <div class="col-md-4"><label
                                class="form-label">{{ $getLabel('Declaration', 'signed_date', 'Signed Date') }} <span
                                    class="text-danger">*</span></label><input type="date" class="form-control"
                                name="signed_date"
                                value="{{ optional($declaration)->signed_date ?? now()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button class="btn btn-success btn-sm">Save Draft</button>
                        {{-- <button class="btn btn-primary btn-sm" name="final_submit" value="1">Final
                            Submit</button> --}}
                    </div>
                </form>
            @else
                @php
                    $renderDetails([
                        'Declaration Accepted' => $declaration->declaration_accepted ?? false ? 'Yes' : 'No',
                        $getLabel('Declaration', 'applicant_fee_amount', 'Applicant Fee Amount') =>
                            $declaration->applicant_fee_amount ?? '',
                        $getLabel('Declaration', 'digital_signature_name', 'Digital Signature Name') =>
                            $declaration->digital_signature_name ?? '',
                        $getLabel('Declaration', 'signed_date', 'Signed Date') => optional($declaration)->signed_date,
                    ]);
                @endphp
                <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('declaration') }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `<ul class="text-start mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>`,
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endpush
