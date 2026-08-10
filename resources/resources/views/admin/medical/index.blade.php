@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
<link rel="stylesheet" href="{{ url('admin/assets/modules/prism/prism.css') }}">
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
                <button href="{{ route('application.create') }}" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">New Application</button>

            </div>
            <div class="col-12">

                @if(session('success'))
                <div class="alert alert-success w-100">
                    {{ session('success') }}
                </div>
                @endif


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
                                        <th>Organisation</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($generals as $key => $general)

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $general->contact_name }}</td>
                                        <td>{{ $general->person_email }}</td>
                                        <td>{{ $general->organisation }}</td>
                                        <td>{{ $general->address_laboratory }}</td>
                                        <td>
                                            <a href="{{ route('application.edit', $general->id) }}" class="btn btn-success btn-sm">Edit</a>
                                            <a href="{{ route('application.destroy', $general->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                        {{-- <td>
                                            <img alt="image" src="{{ asset('admin/assets/img/avatar/avatar-5.png') }}" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                        </td> --}}

                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('application.create') }}" method="GET">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scheme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">Scheme</label>
                    <select name="scheme" class="form-control">
                        <option selected>Select Scheme</option>
                        @foreach ($schemes as $scheme)
                        <option value="{{ $scheme->scheme_name }}">{{ $scheme->scheme_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</div>

@endsection
@section('script')
@endsection
