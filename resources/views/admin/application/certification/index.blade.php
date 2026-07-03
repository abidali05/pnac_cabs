@extends('admin.layouts.adminlayout')
@section('main-content')
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

        .card {
            display: none;
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
    </style>
@endsection
<!-- Start app main Content -->
<div class="main-content">
    <section class="section">
        {{-- Legacy tab-based form disabled per new vertical flow request --}}
        @if (false)

            <div class="mb-3 bg-success rounded-1 p-2">
                <button class="btn btn-success p-2 section-btn" id="General">Part 1 (General Info)</button>
                <button class="btn btn-success p-2 section-btn" id="Employee">Part 2 (Employees)</button>
                <button class="btn btn-success p-2 section-btn" id="Document">Part 3 (Documents)</button>
                <button class="btn btn-success p-2 section-btn" id="Scope">Part 4 (Scope)</button>
                <button class="btn btn-success p-2 section-btn" id="Declaration">Part 5 (Declaration)</button>
            </div>
            <div class="row">


                @php
                    // Extracted scheme from the URL
                    $scheme_name = urldecode(request()->query('scheme_name'));
                    $application = urldecode(request()->query('application'));
                    $isNewApp = $application == 'New Application';
                    $isSubmitted = optional(@$general->declaration)->status === 'submited';

                    $isReadonly = $isNewApp && $isSubmitted;
                    // Closure to return value only for New Application
                    $fieldValue = function ($field) use ($isNewApp, $general) {
                        return $isNewApp ? $general->$field ?? '' : '';
                    };

                @endphp


                <div class="col-12">

                    <div class="card" id="GeneralTable">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">General</h4>
                            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#schemeModal">New General</button> --}}
                        </div>
                        <form action="{{ route('application.store.certification') }}" id="Part1Form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="application" value="{{ $application }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Accreditation Scheme</label>
                                            <input type="text" name="scheme" value="{{ $scheme_name }}" readonly
                                                class="form-control">
                                            <input type="hidden" name="category" value="{{ $scheme_name }}">
                                            <input type="hidden" name="type" value="general">
                                            {{-- <input type="hidden" name="general_id" value="@if (!empty($general->application) && $scheme_name === 'New Application'){{ $general->id ?? '' }}@endif"> --}}
                                            <input type="hidden" name="general_id">
                                            <input type="hidden" name="reference_no" value="{{ $referenceNumber }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        {{-- {{ dd($general->application) }} --}}
                                        <div class="form-group">
                                            <label>CAB Name</label>
                                            <input type="text" name="cab_name" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" required class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Telephone</label>
                                        <input type="text" name="telephone" required class="form-control">
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Email</label>
                                        <input type="email" name="email" required class="form-control">
                                    </div>
                                    <div class="form-group col-4">
                                        <label>NTN/FTN</label>
                                        <input type="text" name="ntn_ftn" required class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="text" name="website" required class="form-control">
                                        </div>



                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>City:</label>
                                            <input type="text" name="city" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Country:</label>
                                            <select name="country" class="form-select" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="country" value="{{ $fieldValue('country') }}" @if ($isReadonly) readonly @endif required class="form-control"> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label>Postal Code</label>
                                            <input type="text" name="postal_code" required class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="footer d-flex justify-content-end">
                                    {{-- <button class="btn btn-success" type="submit">Submit</button> --}}
                                    {{-- <button class="btn btn-secondary prev-btn" type="button">Previous</button> --}}
                                    <button class="btn btn-primary next-btn" type="submit">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Employees --}}
                    <div class="card" id="EmployeeTable">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Employees</h4>
                            {{--  @if (!$isSubmitted)  --}}
                            <button class="btn btn-success" onclick="openEmployeeModal()">New Employees</button>
                            {{--  @endif  --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped v_center employeeTable" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S#</th>
                                            <th>Employees Name</th>
                                            <th>Designation</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="employee-tbody">
                                        @foreach ($employees as $key => $employee)
                                            <tr id="employee-tr">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $employee->employee_name }}</td>
                                                <td>{{ $employee->designation }}</td>
                                                <td>{{ $employee->address }}</td>
                                                <td>{{ $employee->telephone }}</td>
                                                <td>{{ $employee->email }}</td>
                                                @php
                                                    $isSubmitted =
                                                        optional($employee->general->declaration)->status ===
                                                        'submited';
                                                @endphp

                                                <td>
                                                    @if (!$isSubmitted)
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick='openEmployeeModal(@json($employee))'>Edit</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex mt-3">
                                <button class="btn btn-secondary prev-btn m-1" type="button">Previous</button>
                                <button class="btn btn-primary next-btn m-1" type="button">Next</button>
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="card" id="DocumentTable">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Documents</h4>
                            @if (!$isSubmitted)
                                <button class="btn btn-success" onclick="openDocumentModal()">New Documents</button>
                            @endif
                            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#documentModal">New Documents</button> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="documentsTable" class="table table-striped v_center">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S#</th>
                                            <th>Name of Document</th>
                                            <th>File</th>
                                            <th>Date Upload</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="document-tbody">
                                        @forelse ($documentDetails as $key => $document)
                                            <tr id="document-tr">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $document->name }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $document->upload_doc) }}"
                                                        target="_blank">File</a>
                                                </td>
                                                <td>{{ $document->created_at }}</td>

                                                @php
                                                    $isSubmitted =
                                                        optional(@$employee->general->declaration)->status ===
                                                        'submited';
                                                @endphp

                                                <td>
                                                    @if (!$isSubmitted)
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick='openDocumentModal(@json($document))'>Edit</button>
                                                    @endif
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-danger fw-bold">No data
                                                    found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex mt-3">
                                <button class="btn btn-secondary prev-btn m-1" type="button">Previous</button>
                                <button class="btn btn-primary next-btn m-1" type="button">Next</button>
                            </div>
                        </div>
                    </div>

                    {{-- Scope --}}
                    <div class="card" id="ScopeTable">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Scope</h4>
                            {{-- @if (!$isSubmitted)
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#scopeModal">New Scope</button>
                        @endif --}}
                        </div>
                        <div class="card-body row mb-3">
                            @if ($scheme_name == 'Testing')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            {{-- <h5 class="card-title font-weight-bold">ISO 9001:2025</h5> --}}
                                            <h5 class="card-subtitle mb-3">Scope of application</h5>
                                            <h5 class="card-subtitle mb-3 text-muted">Testing</h5>
                                            {{-- <p class="card-text">
                                        <img src="{{ asset('images/iso.png') }}" width="100px" class="rounded-circle" alt="ISO 9001">
                                    </p> --}}
                                            <button class="card-link btn btn-warning" data-type="Testing"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add
                                                Testing</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Testing', 'scope' => 'Testing', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning ">View Testing</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Testing Scope Table --}}

                                <div class="card-header d-flex justify-content-between align-items-center mt-4">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table v_center" id="table-7">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Materials/Products tested*</th>
                                                        <th>Testing Field (e.g. Environmental testing or mechanical
                                                            testing)</th>
                                                        <th>Types of test/Properties measured</th>
                                                        <th>Standard specification/Techniques/equipment used</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->materials }}</td>
                                                            <td>{{ $scope->mechanical }}</td>
                                                            <td>{{ $scope->property_measured }}</td>
                                                            <td>{{ $scope->standard }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeTestingModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Calibration')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-3">
                                            <h5 class="card-subtitle mb-3">Scope of application</h5>
                                            <h5 class="card-subtitle mb-3 text-muted">Calibration</h5>
                                            <button class="card-link btn btn-warning" data-type="Calibration"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add
                                                Calibration</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Calibration', 'scope' => 'Calibration', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning ">View Calibration</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Calibration Scope Table --}}

                                <div class="card-header d-flex justify-content-between align-items-center mt-4">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-8">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Measured quantity</th>
                                                        <th>Range</th>
                                                        <th>*Expanded Uncertainty( + )</th>
                                                        <th>Technique, Reference Standard, Equipment</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->measurement }}</td>
                                                            <td>{{ $scope->range }}</td>
                                                            <td>{{ $scope->expanded }}</td>
                                                            <td>{{ $scope->technique }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeCalibrationModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Testing Calibration Laboratories')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-3">
                                            <h5 class="card-subtitle mb-3">Scope of application</h5>
                                            <h5 class="card-subtitle mb-3 text-muted">Testing</h5>
                                            <button class="card-link btn btn-warning" data-type="Testing"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add
                                                Testing</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Testing', 'scope' => 'Testing']) }}" class="card-link btn btn-warning ">View Testing</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-3">
                                            <h5 class="card-subtitle mb-3">Scope of application</h5>
                                            <h5 class="card-subtitle mb-3 text-muted">Calibration</h5>
                                            <button class="card-link btn btn-warning" data-type="Calibration"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add
                                                Calibration</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Calibration', 'scope' => 'Calibration']) }}" class="card-link btn btn-warning ">View Calibration</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Testing Calibration Laboratories Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center mt-4">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-9">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Materials/Products tested*</th>
                                                        <th>Testing Field (e.g. Environmental testing or mechanical
                                                            testing)</th>
                                                        <th>Types of test/Properties measured</th>
                                                        <th>Standard specification/Techniques/equipment used</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->materials }}</td>
                                                            <td>{{ $scope->mechanical }}</td>
                                                            <td>{{ $scope->property_measured }}</td>
                                                            <td>{{ $scope->standard }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeTestingModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-10">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Measured quantity</th>
                                                        <th>Range</th>
                                                        <th>*Expanded Uncertainty( + )</th>
                                                        <th>Technique, Reference Standard, Equipment</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->measurement }}</td>
                                                            <td>{{ $scope->range }}</td>
                                                            <td>{{ $scope->expanded }}</td>
                                                            <td>{{ $scope->technique }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeCalibrationModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Certification Bodies')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Quality Management System</h5>
                                            <h5 class="card-title font-weight-bold  text-muted">ISO 9001:2025</h5>
                                            <button class="card-link btn btn-warning" data-type="ISO9001"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add ISO
                                                9001:2025</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Certification Bodies', 'scope' => 'ISO9001', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning ">View ISO 9001:2025</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Environmental Management System</h5>
                                            <h5 class="card-title font-weight-bold text-muted">ISO 14001:2025</h5>
                                            <button class="card-link btn btn-warning px-4" data-type="ISO14001"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add ISO
                                                14001</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Certification Bodies', 'scope' => 'ISO14001', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View ISO 14001</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Occupational Health & Safety</h5>
                                            <h5 class="card-title font-weight-bold text-muted">ISO 45001:2025</h5>
                                            <button class="card-link btn btn-warning px-4" data-type="ISO45001"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add ISO
                                                45001</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Certification Bodies', 'scope' => 'ISO45001', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View ISO 45001</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Medical Devices QMS</h5>
                                            <h5 class="card-title font-weight-bold text-muted">ISO 13485:2025</h5>
                                            <button class="card-link btn btn-warning px-4" data-type="ISO13485"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add ISO
                                                13485</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Certification Bodies', 'scope' => 'ISO13485', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View ISO 13485</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Food Safety Management System</h5>
                                            <h5 class="card-title font-weight-bold text-muted">ISO 22000:2025</h5>
                                            <button class="card-link btn btn-warning px-4" data-type="ISO22000"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add ISO
                                                22000</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Certification Bodies', 'scope' => 'ISO22000', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View ISO 22000</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Cetification Bodies Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <h5>ISO9001</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-6">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Technical Cluster</th>
                                                        <th>IAF Code</th>
                                                        <th>Description of economic sector/activity, according to IAF
                                                            ID1</th>
                                                        <th>Date of Scope Applied</th>
                                                        {{-- <th>Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($scopes as $key => $scope)
                                                        @if ($scope->scope_type == 'ISO9001')
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $scope->technicalCluster->name ?? '' }}</td>
                                                                <td>{{ $scope->iaf_code }}</td>
                                                                <td>{{ $scope->description }}</td>
                                                                <td>{{ $scope->created_at }}</td>
                                                                @php
                                                                    $isSubmitted =
                                                                        optional($scope->general->declaration)
                                                                            ->status === 'submited';
                                                                @endphp
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <h5>ISO14001</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-2">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Technical Cluster</th>
                                                        <th>IAF Code</th>
                                                        <th>Description of economic sector/activity, according to IAF
                                                            ID1</th>
                                                        <th>Date of Scope Applied</th>
                                                        {{-- <th>Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        @if ($scope->scope_type == 'ISO14001')
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $scope->technicalCluster->name ?? '' }}</td>
                                                                <td>{{ $scope->iaf_code }}</td>
                                                                <td>{{ $scope->description }}</td>
                                                                <td>{{ $scope->created_at }}</td>
                                                                @php
                                                                    $isSubmitted =
                                                                        optional($scope->general->declaration)
                                                                            ->status === 'submited';
                                                                @endphp
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <h5>ISO45001</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-3">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Technical Cluster</th>
                                                        <th>IAF Code</th>
                                                        <th>Description of economic sector/activity, according to IAF
                                                            ID1</th>
                                                        <th>Date of Scope Applied</th>
                                                        {{-- <th>Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        @if ($scope->scope_type == 'ISO45001')
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $scope->technicalCluster->name ?? '' }}</td>
                                                                <td>{{ $scope->iaf_code }}</td>
                                                                <td>{{ $scope->description }}</td>
                                                                <td>{{ $scope->created_at }}</td>
                                                                @php
                                                                    $isSubmitted =
                                                                        optional($scope->general->declaration)
                                                                            ->status === 'submited';
                                                                @endphp
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <h5>ISO13485</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-4">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Main Technical</th>
                                                        <th>Technical Area</th>
                                                        <th>Product Categories / Descriptions</th>
                                                        <th>Date of Scope Applied</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        @if ($scope->scope_type == 'ISO13485')
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $scope->mainTechnical->technical_name ?? '' }}
                                                                </td>
                                                                <td>{{ $scope->technicalArea->technical_area ?? '' }}
                                                                </td>
                                                                <td>{!! $scope->description ?? '' !!}</td>
                                                                <td>{!! $scope->created_at ?? '' !!}</td>
                                                                @php
                                                                    $isSubmitted =
                                                                        optional($scope->general->declaration)
                                                                            ->status === 'submited';
                                                                @endphp
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="card-body">
                                        <h5>ISO22000</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-5">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Cluster</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Description</th>
                                                        <th>Date of Scope Applied</th>
                                                        {{-- <th>Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        @if ($scope->scope_type == 'ISO22000')
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $scope->cluster->cluster_name ?? '' }}</td>
                                                                <td>{{ $scope->category->category_name ?? '' }}</td>
                                                                <td>{{ $scope->cluster_sub_cat ?? '' }}</td>
                                                                <td>{{ $scope->description ?? '' }}</td>
                                                                <td>{{ $scope->created_at ?? '' }}</td>
                                                                @php
                                                                    $isSubmitted =
                                                                        optional($scope->general->declaration)
                                                                            ->status === 'submited';
                                                                @endphp
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Medical Laboratories')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Scope of Application</h5>
                                            <h6 class="card-title font-weight-bold text-muted">Medical Laboratories
                                            </h6>

                                            <button class="card-link btn btn-warning px-4" data-bs-toggle="modal"
                                                data-bs-target="#scopeModal">Add Medical Laboratories</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Medical Laboratories', 'scope' => 'Medical', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View Medical Laboratories</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Medical Laboratories Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-11">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Materials/Products tested</th>
                                                        <th>Testing field (e.g. environmental testing or mechanical
                                                            testing)</th>
                                                        <th>Types of test/Properties measured</th>
                                                        <th>Reference to standardized method (e.g. ISO 14577-1:2003)/
                                                            Internal method reference</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->meterials }}</td>
                                                            <td>{{ $scope->chemical }}</td>
                                                            <td>{{ $scope->measured }}</td>
                                                            <td>{{ $scope->standardized }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Inspection Bodies')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Scope of Application</h5>
                                            <h6 class="card-title font-weight-bold text-muted">Inspection Bodies</h6>
                                            <button class="card-link btn btn-warning px-4" data-bs-toggle="modal"
                                                data-bs-target="#scopeModal">Add Inspection Bodies</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Inspection Bodies', 'scope' => 'Inspection', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View Inspection Bodies</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Inspection Bodies Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-12">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Description of Inspection(s), including the types of items
                                                            inspected,</th>
                                                        <th>Type and Range of Inspection</th>
                                                        <th>Methods and Procedures</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->description }}</td>
                                                            <td>{{ $scope->range }}</td>
                                                            <td>{{ $scope->procedures }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Halal Certification Bodies')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Scope of Application</h5>
                                            <h6 class="card-subtitle mb-3 text-muted">Halal Certification Bodies</h6>
                                            <a class="card-link btn btn-warning px-4 text-white"
                                                data-bs-toggle="modal" data-bs-target="#scopeModal">Add Halal
                                                Certification Bodies</a>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Halal Certification Bodies', 'scope' => 'Halal', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View Halal Certification Bodies</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Halal Certification Bodies Scope Table --}}

                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-13">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Cat. Code</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->cat_code }}</td>
                                                            <td>{{ $scope->scope_category }}</td>
                                                            <td>{{ $scope->subcategory }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Proficiency Testing Provider')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Scope of Application</h5>
                                            <h6 class="card-subtitle mb-3 text-muted">Proficiency Testing Provider</h6>
                                            <button class="card-link btn btn-warning px-4" data-bs-toggle="modal"
                                                data-bs-target="#scopeModal">Add Proficiency Testing Provider</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Proficiency Testing Provider', 'scope' => 'Proficiency', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View Proficiency Testing Provider</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Proficiency Certification Bodies Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-14">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Items/ Materials/ Matrix/Products</th>
                                                        <th>Type of Scheme/test/properties</th>
                                                        <th>Scheme Protocol.Procedure/technique used</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->item_materials }}</td>
                                                            <td>{{ $scope->type_scheme }}</td>
                                                            <td>{{ $scope->scheme_protocol }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Product Certification Bodies')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Scope of Application</h5>
                                            <h6 class="card-subtitle mb-3 text-muted">Product Certification Bodies</h6>
                                            <button class="card-link btn btn-warning px-4" data-bs-toggle="modal"
                                                data-bs-target="#scopeModal">Add Product Certification Bodies</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Product Certification Bodies', 'scope' => 'Proficiency', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning px-4">View Product Certification Bodies</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Product Certification Bodies Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-15">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>Product</th>
                                                        <th>Standard</th>
                                                        <th>Type of Scheme (ISO/IEC 17067)</th>
                                                        <th>Countries where certificates are to be issued</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->product }}</td>
                                                            <td>{{ $scope->standard }}</td>
                                                            <td>{{ $scope->type_scheme }}</td>
                                                            <td>{{ $scope->countries }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional(@$scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($scheme_name == 'Personnel Certification Bodies')
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border text-center justify-content-center iso-card shadow-sm mt-4"
                                        style="width: 20rem;">
                                        <div class="card-body p-4">
                                            <h5 class="card-subtitle mb-3">Scope of Application</h5>
                                            <h6 class="card-subtitle mb-3 text-muted">Personnel Certification Bodies
                                            </h6>
                                            <button class="card-link btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#scopeModal">Add Personnel Certification
                                                Bodies</button>
                                            {{-- <a href="{{ route('application.view.scope', ['category' => 'Personnel Certification Bodies', 'scope' => 'ISO9001', 'application' => urldecode(request()->query('application'))]) }}" class="card-link btn btn-warning ">View Personnel Certification Bodies</a> --}}
                                        </div>
                                    </div>
                                </div>

                                {{-- Personnel Certification Bodies Scope Table --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>View Scope</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped v_center" id="table-16">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S#</th>
                                                        <th>PERSONNEL CERTIFICATION CATEGORIES </th>
                                                        <th>STANDARDS/NORMATIVE REFERENCES</th>
                                                        <th>Date of Scope Applied</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scopes as $key => $scope)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $scope->technical_cluster }}</td>
                                                            <td>{{ $scope->description_iaf }}</td>
                                                            <td>{{ $scope->created_at }}</td>
                                                            @php
                                                                $isSubmitted =
                                                                    optional($scope->general->declaration)->status ===
                                                                    'submited';
                                                            @endphp

                                                            <td>
                                                                @if (!$isSubmitted)
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick='openScopeAModal(@json($scope))'>Edit</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex mt-5">
                                <button class="btn btn-secondary prev-btn m-1" type="button">Previous</button>
                                <button class="btn btn-primary next-btn m-1" type="button">Next</button>
                            </div>
                        </div>
                    </div>

                    {{-- Declaration --}}
                    @if ($scheme_name == 'Testing' || $scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratories')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form id="declarationForm" action="{{ route('application.store.certification') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <p>
                                            7.1 The laboratory applies for accreditation by PNAC for (please tick
                                            appropriate boxes)
                                        </p>
                                    </div>
                                    <div class="col-12 form-group">
                                        <select name="testing_select" class="form-control">
                                            <option value="Calibration">Calibration</option>
                                            <option value="Testing">Testing</option>
                                            <option disabled>An extension in scope of existing accreditation for a:
                                            </option>
                                            <option value="Calibration laboratory">Calibration laboratory</option>
                                            <option value="Testing Laboratory">Testing Laboratory</option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-12 form-group">
                                <label for="testing_select">Select Options</label>
                                <select id="testing_select" name="testing_select[]" class="form-control" multiple>
                                    <option value="Calibration">Calibration</option>
                                    <option value="Testing">Testing</option>
                                    <optgroup label="Extension Scope">
                                        <option value="Calibration laboratory">Calibration laboratory</option>
                                        <option value="Testing Laboratory">Testing Laboratory</option>
                                    </optgroup>
                                </select>
                            </div> --}}

                                    <div class="form-group">
                                        <p>
                                            7.2. The organisation/laboratory agrees to conform, upon accreditation, with
                                            PNAC requirements as detailed in the Agreement [F-01/04].
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.3. I enclose a cheque (payable to PNAC) for the Applicant fee of <input
                                                type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                @if (@$declaration->application_fee) ? readonly : '' @endif
                                                style="outline: none;">. I understand that this fee is non-refundable.
                                            (see Note below).
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.4. I understand the manner in which the accreditation system functions.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.5. I declare that the information given in this form is correct to the
                                            best of my knowledge and belief
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            <b>Note-1:</b> PNAC will not process your application until it has received
                                            the documents and application fee.
                                        </p>
                                        {{-- <p>
                                    <b>Note-2:</b> The fee cheque/pay order shall be in favour of Pakistan National Accreditation Council, Islamabad
                                </p> --}}
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        @if (!$isSubmitted)
                                            <button type="submit" class="btn btn-success">Final Submition</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif ($scheme_name == 'Certification Bodies')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <p>
                                            6.2. The CB/organisation agrees to conform, upon accreditation, with PNAC
                                            requirements as detailed in the Agreement [F-01/08].
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            6.3. I enclose a copy of Quality Manual and other documents/information (see
                                            Note below)
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.4. I enclose a cheque (payable to PNAC) for the Applicant fee of <input
                                                type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;">. I understand that this fee is non-refundable.
                                            (see Note below).
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.5. I understand the manner in which the accreditation system functions.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.6. I declare that the information given in this form is correct to the
                                            best of my knowledge and belief
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            <b>Note:</b> PNAC will not process your application until it has received
                                            your Quality Manual, procedures, other documents/information and application
                                            fee.
                                        </p>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif ($scheme_name == 'Medical Laboratories')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <p>
                                            6.1 The laboratory applies to PNAC for accreditation for (please tick
                                            appropriate boxes)
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <select name="testing_select" class="form-control">
                                            <option value="Clinical Chemistry">Clinical Chemistry</option>
                                            <option value="Haematology">Haematology</option>
                                            <option value="Histopathology">Histopathology</option>
                                            <option value="Immunology">Immunology</option>
                                            <option value="Microbiology">Microbiology</option>
                                            <option value="Molecular Biology">Molecular Biology</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Other (Please describe)</label>
                                        <textarea name="other_describe" id="" class="form-control" cols="30" rows="10"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            6.2. The organisation/laboratory agrees to conform, upon accreditation, with
                                            PNAC
                                            requirements as detailed in the Agreement [F-01/04].
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.3 The organisation/lab comply fully with ISO 15189: 2012 for accreditation
                                            of Medical testing laboratories.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.4. I enclose a copy of Quality Manual and Quality Procedures (see Note
                                            below)
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.5 I understand PNAC policies and procedures for Assessment, surveillance
                                            and Re-assessment.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.6. I enclose a cheque (payable to PNAC) for the Applicant fee of <input
                                                type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;">. I understand that this fee is non-refundable.
                                            (see Note below).
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.7. I understand the manner in which the accreditation system functions.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            6.8. I declare that the information given in this form is correct to the
                                            best of my knowledge and belief
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            <b>Note:</b> PNAC will not process your application until it has received
                                            your Quality Manual and Quality & Technical Procedures and application fee.
                                        </p>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($scheme_name == 'Inspection Bodies')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <p>
                                            7.1 The Inspection Body applies for accreditation by PNAC as (please tick
                                            appropriate boxes)
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <select name="testing_select" class="form-control">
                                            <option value="TypeA">TypeA</option>
                                            <option value="TypeB">TypeB</option>
                                            <option value="TypeC">TypeC</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            7.2 The organisation/Inspection body comply fully with ISO/IEC 17020
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.3 I understand with PNAC policies and procedures for Assessment,
                                            surveillance and Re-assessment.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.4 The IB/organisation agrees to conform, upon accreditation with PNAC
                                            requirements as detailed in the Agreement [F-01/13].
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.5 I enclose a copy of Quality Manual (see Note below)
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.6 I enclose a copy of filled Document Review Form [F-02/30]
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.7 I enclose a cheque (payable to PNAC) for the Applicant fee of <input
                                                type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;">. I understand that this fee is non-refundable.
                                            (see Note below).
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.8 I understand the manner in which the accreditation system functions.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            7.9 I declare that the information given in this form is correct to the best
                                            of my knowledge and belief.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>
                                    <div class="form-group">
                                        <p>
                                            <b>Note:</b> PNAC will not process your application until it has reviewed
                                            your Quality Manual, procedures and received application fee.
                                        </p>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($scheme_name == 'Halal Certification Bodies')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h5>This declaration should be made by the person named in Section 1.1</h5>
                                    </div>
                                    <div class="form-group">
                                        <label>6.1 That the Certification Body applies to PNAC for accreditation for
                                            (please tick appropriate boxes)</label>
                                    </div>
                                    <div class="form-group">
                                        <select name="testing_select" class="form-control">
                                            <option value="Halal(Scope as per Annex A)">Halal(Scope as per Annex A)
                                            </option>
                                            <option value="An extension in scope of existing accreditation">An
                                                extension in scope of existing accreditation</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>6.2. That the organisation agrees to conform with PNAC requirements, upon
                                            accreditation, as detailed in the Agreement [F-01/18].</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.3. That I enclose a copy of Quality Manual (see Note below)</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.4. That I enclose a cheque (payable to PNAC) as the Applicant fee
                                            <input type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;"> and I understand that this fee is
                                            non-refundable. (See Note below).</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.5. That I understand the procedures of accreditation system and
                                            functions</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.6. That I declare that the information given in this form is correct to
                                            the best of my knowledge and belief</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>

                                    <div class="form-group col-12">
                                        <p>
                                            <b>Note:</b> PNAC will not process application until it has received Quality
                                            Manual, procedures of the CAB and application fee of PNAC.
                                            </h5>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($scheme_name == 'Proficiency Testing Provider')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h5>This declaration should be made by the person named in Section 1.1</h5>
                                    </div>
                                    <div class="form-group">
                                        <label>6.1 The Proficiency Testing Provider applies for accreditation by PNAC as
                                            a</label>
                                    </div>
                                    <div class="form-group">
                                        <select name="testing_select" class="form-control">
                                            <option value="New applicant">New applicant</option>
                                            <option value="An extension in scope of existing accreditation for a">An
                                                extension in scope of existing accreditation for a</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>6.2. The organisation/Proficiency Testing Provider agrees to conform,
                                            upon accreditation, to PNAC requirements as detailed in the Agreement
                                            [F-01/20].</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.3. I enclose a copy of Quality Manual and Quality Procedures (see Note
                                            below)</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.4. I enclose a cheque (payable to PNAC) for the Applicant fee of <input
                                                type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;">.I understand that this fee is non-refundable.
                                            (see Note below). </label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.5. I understand the manner in which the accreditation system
                                            functions.</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.6. I declare that the information given in this form is correct to the
                                            best of my knowledge and belief</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($scheme_name == 'Product Certification Bodies')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h5>This declaration should be made by the person named in Section 1.1</h5>
                                    </div>
                                    <div class="form-group">
                                        <label>6.1 The Product Certification Body applies for accreditation by PNAC as
                                            (please tick appropriate boxes)</label>
                                    </div>
                                    <div class="form-group">
                                        <select name="testing_select" class="form-control">
                                            <option
                                                value="New Applicant as Product certification Body as per the requirements of ISO/IEC 17065">
                                                New Applicant as Product certification Body as per the requirements of
                                                ISO/IEC 17065</option>
                                            <option value="New Applicant as Product certification Body GLOBALGAP">New
                                                Applicant as Product certification Body GLOBALGAP</option>
                                            <option value="An extension in scope of existing accreditation">An
                                                extension in scope of existing accreditation</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>6.2. The PCB/organisation agrees to conform, upon accreditation, PNAC
                                            requirements as detailed in the Agreement [F-01/08].</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.3. I enclose a copy of Quality Manual and other documents/information
                                            (see Note below)</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.4. I enclose a cheque (payable to PNAC) as Application fee amounting
                                            Rs. <input type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;">. I understand that this fee is non-refundable.
                                            (see Note below).</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.5. I understand manner in which the accreditation system
                                            functions</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.6. I declare that the information given in this form is correct to the
                                            best of my knowledge and belief </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($scheme_name == 'Personnel Certification Bodies')
                        <div class="card" id="DeclarationTable">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Declarations</h4>
                            </div>
                            <form action="{{ route('application.store.certification') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category"
                                    value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="application"
                                    value="{{ urldecode(request()->query('application')) }}">
                                <input type="hidden" name="type" value="declaration">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h5>This declaration should be made by the person named in Section 1.1</h5>
                                    </div>
                                    <div class="form-group">
                                        <label>6.1 The Certification Body applies for accreditation to PNAC as (please
                                            tick
                                            appropriate boxes)</label>
                                    </div>
                                    <div class="form-group">
                                        <select name="testing_select" class="form-control">
                                            <option
                                                value="New Applicant as Certification Body as per the requirements of ISO/IEC 17024">
                                                New Applicant as Certification Body as per the requirements of ISO/IEC
                                                17024</option>
                                            <option value="An extension in scope of existing accreditation">An
                                                extension in scope of existing accreditation</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>6.2. The CBP/organisation agrees to conform, upon accreditation, PNAC
                                            requirements as detailed in the Agreement [F-01/08]. Further has gone
                                            through all
                                            other related policies of PNAC</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.3. I enclose a copy of Quality Manual and other documents/information
                                            (see Note
                                            below)</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.4. I enclose a cheque (payable to PNAC) as Application fee amounting
                                            Rs.
                                            <input type="text" name="application_fee"
                                                value="{{ $declaration->application_fee ?? '' }}"
                                                style="outline: none;">. I understand that this fee is non-refundable.
                                            (see Note below).</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.5. I understand manner in which the accreditation system
                                            functions.</label>
                                    </div>
                                    <div class="form-group">
                                        <label>6.6. I declare that the information given in this form is correct to the
                                            best of
                                            my knowledge and belief</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Browse Cheque File</label>
                                        <input type="file" name="upload_file" class="form-control"
                                            accept="application/pdf, image/png, image/jpeg, image/jpg">
                                        <strong class="text-danger">(Please uploaded Pdf,Jpeg,Jpg,PNG Formate
                                            document)</strong>
                                    </div>

                                    <div class="footer mb-5 pb-3">
                                        <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                        <button type="submit" class="btn btn-success">Final Submition</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
    </section>
