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
                // dd($category);
                $application = request()->get('application');
            @endphp

            <div class="col-12">
                {{-- View Scope --}}
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>View {{ $scope }}</h4>
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
                                                <th>Technical Cluster</th>
                                                <th>IAF Code</th>
                                                <th>Description of economic sector/activity, according to IAF ID1</th>
                                                <th>Date of Scope Applied</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->technicalCluster->name }}</td>
                                                    <td>{{ $scope->iaf_code }}</td>
                                                    <td>{{ $scope->description }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    {{-- <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeAModal(@json($scope))'>Edit</button>
                                                        @endif
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($scope == 'ISO14001')
                        <div class="card-body scope-section" id="ISO14001">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped v_center" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S#</th>
                                                <th>Technical Cluster</th>
                                                <th>IAF Code</th>
                                                <th>Description of economic sector/activity, according to IAF ID1</th>
                                                <th>Date of Scope Applied</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->technicalCluster->name }}</td>
                                                    <td>{{ $scope->iaf_code }}</td>
                                                    <td>{{ $scope->description }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    {{-- <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeBModal(@json($scope))'>Edit</button>
                                                        @endif
                                                    </td> --}}
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
                                                <th>Description of economic sector/activity, according to IAF ID1</th>
                                                <th>Date of Scope Applied</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->technicalCluster->name }}</td>
                                                    <td>{{ $scope->iaf_code }}</td>
                                                    <td>{{ $scope->description }}</td>
                                                    <td>{{ $scope->created_at }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    {{-- <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeModal(@json($scope))'>Edit</button>
                                                        @endif
                                                    </td> --}}
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
                                                <th>Main Technical</th>
                                                <th>Technical Area</th>
                                                <th>Product Categories / Descriptions</th>
                                                <th>Date of Scope Applied</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($scopes as $key => $scope)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->mainTechnical->technical_name ?? '' }}</td>
                                                    <td>{{ $scope->technicalArea->technical_area ?? '' }}</td>
                                                    <td>{!! $scope->description ?? '' !!}</td>
                                                    <td>{!! $scope->created_at ?? '' !!}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp

                                                    {{-- <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeModalISO13485(@json($scope))'>Edit</button>
                                                        @endif
                                                    </td> --}}
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
                                            {{-- @dd($scope) --}}
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $scope->cluster->cluster_name ?? '' }}</td>
                                                    <td>{{ $scope->category->category_name ?? '' }}</td>
                                                    <td>{{ $scope->cluster_sub_cat ?? '' }}</td>
                                                    <td>{{ $scope->description ?? '' }}</td>
                                                    <td>{{ $scope->created_at ?? '' }}</td>
                                                    @php
                                                        $isSubmitted = optional($scope->general->declaration)->status === 'submited';
                                                    @endphp
                                                    {{-- <td>
                                                        @if (!$isSubmitted)
                                                            <button class="btn btn-sm btn-primary" onclick='openScopeModalISO22000(@json($scope))'>Edit</button>
                                                        @endif
                                                    </td> --}}
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


{{-- ISO9001 Modal --}}
<div class="modal fade" id="scopeAModal" tabindex="-1" aria-labelledby="scopeAModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeAForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="certification">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope ISO9001</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="technical_cluster_id" id="scop_technical_a" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="iaf_code" id="scop_iaf_a" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description of economic sector/activity, according to IAF ID1</label>
                        <textarea name="description" id="scop_economic_a" class="form-control" required></textarea>
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
<div class="modal fade" id="scopeBModal" tabindex="-1" aria-labelledby="scopeBModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeBForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="certification">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope B</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="scop_technical_b" id="scop_technical_b" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="scop_iaf_b" id="scop_iaf_b" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description of Economic Sector/Activity</label>
                        <textarea name="scop_economic_b" id="scop_economic_b" class="form-control" required></textarea>
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


{{-- ISO45001 Modal --}}
<div class="modal fade" id="scopeModal" tabindex="-1" aria-labelledby="scopeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT" id="scopeFormMethod">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="certification">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="scop_technical_c" id="scop_technical_c" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="scop_iaf_c" id="scop_iaf_c" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description of economic sector/activity</label>
                        <textarea name="scop_economic_c" id="scop_economic_c" class="form-control" required></textarea>
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


{{-- ISO13485 Modal --}}
<div class="modal fade" id="editScopeModal" tabindex="-1" aria-labelledby="editScopeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scopeForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="certification">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Technical Cluster</label>
                        <input type="text" name="scop_main_tech" id="scop_main_tech" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>IAF Code</label>
                        <input type="text" name="scop_areas" id="scop_areas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description of Economic Sector/Activity</label>
                        <textarea name="scop_product" id="scop_product" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- ISO22000 Modal --}}
<div class="modal fade" id="ScopeModalISO22000" tabindex="-1" aria-labelledby="ScopeModalISO22000Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editScopeForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="type" value="scope" id="scope">
            <input type="hidden" name="category" value="certification">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scope</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Technical Cluster</label>
                        <input type="text" name="scop_cluster" id="scop_cluster" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>IAF Code</label>
                        <input type="text" name="scop_category" id="scop_category" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Economic Sector/Activity</label>
                        <input type="text" name="scop_subcategory" id="scop_subcategory" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Date of Scope Applied</label>
                        <input type="text" name="scop_activity" id="scop_activity" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>







@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    // ISO45001
    function openScopeModal(data) {
        $('#scopeForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#scop_technical_c').val(data.scop_technical_c);
        $('#scop_iaf_c').val(data.scop_iaf_c);
        $('#scop_economic_c').val(data.scop_economic_c);
        $('#scope').val();
        $('#scopeModal').modal('show');
    }


    // ISO14001
    function openScopeBModal(data) {
        $('#scopeBForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#scop_technical_b').val(data.scop_technical_b);
        $('#scop_iaf_b').val(data.scop_iaf_b);
        $('#scop_economic_b').val(data.scop_economic_b);
        $('#scope').val();
        $('#scopeBModal').modal('show');
    }


    // ISO9001
    function openScopeAModal(data) {
        $('#scopeAForm').attr('action', `/application/update/certification-bodies/${data.id}`);
        $('#scop_technical_a').val(data.technical_cluster_id);
        $('#scop_iaf_a').val(data.iaf_code);
        $('#scop_economic_a').val(data.description);
        $('#scope').val();
        $('#scopeAModal').modal('show');
    }


    // ISO13485
    function openScopeModalISO13485(scope) {
        $('#scopeForm').attr('action', `/application/update/certification-bodies/${scope.id}`);
        $('#scop_main_tech').val(scope.scop_main_tech);
        $('#scop_areas').val(scope.scop_areas);
        $('#scop_product').val(scope.scop_product);
        $('#scope').val();
        $('#editScopeModal').modal('show');
    }


     // ISO22000
    function openScopeModalISO22000(scope) {
        $('#editScopeForm').attr('action', `/application/update/certification-bodies/${scope.id}`);
        $('#scop_cluster').val(scope.scop_cluster);
        $('#scop_category').val(scope.scop_category);
        $('#scop_subcategory').val(scope.scop_subcategory);
        $('#scop_activity').val(scope.scop_activity);
        $('#scope').val();
        $('#ScopeModalISO22000').modal('show');
    }

</script>

@endsection
