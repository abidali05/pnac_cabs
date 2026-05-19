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

</style>
@endsection
<!-- Start app main Content -->
<div class="main-content">
    <section class="section">
        <div class="row">

            @php
                $scope = request()->get('scope', 'ISO9001');
                $category = request()->get('category');
                $application = request()->get('application');
                // dd($category);
            @endphp

            <div class="col-12">
                {{-- View Scope --}}
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>View {{ $category }} {{ $scope }}</h4>
                        <a href="{{ route('application.create', ['scheme_name' => $category, 'application' => $application]) }}" class="btn btn-danger">Back</a>

                    </div>

                    @if($scope == 'ISO9001')
                        <div class="card-body scope-section" id="ISO9001" style="display: block;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>PERSONNEL CERTIFICATION CATEGORIES </th>
                                                <th>STANDARDS/NORMATIVE REFERENCES</th>
                                                {{-- <th>Description, according to IAF ID1</th> --}}
                                                <th>Date of Scope Applied</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->technical_cluster }}</td>
                                                    {{-- <td>{{ $scope->iaf_code }}</td> --}}
                                                    <td>{{ $scope->description_iaf }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeAModal(@json($scope))'>Edit</button>
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

                    {{-- @if($scope == 'ISO14001')
                        <div class="card-body scope-section" id="ISO14001">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>Technical Cluster</th>
                                                <th>IAF Code</th>
                                                <th>Description, according to IAF ID1</th>
                                                <th>Date of Scope Applied</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->technical_cluster }}</td>
                                                    <td>{{ $scope->iaf_code }}</td>
                                                    <td>{{ $scope->description_iaf }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeBModal(@json($scope))'>Edit</button>
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

                    @if($scope == 'ISO45001')
                        <div class="card-body scope-section" id="ISO45001">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>Technical Cluster</th>
                                                <th>IAF Code</th>
                                                <th>Description, according to IAF ID1</th>
                                                <th>Date of Scope Applied</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->technical_cluster }}</td>
                                                    <td>{{ $scope->iaf_code }}</td>
                                                    <td>{{ $scope->description_iaf }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
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
                    @endif


                    @if($scope == 'ISO13485')
                        <div class="card-body scope-section" id="ISO13485">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>Main Technical Area</th>
                                                <th>Technical Area</th>
                                                <th>Product Categories Covered by the Technical Areas</th>
                                                <th>Date of Scope Applied</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->main_technical }}</td>
                                                    <td>{{ $scope->technical_area }}</td>
                                                    <td>{{ $scope->product_category }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeModalISO13485(@json($scope))'>Edit</button>
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


                    @if($scope == 'ISO22000')
                        <div class="card-body scope-section" id="ISO22000">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>Main Technical Area</th>
                                                <th>Technical Area</th>
                                                <th>Product Categories Covered by the Technical Areas</th>
                                                <th>Date of Scope Applied</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->main_technical }}</td>
                                                    <td>{{ $scope->technical_area }}</td>
                                                    <td>{{ $scope->product_category }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp


                                                    <td>
                                                            @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeModalISO22000(@json($scope))'>Edit</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif --}}

                </div>
            </div>
        </div>
    </section>
</div>


{{-- ISO9001 Modal --}}
<div class="modal fade" id="scopeAModal" tabindex="-1" aria-labelledby="scopeAModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeAForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="personnel">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Personnel Certification Bodies Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>PERSONNEL CERTIFICATION CATEGORIES</label>
                        <input type="text" name="technical_cluster" id="technical_cluster9001" class="form-control" required>
                    </div>
                    {{-- <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="iaf_code" id="iaf_code9001" class="form-control" required>
                    </div> --}}
                    <div class="form-group">
                        <label>STANDARDS/NORMATIVE REFERENCES</label>
                        <textarea name="description_iaf" id="description_iaf9001" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- ISO14001 Modal --}}
{{-- <div class="modal fade" id="scopeBModal" tabindex="-1" aria-labelledby="scopeBModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeBForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="personnel">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope ISO14001</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="technical_cluster" id="technical_cluster14001" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="iaf_code" id="iaf_code14001" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description of Economic Sector/Activity</label>
                        <textarea name="description_iaf" id="description_iaf14001" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}


{{-- ISO45001 Modal --}}
{{-- <div class="modal fade" id="scopeModal" tabindex="-1" aria-labelledby="scopeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT" id="scopeFormMethod">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="personnel">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="technical_cluster" id="technical_cluster45001" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="iaf_code" id="iaf_code45001" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description of economic sector/activity</label>
                        <textarea name="description_iaf" id="description_iaf45001" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}


{{-- ISO13485 Modal --}}
{{-- <div class="modal fade" id="editScopeModal" tabindex="-1" aria-labelledby="editScopeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="personnel">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Main Technical Area</label>
                        <input type="text" name="main_technical" id="main_technical13485" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Technical Area</label>
                        <input type="text" name="technical_area" id="technical_area13485" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Product Categories Covered by the Technical Areas</label>
                        <textarea name="product_category" id="product_category13485" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}


{{-- ISO22000 Modal --}}
{{-- <div class="modal fade" id="ScopeModalISO22000" tabindex="-1" aria-labelledby="ScopeModalISO22000Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editScopeForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="personnel">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Main Technical Area</label>
                        <input type="text" name="main_technical" id="main_technical22000" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Technical Area</label>
                        <input type="text" name="technical_area" id="technical_area22000" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Product Categories Covered by the Technical Areas</label>
                        <textarea name="product_category" id="product_category22000" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}







@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    // ISO45001
    function openScopeModal(data) {
        $('#scopeForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#technical_cluster9001').val(data.technical_cluster);
        $('#iaf_code9001').val(data.iaf_code);
        $('#description_iaf9001').val(data.description_iaf);
        $('#scope').val();
        $('#scopeModal').modal('show');
    }


    // ISO14001

    function openScopeBModal(data) {
        $('#scopeBForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#technical_cluster14001').val(data.technical_cluster);
        $('#iaf_code14001').val(data.iaf_code);
        $('#description_iaf14001').val(data.description_iaf);
        $('#scope').val();
        $('#scopeBModal').modal('show');
    }


    // ISO9001
    function openScopeAModal(data) {
        $('#scopeAForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#technical_cluster9001').val(data.technical_cluster);
        $('#iaf_code9001').val(data.iaf_code);
        $('#description_iaf9001').val(data.description_iaf);
        $('#scope').val();
        $('#scopeAModal').modal('show');
    }


    // ISO13485
    function openScopeModalISO13485(scope) {
        $('#scopeForm').attr('action', `/application/update/certification-bodies/${scope.id}`);
        $('#main_technical13485').val(scope.main_technical);
        $('#technical_area13485').val(scope.technical_area);
        $('#product_category13485').val(scope.product_category);
        $('#scope').val();
        $('#editScopeModal').modal('show');
    }


     // ISO22000
    function openScopeModalISO22000(scope) {
        $('#editScopeForm').attr('action', `/application/update/certification-bodies/${scope.id}`);
        $('#main_technical22000').val(scope.main_technical);
        $('#technical_area22000').val(scope.technical_area);
        $('#product_category22000').val(scope.product_category);
        $('#scope').val();
        $('#ScopeModalISO22000').modal('show');
    }

</script>

@endsection
