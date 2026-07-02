@extends('admin.layouts.adminlayout')

@section('style')
    <style>
        .btn-success {
            background-color: #187a4c;
            color: white;
        }

        .btn-success:hover,
        .btn-success:active {
            background-color: #187a4c !important;
            color: white;
        }

        .bg-success {
            background-color: #187a4c !important;
            color: white;
        }

        .pnac-vertical-form {
            width: 100%;
            max-width: 100%;
        }

        .pnac-collapsible-header {
            cursor: pointer;
            user-select: none;
            background: #187a4c;
            color: #fff;
            border-radius: .35rem;
            padding: .9rem 1rem;
            margin-bottom: .75rem;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: .75rem;
        }

        .pnac-collapsible-header h5,
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
            gap: .6rem;
            flex-shrink: 0;
        }

        .pnac-collapse-chevron {
            width: .7rem;
            height: .7rem;
            border-right: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(45deg);
            transition: transform .25s ease;
            display: inline-block;
            margin-top: .15rem;
        }

        .pnac-collapsible-header[aria-expanded="false"] .pnac-collapse-chevron {
            transform: rotate(-45deg);
        }

        .pnac-collapse-body {
            overflow: hidden;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px 24px;
            padding: .25rem 0;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 14px;
            line-height: 1.5;
            min-width: 0;
        }

        .detail-label {
            font-weight: 700;
            color: #1f2937;
            min-width: 140px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #374151;
            word-break: break-word;
        }

        .field-error {
            display: block;
            color: #dc3545;
            font-size: .82rem;
            margin-top: .25rem;
        }

        @media(max-width:992px) {
            .details-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width:576px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        .pnac-vertical-form .table td {
            min-width: 120px;
            white-space: normal;
            word-wrap: break-word;
            vertical-align: middle;
        }

        .pnac-vertical-form .table th {
            white-space: nowrap;
            font-weight: 600;
        }
    </style>
@endsection

@php
    $currentEditSection = request('edit_section');
    $openSection = session('open_section') ?: request('open_section') ?: $currentEditSection ?: 'step1';
    $saved = $data['saved_sections'] ?? [];
    $isLocked = $application->status === 'Submitted';

    $isSaved = fn(string $s) => (bool) ($saved[$s] ?? false);
    $isEditing = fn(string $s) => !$isLocked && ($currentEditSection === $s || !$isSaved($s));
    $stepUrl = fn(string $s) => route('inspection-body.' . $s . '.save', ['application' => $application->id]);
    $editUrl = fn(string $s) => route('inspection-body.create', [
        'scheme_name' => 'Inspection Bodies',
        'application' => $application->application_type,
        'edit_section' => $s,
    ]);

    $firstRow = fn($rows, $fallback = []) => $rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()
        ? $rows
        : collect([$fallback]);
    $val = fn($row, $field) => is_array($row) ? $row[$field] ?? '' : $row->{$field} ?? '';

    // Load form from DB
    $form = $form ?? \App\Models\ApplicationForm::where('application_name', 'Inspection Bodies')->orWhere('slug', \Str::slug('Inspection Bodies'))->first();
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
        'Inspection Body Information' => [
            'inspection_body_name' => 0,
            'address' => 1,
        ],
        'Parent Organization (if any)' => [
            'parent_organization' => 0,
            'relationship' => 1,
            'parent_address' => 2,
            'parent_postcode' => 3,
            'parent_tel' => 4,
            'parent_fax' => 5,
        ],
        'Invoice Address (if different)' => [
            'invoice_organization' => 0,
            'invoice_address' => 1,
            'invoice_postcode' => 2,
            'invoice_tel' => 3,
            'invoice_fax' => 4,
        ],
        'Establishment & Legal Status' => [
            'date_of_establishment' => 0,
            'legal_status' => 1,
        ],
        'Outside Pakistan Work' => [
            'outside_pakistan' => 0,
            'countries_description' => 1,
        ],
        'Is Inspection the Main Activity?' => [
            'inspection_main_activity' => 0,
            'activity_description' => 1,
        ],
        'Consultant / Consultancy Firm (if any)' => [
            'consultant_name' => 0,
            'consultant_organization' => 1,
            'consultant_address' => 2,
            'consultant_postcode' => 3,
            'consultant_tel' => 4,
            'consultant_fax' => 5,
            'consultant_email' => 6,
        ],
        'Chief Executive' => [
            'name' => 0,
            'qualifications' => 1,
            'experience' => 2,
        ],
        'Quality Management Representative' => [
            'name' => 0,
            'qualifications' => 1,
            'experience' => 2,
        ],
        'Management Members' => [
            'name' => 0,
            'qualifications' => 1,
            'experience' => 2,
        ],
        'Permanent Inspectors' => [
            'name' => 0,
            'qualification' => 1,
            'inspection_field' => 2,
            'inspection_experience' => 3,
        ],
        'Freelance / Subcontracted Inspectors' => [
            'name' => 0,
            'qualification' => 1,
            'inspection_field' => 2,
            'inspection_experience' => 3,
        ],
        'Scope of Inspection' => [
            'description_of_inspection' => 0,
            'type_and_range' => 1,
            'methods_and_procedures' => 2,
        ],
        'Equipment' => [
            'equipment_name' => 0,
            'calibration_organization' => 1,
            'calibration_frequency' => 2,
            'last_calibration_date' => 3,
        ],
        'Inspection Body Type Declaration' => [
            'type_a' => 0,
            'type_b' => 1,
            'type_c' => 2,
        ],
        'Declarations' => [
            'iso17020_compliance' => 0,
            'assessment_understanding' => 1,
            'agreement_acceptance' => 2,
            'quality_manual_attached' => 3,
            'document_review_attached' => 4,
        ],
        'Applicant Fee & Signature' => [
            'applicant_fee' => 0,
            'declaration_name' => 1,
            'declaration_date' => 2,
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
                    $label = $sec['fields'][$idx]['label'];
                }
            } else {
                foreach ($sec['fields'] as $fld) {
                    if (strcasecmp($fld['name'] ?? '', $field) === 0) {
                        $label = $fld['label'] ?? $fallbackLabel;
                        break;
                    }
                }
            }
            $cols[$field] = $label;
        }
        return $cols;
    };

    $renderDetails = function (array $items) {
        echo '<div class="details-grid">';
        foreach ($items as $label => $v) {
            echo '<div class="detail-item"><span class="detail-label">' .
                e($label) .
                ':</span><span class="detail-value">' .
                e($v ?: '-') .
                '</span></div>';
        }
        echo '</div>';
    };
    $renderTable = function ($rows, array $columns) use ($val) {
        echo '<div class="table-responsive"><table class="table table-bordered align-middle"><thead><tr>';
        foreach ($columns as $lbl) {
            echo '<th>' . e($lbl) . '</th>';
        }
        echo '</tr></thead><tbody>';
        if ($rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()) {
            foreach ($rows as $row) {
                echo '<tr>';
                foreach ($columns as $field => $lbl) {
                    echo '<td>' . e($val($row, $field) ?: '-') . '</td>';
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
        <div class="pnac-vertical-form ib-application-form w-100">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h4 class="mb-0 text-success">Application For Inspection Body Accreditation</h4>
                    <small class="text-muted">F-01/10 &nbsp;|&nbsp; ISO/IEC 17020</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">{{ $application->status }}</span>
                    {{-- <span class="badge bg-light text-dark">{{ $application->application_no ?: 'Draft' }}</span> --}}
                </div>
            </div>

            <div id="pnacVerticalForm">

                {{-- ========== STEP 1 ========== --}}
                @php $org = $data['organization'] ?? null; @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step1"
                    data-open="{{ $openSection === 'step1' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 1: {{ $getSection('Inspection Body Information') ? $getSection('Inspection Body Information')['title'] : 'Organization Details' }}</h5>
                            <p class="text-muted mb-0">Inspection body, contact, parent, invoice & consultant.</p>
                        </div>
                        <span class="badge {{ $isSaved('step1') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step1') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step1'))
                        @include('application.certification_bodies.inspection_body.steps.step1', [
                            'org' => $org,
                            'isLocked' => $isLocked,
                            'stepUrl' => $stepUrl('step1'),
                            'getSection' => $getSection,
                            'getLabel' => $getLabel,
                            'getColumns' => $getColumns,
                        ])
                    @else
                        @php
                            $renderDetails([
                                $getLabel('Inspection Body Information', 'inspection_body_name', 'Inspection Body Name') => $org->inspection_body_name ?? '',
                                $getLabel('Inspection Body Information', 'address', 'Address') => $org->address ?? '',
                                $getLabel('Parent Organization (if any)', 'parent_organization', 'Parent Organization') => $org->parent_organization ?? '',
                                $getLabel('Parent Organization (if any)', 'relationship', 'Relationship') => $org->relationship ?? '',
                                $getLabel('Parent Organization (if any)', 'parent_address', 'Parent Address') => $org->parent_address ?? '',
                                $getLabel('Parent Organization (if any)', 'parent_postcode', 'Parent Postcode') => $org->parent_postcode ?? '',
                                $getLabel('Parent Organization (if any)', 'parent_tel', 'Parent Tel') => $org->parent_tel ?? '',
                                $getLabel('Parent Organization (if any)', 'parent_fax', 'Parent Fax') => $org->parent_fax ?? '',
                                $getLabel('Establishment & Legal Status', 'legal_status', 'Legal Status') => $org->legal_status ?? '',
                                $getLabel('Establishment & Legal Status', 'date_of_establishment', 'Date of Establishment') => $org->date_of_establishment ?? '',
                                $getLabel('Outside Pakistan Work', 'outside_pakistan', 'Outside Pakistan') => $org->outside_pakistan ?? '',
                                $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_name', 'Consultant Name') => $org->consultant_name ?? '',
                                $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_email', 'Consultant Email') => $org->consultant_email ?? '',
                            ]);
                        @endphp
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ $editUrl('step1') }}" class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>

                {{-- ========== STEP 2 ========== --}}
                @php
                    $staffRoles = $data['staff_roles'] ?? collect();
                    $mgmtMembers = $data['mgmt_members'] ?? collect();
                    $inspectors = $data['inspectors'] ?? collect();
                    $freelance = $data['freelance'] ?? collect();
                    
                    $ceTitle = $getSection('Chief Executive') ? $getSection('Chief Executive')['title'] : 'Chief Executive';
                    $ceCols = $getColumns('Chief Executive', ['name' => 'Name', 'qualifications' => 'Qualifications', 'experience' => 'Experience']);
                    
                    $qmrTitle = $getSection('Quality Management Representative') ? $getSection('Quality Management Representative')['title'] : 'Quality Management Representative';
                    $qmrCols = $getColumns('Quality Management Representative', ['name' => 'Name', 'qualifications' => 'Qualifications', 'experience' => 'Experience']);
                    
                    $mgmtTitle = $getSection('Management Members') ? $getSection('Management Members')['title'] : 'Management Members';
                    $mgmtCols = $getColumns('Management Members', ['name' => 'Name', 'qualifications' => 'Qualifications', 'experience' => 'Experience']);
                    
                    $permTitle = $getSection('Permanent Inspectors') ? $getSection('Permanent Inspectors')['title'] : 'Permanent Inspectors';
                    $permCols = $getColumns('Permanent Inspectors', [
                        'name' => 'Name',
                        'qualification' => 'Qualification',
                        'inspection_field' => 'Inspection Field',
                        'inspection_experience' => 'Experience',
                    ]);
                    
                    $freelanceTitle = $getSection('Freelance / Subcontracted Inspectors') ? $getSection('Freelance / Subcontracted Inspectors')['title'] : 'Freelance / Subcontracted Inspectors';
                    $freelanceCols = $getColumns('Freelance / Subcontracted Inspectors', [
                        'name' => 'Name',
                        'qualification' => 'Qualification',
                        'inspection_field' => 'Inspection Field',
                        'inspection_experience' => 'Experience',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step2"
                    data-open="{{ $openSection === 'step2' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 2: Staff &amp; Inspectors</h5>
                            <p class="text-muted mb-0">Key staff, management members, and inspectors.</p>
                        </div>
                        <span class="badge {{ $isSaved('step2') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step2') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step2'))
                        @include(
                            'application.certification_bodies.inspection_body.steps.step2',
                            [
                                'staffRoles' => $staffRoles,
                                'mgmtMembers' => $mgmtMembers,
                                'inspectors' => $inspectors,
                                'freelance' => $freelance,
                                'isLocked' => $isLocked,
                                'staffCols' => $ceCols, // will map inside step2
                                'inspCols' => $permCols, // will map inside step2
                                'firstRow' => $firstRow,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                                'ceTitle' => $ceTitle,
                                'ceCols' => $ceCols,
                                'qmrTitle' => $qmrTitle,
                                'qmrCols' => $qmrCols,
                                'mgmtTitle' => $mgmtTitle,
                                'mgmtCols' => $mgmtCols,
                                'permTitle' => $permTitle,
                                'permCols' => $permCols,
                                'freelanceTitle' => $freelanceTitle,
                                'freelanceCols' => $freelanceCols,
                            ])
                    @else
                        <h6><strong>{{ $ceTitle }}</strong></h6>
                        @php $renderTable($staffRoles->get('Chief Executive',collect()), $ceCols); @endphp
                        <h6 class="mt-4"><strong>{{ $qmrTitle }}</strong></h6>
                        @php $renderTable($staffRoles->get('Quality Management Representative',collect()), $qmrCols); @endphp
                        <h6 class="mt-4"><strong>{{ $mgmtTitle }}</strong></h6>
                        @php $renderTable($mgmtMembers, $mgmtCols); @endphp
                        <h6 class="mt-4"><strong>{{ $permTitle }}</strong></h6>
                        @php $renderTable($inspectors, $permCols); @endphp
                        <h6 class="mt-4"><strong>{{ $freelanceTitle }}</strong></h6>
                        @php $renderTable($freelance, $freelanceCols); @endphp
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ $editUrl('step2') }}" class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>

                {{-- ========== STEP 3 ========== --}}
                @php
                    $scopes = $data['scopes'] ?? collect();
                    $equipment = $data['equipment'] ?? collect();
                    
                    $scopeTitle = $getSection('Scope of Inspection') ? $getSection('Scope of Inspection')['title'] : 'Scope of Inspection';
                    $scopeCols = $getColumns('Scope of Inspection', [
                        'description_of_inspection' => 'Description of Inspection',
                        'type_and_range' => 'Type and Range',
                        'methods_and_procedures' => 'Methods and Procedures',
                    ]);
                    
                    $equipTitle = $getSection('Equipment') ? $getSection('Equipment')['title'] : 'Equipment';
                    $equipCols = $getColumns('Equipment', [
                        'equipment_name' => 'Equipment Name',
                        'calibration_organization' => 'Calibration Organization',
                        'calibration_frequency' => 'Calibration Frequency',
                        'last_calibration_date' => 'Last Calibration Date',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step3"
                    data-open="{{ $openSection === 'step3' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 3: Scope &amp; Equipment</h5>
                            <p class="text-muted mb-0">Scope of inspection and equipment list.</p>
                        </div>
                        <span class="badge {{ $isSaved('step3') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step3') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step3'))
                        @include(
                            'application.certification_bodies.inspection_body.steps.step3',
                            [
                                'scopes' => $scopes,
                                'equipment' => $equipment,
                                'isLocked' => $isLocked,
                                'firstRow' => $firstRow,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                                'scopeTitle' => $scopeTitle,
                                'scopeCols' => $scopeCols,
                                'equipTitle' => $equipTitle,
                                'equipCols' => $equipCols,
                            ])
                    @else
                        <h6><strong>{{ $scopeTitle }}</strong></h6>
                        @php $renderTable($scopes, $scopeCols); @endphp
                        <h6 class="mt-4"><strong>{{ $equipTitle }}</strong></h6>
                        @php $renderTable($equipment, $equipCols); @endphp
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ $editUrl('step3') }}" class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>

                {{-- ========== STEP 4 ========== --}}
                @php $declaration = $data['declaration'] ?? null; @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step4"
                    data-open="{{ $openSection === 'step4' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 4: {{ $getSection('Declarations') ? $getSection('Declarations')['title'] : 'Declaration & Submit' }}</h5>
                            <p class="text-muted mb-0">Inspection body type declaration, agreement, and final submission.
                            </p>
                        </div>
                        <span class="badge {{ $isSaved('step4') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('step4') ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>
                    @if ($isEditing('step4'))
                        @include(
                            'application.certification_bodies.inspection_body.steps.step4',
                            [
                                'declaration' => $declaration,
                                'isLocked' => $isLocked,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                            ])
                    @else
                        @php
                            $renderDetails([
                                $getLabel('Inspection Body Type Declaration', 'type_a', 'Type A') => $declaration->type_a ?? false ? 'Yes' : 'No',
                                $getLabel('Inspection Body Type Declaration', 'type_b', 'Type B') => $declaration->type_b ?? false ? 'Yes' : 'No',
                                $getLabel('Inspection Body Type Declaration', 'type_c', 'Type C') => $declaration->type_c ?? false ? 'Yes' : 'No',
                                $getLabel('Declarations', 'iso17020_compliance', 'ISO/IEC 17020 Compliance') => $declaration->iso17020_compliance ?? false ? 'Yes' : 'No',
                                $getLabel('Declarations', 'assessment_understanding', 'Assessment Understanding') =>
                                    $declaration->assessment_understanding ?? false ? 'Yes' : 'No',
                                $getLabel('Declarations', 'agreement_acceptance', 'Agreement Acceptance') => $declaration->agreement_acceptance ?? false ? 'Yes' : 'No',
                                $getLabel('Declarations', 'quality_manual_attached', 'Quality Manual Attached') =>
                                    $declaration->quality_manual_attached ?? false ? 'Yes' : 'No',
                                $getLabel('Declarations', 'document_review_attached', 'Document Review Attached') =>
                                    $declaration->document_review_attached ?? false ? 'Yes' : 'No',
                                $getLabel('Applicant Fee & Signature', 'applicant_fee', 'Applicant Fee') => $declaration->applicant_fee ?? '',
                                $getLabel('Applicant Fee & Signature', 'declaration_name', 'Declaration Name') => $declaration->declaration_name ?? '',
                                $getLabel('Applicant Fee & Signature', 'declaration_date', 'Declaration Date') => $declaration->declaration_date ?? '',
                            ]);
                        @endphp
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ $editUrl('step4') }}" class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>

                {{-- ========== DOCUMENTS ========== --}}
                {{-- @php
                    $documents = $data['documents'] ?? collect();
                    $docsByType = $documents->keyBy('document_type');
                    $requiredDocs = [
                        'Quality Manual',
                        'F-02/30 Document Review',
                        'Calibration Reports',
                        'Sample Worksheets',
                        'Internal Audit Report',
                        'Management Review Report',
                        'CVs',
                        'Performed Inspection List',
                        'Fee Evidence',
                    ];
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="documents"
                    data-open="{{ $openSection === 'documents' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Documents Upload</h5>
                            <p class="text-muted mb-0">Upload required supporting documents.</p>
                        </div>
                        <span class="badge {{ $isSaved('documents') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $isSaved('documents') ? 'Uploaded' : 'Pending' }}
                        </span>
                    </div>
                    @if (!$isLocked)
                        <form method="POST"
                            action="{{ route('inspection-body.documents.store', ['application' => $application->id]) }}"
                            enctype="multipart/form-data" class="js-card-form ib-js-card-form mb-3">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label">Document Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="document_type" required>
                                        <option value="">Select type</option>
                                        @foreach ($requiredDocs as $dt)
                                            <option value="{{ $dt }}">{{ $dt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="document_file" required
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success w-100">Upload</button>
                                </div>
                            </div>
                        </form>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>File Name</th>
                                    <th>Uploaded</th>
                                    @if (!$isLocked)
                                        <th style="width:80px;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td>{{ $doc->document_type }}</td>
                                        <td>
                                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank">
                                                {{ $doc->original_name }}
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($doc->updated_at)->format('d M Y') }}</td>
                                        @if (!$isLocked)
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('inspection-body.documents.destroy', ['application' => $application->id, 'document' => $doc->id]) }}"
                                                    onsubmit="return confirm('Delete this document?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $isLocked ? 3 : 4 }}" class="text-muted">No documents uploaded yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> --}}

            </div>{{-- #pnacVerticalForm --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ── Collapsible cards ──────────────────────────────────────────────────────
            const cards = Array.from(document.querySelectorAll('#pnacVerticalForm > .pnac-step-card'));
            const preferredOpen = '{{ session('open_section', request('edit_section')) }}';
            const hasBS = typeof bootstrap !== 'undefined' && typeof bootstrap.Collapse !== 'undefined';

            cards.forEach(function(card, index) {
                const header = card.querySelector(':scope > .d-flex.justify-content-between');
                if (!header) return;

                const bodyId = 'ibCollapseBody' + (index + 1);
                const body = document.createElement('div');
                body.id = bodyId;
                body.className = hasBS ? 'collapse pnac-collapse-body' : 'pnac-collapse-body';

                Array.from(card.children).filter(c => c !== header).forEach(c => body.appendChild(c));
                card.appendChild(body);

                header.classList.add('pnac-collapsible-header');
                header.setAttribute('role', 'button');
                header.setAttribute('tabindex', '0');
                header.setAttribute('aria-controls', bodyId);

                const titleArea = document.createElement('div');
                titleArea.className = 'pnac-card-title-area';
                const existDiv = header.querySelector(':scope > div');
                if (existDiv) titleArea.appendChild(existDiv);

                const actions = document.createElement('div');
                actions.className = 'pnac-card-actions';
                const badge = header.querySelector('.badge');
                if (badge) actions.appendChild(badge);
                const chev = document.createElement('span');
                chev.className = 'pnac-collapse-chevron';
                chev.setAttribute('aria-hidden', 'true');
                actions.appendChild(chev);

                header.innerHTML = '';
                header.appendChild(titleArea);
                header.appendChild(actions);

                const section = card.getAttribute('data-section');
                const shouldOpen = preferredOpen ? preferredOpen === section : index === 0;

                if (shouldOpen) {
                    header.setAttribute('aria-expanded', 'true');
                    if (hasBS) body.classList.add('show');
                    else body.style.maxHeight = body.scrollHeight + 'px';
                } else {
                    header.setAttribute('aria-expanded', 'false');
                    if (!hasBS) body.style.maxHeight = '0px';
                }

                const toggle = function() {
                    if (hasBS) {
                        const inst = bootstrap.Collapse.getOrCreateInstance(body, {
                            toggle: false
                        });
                        body.classList.contains('show') ? inst.hide() : inst.show();
                    } else {
                        const exp = header.getAttribute('aria-expanded') === 'true';
                        body.style.maxHeight = exp ? '0px' : body.scrollHeight + 'px';
                        header.setAttribute('aria-expanded', String(!exp));
                    }
                };
                header.addEventListener('click', toggle);
                header.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggle();
                    }
                });
                if (hasBS) {
                    body.addEventListener('shown.bs.collapse', () => header.setAttribute('aria-expanded',
                        'true'));
                    body.addEventListener('hidden.bs.collapse', () => header.setAttribute('aria-expanded',
                        'false'));
                }
            });

            // Recalculate open section height after render
            setTimeout(function() {
                cards.forEach(function(card) {
                    const collapseBody = card.querySelector('.pnac-collapse-body');
                    if (!collapseBody || hasBS) return;
                    const hdr = card.querySelector('.pnac-collapsible-header');
                    if (hdr && hdr.getAttribute('aria-expanded') === 'true') {
                        collapseBody.style.maxHeight = collapseBody.scrollHeight + 'px';
                    }
                });
            }, 100);

            // ── Field-level validation ─────────────────────────────────────────────────
            document.querySelectorAll('.js-card-form').forEach(function(form) {
                const attachError = function(field, msg) {
                    let el = field.parentElement.querySelector('.field-error');
                    if (!el) {
                        el = document.createElement('small');
                        el.className = 'field-error';
                        field.parentElement.appendChild(el);
                    }
                    el.textContent = msg;
                    field.classList.add('is-invalid');
                };
                const clearError = function(field) {
                    field.classList.remove('is-invalid');
                    const el = field.parentElement.querySelector('.field-error');
                    if (el) el.remove();
                };
                form.querySelectorAll('input,select,textarea').forEach(f => {
                    f.addEventListener('input', () => clearError(f));
                    f.addEventListener('change', () => clearError(f));
                });
                form.addEventListener('submit', function(e) {
                    let err = false;
                    form.querySelectorAll('input,select,textarea').forEach(function(f) {
                        clearError(f);
                        if (f.disabled || ['hidden', 'button', 'submit'].includes(f.type))
                            return;
                        if (!f.checkValidity()) {
                            err = true;
                            attachError(f, f.validity.typeMismatch ?
                                'Please enter a valid value.' :
                                'This field is required.');
                        }
                    });
                    if (err) {
                        e.preventDefault();
                        e.stopPropagation();
                        const inv = form.querySelector('.is-invalid');
                        if (inv) {
                            inv.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            inv.focus();
                        }
                    }
                });
            });
        });
    </script>
@endsection
