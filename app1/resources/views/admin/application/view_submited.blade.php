@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
<style>
    table tr, th{
        font-size: 12px;
    }
</style>
@endsection

<!-- Start app main Content -->
<div class="main-content">
    <section class="section">
        <div class="row">

            <div class="mb-3 mt-2 d-flex justify-content-between">
                <h6>Show Submited Application</h6>
                <a href="{{ route('application.submited.index') }}" class="btn btn-danger">Back</a>
            </div>

            <div class="col-12">

                {{-- General Info --}}
                <div class="card">
                    <div class="card-header">
                        <h6>CAB Basic Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">CAB Name:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->cab_name }}
                            </div>
                            <div class="form-group col-3">
                                <label  style="font-weight:800 !important">Telephone:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->telephone }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">References File Number:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->postal_code }}
                            </div>

                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">Date of Applied:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->created_at }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">Email:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->email }}
                            </div>
                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">Designation:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->city }}
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">Country:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->country }}
                            </div>
                            <div class="form-group col-3">
                                <label style="font-weight:800 !important">Cab NTN/FTN:</label>
                            </div>
                            <div class="form-group col-3">
                                {{ $general->ntn_ftn }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Employee Detail --}}
            <div class="card">
                <div class="card-header">
                    <h6>CAB Employement Record</h6>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="employeeTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Telephone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['employees'] as $key => $employee)
                                <tr>
                                    <td>{{ $employee->employee_name }}</td>
                                    <td>{{ $employee->designation }}</td>
                                    <td>{{ $employee->telephone }}</td>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- Document Detail --}}
            <div class="card">
                <div class="card-header">
                    <h6>CAB Document's</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name of Document</th>
                                    <th>Date of Upload</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['documents'] as $key => $document)
                                <tr>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->created_at }}</td>
                                    @php
                                    if(!empty($document->upload_doc))
                                    {
                                    $filePath = asset('storage/' . $document->upload_doc);
                                    $extension = pathinfo($document->upload_doc, PATHINFO_EXTENSION);
                                    }
                                    @endphp
                                    <td>
                                        @if(!empty($filePath))
                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                        <a href="{{ asset('storage/' . $document->upload_doc) }}">View File</a>

                                        @elseif(strtolower($extension) === 'pdf')
                                        <a href="{{ $filePath }}" target='_blank'> View File</a>
                                        {{-- <iframe src="{{ $filePath }}" width="100%" height="600px" frameborder="0">File</iframe> --}}
                                        @else
                                        <p>Unsupported file format.</p>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- ISO9001 --}}
            {{-- @if($scopes['ISO9001'] ?? '' || $scopes['ISO14001'] ?? '' || $scopes['ISO45001'] ?? '' || $scopes['ISO13485'] ?? '' || $scopes['ISO22000'] ?? '') --}}

            <div class="card mb-4">
                @isset($scopes['ISO9001'])
                <div class="p-2 badge-none rounded-1">
                    <h6 class="m-1">CAB Applied Scope</h6>
                </div>
                <div class="border mb-3">
                    <h6 class="badge-primary w-100 p-3">Certification Bodies Scope</h6>

                <div class="card-header">
                    <h6>Quality Management System (ISO 9001)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped v_center" id="ISO9001">
                            <thead>
                                <tr>
                                    <th>Technical Cluster</th>
                                    <th>IAF Code</th>
                                    <th>Description of economic sector/activity</th>
                                    <th>Date of Scope Applied</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['ISO9001'] as $scope)
                                <tr>
                                    <td>{{ $scope->scop_technical_a }}</td>
                                    <td>{{ $scope->scop_iaf_a }}</td>
                                    <td>{{ $scope->scop_economic_a }}</td>
                                    <td>{{ $scope->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endisset

                {{-- ISO14001 --}}
                @isset($scopes['ISO14001'])
                <div class="card-header">
                    <h6>Enviromental Management System (ISO 14001)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped v_center" id="ISO14001">
                            <thead>
                                <tr>
                                    <th>Technical Cluster</th>
                                    <th>IAF Code</th>
                                    <th>Description of economic sector/activity</th>
                                    <th>Date of Scope Applied</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scopes['ISO14001'] as $scope)
                                <tr>
                                    <td>{{ $scope->scop_technical_b }}</td>
                                    <td>{{ $scope->scop_iaf_b }}</td>
                                    <td>{{ $scope->scop_economic_b }}</td>
                                    <td>{{ $scope->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endisset

                {{-- ISO45001 --}}
                 @isset($scopes['ISO45001'])
                <div class="card-header">
                    <h6>Occupational Hralth and Safety Management Systems (ISO 45001)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped v_center" id="ISO45001">
                            <thead>
                                <tr>
                                    <th>Technical Cluster</th>
                                    <th>IAF Code</th>
                                    <th>Description of economic sector/activity</th>
                                    <th>Date of Scope Applied</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scopes['ISO45001'] as $scope)
                                <tr>
                                    <td>{{ $scope->scop_technical_c }}</td>
                                    <td>{{ $scope->scop_iaf_c }}</td>
                                    <td>{{ $scope->scop_economic_c }}</td>
                                    <td>{{ $scope->scop_activity_c }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endisset

                {{-- ISO13485 --}}
                @isset($scopes['ISO13485'])
                <div class="card-header">
                    <h6>Medical Devices Quality Management System (ISO 13485)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped v_center" id="ISO13485">
                            <thead>
                                <tr>
                                    <th>Technical Cluster</th>
                                    <th>IAF Code</th>
                                    <th>Description of economic sector/activity</th>
                                    <th>Date of Scope Applied</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scopes['ISO13485'] as $scope)
                                <tr>
                                    <td>{{ $scope->scop_main_tech }}</td>
                                    <td>{{ $scope->scop_areas }}</td>
                                    <td>{{ $scope->scop_product }}</td>
                                    <td>{{ $scope->scop_cluster }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- ISO22000 --}}
                @isset($scopes['ISO22000'])
                <div class="card-header">
                    <h6>Food Safety Management System (ISO 22000)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped v_center" id="ISO22000">
                            <thead>
                                <tr>
                                    <th>Technical Cluster</th>
                                    <th>IAF Code</th>
                                    <th>Description of economic sector/activity</th>
                                    <th>Date of Scope Applied</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scopes['ISO22000'] as $scope)
                                <tr>
                                    <td>{{ $scope->scop_category }}</td>
                                    <td>{{ $scope->scop_subcategory }}</td>
                                    <td>{{ $scope->scop_activity }}</td>
                                    <td>{{ $scope->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endisset
                </div>
            </div>
            {{-- @endif --}}


            {{-- Medical Detail --}}
            @isset($scopes['medical'])
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 badge-primary mt-1">
                        <h6>Medical Laboratories Scope</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Meterials tested</th>
                                        <th>Testing field (e.g. Chemical, Micro etc)</th>
                                        <th>Type of test/Properties measured</th>
                                        <th>Reference of Standardized method</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['medical'] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->meterials }}</td>
                                    <td>{{ $scope->chemical }}</td>
                                    <td>{{ $scope->measured }}</td>
                                    <td>{{ $scope->standardized }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset

            {{-- Halal --}}
            @isset($scopes['halal'])
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 badge-primary mt-1">
                        <h6>Halal Certification Bodies Scope</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Cat. Code</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['halal'] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->cat_code }}</td>
                                    <td>{{ $scope->scope_category }}</td>
                                    <td>{{ $scope->subcategory }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset

            {{-- Inspection --}}
            @isset($scopes['inspection'])
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 badge-primary mt-1">
                        <h6>Inspection Bodies</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Description of Inspection(s), including the types of items inspected,</th>
                                        <th>Type and Range of Inspection</th>
                                        <th>Methods and Procedures</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['inspection'] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->description }}</td>
                                    <td>{{ $scope->range }}</td>
                                    <td>{{ $scope->procedures }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset

            {{-- Product --}}
            @isset($scopes['product'])
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 badge-primary mt-1">
                        <h6>Product Certification Bodies</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Product</th>
                                        <th>Standard</th>
                                        <th>Type of Scheme (ISO/IEC 17067)</th>
                                        <th>Countries where certificates are to be issued</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['product'] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->product }}</td>
                                    <td>{{ $scope->standard }}</td>
                                    <td>{{ $scope->type_scheme }}</td>
                                    <td>{{ $scope->countries }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset

            {{-- Proficiency --}}
            @isset($scopes['proficiency'])
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 badge-primary mt-1">
                        <h6>Proficiency Testing Provider Scope</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Items/ Materials/ Matrix/Products</th>
                                        <th>Type of Scheme/test/properties</th>
                                        <th>Scheme Protocol.Procedure/technique used</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['proficiency'] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->item_materials }}</td>
                                    <td>{{ $scope->type_scheme }}</td>
                                    <td>{{ $scope->scheme_protocol }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset

            {{-- testing --}}
            @if (!empty($scopes['testing'] ?? []) || !empty($scopes['testing_calibration'] ?? []))
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 mt-1" style="background-color: #187a4c ; color: #ffffff;">
                    <h6>Testing Scope</h6>
                </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Materials/Products tested*</th>
                                        <th>Testing Field (e.g. Environmental testing or mechanical testing)</th>
                                        <th>Types of test/Properties measured</th>
                                        <th>Standard specification/Techniques/equipment used</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['testing'] ?? [] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->materials }}</td>
                                    <td>{{ $scope->mechanical }}</td>
                                    <td>{{ $scope->property_measured }}</td>
                                    <td>{{ $scope->standard }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Calibration --}}
            @if (!empty($scopes['calibration'] ?? []) || !empty($scopes['testing_calibration'] ?? []))
            <div class="shadow-lg p-2 badge-none rounded-1">
                <h6 class="m-1">CAB Applied Scope</h6>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="shadow-lg p-2 badge-primary mt-1">
                        <h6>Calibration Scope</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="documentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Measured quantity</th>
                                        <th>Range</th>
                                        <th>*Expanded Uncertainty( + )</th>
                                        <th>Technique, Reference Standard, Equipment</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($scopes['calibration'] ?? [] as $key => $scope)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $scope->measurement }}</td>
                                    <td>{{ $scope->range }}</td>
                                    <td>{{ $scope->expanded }}</td>
                                    <td>{{ $scope->technique }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif


            {{-- Declaration Detail --}}
            <div class="card">
                <div class="card-header">
                    <h6>CAB Declaration</h6>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="declarationTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S#</th>
                                    <th>Category</th>
                                    <th>Application Fee</th>
                                    <th>File</th>
                                    @if(request()->get('category') == 'Medical Laboratories')
                                        <th>Other Describe</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($declarations as $key => $declaration)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $declaration->testing_select }}</td>
                                    <td>{{ $declaration->application_fee }}</td>
                                    <td>
                                        @php
                                    if(!empty($declaration->upload_file))
                                    {
                                    $filePath = asset('storage/' . $document->upload_doc);
                                    $extension = pathinfo($document->upload_doc, PATHINFO_EXTENSION);
                                    }
                                    @endphp

                                        @if(!empty($filePath))
                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                        <a href="{{ asset('storage/' . $document->upload_doc) }}">View File</a>

                                        @elseif(strtolower($extension) === 'pdf')
                                        <a href="{{ $filePath }}" target='_blank'> View File</a>
                                        {{-- <iframe src="{{ $filePath }}" width="100%" height="600px" frameborder="0">File</iframe> --}}
                                        @else
                                        <p>Unsupported file format.</p>
                                        @endif
                                        @endif
                                    </td>

                                        @if(request()->get('category') == 'Medical Laboratories')
                                        <td>{{ $declaration->other_describe }}</td>

                                        @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>


@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable();
        $('#documentTable').DataTable();
        $('#ISO9001').DataTable();
        $('#ISO14001').DataTable();
        $('#ISO45001').DataTable();
        $('#ISO13485').DataTable();
        $('#ISO22000').DataTable();
    });

</script>
@endsection
