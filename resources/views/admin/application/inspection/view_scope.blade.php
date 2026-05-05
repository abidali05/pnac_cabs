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

    table tr th {
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
                $scope = request()->get('category');
                $application = request()->get('application');
            @endphp
            <div class="col-12">
                {{-- View Scope --}}
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>View {{ $scope }} Scope</h4>
                        <a href="{{ route('application.create', ['scheme_name' => $scope, 'application' => $application]) }}" class="btn btn-danger">Back</a>

                    </div>

                    <div class="card-body scope-section">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped v_center" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S#</th>
                                            <th>Description of Inspection(s), including the types of items inspected,</th>
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
                                            $isSubmitted = optional(@$scope->general->declaration)->status === 'submited';
                                            @endphp

                                            <td>
                                                @if (!$isSubmitted)
                                                <button class="btn btn-sm btn-primary" onclick='openScopeModal(@json($scope))'>Edit</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


{{-- Testing Modal --}}
<div class="modal fade" id="scopeModal" tabindex="-1" aria-labelledby="scopeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="inspection">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Inspection Bodies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                <div class="form-group">
                    <label>
                        <b>Description of Inspection(s), including the types of items inspected,</b>
                        <p>
                            <p>for example: Product Design, Products
                                (specified as Materials or Equipment),
                                Installations, Plant, Premises, Processes,
                                Services and Surveys, etc.
                            </p>
                        </p>
                    </label>
                    <input type="text" name="description" id="description" required class="form-control">
                </div>
                <div class="form-group">
                    <label>
                        <b>Type and Range of Inspection</b>
                        <p>
                            for example:
                            In-Service Inspection or
                            Inspection of New
                            Products
                        </p>
                    </label>
                    <input type="text" name="range" id="range" required class="form-control">
                </div>
                <div class="form-group">
                    <label>
                        <b>Methods and Procedures</b>
                        <p>
                            such as: Regulations, Standards, Specifications, Internal Normative documents.
                        </p>
                    </label>
                    <input type="text" name="procedures" id="procedures" required class="form-control">
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
    function openScopeModal(data) {
        $('#scopeForm').attr('action', `/application/update/certification-bodies/${data.id}`);

        $('#description').val(data.description);
        $('#range').val(data.range);
        $('#procedures').val(data.procedures);
        $('#scope').val();
        $('#scopeModal').modal('show');
    }

</script>



@endsection
