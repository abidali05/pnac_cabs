@extends('admin.layouts.adminlayout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">

    <style>
        .btn-success {
            background-color: #187a4c;
            color: white;
        }

        .btn-success:hover {
            background-color: #187a4c !important;
            color: white;
        }

        .btn-success:active {
            background-color: #187a4c !important;
            color: white;
        }

        .bg-success {
            background-color: #187a4c !important;
            color: white;
        }



        .iso-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
        }

        .iso-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .iso-card img {
            transition: transform 0.3s ease;
        }

        .iso-card:hover img {
            transform: scale(1.1);
        }

        .iso-card .btn {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .iso-card .btn:hover {
            background-color: #ff9800;
            color: white;
        }

        .pnac-vertical-form {
            width: 100%;
            max-width: 100%;
        }

        .pnac-vertical-form #pnacVerticalForm {
            width: 100%;
        }

        .pnac-vertical-form .pnac-step-card {
            width: 100%;
        }

        @media (max-width: 767.98px) {
            .pnac-vertical-form .pnac-step-card {
                padding: 1rem !important;
            }
        }

        .pnac-collapsible-header {
            cursor: pointer;
            user-select: none;
            background: #187a4c;
            color: #fff;
            border-radius: 0.35rem;
            padding: 0.9rem 1rem;
            margin-bottom: 0.75rem;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 0.75rem;
        }

        .pnac-collapsible-header h5,
        .pnac-collapsible-header h4,
        .pnac-collapsible-header h3,
        .pnac-collapsible-header p,
        .pnac-collapsible-header small {
            color: #fff !important;
            margin-bottom: 0;
        }

        .pnac-card-title-area {
            min-width: 0;
        }

        .pnac-card-actions {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            flex-shrink: 0;
        }

        .pnac-collapsible-header .badge {
            white-space: nowrap;
        }

        .pnac-collapsible-header .badge.bg-warning {
            background-color: #fff3cd !important;
            color: #664d03 !important;
        }

        .pnac-collapse-chevron {
            width: 0.7rem;
            height: 0.7rem;
            border-right: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(45deg);
            transition: transform 0.25s ease;
            display: inline-block;
            margin-top: 0.15rem;
        }

        .pnac-collapsible-header[aria-expanded="true"] .pnac-collapse-chevron {
            transform: rotate(45deg);
        }

        .pnac-collapsible-header[aria-expanded="false"] .pnac-collapse-chevron {
            transform: rotate(-45deg);
        }

        .pnac-collapse-body {
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .pnac-collapse-body.pnac-is-open {
            overflow: visible;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 24px;
            padding: 0.25rem 0;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 14px;
            line-height: 1.5;
            min-width: 0;
        }

        .detail-label {
            font-weight: 700;
            color: #1f2937;
        }

        .detail-value {
            color: #374151;
            word-break: break-word;
        }

        .detail-value a {
            color: #187a4c;
            text-decoration: underline;
        }

        .field-error {
            display: block;
            color: #dc3545;
            font-size: 0.82rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        .pnac-vertical-form .table td {
            min-width: 120px;
            max-width: 250px;
            white-space: normal;
            word-wrap: break-word;
            vertical-align: middle;
        }

        .pnac-vertical-form .table th {
            white-space: nowrap;
            font-weight: 600;
        }

        .pnac-vertical-form .table .form-control-sm,
        .pnac-vertical-form .table .form-select-sm {
            font-size: 13px;
            padding: 4px 8px;
        }

        .pnac-vertical-form .table .form-select-sm[multiple] {
            min-height: 70px;
            height: auto;
        }
    </style>
@endsection

@php
    $currentEditSection = request('edit_section');
    $openSection = session('open_section') ?: request('open_section') ?: $currentEditSection ?: 'step1';
    $saved = $mlabData['saved_sections'] ?? [];
    $isLocked = !empty($mlabApplication) && $mlabApplication->status === 'Submitted';

    $isSaved = fn(string $section) => (bool) ($saved[$section] ?? false);
    $isEditing = fn(string $section) => !$isLocked && ($currentEditSection === $section || !$isSaved($section));
    $sectionUrl = fn(string $section) => route('mlab.save' . ucfirst($section), [
        'mlabApplication' => $mlabApplication->id,
    ]);
    $editUrl = fn(string $section) => route('application.create', [
        'scheme_name' => request('scheme_name'),
        'application' => 'Medical Laboratory',
        'edit_section' => $section,
    ]);

    // Helper functions
    $firstRow = fn($rows, $fallback = []) => $rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()
        ? $rows
        : collect([$fallback]);
    $value = fn($row, string $field) => is_array($row) ? $row[$field] ?? '' : $row->{$field} ?? '';

    // Load existing form schema dynamically
    $form =
        $form ??
        \App\Models\ApplicationForm::where('application_name', $scheme_name)
            ->orWhere('slug', \Str::slug($scheme_name))
            ->first();
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

    $fieldIndexMap = [
        'About Yourselves' => [
            'organisation_name' => 0,
            'lab_address' => 1,
            'title' => 2,
            'contact_name' => 3,
            'contact_designation' => 4,
            'parent_organisation' => 5,
            'parent_relationship' => 6,
            'parent_address' => 7,
            'parent_tel' => 8,
            'parent_fax' => 9,
            'invoice_organisation' => 10,
            'invoice_address' => 11,
            'invoice_postcode' => 12,
            'invoice_tel' => 13,
            'invoice_fax' => 14,
            'ownership_type' => 15,
            'registration_no' => 16,
            'ownership_other_description' => 17,
            'testing_main_activity' => 18,
            'main_activity_description' => 19,
            'consultant_name' => 20,
            'consultant_organisation' => 21,
            'consultant_address' => 22,
            'consultant_postcode' => 23,
            'consultant_tel' => 24,
            'consultant_fax' => 25,
            'consultant_email' => 26,
            'facility_permanent' => 27,
            'facility_sample_collection' => 28,
            'facility_temporary' => 29,
            'facility_mobile' => 30,
            'sample_collection_list' => 31,
            'fields_of_testing' => 32,
            'other_field' => 33,
        ],
        'Technical Management' => [
            'department' => 0,
            'name_designation' => 1,
            'qualification' => 2,
            'experience' => 3,
            'training' => 4,
            'authorized_area' => 5,
            'signature' => 6,
        ],
        'Quality Manager' => [
            'name' => 0,
            'qualification' => 1,
            'experience' => 2,
            'training' => 3,
            'signature' => 4,
        ],
        'Laboratory Staff' => [
            'section_name' => 0,
            'section_leader' => 1,
            'qualification' => 2,
            'experience' => 3,
            'training' => 4,
            'authorized_area' => 5,
        ],
        'Test Scope' => [
            'sample_type' => 0,
            'test_type' => 1,
            'range' => 2,
            'detection_limit' => 3,
            'uncertainty' => 4,
            'standard_method' => 5,
            'equipment_used' => 6,
            'qc_measures' => 7,
        ],
        'Equipment' => [
            'equipment_name' => 0,
            'model' => 1,
            'capacity' => 2,
            'detection_limit' => 3,
            'calibration_date' => 4,
            'next_calibration' => 5,
            'usage' => 6,
        ],
        'Reference Materials' => [
            'name' => 0,
            'supplier' => 1,
            'expiry' => 2,
            'traceability' => 3,
            'purpose' => 4,
        ],
        'Proficiency Testing' => [
            'sample_type' => 0,
            'test' => 1,
            'date' => 2,
            'organizing_body' => 3,
            'z_score' => 4,
            'corrective_action' => 5,
        ],
        'About Your Quality System' => [
            'calibration_program_exists' => 0,
            'calibration_program_comment' => 1,
            'record_maintained' => 2,
            'record_maintained_comment' => 3,
            'facilities_adequate' => 4,
            'facilities_adequate_comment' => 5,
            'internal_procedure_exists' => 6,
            'internal_procedure_comment' => 7,
            'traceability_pnac' => 8,
            'traceability_pnac_comment' => 9,
            'traceability_other' => 10,
            'in_house_calibration' => 11,
            'in_house_uncertainty_identified' => 12,
            'in_house_uncertainty_incorporated' => 13,
            'complies' => 14,
        ],
        'Area of non-compliance' => [
            'area' => 0,
            'rectification_date' => 1,
        ],
        'Other Approvals' => [
            'body_name' => 0,
            'scope' => 1,
            'certificate_no' => 2,
            'start_date' => 3,
            'expiry_date' => 4,
        ],
        'Declaration' => [
            'application_types' => 0,
            'other_type' => 1,
            'agreement_accepted' => 2,
            'fee' => 3,
            'signed_by' => 4,
            'signed_date' => 5,
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

    $renderDetails = function (array $items) {
        echo '<div class="details-grid">';
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
                    $cellValue = $value($row, $field);
                    if (is_array($cellValue)) {
                        $cellValue = implode(', ', $cellValue);
                    }
                    echo '<td>' . e($cellValue ?: '-') . '</td>';
                }
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="' . count($columns) . '" class="text-muted">No records saved.</td></tr>';
        }
        echo '</tbody></table></div>';
    };
@endphp

@section('main-content')
    <div class="main-content">
        <div class="pnac-vertical-form mlab-application-form w-100">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h4 class="mb-0 text-success">Medical Laboratory Accreditation (ISO 15189)</h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">{{ $mlabApplication->status }}</span>
                    {{-- <span class="badge bg-light text-dark">{{ $mlabApplication->application_no ?: 'Draft' }}</span> --}}
                </div>
            </div>

            <div id="pnacVerticalForm">

                {{-- ========================================================== --}}
                {{-- STEP 1: About Yourselves                                   --}}
                {{-- ========================================================== --}}
                @php $step1 = $mlabData['step1_organisation'] ?? null; @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step1"
                    data-open="{{ $openSection === 'step1' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 1:
                                {{ $getSection('About Yourselves') ? $getSection('About Yourselves')['title'] : 'About Yourselves' }}
                            </h5>
                            <p class="text-muted mb-0">Please type or use BLOCK LETTERS.</p>
                        </div>
                        <span class="badge {{ $isSaved('step1') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step1') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step1'))
                        <form method="POST" action="{{ $sectionUrl('step1') }}" class="js-card-form mlab-js-card-form">
                            @csrf

                            <div class="row g-3">
                                {{-- Organisation Name and Address (master table fields) --}}
                                <div class="col-md-6">
                                    <label
                                        class="form-label">{{ $getLabel('About Yourselves', 'organisation_name', 'Organisation Name') }}
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" name="organisation_name"
                                        value="{{ old('organisation_name', $mlabApplication->organisation_name ?? '') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label">{{ $getLabel('About Yourselves', 'lab_address', 'Medical Laboratory Address') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="lab_address" rows="2" required>{{ old('lab_address', $mlabApplication->lab_address ?? '') }}</textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Postcode</label>
                                    <input class="form-control" name="postcode"
                                        value="{{ old('postcode', $general->postal_code ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Telephone</label>
                                    <input class="form-control" name="tel"
                                        value="{{ old('tel', $general->telephone ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fax</label>
                                    <input class="form-control" name="fax"
                                        value="{{ old('fax', $general->fax ?? '') }}">
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
                                    <input class="form-control" name="city"
                                        value="{{ old('city', $general->city ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Country</label>
                                    <input class="form-control" name="country"
                                        value="{{ old('country', $general->country ?? '') }}">
                                </div>

                                {{-- 1.1 Name and position of authorising person --}}
                                <div class="col-12">
                                    <h6 class="fw-bold">1.1 Name and position (Director level) of person authorising this
                                        application</h6>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'title', 'Title') }} <span
                                            class="text-danger">*</span></label><input class="form-control" name="title"
                                        value="{{ old('title', $step1->title ?? '') }}" required></div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'contact_name', 'Name') }}
                                        <span class="text-danger">*</span></label><input class="form-control"
                                        name="contact_name" value="{{ old('contact_name', $step1->contact_name ?? '') }}"
                                        required></div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'contact_designation', 'Position') }}
                                        <span class="text-danger">*</span></label><input class="form-control"
                                        name="contact_designation"
                                        value="{{ old('contact_designation', $step1->contact_designation ?? '') }}"
                                        required></div>

                                {{-- 1.2 Parent Organisation (if any) — asterisk/required SKIP --}}
                                <div class="col-12 mt-3">
                                    <h6 class="fw-bold">1.2 Name and address of the parent organisation (if any)</h6>
                                </div>
                                <div class="col-md-12"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'parent_organisation', 'Parent Organisation') }}</label><input
                                        class="form-control" name="parent_organisation"
                                        value="{{ old('parent_organisation', $step1->parent_organisation ?? '') }}"></div>
                                <div class="col-md-12"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'parent_relationship', 'Relationship with Parent organisation') }}</label><input
                                        class="form-control" name="parent_relationship"
                                        value="{{ old('parent_relationship', $step1->parent_relationship ?? '') }}"></div>
                                <div class="col-md-12"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'parent_address', 'Address') }}</label>
                                    <textarea class="form-control" name="parent_address" rows="2">{{ old('parent_address', $step1->parent_address ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'parent_tel', 'Tel') }}</label><input
                                        class="form-control" name="parent_tel"
                                        value="{{ old('parent_tel', $step1->parent_tel ?? '') }}"></div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'parent_fax', 'Fax') }}</label><input
                                        class="form-control" name="parent_fax"
                                        value="{{ old('parent_fax', $step1->parent_fax ?? '') }}"></div>

                                {{-- 1.3 Invoice Address --}}
                                <div class="col-12 mt-3">
                                    <h6 class="fw-bold">1.3 Address for invoicing (if different from the laboratory’s
                                        address)</h6>
                                </div>
                                <div class="col-md-12"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'invoice_organisation', 'Organisation') }}
                                        <span class="text-danger">*</span></label><input class="form-control"
                                        name="invoice_organisation"
                                        value="{{ old('invoice_organisation', $step1->invoice_organisation ?? '') }}"
                                        required>
                                </div>
                                <div class="col-md-12"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'invoice_address', 'Address') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="invoice_address" rows="2" required>{{ old('invoice_address', $step1->invoice_address ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'invoice_postcode', 'Postcode') }}
                                        <span class="text-danger">*</span></label><input class="form-control"
                                        name="invoice_postcode"
                                        value="{{ old('invoice_postcode', $step1->invoice_postcode ?? '') }}" required>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'invoice_tel', 'Tel') }} <span
                                            class="text-danger">*</span></label><input class="form-control"
                                        name="invoice_tel" value="{{ old('invoice_tel', $step1->invoice_tel ?? '') }}"
                                        required>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'invoice_fax', 'Fax') }} <span
                                            class="text-danger">*</span></label><input class="form-control"
                                        name="invoice_fax" value="{{ old('invoice_fax', $step1->invoice_fax ?? '') }}"
                                        required>
                                </div>

                                {{-- 1.4 Ownership --}}
                                <div class="col-12 mt-3">
                                    <h6 class="fw-bold">
                                        {{ $getLabel('About Yourselves', 'ownership_type', '1.4 Information about ownership: please tick the appropriate box.') }}
                                        <span class="text-danger">*</span>
                                    </h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        @php
                                            $ownershipOptions = [
                                                'Owned by an individual' => 'Owned by an individual',
                                                'Owned by a private company/partnership' =>
                                                    'Owned by a private company/partnership',
                                                'Part of an academic institution' => 'Part of an academic institution',
                                                'Owned by public hospital' => 'Owned by public hospital',
                                                'Owned by a private hospital' => 'Owned by a private hospital',
                                                'Other' => 'Other',
                                            ];
                                            $selectedOwnership = old('ownership_type', $step1->ownership_type ?? '');
                                        @endphp
                                        @foreach ($ownershipOptions as $value => $label)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ownership_type"
                                                        value="{{ $value }}" id="own_{{ $loop->index }}"
                                                        @if ($loop->first) required @endif
                                                        @if ($selectedOwnership === $value) checked @endif>
                                                    <label class="form-check-label"
                                                        for="own_{{ $loop->index }}">{{ $label }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-2">
                                        <label
                                            class="form-label">{{ $getLabel('About Yourselves', 'registration_no', 'Registration No. (if applicable)') }}
                                            <span class="text-danger">*</span></label>
                                        <input class="form-control" name="registration_no"
                                            value="{{ old('registration_no', $step1->registration_no ?? '') }}" required>
                                        <label
                                            class="form-label">{{ $getLabel('About Yourselves', 'ownership_other_description', 'If Other, please describe') }}
                                            <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="ownership_other_description" rows="2" required>{{ old('ownership_other_description', $step1->ownership_other_description ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- 1.5 Main activity of parent company --}}
                                <div class="col-12 mt-3">
                                    <h6 class="fw-bold">
                                        {{ $getLabel('About Yourselves', 'testing_main_activity', '1.5 Is testing the main activity of the parent company?') }}
                                        <span class="text-danger">*</span>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="testing_main_activity"
                                            value="yes" id="tma_yes" required
                                            @if (old('testing_main_activity', $step1->testing_main_activity ?? '') === 'yes') checked @endif>
                                        <label class="form-check-label" for="tma_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="testing_main_activity"
                                            value="no" id="tma_no" required
                                            @if (old('testing_main_activity', $step1->testing_main_activity ?? '') === 'no') checked @endif>
                                        <label class="form-check-label" for="tma_no">No</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label">{{ $getLabel('About Yourselves', 'main_activity_description', 'If No, describe the main activities of the parent company') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="main_activity_description" rows="2" required>{{ old('main_activity_description', $step1->main_activity_description ?? '') }}</textarea>
                                </div>

                                {{-- 1.6 Consultant (if any) — asterisk/required SKIP --}}
                                <div class="col-12 mt-3">
                                    <h6 class="fw-bold">1.6 Name of Consultant / Consultancy Firm (if any)</h6>
                                </div>
                                <div class="col-md-6"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_name', 'Name') }}</label><input
                                        class="form-control" name="consultant_name"
                                        value="{{ old('consultant_name', $step1->consultant_name ?? '') }}"></div>
                                <div class="col-md-6"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_organisation', 'Organisation') }}</label><input
                                        class="form-control" name="consultant_organisation"
                                        value="{{ old('consultant_organisation', $step1->consultant_organisation ?? '') }}">
                                </div>
                                <div class="col-md-12"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_address', 'Address') }}</label>
                                    <textarea class="form-control" name="consultant_address" rows="2">{{ old('consultant_address', $step1->consultant_address ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_postcode', 'Postcode') }}</label><input
                                        class="form-control" name="consultant_postcode"
                                        value="{{ old('consultant_postcode', $step1->consultant_postcode ?? '') }}"></div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_tel', 'Tel') }}</label><input
                                        class="form-control" name="consultant_tel"
                                        value="{{ old('consultant_tel', $step1->consultant_tel ?? '') }}"></div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_fax', 'Fax') }}</label><input
                                        class="form-control" name="consultant_fax"
                                        value="{{ old('consultant_fax', $step1->consultant_fax ?? '') }}"></div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('About Yourselves', 'consultant_email', 'E-Mail') }}</label><input
                                        type="email" class="form-control" name="consultant_email"
                                        value="{{ old('consultant_email', $step1->consultant_email ?? '') }}"></div>

                                {{-- 1.7 Facility Types --}}
                                <div class="col-12 mt-3">
                                    <h6 class="fw-bold">1.7 Do you conduct Testing in the following category? (if yes,
                                        please clearly mention the scope of accreditation, Part of this application)</h6>
                                </div>
                                @php
                                    $facilityTypes = [
                                        'facility_permanent' => 'Permanent facility',
                                        'facility_sample_collection' => 'Sample Collection Centre',
                                        'facility_temporary' =>
                                            'Temporary Facility (when a facility is created temporarily)',
                                        'facility_mobile' => 'Mobile Laboratory',
                                    ];
                                @endphp
                                @foreach ($facilityTypes as $field => $label)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="{{ $field }}"
                                                value="yes" id="{{ $field }}"
                                                @if (old($field, $step1->{$field} ?? '') === 'yes') checked @endif>
                                            <label class="form-check-label"
                                                for="{{ $field }}">{{ $getLabel('About Yourselves', $field, $label) }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-12">
                                    <label
                                        class="form-label">{{ $getLabel('About Yourselves', 'sample_collection_list', 'If Sample Collection Centre is Yes, attach list of sample collection centres (upload later)') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="file" name="sample_collection_list" class="form-control">
                                </div>

                                {{-- Fields of Testing --}}
                                <div class="col-12 mt-3">
                                    <label
                                        class="form-label">{{ $getLabel('About Yourselves', 'fields_of_testing', 'Fields of Testing') }}
                                        <span class="text-danger">*</span></label>
                                    <div class="row">
                                        @php $fields = ['Clinical Chemistry', 'Haematology', 'Histopathology', 'Immunology', 'Microbiology', 'Molecular Biology']; @endphp
                                        @foreach ($fields as $field)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="fields_of_testing[]" value="{{ $field }}"
                                                        @if (is_array(old('fields_of_testing', $step1->fields_of_testing ?? [])) &&
                                                                in_array($field, old('fields_of_testing', $step1->fields_of_testing ?? []))) checked @endif>
                                                    <label class="form-check-label">{{ $field }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="fields_of_testing[]" value="Other" id="otherFieldCheck">
                                                <label class="form-check-label">Other</label>
                                            </div>
                                            <input class="form-control mt-1" name="other_field"
                                                placeholder="Please specify"
                                                value="{{ old('other_field', $step1->other_field ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-success btn-sm">Save Draft</button>
                            </div>
                        </form>
                    @else
                        {{-- View Mode --}}
                        @php
                            // Ensure we have organisation_name and lab_address from master application
                            $renderDetails(
                                array_merge(
                                    [
                                        $getLabel('About Yourselves', 'organisation_name', 'Organisation Name') =>
                                            $mlabApplication->organisation_name ?? '-',
                                        $getLabel('About Yourselves', 'lab_address', 'Laboratory Address') =>
                                            $mlabApplication->lab_address ?? '-',
                                        'Postcode' => $general->postal_code ?? '-',
                                        'Telephone' => $general->telephone ?? '-',
                                        'Fax' => $general->fax ?? '-',
                                        'NTN/FTN' => $general->ntn_ftn ?? '-',
                                        'Website' => $general->website ?? '-',
                                        'City' => $general->city ?? '-',
                                        'Country' => $general->country ?? '-',
                                    ],
                                    [
                                        $getLabel('About Yourselves', 'title', 'Title') => $step1->title ?? '-',
                                        $getLabel('About Yourselves', 'contact_name', 'Name') =>
                                            $step1->contact_name ?? '-',
                                        $getLabel('About Yourselves', 'contact_designation', 'Position') =>
                                            $step1->contact_designation ?? '-',
                                        $getLabel('About Yourselves', 'parent_organisation', 'Parent Organisation') =>
                                            $step1->parent_organisation ?? '-',
                                        $getLabel('About Yourselves', 'parent_relationship', 'Relationship') =>
                                            $step1->parent_relationship ?? '-',
                                        $getLabel('About Yourselves', 'parent_address', 'Parent Address') =>
                                            $step1->parent_address ?? '-',
                                        $getLabel('About Yourselves', 'parent_postcode', 'Parent Postcode') =>
                                            $step1->parent_postcode ?? '-',
                                        $getLabel('About Yourselves', 'parent_tel', 'Parent Tel') =>
                                            $step1->parent_tel ?? '-',
                                        $getLabel('About Yourselves', 'parent_fax', 'Parent Fax') =>
                                            $step1->parent_fax ?? '-',
                                        $getLabel('About Yourselves', 'invoice_organisation', 'Invoice Organisation') =>
                                            $step1->invoice_organisation ?? '-',
                                        $getLabel('About Yourselves', 'invoice_address', 'Invoice Address') =>
                                            $step1->invoice_address ?? '-',
                                        $getLabel('About Yourselves', 'invoice_postcode', 'Invoice Postcode') =>
                                            $step1->invoice_postcode ?? '-',
                                        $getLabel('About Yourselves', 'invoice_tel', 'Invoice Tel') =>
                                            $step1->invoice_tel ?? '-',
                                        $getLabel('About Yourselves', 'invoice_fax', 'Invoice Fax') =>
                                            $step1->invoice_fax ?? '-',
                                        $getLabel('About Yourselves', 'ownership_type', 'Ownership') =>
                                            $step1->ownership_type ?? '-',
                                        $getLabel('About Yourselves', 'registration_no', 'Registration No.') =>
                                            $step1->registration_no ?? '-',
                                        $getLabel(
                                            'About Yourselves',
                                            'ownership_other_description',
                                            'Other Ownership Description',
                                        ) => $step1->ownership_other_description ?? '-',
                                        $getLabel(
                                            'About Yourselves',
                                            'testing_main_activity',
                                            'Testing Main Activity?',
                                        ) => ucfirst($step1->testing_main_activity ?? '-'),
                                        $getLabel(
                                            'About Yourselves',
                                            'main_activity_description',
                                            'Main Activity Description',
                                        ) => $step1->main_activity_description ?? '-',
                                        $getLabel('About Yourselves', 'consultant_name', 'Consultant Name') =>
                                            $step1->consultant_name ?? '-',
                                        $getLabel(
                                            'About Yourselves',
                                            'consultant_organisation',
                                            'Consultant Organisation',
                                        ) => $step1->consultant_organisation ?? '-',
                                        $getLabel('About Yourselves', 'consultant_address', 'Consultant Address') =>
                                            $step1->consultant_address ?? '-',
                                        $getLabel('About Yourselves', 'consultant_postcode', 'Consultant Postcode') =>
                                            $step1->consultant_postcode ?? '-',
                                        $getLabel('About Yourselves', 'consultant_tel', 'Consultant Tel') =>
                                            $step1->consultant_tel ?? '-',
                                        $getLabel('About Yourselves', 'consultant_fax', 'Consultant Fax') =>
                                            $step1->consultant_fax ?? '-',
                                        $getLabel('About Yourselves', 'consultant_email', 'Consultant Email') =>
                                            $step1->consultant_email ?? '-',
                                        $getLabel('About Yourselves', 'facility_permanent', 'Permanent Facility') =>
                                            ($step1->facility_permanent ?? '') === 'yes' ? 'Yes' : 'No',
                                        $getLabel(
                                            'About Yourselves',
                                            'facility_sample_collection',
                                            'Sample Collection Centre',
                                        ) => ($step1->facility_sample_collection ?? '') === 'yes' ? 'Yes' : 'No',
                                        $getLabel('About Yourselves', 'facility_temporary', 'Temporary Facility') =>
                                            ($step1->facility_temporary ?? '') === 'yes' ? 'Yes' : 'No',
                                        $getLabel('About Yourselves', 'facility_mobile', 'Mobile Laboratory') =>
                                            ($step1->facility_mobile ?? '') === 'yes' ? 'Yes' : 'No',
                                        $getLabel(
                                            'About Yourselves',
                                            'fields_of_testing',
                                            'Fields of Testing',
                                        ) => is_array($step1->fields_of_testing ?? [])
                                            ? implode(', ', $step1->fields_of_testing)
                                            : '-',
                                        $getLabel('About Yourselves', 'other_field', 'Other Testing Field') =>
                                            $step1->other_field ?? '-',
                                    ],
                                ),
                            );
                        @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step1') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>
                @php
                    $technicalManagement = $mlabData['technical_management'] ?? collect();
                    $qualityManager = $mlabData['quality_manager'] ?? null;
                    $labStaff = $mlabData['lab_staff'] ?? collect();
                    $techMgmtTitle = $getSection('Technical Management')
                        ? $getSection('Technical Management')['title']
                        : 'Technical Management';
                    $techMgmtCols = $getColumns('Technical Management', [
                        'department' => 'Department',
                        'name_designation' => 'Name & Designation',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                        'training' => 'Training',
                        'authorized_area' => 'Authorized Area',
                        'signature' => 'Signature',
                    ]);
                    $qmTitle = $getSection('Quality Manager')
                        ? $getSection('Quality Manager')['title']
                        : 'Quality Manager';
                    $qmCols = $getColumns('Quality Manager', [
                        'name' => 'Name',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                        'training' => 'Training',
                        'signature' => 'Signature',
                    ]);
                    $labStaffTitle = $getSection('Laboratory Staff')
                        ? $getSection('Laboratory Staff')['title']
                        : 'Laboratory Staff';
                    $labStaffCols = $getColumns('Laboratory Staff', [
                        'section_name' => 'Section Name',
                        'section_leader' => 'Section Leader',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                        'training' => 'Training',
                        'authorized_area' => 'Authorized Area',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step2"
                    data-open="{{ $openSection === 'step2' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 2:
                                {{ $getSection('Staff Information') ? $getSection('Staff Information')['title'] : 'Staff Information' }}
                            </h5>
                            <p class="text-muted mb-0">Technical management, quality manager, and lab staff.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step2') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step2') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step2'))
                        <form method="POST" action="{{ $sectionUrl('step2') }}" class="js-card-form mlab-js-card-form">
                            @csrf
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $techMgmtTitle,
                                'target' => 'mlabTechMgmtRows',
                                'name' => 'technical_management',
                                'rows' => $firstRow(
                                    $technicalManagement,
                                    array_fill_keys(array_keys($techMgmtCols), '')),
                                'columns' => $techMgmtCols,
                                'isLocked' => $isLocked,
                            ])
                            @php
                                $qm = $firstRow($qualityManager, array_fill_keys(array_keys($qmCols), ''));
                            @endphp

                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $qmTitle,
                                'target' => 'mlabQualityManagerRows',
                                'name' => 'quality_manager',
                                'rows' => $qm,
                                'columns' => $qmCols,
                                'isLocked' => $isLocked,
                            ])
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $labStaffTitle,
                                'target' => 'mlabLabStaffRows',
                                'name' => 'lab_staff',
                                'rows' => $firstRow($labStaff, array_fill_keys(array_keys($labStaffCols), '')),
                                'columns' => $labStaffCols,
                                'isLocked' => $isLocked,
                            ])
                            <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                                    Draft</button></div>
                        </form>
                    @else
                        <h6><strong>{{ $techMgmtTitle }}</strong></h6>
                        @php $renderTable($technicalManagement, $techMgmtCols); @endphp
                        <h6 class="mt-4"><strong>{{ $qmTitle }}</strong></h6>
                        @php
                            $qmCollection =
                                $qualityManager instanceof \Illuminate\Support\Collection
                                    ? $qualityManager
                                    : ($qualityManager
                                        ? collect([$qualityManager])
                                        : collect());
                        @endphp
                        @php $renderTable($qmCollection, $qmCols); @endphp
                        <h6 class="mt-4"><strong>{{ $labStaffTitle }}</strong></h6>
                        @php $renderTable($labStaff, $labStaffCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step2') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ========================================================== --}}
                {{-- STEP 3: Scope of Application                                 --}}
                {{-- ========================================================== --}}
                @php
                    $scopeTests = $mlabData['scope_tests'] ?? collect();
                    $equipment = $mlabData['equipment'] ?? collect();
                    $referenceMaterials = $mlabData['reference_materials'] ?? collect();
                    $proficiencyTesting = $mlabData['proficiency_testing'] ?? collect();

                    $testScopeTitle = $getSection('Test Scope') ? $getSection('Test Scope')['title'] : 'Test Scope';
                    $testScopeCols = $getColumns('Test Scope', [
                        'sample_type' => 'Sample Type / Matrix',
                        'test_type' => 'Test Type',
                        'range' => 'Range',
                        'detection_limit' => 'Detection Limit',
                        'uncertainty' => 'Uncertainty (MU)',
                        'standard_method' => 'Standard Method',
                        'equipment_used' => 'Equipment Used',
                        'qc_measures' => 'QC Measures',
                    ]);
                    $equipmentTitle = $getSection('Equipment') ? $getSection('Equipment')['title'] : 'Equipment';
                    $equipmentCols = $getColumns('Equipment', [
                        'equipment_name' => 'Equipment Name',
                        'model' => 'Model',
                        'capacity' => 'Capacity',
                        'detection_limit' => 'Detection Limit',
                        'calibration_date' => 'Calibration Date',
                        'next_calibration' => 'Next Calibration',
                        'usage' => 'Usage',
                    ]);
                    $refMaterialsTitle = $getSection('Reference Materials')
                        ? $getSection('Reference Materials')['title']
                        : 'Reference Materials';
                    $refMaterialsCols = $getColumns('Reference Materials', [
                        'name' => 'Name',
                        'supplier' => 'Supplier',
                        'expiry' => 'Expiry',
                        'traceability' => 'Traceability',
                        'purpose' => 'Purpose',
                    ]);
                    $ptTitle = $getSection('Proficiency Testing')
                        ? $getSection('Proficiency Testing')['title']
                        : 'Proficiency Testing';
                    $ptCols = $getColumns('Proficiency Testing', [
                        'sample_type' => 'Sample Type',
                        'test' => 'Test',
                        'date' => 'Date',
                        'organizing_body' => 'Organizing Body',
                        'z_score' => 'Z-score',
                        'corrective_action' => 'Corrective Action',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step3"
                    data-open="{{ $openSection === 'step3' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 3:
                                {{ $getSection('Scope of Application') ? $getSection('Scope of Application')['title'] : 'Scope of Application' }}
                            </h5>
                            <p class="text-muted mb-0">Tests, equipment, reference materials, and proficiency testing.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step3') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step3') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step3'))
                        <form method="POST" action="{{ $sectionUrl('step3') }}" class="js-card-form mlab-js-card-form">
                            @csrf
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $testScopeTitle,
                                'target' => 'mlabScopeTestsRows',
                                'name' => 'scope_tests',
                                'rows' => $firstRow($scopeTests, array_fill_keys(array_keys($testScopeCols), '')),
                                'columns' => $testScopeCols,
                                'isLocked' => $isLocked,
                            ])
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $equipmentTitle,
                                'target' => 'mlabEquipmentRows',
                                'name' => 'equipment',
                                'rows' => $firstRow($equipment, array_fill_keys(array_keys($equipmentCols), '')),
                                'columns' => $equipmentCols,
                                'isLocked' => $isLocked,
                            ])
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $refMaterialsTitle,
                                'target' => 'mlabRefMaterialsRows',
                                'name' => 'reference_materials',
                                'rows' => $firstRow(
                                    $referenceMaterials,
                                    array_fill_keys(array_keys($refMaterialsCols), '')),
                                'columns' => $refMaterialsCols,
                                'isLocked' => $isLocked,
                            ])
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $ptTitle,
                                'target' => 'mlabPTRows',
                                'name' => 'proficiency_testing',
                                'rows' => $firstRow($proficiencyTesting, array_fill_keys(array_keys($ptCols), '')),
                                'columns' => $ptCols,
                                'isLocked' => $isLocked,
                            ])
                            <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                                    Draft</button></div>
                        </form>
                    @else
                        <h6><strong>{{ $testScopeTitle }}</strong></h6>
                        @php $renderTable($scopeTests, $testScopeCols); @endphp
                        <h6 class="mt-4"><strong>{{ $equipmentTitle }}</strong></h6>
                        @php $renderTable($equipment, $equipmentCols); @endphp
                        <h6 class="mt-4"><strong>{{ $refMaterialsTitle }}</strong></h6>
                        @php $renderTable($referenceMaterials, $refMaterialsCols); @endphp
                        <h6 class="mt-4"><strong>{{ $ptTitle }}</strong></h6>
                        @php $renderTable($proficiencyTesting, $ptCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step3') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ========================================================== --}}
                {{-- STEP 4: Quality System                                     --}}
                {{-- ========================================================== --}}
                {{-- ========================================================== --}}
                {{-- STEP 4: About Your Quality System                          --}}
                {{-- ========================================================== --}}
                @php
                    $calSystem = $mlabData['calibration_system'] ?? null;
                    $isoCompliance = $mlabData['iso_compliance'] ?? null;
                    $complies = $isoCompliance->complies ?? 'yes';
                    $nonComplianceRows = $isoCompliance->non_compliance_areas ?? [];
                    if (!is_array($nonComplianceRows)) {
                        $nonComplianceRows = [];
                    }
                @endphp
                @php
                    $calSystem = $mlabData['calibration_system'] ?? null;
                    $isoCompliance = $mlabData['iso_compliance'] ?? null;
                    $complies = $isoCompliance->complies ?? 'yes';
                    $nonComplianceRows = $isoCompliance->non_compliance_areas ?? [];
                    if (!is_array($nonComplianceRows)) {
                        $nonComplianceRows = [];
                    }
                    $nonComplianceTitle = $getSection('Area of non-compliance')
                        ? $getSection('Area of non-compliance')['title']
                        : 'Area of non-compliance';
                    $nonComplianceCols = $getColumns('Area of non-compliance', [
                        'area' => 'Area of non‑compliance',
                        'rectification_date' => 'Rectified by (date)',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step4"
                    data-open="{{ $openSection === 'step4' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 4:
                                {{ $getSection('About Your Quality System') ? $getSection('About Your Quality System')['title'] : 'About Your Quality System' }}
                            </h5>
                            <p class="text-muted mb-0">Please fill the PNAC form F-02/18.</p>
                        </div>
                        <span class="badge {{ $isSaved('step4') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step4') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step4'))
                        <form method="POST" action="{{ $sectionUrl('step4') }}"
                            class="js-card-form mlab-js-card-form">
                            @csrf
                            <h6 class="fw-bold">A. Equipment and calibration</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:50%;">Question</th>
                                            <th style="width:15%;">Yes</th>
                                            <th style="width:15%;">No</th>
                                            <th style="width:20%;">Quality Manual reference / other comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $questions = [
                                                [
                                                    'field' => 'calibration_program_exists',
                                                    'comment' => 'calibration_program_comment',
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'calibration_program_exists',
                                                        '1. Does a fully documented calibration program exist to ensure that the accuracy of equipment is adequate for the service operated by the laboratory?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'record_maintained',
                                                    'comment' => 'record_maintained_comment',
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'record_maintained',
                                                        '2. Is a record maintained for test equipment, including calibration results?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'facilities_adequate',
                                                    'comment' => 'facilities_adequate_comment',
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'facilities_adequate',
                                                        '3. Are adequate facilities and environments provided for calibration, handling, control, storage and maintenance of all testing & measuring equipment?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'internal_procedure_exists',
                                                    'comment' => 'internal_procedure_comment',
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'internal_procedure_exists',
                                                        '4. Are there documented procedures for internal calibration (if any) of all equipments and reference standards which cover the method of calibration and maximum intervals between calibrations?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'traceability_pnac',
                                                    'comment' => 'traceability_pnac_comment',
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'traceability_pnac',
                                                        '5. Are the internal laboratory reference standards, and the calibration of key testing equipment traceable to national standard through:',
                                                    ),
                                                ],
                                                [
                                                    'field' => null,
                                                    'comment' => 'traceability_other',
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'traceability_other',
                                                        '   - Other bodies (specify)?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'in_house_calibration',
                                                    'comment' => null,
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'in_house_calibration',
                                                        '6. Do you perform in-house calibration of your instruments?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'in_house_uncertainty_identified',
                                                    'comment' => null,
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'in_house_uncertainty_identified',
                                                        '   a. Have you identified source of uncertainty measurement?',
                                                    ),
                                                ],
                                                [
                                                    'field' => 'in_house_uncertainty_incorporated',
                                                    'comment' => null,
                                                    'label' => $getLabel(
                                                        'About Your Quality System',
                                                        'in_house_uncertainty_incorporated',
                                                        '   b. Do you incorporate uncertainty of measurement in your calibration?',
                                                    ),
                                                ],
                                            ];
                                        @endphp
                                        @foreach ($questions as $q)
                                            <tr>
                                                <td>{{ $q['label'] }}</td>
                                                <td>
                                                    @if ($q['field'])
                                                        <input type="radio" name="{{ $q['field'] }}" value="yes"
                                                            @if (($calSystem->{$q['field']} ?? '') === 'yes') checked @endif>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($q['field'])
                                                        <input type="radio" name="{{ $q['field'] }}" value="no"
                                                            @if (($calSystem->{$q['field']} ?? '') === 'no') checked @endif>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($q['comment'])
                                                        <textarea class="form-control form-control-sm" name="{{ $q['comment'] }}" rows="2">{{ old($q['comment'], $calSystem->{$q['comment']} ?? '') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <h6 class="fw-bold">B. Compliance with ISO 15189:2012 and PNAC Accreditation Requirements</h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label
                                        class="fw-semibold">{{ $getLabel('About Your Quality System', 'complies', '1. Do you consider that your laboratory complies with ISO 15189:2012 and PNAC accreditation requirements?') }}</label>
                                    <div class="mt-1">
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input mlab-iso-toggle" type="radio"
                                                name="iso_compliance[complies]" value="yes"
                                                @checked($complies === 'yes')> Yes
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input mlab-iso-toggle" type="radio"
                                                name="iso_compliance[complies]" value="no"
                                                @checked($complies === 'no')> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mlab-non-compliance-wrap mt-3">
                                @include('admin.application.medical_laboratory._repeatable_table', [
                                    'title' => $nonComplianceTitle,
                                    'target' => 'mlabNonComplianceRows',
                                    'name' => 'iso_compliance[non_compliance_areas]',
                                    'rows' =>
                                        $complies === 'no'
                                            ? (count($nonComplianceRows)
                                                ? collect($nonComplianceRows)
                                                : collect([['area' => '', 'rectification_date' => '']]))
                                            : collect([['area' => '', 'rectification_date' => '']]),
                                    'columns' => $nonComplianceCols,
                                    'isLocked' => $isLocked,
                                ])
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-success btn-sm">Save Draft</button>
                            </div>
                        </form>
                    @else
                        {{-- View Mode --}}
                        @php
                            $renderDetails([
                                $getLabel(
                                    'About Your Quality System',
                                    'calibration_program_exists',
                                    'Calibration Program Exists',
                                ) => ucfirst($calSystem->calibration_program_exists ?? '-'),
                                $getLabel('About Your Quality System', 'calibration_program_comment', 'Comment') =>
                                    $calSystem->calibration_program_comment ?? '-',
                                $getLabel(
                                    'About Your Quality System',
                                    'record_maintained',
                                    'Record Maintained',
                                ) => ucfirst($calSystem->record_maintained ?? '-'),
                                $getLabel('About Your Quality System', 'record_maintained_comment', 'Comment') =>
                                    $calSystem->record_maintained_comment ?? '-',
                                $getLabel(
                                    'About Your Quality System',
                                    'facilities_adequate',
                                    'Facilities Adequate',
                                ) => ucfirst($calSystem->facilities_adequate ?? '-'),
                                $getLabel('About Your Quality System', 'facilities_adequate_comment', 'Comment') =>
                                    $calSystem->facilities_adequate_comment ?? '-',
                                $getLabel(
                                    'About Your Quality System',
                                    'internal_procedure_exists',
                                    'Internal Procedure Exists',
                                ) => ucfirst($calSystem->internal_procedure_exists ?? '-'),
                                $getLabel('About Your Quality System', 'internal_procedure_comment', 'Comment') =>
                                    $calSystem->internal_procedure_comment ?? '-',
                                $getLabel(
                                    'About Your Quality System',
                                    'traceability_pnac',
                                    'Traceability PNAC',
                                ) => ucfirst($calSystem->traceability_pnac ?? '-'),
                                $getLabel('About Your Quality System', 'traceability_pnac_comment', 'Comment') =>
                                    $calSystem->traceability_pnac_comment ?? '-',
                                $getLabel('About Your Quality System', 'traceability_other', 'Other Bodies') =>
                                    $calSystem->traceability_other ?? '-',
                                $getLabel(
                                    'About Your Quality System',
                                    'in_house_calibration',
                                    'In-house Calibration',
                                ) => ucfirst($calSystem->in_house_calibration ?? '-'),
                                $getLabel(
                                    'About Your Quality System',
                                    'in_house_uncertainty_identified',
                                    'Uncertainty Identified',
                                ) => ucfirst($calSystem->in_house_uncertainty_identified ?? '-'),
                                $getLabel(
                                    'About Your Quality System',
                                    'in_house_uncertainty_incorporated',
                                    'Uncertainty Incorporated',
                                ) => ucfirst($calSystem->in_house_uncertainty_incorporated ?? '-'),
                                $getLabel('About Your Quality System', 'complies', 'ISO 15189 Compliance') => ucfirst(
                                    $complies,
                                ),
                            ]);
                            if ($complies === 'no') {
                                echo '<h6 class="mt-4"><strong>' . e($nonComplianceTitle) . '</strong></h6>';
                                $renderTable(collect($nonComplianceRows), $nonComplianceCols);
                            }
                        @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step4') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- STEP 5: Other Approvals                                    --}}
                {{-- ========================================================== --}}
                @php
                    $otherApprovals = $mlabData['other_approvals'] ?? collect();
                    $otherApprovalsTitle = $getSection('Other Approvals')
                        ? $getSection('Other Approvals')['title']
                        : 'Other Approvals';
                    $otherApprovalsCols = $getColumns('Other Approvals', [
                        'body_name' => 'Approval Body Name',
                        'scope' => 'Scope',
                        'certificate_no' => 'Certificate No',
                        'start_date' => 'Start Date',
                        'expiry_date' => 'Expiry Date',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step5"
                    data-open="{{ $openSection === 'step5' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 5: {{ $otherApprovalsTitle }}</h5>
                            <p class="text-muted mb-0">Existing approvals and certificates.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step5') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step5') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step5'))
                        <form method="POST" action="{{ $sectionUrl('step5') }}"
                            class="js-card-form mlab-js-card-form">
                            @csrf
                            @include('admin.application.medical_laboratory._repeatable_table', [
                                'title' => $otherApprovalsTitle,
                                'target' => 'mlabApprovalRows',
                                'name' => 'other_approvals',
                                'rows' => $firstRow(
                                    $otherApprovals,
                                    array_fill_keys(array_keys($otherApprovalsCols), '')),
                                'columns' => $otherApprovalsCols,
                                'isLocked' => $isLocked,
                            ])
                            <div class="d-flex justify-content-end mt-3"><button class="btn btn-success btn-sm">Save
                                    Draft</button></div>
                        </form>
                    @else
                        @php $renderTable($otherApprovals, $otherApprovalsCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step5') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ========================================================== --}}
                {{-- STEP 6: Declaration                                        --}}
                {{-- ========================================================== --}}

                @php
                    $declaration = $mlabData['declaration'] ?? null;
                    // Safely get application types array
                    $declarationAppTypes = [];
                    if ($declaration && isset($declaration->application_types)) {
                        $decoded = json_decode($declaration->application_types, true);
                        $declarationAppTypes = is_array($decoded) ? $decoded : [];
                    }
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step6"
                    data-open="{{ $openSection === 'step6' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 6:
                                {{ $getSection('Declaration') ? $getSection('Declaration')['title'] : 'Declaration' }}
                            </h5>
                            <p class="text-muted mb-0">Application type, agreement, fee, and final submission.</p>
                        </div>
                        <span class="badge {{ $isSaved('step6') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step6') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step6'))
                        <form method="POST" action="{{ $sectionUrl('step6') }}"
                            class="js-card-form mlab-js-card-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label
                                        class="form-label">{{ $getLabel('Declaration', 'application_types', 'Application Types') }}</label>
                                    @php $appTypes = ['Clinical Chemistry', 'Haematology', 'Histopathology', 'Immunology', 'Microbiology', 'Molecular Biology']; @endphp
                                    <div class="row">
                                        @foreach ($appTypes as $type)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="application_types[]" value="{{ $type }}"
                                                        @if (in_array($type, old('application_types', $declarationAppTypes))) checked @endif>
                                                    <label class="form-check-label">{{ $type }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="application_types[]" value="Other" id="declOtherCheck">
                                                <label class="form-check-label">Other</label>
                                            </div>
                                            <input class="form-control mt-1" name="other_type"
                                                placeholder="Please specify"
                                                value="{{ old('other_type', $declaration->other_type ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agreement_accepted"
                                            value="1" @checked($declaration && $declaration->agreement_accepted ?? false) required>
                                        <label
                                            class="form-check-label">{{ $getLabel('Declaration', 'agreement_accepted', 'I agree to the terms and conditions.') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('Declaration', 'fee', 'Applicant Fee (PKR)') }}</label>
                                    <input class="form-control" name="fee"
                                        value="{{ old('fee', $declaration->fee ?? '') }}">
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('Declaration', 'signed_by', 'Signed By') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="signed_by"
                                        value="{{ old('signed_by', $declaration->signed_by ?? '') }}" required>
                                </div>
                                <div class="col-md-4"><label
                                        class="form-label">{{ $getLabel('Declaration', 'signed_date', 'Signed Date') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="signed_date"
                                        value="{{ old('signed_date', $declaration->signed_date ?? now()->format('Y-m-d')) }}"
                                        required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button class="btn btn-success btn-sm">Save Draft</button>

                            </div>
                        </form>
                    @else
                        {{-- View Mode --}}
                        @php
                            // Safely get app types list
                            $appTypesList = '-';
                            if ($declaration && isset($declaration->application_types)) {
                                $decoded = json_decode($declaration->application_types, true);
                                $appTypesList = is_array($decoded) ? implode(', ', $decoded) : '-';
                            }
                            $renderDetails([
                                $getLabel('Declaration', 'application_types', 'Application Types') => $appTypesList,
                                $getLabel('Declaration', 'other_type', 'Other Type') => $declaration->other_type ?? '-',
                                $getLabel('Declaration', 'agreement_accepted', 'Agreement Accepted') =>
                                    $declaration && $declaration->agreement_accepted ? 'Yes' : 'No',
                                $getLabel('Declaration', 'fee', 'Applicant Fee') => $declaration->fee ?? '-',
                                $getLabel('Declaration', 'signed_by', 'Signed By') => $declaration->signed_by ?? '-',
                                $getLabel('Declaration', 'signed_date', 'Signed Date') =>
                                    $declaration->signed_date ?? '-',
                            ]);
                        @endphp
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ $editUrl('step6') }}" class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Collapsible script (only one copy) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = Array.from(document.querySelectorAll(
                '.pnac-vertical-form #pnacVerticalForm > .pnac-step-card'
            ));
            if (!cards.length) return;

            const hasBootstrapCollapse = typeof bootstrap !== 'undefined' && typeof bootstrap.Collapse !==
                'undefined';
            const preferredOpenSection = '{{ session('open_section', request('edit_section')) }}';

            cards.forEach(function(card, index) {
                const header = card.querySelector(':scope > .d-flex.justify-content-between');
                if (!header) return;

                const bodyId = 'pnacCollapseBody' + (index + 1);
                const body = document.createElement('div');
                body.id = bodyId;
                body.className = hasBootstrapCollapse ? 'collapse pnac-collapse-body' :
                    'pnac-collapse-body';

                const childrenToMove = Array.from(card.children).filter(function(child) {
                    return child !== header;
                });
                childrenToMove.forEach(function(child) {
                    body.appendChild(child);
                });
                card.appendChild(body);

                header.classList.add('pnac-collapsible-header');
                header.setAttribute('role', 'button');
                header.setAttribute('tabindex', '0');
                header.setAttribute('aria-controls', bodyId);

                const titleArea = document.createElement('div');
                titleArea.className = 'pnac-card-title-area';

                const existingTitle = header.querySelector(':scope > div');
                if (existingTitle) {
                    titleArea.appendChild(existingTitle);
                } else {
                    const heading = header.querySelector('h4, h5, h3');
                    if (heading) {
                        titleArea.appendChild(heading);
                    }
                }

                const actions = document.createElement('div');
                actions.className = 'pnac-card-actions';

                const existingBadge = header.querySelector('.badge');
                if (existingBadge) {
                    actions.appendChild(existingBadge);
                }

                const chevron = document.createElement('span');
                chevron.className = 'pnac-collapse-chevron';
                chevron.setAttribute('aria-hidden', 'true');
                actions.appendChild(chevron);

                header.innerHTML = '';
                header.appendChild(titleArea);
                header.appendChild(actions);

                const cardSection = card.getAttribute('data-section');
                const shouldOpen = preferredOpenSection ? preferredOpenSection === cardSection : index ===
                    0;

                if (shouldOpen) {
                    header.setAttribute('aria-expanded', 'true');
                    if (hasBootstrapCollapse) {
                        body.classList.add('show');
                    } else {
                        body.style.maxHeight = '9999px';
                        body.classList.add('pnac-is-open');
                    }
                } else {
                    header.setAttribute('aria-expanded', 'false');
                    if (!hasBootstrapCollapse) {
                        body.style.maxHeight = '0px';
                    }
                }

                const toggleBody = function() {
                    if (hasBootstrapCollapse) {
                        const instance = bootstrap.Collapse.getOrCreateInstance(body, {
                            toggle: false
                        });
                        if (body.classList.contains('show')) {
                            instance.hide();
                        } else {
                            instance.show();
                        }
                    } else {
                        const isExpanded = header.getAttribute('aria-expanded') === 'true';
                        if (isExpanded) {
                            body.style.maxHeight = '0px';
                            body.classList.remove('pnac-is-open');
                        } else {
                            // Use a large value so content is never clipped
                            body.style.maxHeight = '9999px';
                            body.classList.add('pnac-is-open');
                        }
                        header.setAttribute('aria-expanded', String(!isExpanded));
                    }
                };

                header.addEventListener('click', toggleBody);
                header.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        toggleBody();
                    }
                });

                if (hasBootstrapCollapse) {
                    body.addEventListener('shown.bs.collapse', function() {
                        header.setAttribute('aria-expanded', 'true');
                    });
                    body.addEventListener('hidden.bs.collapse', function() {
                        header.setAttribute('aria-expanded', 'false');
                    });
                }
            });

            // After all sections are set up, recalculate open section heights
            // using a small delay to allow images/fonts to load
            setTimeout(function() {
                cards.forEach(function(card) {
                    const collapseBody = card.querySelector('.pnac-collapse-body');
                    if (!collapseBody || hasBootstrapCollapse) return;
                    const header = card.querySelector('.pnac-collapsible-header');
                    if (header && header.getAttribute('aria-expanded') === 'true') {
                        collapseBody.style.maxHeight = collapseBody.scrollHeight + 'px';
                    }
                });
            }, 100);
        });
    </script>

    {{-- Form validation script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.js-card-form');
            if (!forms.length) return;

            const attachError = function(field, message) {
                let holder = field.parentElement.querySelector('.field-error');
                if (!holder) {
                    holder = document.createElement('small');
                    holder.className = 'field-error';
                    field.parentElement.appendChild(holder);
                }
                holder.textContent = message;
                field.classList.add('is-invalid');
            };

            const clearError = function(field) {
                field.classList.remove('is-invalid');
                const holder = field.parentElement.querySelector('.field-error');
                if (holder) holder.remove();
            };

            forms.forEach(function(form) {
                const fields = form.querySelectorAll('input, select, textarea');

                fields.forEach(function(field) {
                    const wrapper = field.closest('div');
                    const label = wrapper ? wrapper.querySelector('label.form-label') : null;
                    const labelText = label ? label.textContent.replace(':', '').trim() :
                        'This field';
                    if (!field.dataset.error) {
                        field.dataset.error = 'Please enter ' + labelText.toLowerCase() + '.';
                    }
                    if (field.type === 'email' && !field.dataset.errorType) {
                        field.dataset.errorType = 'Please enter a valid email address.';
                    }
                    if (field.type === 'url' && !field.dataset.errorType) {
                        field.dataset.errorType = 'Please enter a valid website URL.';
                    }
                });

                fields.forEach(function(field) {
                    field.addEventListener('input', function() {
                        clearError(field);
                    });
                    field.addEventListener('change', function() {
                        clearError(field);
                    });
                });

                form.addEventListener('submit', function(event) {
                    let hasError = false;
                    fields.forEach(function(field) {
                        clearError(field);
                        if (field.disabled || field.type === 'hidden' || field.type ===
                            'button' || field.type === 'submit') {
                            return;
                        }
                        if (!field.checkValidity()) {
                            hasError = true;
                            let msg = field.dataset.error || 'This field is required.';
                            if (field.validity.typeMismatch) {
                                msg = field.dataset.errorType ||
                                    'Please enter a valid value.';
                            } else if (field.validity.patternMismatch) {
                                msg = 'Please match the requested format.';
                            } else if (field.validity.tooLong) {
                                msg = 'The value is too long.';
                            } else if (field.validity.tooShort) {
                                msg = 'The value is too short.';
                            } else if (field.validationMessage) {
                                msg = field.validationMessage;
                            }
                            attachError(field, msg);
                        }
                    });

                    if (hasError) {
                        event.preventDefault();
                        event.stopPropagation();
                        const firstInvalid = form.querySelector('.is-invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            firstInvalid.focus();
                        }
                        return;
                    }
                });
            });
        });
    </script>
@endsection
