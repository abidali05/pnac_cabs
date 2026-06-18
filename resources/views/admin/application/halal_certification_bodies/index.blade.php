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
                            <h5 class="mb-1">Step 1: Basic Information</h5>
                            <p class="text-muted mb-0">HCB details, contact person, sub-offices & accreditation request.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step1') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step1') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step1'))
                        @include(
                            'admin.application.halal_certification_bodies.step_1_basic_information',
                            compact('basicInfo', 'subOffices', 'isLocked', 'stepUrl', 'firstRow'))
                    @else
                        @php $renderDetails(['Organization Name'=>$basicInfo->organization_name??'','Address'=>$basicInfo->address??'','Telephone'=>$basicInfo->telephone??'','Contact Name'=>$basicInfo->contact_name??'','Contact Email'=>$basicInfo->contact_email??'']); @endphp
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
                            <h5 class="mb-1">Step 2: About HCB</h5>
                            <p class="text-muted mb-0">Authorized person, parent org, invoice address, ownership &
                                consultant.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step2') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step2') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step2'))
                        @include(
                            'admin.application.halal_certification_bodies.step_2_about_hcb',
                            compact('aboutHcb', 'isLocked', 'stepUrl'))
                    @else
                        @php $renderDetails(['Authorized Person'=>$aboutHcb->name??'','Position'=>$aboutHcb->position??'','Parent Organization'=>$aboutHcb->parent_organization??'','Ownership Type'=>$aboutHcb->ownership_type??'','Is Halal Main Activity'=>$aboutHcb->is_halal_main_activity??'','Consultant'=>$aboutHcb->consultant_name??'']); @endphp
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
                    $staffCols = [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'experience' => 'Experience',
                    ];
                    $auditorCols = [
                        'name' => 'Name',
                        'religion' => 'Religion',
                        'qualification' => 'Qualification',
                        'auditing_field' => 'Auditing Field',
                        'audit_experience' => 'Audit Experience',
                    ];
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
                            compact(
                                'chiefExecs',
                                'shariahExp',
                                'qualityReps',
                                'mgmtMembers',
                                'permAuditors',
                                'extAuditors',
                                'isLocked',
                                'stepUrl',
                                'firstRow',
                                'staffCols',
                                'auditorCols'))
                    @else
                        <h6><strong>Chief Executives</strong></h6> @php $renderTable($chiefExecs,$staffCols); @endphp
                        <h6 class="mt-3"><strong>Shariah Experts</strong></h6> @php $renderTable($shariahExp,$staffCols); @endphp
                        <h6 class="mt-3"><strong>Quality Management Representatives</strong></h6> @php $renderTable($qualityReps,$staffCols); @endphp
                        <h6 class="mt-3"><strong>Management Members</strong></h6> @php $renderTable($mgmtMembers,$staffCols); @endphp
                        <h6 class="mt-3"><strong>Permanent Auditors</strong></h6> @php $renderTable($permAuditors,$auditorCols); @endphp
                        <h6 class="mt-3"><strong>External Auditors</strong></h6> @php $renderTable($extAuditors,$auditorCols); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step3') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 4: Scope of Application ===== --}}
                @php $scopes = $data['scopes'] ?? collect(); @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step4"
                    data-open="{{ $openSection === 'step4' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 4: Scope of Application</h5>
                            <p class="text-muted mb-0">Halal certification categories, subcategories & activities.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step4') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step4') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step4'))
                        @include(
                            'admin.application.halal_certification_bodies.step_4_scope_application',
                            compact('scopes', 'isLocked', 'stepUrl', 'firstRow'))
                    @else
                        @php $renderTable($scopes,['category_code'=>'Cat. Code','category'=>'Category','subcategory'=>'Sub Category','included_activities'=>'Included Activities']); @endphp
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step4') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 5: Quality System ===== --}}
                @php
                    $qs = $data['quality_system'] ?? collect();
                    $nonComply = $data['non_compliances'] ?? collect();
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
                            compact('qs', 'nonComply', 'isLocked', 'stepUrl', 'firstRow'))
                    @else
                        <p class="text-muted">{{ $qs->count() }} quality system answer(s) saved.</p>
                        @if ($nonComply->isNotEmpty())
                            <h6 class="mt-3"><strong>Non-Compliance Areas</strong></h6>
                            @php $renderTable($nonComply,['area_of_non_compliance'=>'Area of Non-Compliance','rectified_by_date'=>'Rectified By Date']); @endphp
                        @endif
                        <div class="d-flex justify-content-end mt-3"><a href="{{ $editUrl('step5') }}"
                                class="btn btn-outline-success btn-sm">Edit</a></div>
                    @endif
                </div>

                {{-- ===== STEP 6: Other Approvals ===== --}}
                @php $approvals = $data['other_approvals'] ?? collect(); @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card" data-section="step6"
                    data-open="{{ $openSection === 'step6' ? '1' : '0' }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step 6: Other Approvals</h5>
                            <p class="text-muted mb-0">Existing accreditation certificates from other bodies.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step6') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step6') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step6'))
                        @include(
                            'admin.application.halal_certification_bodies.step_6_other_approvals',
                            compact('approvals', 'isLocked', 'stepUrl', 'firstRow'))
                    @else
                        @php $renderTable($approvals,['approval_body_name'=>'Approval Body','scope'=>'Scope','certificate_number'=>'Cert No.','start_date'=>'Start Date','expiry_date'=>'Expiry Date']); @endphp
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
                            <h5 class="mb-1">Step 7: Declaration &amp; Submit</h5>
                            <p class="text-muted mb-0">Final declaration, applicant fee, signature and submission.</p>
                        </div>
                        <span
                            class="badge {{ $isSaved('step7') ? 'bg-success' : 'bg-warning text-dark' }}">{{ $isSaved('step7') ? 'Saved' : 'Unsaved' }}</span>
                    </div>
                    @if ($isEditing('step7'))
                        @include(
                            'admin.application.halal_certification_bodies.step_7_declaration',
                            compact('declaration', 'isLocked', 'stepUrl'))
                    @else
                        @php $renderDetails(['Halal Scope'=>($declaration->halal_scope??false)?'Yes':'No','Extension of Scope'=>($declaration->extension_scope??false)?'Yes':'No','Quality Manual Confirmed'=>($declaration->quality_manual_confirmed??false)?'Yes':'No','Declaration Accepted'=>($declaration->declaration_accepted??false)?'Yes':'No','Applicant Fee'=>$declaration->applicant_fee_amount??'','Signed By'=>$declaration->signed_by??'','Signed Date'=>$declaration->signed_date??'']); @endphp
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
    <script src="{{ asset('js/halal-certification.js') }}"></script>
@endsection