</div>

@include('admin.application.certification.modal')
@endif

@php
    $scheme = $scheme_name ?? request('scheme_name');
@endphp

@if ($scheme === 'Certification Bodies')
    @include('admin.application.certification_bodies.form')
@elseif ($scheme === 'Medical Laboratories')
    @include('admin.application.medical_laboratory.index')
@else
    @include('admin.application.certification.vertical_form')
@endif
@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = Array.from(document.querySelectorAll(
            '.pnac-vertical-form #pnacVerticalForm > .pnac-basic-card, .pnac-vertical-form #pnacVerticalForm > .pnac-step-card'
        ));
        if (!cards.length) return;

        const hasBootstrapCollapse = typeof bootstrap !== 'undefined' && typeof bootstrap.Collapse !==
            'undefined';
        const preferredOpenSection =
            '{{ session('open_section') ?: request('open_section') ?: request('edit_section') }}';

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
                    body.style.maxHeight = body.scrollHeight + 'px';
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
                    } else {
                        body.style.maxHeight = body.scrollHeight + 'px';
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

        // Recalculate open section height after render
        setTimeout(function() {
            cards.forEach(function(card) {
                const collapseBody = card.querySelector('.pnac-collapse-body');
                if (!collapseBody || hasBootstrapCollapse) return;
                const hdr = card.querySelector('.pnac-collapsible-header');
                if (hdr && hdr.getAttribute('aria-expanded') === 'true') {
                    collapseBody.style.maxHeight = collapseBody.scrollHeight + 'px';
                }
            });
        }, 100);
    });
