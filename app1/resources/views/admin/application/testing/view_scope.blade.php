@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
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
        background-color: #1ba33b !important;
        color: white;
    }

    .bg-success {
        background-color: #187a4c !important;
        color: white;
    }
    table tr th{
        font-size: 12px;
        white-space: nowrap;
    }

</style>
@endsection
<!-- Start app main Content -->
<div class="main-content">
    <section class="section">
        <div class="row">

            @php
                $scope = request()->get('scope');
                $application = request()->get('application');
                // dd($application);
            @endphp

            <div class="col-12">
                {{-- View Scope --}}
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>View {{ $scope }} Scope</h4>


                        <a href="{{ route('application.create', ['scheme_name' => $scope, 'application' => $application]) }}" class="btn btn-danger">Back</a>
                    </div>

                    @if($scope == 'Testing' || $scope == 'Testing Calibration Laboratories')
                        <div class="card-body scope-section" id="Testing" style="display: block;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>Materials/Products tested*</th>
                                                <th>Testing Field (e.g. Environmental testing or mechanical testing)</th>
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
                                                $isSubmitted = optional(@$scope->general->declaration)->status === 'submited';
                                                @endphp

                                                <td>
                                                    @if (!$isSubmitted)
                                                        <button class="btn btn-sm btn-primary" onclick='openScopeTestingModal(@json($scope))'>Edit</button>
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

                    @if($scope == 'Calibration' || $scope == 'Testing Calibration Laboratories')
                        <div class="card-body scope-section" id="Calibration" style="display: block;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
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
                                                $isSubmitted = optional(@$scope->general->declaration)->status === 'submited';
                                                @endphp

                                                <td>
                                                    @if (!$isSubmitted)
                                                    <button class="btn btn-sm btn-primary" onclick='openScopeCalibrationModal(@json($scope))'>Edit</button>
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
                </div>
            </div>
        </div>
    </section>
</div>


{{-- Testing Modal --}}
<div class="modal fade" id="scopeTestingModal" tabindex="-1" aria-labelledby="scopeTestingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeTestingForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="testing">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Testing Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Materials/Products tested*</label>
                        <textarea name="materials" id="materials" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Testing Field (e.g. Environmental testing or mechanical testing)</label>
                        <textarea name="mechanical" id="mechanical" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Types of test/Properties measured</label>
                        <textarea name="property_measured" id="property_measured" required class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Reference to standardized method (e.g.ISO 14577-1:2003)/ Internal method reference</label>
                        <textarea name="standard" id="standard" required class="form-control"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- Calibration Modal --}}
<div class="modal fade" id="scopeCalibrationModal" tabindex="-1" aria-labelledby="scopeCalibrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeCalibrationForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="calibration">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Calibration Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Measured quantity</label>
                        <textarea name="measurement" id="measurement" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Range</label>
                        <textarea name="range" id="range" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>*Expanded Uncertainty( + )</label>
                        <textarea name="expanded" id="expanded" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Technique, Reference Standard, Equipment</label>
                        <textarea name="technique" id="technique" class="form-control"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>




@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    // Testing
    function openScopeTestingModal(data) {
        $('#scopeTestingForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#materials').val(data.materials);
        $('#mechanical').val(data.mechanical);
        $('#property_measured').val(data.property_measured);
        $('#standard').val(data.standard);
        $('#scope').val();
        $('#scopeTestingModal').modal('show');
    }

    // Caliration
    function openScopeCalibrationModal(data) {
        $('#scopeCalibrationForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#measurement').val(data.measurement);
        $('#range').val(data.range);
        $('#expanded').val(data.expanded);
        $('#technique').val(data.technique);
        $('#scope').val();
        $('#scopeCalibrationModal').modal('show');
    }

</script>



@endsection
