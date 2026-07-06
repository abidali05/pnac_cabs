@extends('admin.layouts.adminlayout')
@section('main-content')

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">

                <div class="row">

                    <div class="mb-2">
                        <a href="{{ route('scheme.create') }}" class="btn btn-success float-right">New Scheme</a>

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
                                                <th class="text-center">#</th>
                                                <th>Scheme</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schemes as $key => $scheme)

                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $scheme->scheme_name }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('scheme.edit',$scheme->id) }}" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                                                    <form action="{{ route('scheme.destroy', $scheme->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
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

@endsection
