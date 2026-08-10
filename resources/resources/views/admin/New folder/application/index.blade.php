@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
{{-- <link rel="stylesheet" href="{{ url('admin/assets/modules/prism/prism.css') }}"> --}}
@endsection

<!-- Start app main Content -->
<div class="main-content">
    <section class="section">


        {{-- <div class="search mb-2">
                    <div class="row">
                        <div class="col-4">
                            <label for="">Scheme</label>
                            <select name="scheme" class="form-control" id="">
                                <option value="">--Please Select--</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Category</label>
                            <select name="category" class="form-control" id="">
                                <option value="">--Please Select--</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">File Program</label>
                            <select name="file_program" class="form-control" id="">
                                <option value="">--Please Select--</option>
                            </select>
                        </div>
                    </div>
                </div> --}}

        <div class="row">

            <div class="mb-2">
                <button class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#schemeModal">New Application</button>

            </div>
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Index</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        {{-- <th>Organisation</th> --}}
                                        {{-- <th>Address</th> --}}
                                        <th>category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($mergedApplications as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $application['contact_name'] }}</td>
                                            <td>{{ $application['person_email'] }}</td>
                                            {{-- <td>{{ $application['organisation'] }}</td> --}}
                                            {{-- <td>{{ $application['address'] }}</td> --}}
                                            <td>{{ $application['category'] }}</td>

                                            <td>
                                                {{-- @can('edit Application') --}}
                                                <button type="button"
                                                    class="btn btn-success btn-sm"
                                                    data-id="{{ $application['id'] }}"
                                                    data-category="{{ $application['category'] }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                    Edit
                                                </button>
                                                {{-- @endcan --}}

                                                @can('edit Application')
                                                <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    data-id="{{ $application['id'] }}"
                                                    data-category="{{ $application['category'] }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">
                                                    Delete
                                                </button>
                                                @endcan
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
    </section>
</div>

<!-- Single Dynamic Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" action="" method="GET">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to edit this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Single Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Scheme Modal -->
<div class="modal fade" id="schemeModal" tabindex="-1" aria-labelledby="schemeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('application.create') }}" method="GET">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="schemeModalLabel">Scheme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">Scheme</label>
                    <select name="scheme_name" class="form-control" required>
                        <option selected disabled>Select Scheme</option>
                        @foreach ($schemes as $scheme)
                        <option value="{{ $scheme->scheme_name }}">{{ $scheme->scheme_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Next</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</div>

@endsection
@section('script')
<script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const category = button.getAttribute('data-category');

        const form = document.getElementById('editForm');
        // form.action = `/application/edit/${id}?category=${encodeURIComponent(category)}`;
        form.action = `/application/edit/${id}/${encodeURIComponent(category)}`;
    });


    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const category = button.getAttribute('data-category');

        const form = document.getElementById('deleteForm');
        form.action = `/application/destroy/${id}/${encodeURIComponent(category)}`;
    });
</script>
@endsection