</script>
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
@if (($scheme_name ?? request('scheme_name')) === 'Certification Bodies')
    <script src="{{ asset('js/certification-bodies.js') }}"></script>
@endif

@if (false)
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    @include('admin.application.certification.modal_script');
    <script>
        $(document).ready(function() {
            $('#table-12').DataTable();
            $('#table-2').DataTable();
            $('#table-3').DataTable();
            $('#table-4').DataTable();
            $('#table-5').DataTable();
            $('#table-6').DataTable();
            $('#table-7').DataTable();
            $('#table-8').DataTable();
            $('#table-9').DataTable();
            $('#table-10').DataTable();
            $('#table-11').DataTable();
            $('#table-12').DataTable();
            $('#table-13').DataTable();
            $('#table-14').DataTable();
            $('#table-15').DataTable();
            $('#table-16').DataTable();

        });
    </script>
    <script>
        $(document).ready(function() {
            const sections = ["General", "Employee", "Document", "Scope", "Declaration"];
            let currentIndex = 0;

            // Get current route path (URL)
            const currentRoute = window.location.pathname;
            const lastRoute = localStorage.getItem('lastRoute');

            // window.previousUrl = "{{ url()->previous() }}";
            // const lastRoute = window.previousUrl;
            // alert(lastRoute)

            if (lastRoute !== currentRoute) {
                localStorage.removeItem('lastSection'); // new route = reset tab
            }

            localStorage.setItem('lastRoute', currentRoute);

            // Load last section or default to General
            const lastSection = localStorage.getItem('lastSection');
            if (lastSection && sections.includes(lastSection)) {
                currentIndex = sections.indexOf(lastSection);
            }

            showSection(currentIndex); // Show on load

            function showSection(index) {
                $(".card").hide(); // Hide all sections
                $("#" + sections[index] + "Table").show(); // Show current
                localStorage.setItem("lastSection", sections[index]); // Save current tab
            }

            // Validation before moving forward
            function validateCurrentSection() {
                const currentSection = sections[currentIndex];

                if (currentSection === "General") {
                    const generalForm = document.getElementById("Part1Form");
                    if (!generalForm.checkValidity()) {
                        generalForm.reportValidity();
                        return false;
                    }
                }

                if (currentSection === "Employee") {
                    const count = $("#employee-tbody #employee-tr").length;
                    if (count === 0) {
                        alert("⚠️ Please add at least one employee.");
                        return false;
                    }
                }

                if (currentSection === "Document") {
                    const count = $("#document-tbody #document-tr").length;
                    if (count === 0) {
                        alert("⚠️ Please add at least one document.");
                        return false;
                    }
                }

                return true;
            }

            // Next button
            $(".next-btn").click(function() {
                if (validateCurrentSection() && currentIndex < sections.length - 1) {
                    currentIndex++;
                    showSection(currentIndex);
                }
            });

            // Prev button
            $(".prev-btn").click(function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    showSection(currentIndex);
                }
            });

            // Section buttons (manual click)
            $(".section-btn").click(function() {
                const targetId = $(this).attr("id");
                const targetIndex = sections.indexOf(targetId);

                if (targetIndex === currentIndex + 1) {
                    if (validateCurrentSection()) {
                        currentIndex = targetIndex;
                        showSection(currentIndex);
                    }
                } else if (targetIndex <= currentIndex) {
                    currentIndex = targetIndex;
                    showSection(currentIndex);
                } else {
                    alert("⚠️ Please complete the current part before moving forward.");
                }
            });
        });
    </script>
    <script>
        // force reset to General after Declaration submit
        const declarationForm = document.getElementById("declarationForm");
        if (declarationForm) {
            declarationForm.addEventListener("submit", function() {
                localStorage.setItem("lastSection", "General");
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            $('#summernote1').summernote();
        });




        // latest working with redirect code

        // $(document).ready(function() {
        //     const sections = ["General", "Employee", "Document", "Scope", "Declaration"];
        //     let currentIndex = 0;

        //     // Check if this is a returning visit (not a refresh)
        //     if (performance.getEntriesByType("navigation")[0].type === "navigate") {
        //         const lastVisitTime = parseInt(sessionStorage.getItem('lastVisitTime'));
        //         const currentTime = Date.now();

        //         // If less than 1 second gap, consider it a refresh
        //         if (!lastVisitTime || (currentTime - lastVisitTime) > 1000) {
        //             localStorage.removeItem('lastSection');
        //         }

        //         sessionStorage.setItem('lastVisitTime', currentTime.toString());
        //     }

        //     $(".card").hide();

        //     // Load last section, or default to General (0)
        //     const lastSection = localStorage.getItem('lastSection');
        //     if (lastSection && sections.includes(lastSection)) {
        //         currentIndex = sections.indexOf(lastSection);
        //     }

        //     showSection(currentIndex);

        //     // Track navigation away
        //     $(window).on('beforeunload', function() {
        //         const currentTime = Date.now();
        //         sessionStorage.setItem('lastVisitTime', currentTime.toString());
        //     });

        //     function showSection(index) {
        //         $(".card").hide();
        //         $("#" + sections[index] + "Table").show();
        //         localStorage.setItem("lastSection", sections[index]);
        //     }

        //     // [Rest of your existing functions remain the same]
        //     function validateCurrentSection() {
        //         const currentSection = sections[currentIndex];

        //         if (currentSection === "General") {
        //             const generalForm = document.getElementById("Part1Form");
        //             if (!generalForm.checkValidity()) {
        //                 generalForm.reportValidity();
        //                 return false;
        //             }
        //         }

        //         if (currentSection === "Employee") {
        //             const employeeCount = $("#table-1 #employee-tbody #employee-tr").length;
        //             if (employeeCount === 0) {
        //                 alert("⚠️ Please add at least one employee before proceeding.");
        //                 return false;
        //             }
        //         }

        //         if (currentSection === "Document") {
        //             const documentCount = $("#documentsTable #document-tbody #document-tr").length;
        //             if (documentCount === 0) {
        //                 alert("⚠️ Please add at least one document before proceeding.");
        //                 return false;
        //             }
        //         }

        //         return true;
        //     }

        //     $(".next-btn").click(function() {
        //         if (validateCurrentSection() && currentIndex < sections.length - 1) {
        //             currentIndex++;
        //             showSection(currentIndex);
        //         }
        //     });

        //     $(".prev-btn").click(function() {
        //         if (currentIndex > 0) {
        //             currentIndex--;
        //             showSection(currentIndex);
        //         }
        //     });

        //     $(".section-btn").click(function() {
        //         const targetId = $(this).attr("id");
        //         const targetIndex = sections.indexOf(targetId);

        //         if (targetIndex === currentIndex + 1) {
        //             if (validateCurrentSection()) {
        //                 currentIndex = targetIndex;
        //                 showSection(currentIndex);
        //             }
        //         } else if (targetIndex <= currentIndex) {
        //             currentIndex = targetIndex;
        //             showSection(currentIndex);
        //         } else {
        //             alert("⚠️ Please complete the current part before moving forward.");
        //         }
        //     });
        // });



        // certification Scope Modal active button
        $(document).ready(function() {
            $(".scope-btn").click(function() {
                // Remove active class from all buttons
                $(".scope-btn").removeClass("active");

                // Add active class to clicked button
                $(this).addClass("active");

                // Hide all sections with fadeOut
                $(".scope-section").fadeOut(200);

                // Show target section with fadeIn
                let target = $(this).data("target");
                // alert(target)
                setTimeout(() => {
                    $(target).fadeIn(300);
                }, 200);
            });
        });


        // image validation
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("declarationForm"); // Replace with your form's ID
            const fileInput = document.querySelector('input[name="uplaod_file"]');

            form.addEventListener("submit", function(e) {
                const file = fileInput.files[0];

                if (!file) {
                    alert("Please select a file before submitting.");
                    e.preventDefault();
                    return;
                }

                const allowedTypes = ["image/png", "image/jpg", "image/jpeg", "application/pdf"];
                if (!allowedTypes.includes(file.type)) {
                    alert("Invalid file type. Only PNG, JPG, JPEG, and PDF are allowed.");
                    e.preventDefault();
                    return;
                }

                const maxSize = 2 * 1024 * 1024; // 2 MB
                if (file.size > maxSize) {
                    alert("File is too large. Maximum size allowed is 2MB.");
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>

    <script>
        // $(document).ready(function () {
        //     $('.technical-cluster').on('change', function () {
        //         // alert('Cluster changed');
        //         const $this = $(this);
        //         const clusterId = $this.val();
        //         const clusterCode = $this.find('option:selected').data('cluster-code');

        //         // Get suffix like 'A', 'B', 'C' from the ID (e.g., technicalClusterSelectA)
        //         const suffix = $this.attr('id').replace('technicalClusterSelect', '');

        //         const iafDropdown = $('#iafCodeDropdown' + suffix);
        //         const descriptionDropdown = $('#descriptionDropdown' + suffix);
        //         // alert(clusterId);

        //         if (clusterId) {
        //             $.ajax({
        //                 url: `/application/get-iaf-codes/${clusterId}`,
        //                 type: 'GET',
        //                 data: {
        //                     cluster_code: clusterCode // ✅ send cluster code
        //                 },
        //                 success: function (data) {
        //                     console.log(data);

        //                     iafDropdown.empty().append('<option selected disabled>Select IAF Code</option>');
        //                     descriptionDropdown.empty().append('<option selected disabled>Select Description</option>');

        //                     data.forEach(function (item) {
        //                         iafDropdown.append(
        //                             `<option value="${item.iaf_code}">${item.iaf_code}</option>`
        //                         );
        //                         descriptionDropdown.append(
        //                             `<option value="${item.description}">${item.description}</option>`
        //                         );
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // });
        $(document).ready(function() {
            // Step 1: Technical Cluster change
            $('.technical-cluster').on('change', function() {
                const $this = $(this);
                const clusterId = $this.val();
                const clusterCode = $this.find('option:selected').data('cluster-code');
                const suffix = $this.attr('id').replace('technicalClusterSelect', '');

                const iafDropdown = $('#iafCodeDropdown' + suffix);
                const descriptionDropdown = $('#descriptionDropdown' + suffix);

                // Clear both dropdowns initially
                iafDropdown.empty().append('<option selected disabled>Select IAF Code</option>');
                descriptionDropdown.empty().append('<option selected disabled>Select Description</option>');

                if (clusterId) {
                    $.ajax({
                        url: `/application/get-iaf-codes/${clusterId}`,
                        type: 'GET',
                        data: {
                            cluster_code: clusterCode
                        },
                        success: function(data) {
                            // Expecting: data = [{iaf_code: "34", description: "Food"}, {...}]
                            // Populate IAF dropdown only
                            data.forEach(function(item) {
                                iafDropdown.append(
                                    `<option value="${item.iaf_code}" data-description="${item.description}">${item.iaf_code}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // Step 2: IAF Code change
            $('select[id^="iafCodeDropdown"]').on('change', function() {
                const $this = $(this);
                const selectedOption = $this.find('option:selected');
                const description = selectedOption.data('description');
                const suffix = $this.attr('id').replace('iafCodeDropdown', '');

                const descriptionDropdown = $('#descriptionDropdown' + suffix);
                descriptionDropdown.empty();

                if (description) {
                    descriptionDropdown.append(`<option selected>${description}</option>`);
                } else {
                    descriptionDropdown.append('<option selected disabled>No Description Found</option>');
                }
            });
        });
    </script>
    {{-- get technical Area --}}
    <script>
        $(document).ready(function() {
            // Load Technical Areas
            $('#main-technical').on('change', function() {
                let mainId = $(this).val();

                $('#technical-area').empty().append('<option selected disabled>Loading...</option>');
                $('#description-select').empty().append(
                    '<option selected disabled>Select Description</option>');

                $.ajax({
                    url: `/application/get-technical-areas/${mainId}`,
                    type: 'GET',
                    success: function(areas) {
                        $('#technical-area').empty().append(
                            '<option selected disabled>Select Technical Area</option>');
                        areas.forEach(area => {
                            $('#technical-area').append(
                                `<option value="${area.id}">${area.technical_area}</option>`
                            );
                        });
                    }
                });
            });

            // Load Descriptions
            $('#technical-area').on('change', function() {
                let mainId = $('#main-technical').val();
                let areaId = $(this).val();

                $('#description-select').empty().append('<option selected disabled>Loading...</option>');

                $.ajax({
                    url: `/application/get-descriptions/${mainId}/${areaId}`,
                    type: 'GET',
                    success: function(descriptions) {
                        $('#description-select').empty().append(
                            '<option selected disabled>Select Description</option>');
                        descriptions.forEach(desc => {
                            $('#description-select').append(
                                `<option value="${desc.description}">${desc.description}</option>`
                            );
                        });
                    }
                });
            });
        });
    </script>

    {{-- 22000 --}}
    <script>
        $(document).ready(function() {
            $('#clusterSelect').on('change', function() {
                var clusterId = $(this).val();

                if (clusterId) {
                    $.ajax({
                        url: '{{ route('application.get.categories') }}',
                        type: 'GET',
                        data: {
                            cluster_id: clusterId
                        },
                        success: function(data) {
                            $('#categorySelect').empty().append(
                                '<option selected disabled>Select Category</option>');
                            $('#subcategorySelect').empty().append(
                                '<option selected disabled>Select Sub-Category</option>');

                            $.each(data, function(key, category) {
                                $('#categorySelect').append('<option value="' + category
                                    .id + '">' + category.category_name +
                                    '</option>');
                            });
                        }
                    });
                }
            });

            $('#categorySelect').on('change', function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: '{{ route('application.get.subcategories') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
                            $('#subcategorySelect').empty().append(
                                '<option selected disabled>Select Sub-Category</option>');

                            $.each(data, function(key, sub) {
                                $('#subcategorySelect').append('<option value="' + sub
                                    .sub_name + '">' + sub.sub_name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>

    {{-- open certification scope modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scopeButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-type]');
            const allSections = document.querySelectorAll('.scope-section');
            scopeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const type = button.getAttribute(
                        'data-type'); // Now this matches the ID exactly

                    // Hide all scope sections
                    allSections.forEach(section => {
                        section.style.display = 'none';
                    });

                    // Show only the selected one
                    const activeSection = document.getElementById(type);
                    if (activeSection) {
                        activeSection.style.display = 'block';
                    }
                });
            });
        });
    </script>
@endif
@endsection
