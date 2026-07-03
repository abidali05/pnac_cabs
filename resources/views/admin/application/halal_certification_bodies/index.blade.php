@extends('admin.layouts.adminlayout')

@section('style')
    <style>
        .btn-success {
            background-color: #187a4c;
            color: #fff;
        }

        .btn-success:hover,
        .btn-success:active {
            background-color: #187a4c !important;
            color: #fff;
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
        .pnac-collapsible-header p {
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
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 24px;
            padding: .25rem 0;
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

        .field-error {
            display: block;
            color: #dc3545;
            font-size: .82rem;
            margin-top: .25rem;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        .pnac-vertical-form .table td {
            min-width: 100px;
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
    $stepUrl = fn(string $s) => route('hcb.' . $s . '.save', ['application' => $application->id]);
    $editUrl = fn(string $s) => route('hcb.create', [
        'scheme_name' => 'Halal Certification Bodies',
        'application' => $application->application_type,
        'edit_section' => $s,
    ]);
    $firstRow = fn($rows, $fb = []) => $rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()
        ? $rows
        : collect([$fb]);
    $val = fn($row, $f) => is_array($row) ? $row[$f] ?? '' : $row->{$f} ?? '';

    // Load form from DB
    $form = $form ?? \App\Models\ApplicationForm::where('application_name', 'Halal Certification Bodies')->orWhere('slug', \Str::slug('Halal Certification Bodies'))->first();
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
        '1.1 HCB Information' => [
            'organization_name' => 0,
            'address' => 1,
            'postcode' => 2,
            'telephone' => 3,
            'fax' => 4,
        ],
        '1.2 Contact Person' => [
            'contact_name' => 0,
            'designation' => 1,
            'contact_email' => 2,
            'contact_address' => 3,
            'contact_postcode' => 4,
            'contact_tel' => 5,
            'contact_fax' => 6,
        ],
        '2.1 Authorized Person' => [
            'title' => 0,
            'name' => 1,
            'position' => 2,
        ],
        '2.2 Parent Organization (if any)' => [
            'parent_organization' => 0,
            'relationship' => 1,
            'parent_address' => 2,
            'parent_postcode' => 3,
            'parent_telephone' => 4,
            'parent_fax' => 5,
        ],
        '2.3 Invoice Address (if different)' => [
            'invoice_organization' => 0,
            'invoice_address' => 1,
            'invoice_postcode' => 2,
            'invoice_telephone' => 3,
            'invoice_fax' => 4,
        ],
        '2.4 Ownership' => [
            'ownership_type' => 0,
            'other_description' => 1,
        ],
        '2.5 Main Activity' => [
            'is_halal_main_activity' => 0,
            'activity_description' => 1,
        ],
        '2.6 Consultant / Consultancy Firm' => [
            'consultant_name' => 0,
            'consultant_organization' => 1,
            'consultant_address' => 2,
            'consultant_postcode' => 3,
            'consultant_tel' => 4,
            'consultant_fax' => 5,
            'consultant_email' => 6,
        ],
        '3.1 Chief Executive(s)' => [
            'name' => 0,
            'religion' => 1,
            'qualification' => 2,
            'experience' => 3,
        ],
        '3.2 Shariah Expert(s)' => [
            'name' => 0,
            'religion' => 1,
            'qualification' => 2,
            'experience' => 3,
        ],
        '3.3 Quality Management Representative(s)' => [
            'name' => 0,
            'religion' => 1,
            'qualification' => 2,
            'experience' => 3,
        ],
        '3.4 Management Members' => [
            'name' => 0,
            'religion' => 1,
            'qualification' => 2,
            'experience' => 3,
        ],
        '3.5 Permanent Auditors' => [
            'name' => 0,
            'religion' => 1,
            'qualification' => 2,
            'auditing_field' => 3,
            'audit_experience' => 4,
        ],
        '3.6 External / Subcontracted Auditors' => [
            'name' => 0,
            'religion' => 1,
            'qualification' => 2,
            'auditing_field' => 3,
            'audit_experience' => 4,
        ],
        'Scope of Halal Certification' => [
            'category_code' => 0,
            'category' => 1,
            'subcategory' => 2,
            'included_activities' => 3,
        ],
        'Organisation & Management' => [
            '1_does_the_hcb_have_a_defined_organisational_structure_showing_main_activities_lines_of_responsibility_and_reporting' => 0,
            'comments_qm_reference' => 1,
            '2_is_it_clear_from_the_structure_that_the_certification_function_is_independent_from_other_company_activities' => 2,
            'comments_qm_reference' => 3, // fallback will match by code in loop or index
        ],
        'Quality Audit & Review' => [
            '1_does_the_hcb_have_a_documented_procedure_for_internal_quality_audits' => 0,
            'comments_qm_reference' => 1,
        ],
        'HCB Staff' => [
            '1_does_the_hcb_have_sufficient_qualified_staff_for_all_aspects_of_the_certification_process' => 0,
            'comments_qm_reference' => 1,
        ],
        'Procedures' => [
            '1_are_there_documented_procedures_for_all_stages_of_the_certification_process_application_audit_decision_certification_surveillance' => 0,
            'comments_qm_reference' => 1,
        ],
        'Records' => [
            '1_does_the_hcb_maintain_records_of_all_applications_audits_and_certification_decisions' => 0,
            'comments_qm_reference' => 1,
        ],
        'Complaints and Anomalies' => [
            '1_does_the_hcb_have_a_documented_procedure_for_handling_complaints_from_applicants_or_certified_organisations' => 0,
            'comments_qm_reference' => 1,
        ],
        'Sub Contracting' => [
            '1_where_the_hcb_sub_contracts_audit_work_are_there_documented_criteria_for_selecting_sub_contractors' => 0,
            'comments_qm_reference' => 1,
        ],
        'Outside Support Services' => [
            '1_where_outside_support_services_are_used_are_there_documented_agreements_defining_the_services_provided' => 0,
            'comments_qm_reference' => 1,
        ],
        'Overall Compliance' => [
            'does_the_hcb_comply_with_pnac_requirements_for_halal_certification_bodies' => 0,
        ],
        'Non-Compliance Areas' => [
            'area_of_non_compliance' => 0,
            'rectified_by_date' => 1,
        ],
        'Other Approvals / Existing Certificates' => [
            'approval_body_name' => 0,
            'approval_body_address' => 1,
            'scope' => 2,
            'certificate_number' => 3,
            'start_date' => 4,
            'expiry_date' => 5,
        ],
        '7.1 Application Type' => [
            'halal_scope' => 0,
            'extension_scope' => 1,
        ],
        '7.2 Declarations' => [
            'quality_manual_confirmed' => 0,
            'declaration_accepted' => 1,
        ],
        '7.3 Applicant Fee & Signature' => [
            'applicant_fee_amount' => 0,
            'signed_by' => 1,
            'signed_date' => 2,
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
    $renderTable = function ($rows, array $cols) use ($val) {
        echo '<div class="table-responsive"><table class="table table-bordered align-middle"><thead><tr>';
        foreach ($cols as $lbl) {
            echo '<th>' . e($lbl) . '</th>';
        }
        echo '</tr></thead><tbody>';
        if ($rows instanceof \Illuminate\Support\Collection && $rows->isNotEmpty()) {
            foreach ($rows as $row) {
                echo '<tr>';
                foreach ($cols as $field => $lbl) {
                    echo '<td>' . e($val($row, $field) ?: '-') . '</td>';
                }
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="' . count($cols) . '" class="text-muted">No records saved.</td></tr>';
        }
        echo '</tbody></table></div>';
    };
@endphp

@section('main-content')
    <div class="main-content">
        <div class="pnac-vertical-form hcb-application-form w-100">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h4 class="mb-0 text-success">Application For Halal Certification Body Accreditation</h4>
                    <small class="text-muted">F-01/17 &nbsp;|&nbsp; Halal Certification</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">{{ $application->status }}</span>
                    {{-- <span class="badge bg-light text-dark">{{ $application->application_no ?: 'Draft' }}</span> --}}
                </div>
            </div>

            <div id="pnacVerticalForm">

                {{-- ===== STEP 1: Basic Information ===== --}}
                @php
                    $basicInfo = $data['basic_info'] ?? null;
                    $subOffices = $data['sub_offices'] ?? collect();
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step1"
                    data-open="{{ $openSection === 'step1' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 1: {{ $getSection('1.1 HCB Information') ? $getSection('1.1 HCB Information')['title'] : 'Basic Information' }}</h5>
                            <p class="text-muted mb-0">HCB details, contact person, sub-offices & accreditation request.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step1') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step1') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step1'))
                        @include(
                            'admin.application.halal_certification_bodies.step_1_basic_information',
                            compact('basicInfo', 'subOffices', 'isLocked', 'stepUrl', 'firstRow', 'getSection', 'getLabel', 'getColumns'))
                    @else
                        @php 
                            $renderDetails([
                                $getLabel('1.1 HCB Information', 'organization_name', 'Organization Name') => $basicInfo->organization_name??'',
                                $getLabel('1.1 HCB Information', 'address', 'Address') => $basicInfo->address??'',
                                $getLabel('1.1 HCB Information', 'telephone', 'Telephone') => $basicInfo->telephone??'',
                                $getLabel('1.2 Contact Person', 'contact_name', 'Contact Name') => $basicInfo->contact_name??'',
                                $getLabel('1.2 Contact Person', 'contact_email', 'Contact Email') => $basicInfo->contact_email??''
                            ]); 
                        @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step1') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 2: About HCB ===== --}}
                @php $aboutHcb = $data['about_hcb'] ?? null; @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step2"
                    data-open="{{ $openSection === 'step2' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 2: {{ $getSection('2.1 Authorized Person') ? $getSection('2.1 Authorized Person')['title'] : 'About HCB' }}</h5>
                            <p class="text-muted mb-0">Authorized person, parent org, invoice address, ownership &
                                consultant.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step2') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step2') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step2'))
                        @include(
                            'admin.application.halal_certification_bodies.step_2_about_hcb',
                            compact('aboutHcb', 'isLocked', 'stepUrl', 'getSection', 'getLabel', 'getColumns'))
                    @else
                        @php 
                            $renderDetails([
                                $getLabel('2.1 Authorized Person', 'name', 'Authorized Person') => $aboutHcb->name??'',
                                $getLabel('2.1 Authorized Person', 'position', 'Position') => $aboutHcb->position??'',
                                $getLabel('2.2 Parent Organization (if any)', 'parent_organization', 'Parent Organization') => $aboutHcb->parent_organization??'',
                                $getLabel('2.4 Ownership', 'ownership_type', 'Ownership Type') => $aboutHcb->ownership_type??'',
                                $getLabel('2.5 Main Activity', 'is_halal_main_activity', 'Is Halal Main Activity') => $aboutHcb->is_halal_main_activity??'',
                                $getLabel('2.6 Consultant / Consultancy Firm', 'consultant_name', 'Consultant') => $aboutHcb->consultant_name??''
                            ]); 
                        @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step2') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 3: Staff Information ===== --}}
                @php
                    $chiefExecs = $data['chief_execs'] ?? collect();
                    $shariahExp = $data['shariah_experts'] ?? collect();
                    $qualityReps = $data['quality_reps'] ?? collect();
                    $mgmtMembers = $data['mgmt_members'] ?? collect();
                    $permAuditors = $data['perm_auditors'] ?? collect();
                    $extAuditors = $data['ext_auditors'] ?? collect();
                    
                    $ceTitle = $getSection('3.1 Chief Executive(s)') ? $getSection('3.1 Chief Executive(s)')['title'] : '3.1 Chief Executive(s)';
                    $ceCols = $getColumns('3.1 Chief Executive(s)', [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                    ]);

                    $seTitle = $getSection('3.2 Shariah Expert(s)') ? $getSection('3.2 Shariah Expert(s)')['title'] : '3.2 Shariah Expert(s)';
                    $seCols = $getColumns('3.2 Shariah Expert(s)', [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                    ]);

                    $qmrTitle = $getSection('3.3 Quality Management Representative(s)') ? $getSection('3.3 Quality Management Representative(s)')['title'] : '3.3 Quality Management Representative(s)';
                    $qmrCols = $getColumns('3.3 Quality Management Representative(s)', [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                    ]);

                    $mgmtTitle = $getSection('3.4 Management Members') ? $getSection('3.4 Management Members')['title'] : '3.4 Management Members';
                    $mgmtCols = $getColumns('3.4 Management Members', [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                    ]);

                    $permTitle = $getSection('3.5 Permanent Auditors') ? $getSection('3.5 Permanent Auditors')['title'] : '3.5 Permanent Auditors';
                    $permCols = $getColumns('3.5 Permanent Auditors', [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'auditing_field' => 'Auditing Field',
                        'audit_experience' => 'Audit Experience',
                    ]);

                    $extTitle = $getSection('3.6 External / Subcontracted Auditors') ? $getSection('3.6 External / Subcontracted Auditors')['title'] : '3.6 External / Subcontracted Auditors';
                    $extCols = $getColumns('3.6 External / Subcontracted Auditors', [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'auditing_field' => 'Auditing Field',
                        'audit_experience' => 'Audit Experience',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step3"
                    data-open="{{ $openSection === 'step3' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 3: Staff Information</h5>
                            <p class="text-muted mb-0">Chief executives, Shariah experts, quality reps, management members &
                                auditors.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step3') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step3') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step3'))
                        @include(
                            'admin.application.halal_certification_bodies.step_3_staff_information',
                            [
                                'chiefExecs' => $chiefExecs,
                                'shariahExp' => $shariahExp,
                                'qualityReps' => $qualityReps,
                                'mgmtMembers' => $mgmtMembers,
                                'permAuditors' => $permAuditors,
                                'extAuditors' => $extAuditors,
                                'isLocked' => $isLocked,
                                'stepUrl' => $stepUrl,
                                'firstRow' => $firstRow,
                                'staffCols' => $ceCols,
                                'auditorCols' => $permCols,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                                'ceTitle' => $ceTitle,
                                'ceCols' => $ceCols,
                                'seTitle' => $seTitle,
                                'seCols' => $seCols,
                                'qmrTitle' => $qmrTitle,
                                'qmrCols' => $qmrCols,
                                'mgmtTitle' => $mgmtTitle,
                                'mgmtCols' => $mgmtCols,
                                'permTitle' => $permTitle,
                                'permCols' => $permCols,
                                'extTitle' => $extTitle,
                                'extCols' => $extCols,
                            ])
                    @else
                        <h6><strong>{{ $ceTitle }}</strong></h6> @php $renderTable($chiefExecs,$ceCols); @endphp
                        <h6 class="mt-3"><strong>{{ $seTitle }}</strong></h6> @php $renderTable($shariahExp,$seCols); @endphp
                        <h6 class="mt-3"><strong>{{ $qmrTitle }}</strong></h6> @php $renderTable($qualityReps,$qmrCols); @endphp
                        <h6 class="mt-3"><strong>{{ $mgmtTitle }}</strong></h6> @php $renderTable($mgmtMembers,$mgmtCols); @endphp
                        <h6 class="mt-3"><strong>{{ $permTitle }}</strong></h6> @php $renderTable($permAuditors,$permCols); @endphp
                        <h6 class="mt-3"><strong>{{ $extTitle }}</strong></h6> @php $renderTable($extAuditors,$extCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step3') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 4: Scope of Application ===== --}}
                @php 
                    $scopes = $data['scopes'] ?? collect();
                    $scopeTitle = $getSection('Scope of Halal Certification') ? $getSection('Scope of Halal Certification')['title'] : 'Scope of Halal Certification';
                    $scopeCols = $getColumns('Scope of Halal Certification', [
                        'category_code' => 'Cat. Code',
                        'category' => 'Category',
                        'subcategory' => 'Sub Category',
                        'included_activities' => 'Included Activities',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step4"
                    data-open="{{ $openSection === 'step4' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 4: {{ $scopeTitle }}</h5>
                            <p class="text-muted mb-0">Halal certification categories, subcategories & activities.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step4') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step4') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step4'))
                        @include(
                            'admin.application.halal_certification_bodies.step_4_scope_application',
                            [
                                'scopes' => $scopes,
                                'isLocked' => $isLocked,
                                'stepUrl' => $stepUrl,
                                'firstRow' => $firstRow,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                                'scopeTitle' => $scopeTitle,
                                'scopeCols' => $scopeCols,
                            ])
                    @else
                        @php $renderTable($scopes, $scopeCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step4') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 5: Quality System ===== --}}
                @php
                    $qs = $data['quality_system'] ?? collect();
                    $nonComply = $data['non_compliances'] ?? collect();
                    
                    $ncTitle = $getSection('Non-Compliance Areas') ? $getSection('Non-Compliance Areas')['title'] : 'Non-Compliance Areas';
                    $ncCols = $getColumns('Non-Compliance Areas', [
                        'area_of_non_compliance' => 'Area of Non-Compliance',
                        'rectified_by_date' => 'Rectified By Date',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step5"
                    data-open="{{ $openSection === 'step5' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 5: Quality System</h5>
                            <p class="text-muted mb-0">Organisation, management, audit, staff, procedures, records &
                                compliance.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step5') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step5') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step5'))
                        @include(
                            'admin.application.halal_certification_bodies.step_5_quality_system',
                            [
                                'qs' => $qs,
                                'nonComply' => $nonComply,
                                'isLocked' => $isLocked,
                                'stepUrl' => $stepUrl,
                                'firstRow' => $firstRow,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                                'ncTitle' => $ncTitle,
                                'ncCols' => $ncCols,
                            ])
                    @else
                        <p class="text-muted">{{ $qs->count() }} quality system answer(s) saved.</p>
                        @if ($nonComply->isNotEmpty())
                            <h6 class="mt-3"><strong>{{ $ncTitle }}</strong></h6>
                            @php $renderTable($nonComply, $ncCols); @endphp
                        @endif
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step5') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 6: Other Approvals ===== --}}
                @php 
                    $approvals = $data['other_approvals'] ?? collect();
                    $otherTitle = $getSection('Other Approvals / Existing Certificates') ? $getSection('Other Approvals / Existing Certificates')['title'] : 'Other Approvals / Existing Certificates';
                    $otherCols = $getColumns('Other Approvals / Existing Certificates', [
                        'approval_body_name' => 'Approval Body',
                        'scope' => 'Scope',
                        'certificate_number' => 'Cert No.',
                        'start_date' => 'Start Date',
                        'expiry_date' => 'Expiry Date',
                    ]);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step6"
                    data-open="{{ $openSection === 'step6' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 6: {{ $otherTitle }}</h5>
                            <p class="text-muted mb-0">Existing accreditation certificates from other bodies.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step6') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step6') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step6'))
                        @include(
                            'admin.application.halal_certification_bodies.step_6_other_approvals',
                            [
                                'approvals' => $approvals,
                                'isLocked' => $isLocked,
                                'stepUrl' => $stepUrl,
                                'firstRow' => $firstRow,
                                'getSection' => $getSection,
                                'getLabel' => $getLabel,
                                'getColumns' => $getColumns,
                            ])
                    @else
                        @php $renderTable($approvals, $otherCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step6') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 7: Declaration ===== --}}
                @php $declaration = $data['declaration'] ?? null; @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step7"
                    data-open="{{ $openSection === 'step7' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 7: {{ $getSection('7.2 Declarations') ? $getSection('7.2 Declarations')['title'] : 'Declaration & Submit' }}</h5>
                            <p class="text-muted mb-0">Final declaration, applicant fee, signature and submission.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step7') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step7') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step7'))
                        @include(
                            'admin.application.halal_certification_bodies.step_7_declaration',
                            compact('declaration', 'isLocked', 'stepUrl', 'getSection', 'getLabel', 'getColumns'))
                    @else
                        @php 
                            $renderDetails([
                                $getLabel('7.1 Application Type', 'halal_scope', 'Halal Scope') => ($declaration->halal_scope??false)?'Yes':'No',
                                $getLabel('7.1 Application Type', 'extension_scope', 'Extension of Scope') => ($declaration->extension_scope??false)?'Yes':'No',
                                $getLabel('7.2 Declarations', 'quality_manual_confirmed', 'Quality Manual Confirmed') => ($declaration->quality_manual_confirmed??false)?'Yes':'No',
                                $getLabel('7.2 Declarations', 'declaration_accepted', 'Declaration Accepted') => ($declaration->declaration_accepted??false)?'Yes':'No',
                                $getLabel('7.3 Applicant Fee & Signature', 'applicant_fee_amount', 'Applicant Fee') => $declaration->applicant_fee_amount??'',
                                $getLabel('7.3 Applicant Fee & Signature', 'signed_by', 'Signed By') => $declaration->signed_by??'',
                                $getLabel('7.3 Applicant Fee & Signature', 'signed_date', 'Signed Date') => $declaration->signed_date??''
                            ]); 
                        @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step7') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>



            </div>{{-- #pnacVerticalForm --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cards = Array.from(document.querySelectorAll('#pnacVerticalForm > .pnac-step-card'));
            var preferredOpen =
                '{{ session('open_section') ?: request('open_section') ?: request('edit_section') }}';
            var hasBS = typeof bootstrap !== 'undefined' && typeof bootstrap.Collapse !== 'undefined';

            cards.forEach(function(card, index) {
                var header = card.querySelector(':scope > .d-flex.justify-content-between');
                if (!header) return;

                var bodyId = 'hcbCollapseBody' + (index + 1);
                var body = document.createElement('div');
                body.id = bodyId;
                body.className = hasBS ? 'collapse pnac-collapse-body' : 'pnac-collapse-body';

                Array.from(card.children).filter(function(c) {
                    return c !== header;
                }).forEach(function(c) {
                    body.appendChild(c);
                });
                card.appendChild(body);

                header.classList.add('pnac-collapsible-header');
                header.setAttribute('role', 'button');
                header.setAttribute('tabindex', '0');

                var titleArea = document.createElement('div');
                titleArea.className = 'pnac-card-title-area';
                var existDiv = header.querySelector(':scope > div');
                if (existDiv) titleArea.appendChild(existDiv);

                var actions = document.createElement('div');
                actions.className = 'pnac-card-actions';
                var badge = header.querySelector('.badge');
                if (badge) actions.appendChild(badge);
                var chev = document.createElement('span');
                chev.className = 'pnac-collapse-chevron';
                actions.appendChild(chev);

                header.innerHTML = '';
                header.appendChild(titleArea);
                header.appendChild(actions);

                var section = card.getAttribute('data-section');
                var shouldOpen = preferredOpen ? preferredOpen === section : index === 0;

                if (shouldOpen) {
                    header.setAttribute('aria-expanded', 'true');
                    if (hasBS) body.classList.add('show');
                    else body.style.maxHeight = '9999px';
                } else {
                    header.setAttribute('aria-expanded', 'false');
                    if (!hasBS) body.style.maxHeight = '0px';
                }

                var toggle = function() {
                    if (hasBS) {
                        var inst = bootstrap.Collapse.getOrCreateInstance(body, {
                            toggle: false
                        });
                        body.classList.contains('show') ? inst.hide() : inst.show();
                    } else {
                        var exp = header.getAttribute('aria-expanded') === 'true';
                        body.style.maxHeight = exp ? '0px' : '9999px';
                        header.setAttribute('aria-expanded', String(!exp));
                    }
                };
                header.addEventListener('click', toggle);
                header.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggle();
                    }
                });
                if (hasBS) {
                    body.addEventListener('shown.bs.collapse', function() {
                        header.setAttribute('aria-expanded', 'true');
                    });
                    body.addEventListener('hidden.bs.collapse', function() {
                        header.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        });
    </script>
    <script src="{{ url('admin/js/halal-certification.js') }}?v={{ time() }}"></script>
@endsection
