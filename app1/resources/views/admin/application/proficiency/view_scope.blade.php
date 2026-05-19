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
        <form id="scopeAForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="proficiency">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Proficiency Testing Provider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        {{-- <label>Proficiency Testing Field or Area or Parameter (eg Tensile Testing)</label> --}}
                        <label>Items/ Materials/ Matrix/Products</label>
                        <p>
                            (e.g., Reinforced Steel Bars, water,
                            waste water)
                        </p>
                        <input type="text" name="item_materials" id="item_materials" required class="form-control">
                    </div>
                    <div class="form-group">
                        {{-- <label>Proficiency Testing Items/ Materials/ Matrix/Products (eg Reinforced Steel Bars)</label> --}}
                        <label>Type of Scheme/test/properties</label>
                        <input type="text" name="type_scheme" id="type_scheme" required class="form-control">
                    </div>
                    <div class="form-group">
                        {{-- <label>Number of Proficiency Test Item Round (e.g 5 nos)</label> --}}
                        <label>Scheme Protocol.Procedure/technique used</label>
                        <input type="text" name="scheme_protocol" id="scheme_protocol" required class="form-control">
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
        $('#item_materials').val(data.item_materials);
        $('#type_scheme').val(data.type_scheme);
        $('#scheme_protocol').val(data.scheme_protocol);
        $('#scope').val();
        $('#scopeModal').modal('show');
    }

</script>



@endsection
