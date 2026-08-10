@extends('admin.layouts.adminlayout')
@section('main-content')

    <!-- Start app main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row">

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
                                            <th class="text-center">#</th>
                                            <th>CAB Name</th>
                                            <th>Adddress</th>
                                            <th>Telephone</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>Date of Applied</th>
                                            <th>Accreditation Scheme</th>
                                            <th>Application</th>
                                            <th>Status</th>
                                            <th>Message</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($certifications as $key => $certification)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $certification->cab_name }}</td>
                                                <td>{{ $certification->address }}</td>
                                                <td>{{ $certification->telephone }}</td>
                                                <td>{{ $certification->email }}</td>
                                                <td>{{ $certification->city }}</td>
                                                <td>{{ $certification->created_at }}</td>
                                                <td>{{ $certification->category }}</td>
                                                <td>{{ $certification->application }}</td>
                                                <td>
                                                    @if($certification->status == 'Pending')
                                                        <span
                                                            class="p-1 text-white rounded bg-warning">{{ $certification->status }}</span>
                                                    @elseif($certification->status == 'Approved')
                                                        <span
                                                            class="p-1 text-white rounded bg-warning">Accepted for further process</span>
                                                    @else
                                                        <span class="p-1 text-white rounded bg-danger d-inline-block text-truncate"
                                                            style="max-width: 200px; white-space: nowrap;">
                                                            {{ $certification->status }}
                                                        </span>

                                                    @endif
                                                </td>
                                                <td>{{ $certification->status == 'Not Approved' ? $certification->application_statuses->message : '' }}
                                                </td>
                                                <td>
                                                    {{-- <a
                                                        href="{{ route('application.submited.view', [$certification->id, 'category' => $certification->category]) }}"
                                                        type="button" class="btn btn-success btn-sm"
                                                        data-id="{{ $certification->id }}"
                                                        data-category="{{ $certification->category }}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"> --}}
                                                        <a href="{{ route('application.submited.view', [$certification->id, 'category' => $certification->category]) }}"
                                                            type="button" class="btn btn-success btn-sm">
                                                            View
                                                        </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>


@endsection