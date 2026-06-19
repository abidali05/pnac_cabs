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
                            <h5 class="mb-1">Step 1: Organization Details</h5>
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
                        ])
                    @else
                        @php
                            $renderDetails([
                                'Inspection Body Name' => $org->inspection_body_name ?? '',
                                'Address' => $org->address ?? '',
                                'Parent Organization' => $org->parent_organization ?? '',
                                'Relationship' => $org->relationship ?? '',
                                'Parent Address' => $org->parent_address ?? '',
                                'Parent Postcode' => $org->parent_postcode ?? '',
                                'Parent Tel' => $org->parent_tel ?? '',
                                'Parent Fax' => $org->parent_fax ?? '',

                                'Legal Status' => $org->legal_status ?? '',
                                'Date of Establishment' => $org->date_of_establishment ?? '',
                                'Outside Pakistan' => $org->outside_pakistan ?? '',
                                'Consultant Name' => $org->consultant_name ?? '',
                                'Consultant Email' => $org->consultant_email ?? '',
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
                    $staffCols = ['name' => 'Name', 'qualifications' => 'Qualifications', 'experience' => 'Experience'];
                    $inspCols = [
                        'name' => 'Name',
                        'qualification' => 'Qualification',
                        'inspection_field' => 'Inspection Field',
                        'inspection_experience' => 'Experience',
                    ];
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
                            compact(
                                'staffRoles',
                                'mgmtMembers',
                                'inspectors',
                                'freelance',
                                'isLocked',
                                'staffCols',
                                'inspCols',
                                'firstRow'))
                    @else
                        <h6><strong>Chief Executive</strong></h6>
                        @php $renderTable($staffRoles->get('Chief Executive',collect()),$staffCols); @endphp
                        <h6 class="mt-4"><strong>Quality Management Representative</strong></h6>
                        @php $renderTable($staffRoles->get('Quality Management Representative',collect()),$staffCols); @endphp
                        <h6 class="mt-4"><strong>Management Members</strong></h6>
                        @php $renderTable($mgmtMembers,$staffCols); @endphp
                        <h6 class="mt-4"><strong>Permanent Inspectors</strong></h6>
                        @php $renderTable($inspectors,$inspCols); @endphp
                        <h6 class="mt-4"><strong>Freelance Inspectors</strong></h6>
                        @php $renderTable($freelance,$inspCols); @endphp
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ $editUrl('step2') }}" class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>

                {{-- ========== STEP 3 ========== --}}
                @php
                    $scopes = $data['scopes'] ?? collect();
                    $equipment = $data['equipment'] ?? collect();
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
                            compact('scopes', 'equipment', 'isLocked', 'firstRow'))
                    @else
                        <h6><strong>Scope of Inspection</strong></h6>
                        @php $renderTable($scopes,['description_of_inspection'=>'Description','type_and_range'=>'Type & Range','methods_and_procedures'=>'Methods & Procedures']); @endphp
                        <h6 class="mt-4"><strong>Equipment</strong></h6>
                        @php $renderTable($equipment,['equipment_name'=>'Equipment Name','calibration_organization'=>'Calibration Org','calibration_frequency'=>'Frequency','last_calibration_date'=>'Last Calibration']); @endphp
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
                            <h5 class="mb-1">Step 4: Declaration &amp; Submit</h5>
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
                            compact('declaration', 'isLocked'))
                    @else
                        @php
                            $renderDetails([
                                'Type A' => $declaration->type_a ?? false ? 'Yes' : 'No',
                                'Type B' => $declaration->type_b ?? false ? 'Yes' : 'No',
                                'Type C' => $declaration->type_c ?? false ? 'Yes' : 'No',
                                'ISO/IEC 17020 Compliance' => $declaration->iso17020_compliance ?? false ? 'Yes' : 'No',
                                'Assessment Understanding' =>
                                    $declaration->assessment_understanding ?? false ? 'Yes' : 'No',
                                'Agreement Acceptance' => $declaration->agreement_acceptance ?? false ? 'Yes' : 'No',
                                'Quality Manual Attached' =>
                                    $declaration->quality_manual_attached ?? false ? 'Yes' : 'No',
                                'Document Review Attached' =>
                                    $declaration->document_review_attached ?? false ? 'Yes' : 'No',
                                'Applicant Fee' => $declaration->applicant_fee ?? '',
                                'Declaration Name' => $declaration->declaration_name ?? '',
                                'Declaration Date' => $declaration->declaration_date ?? '',
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
