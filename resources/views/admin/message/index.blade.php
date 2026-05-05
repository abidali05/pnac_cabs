@extends('admin.layouts.adminlayout')
@section('main-content')

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">

                <div class="row">

                    <div class="mb-2">
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
                                                <th class="text-center">#</th>
                                                <th>Subject</th>
                                                <th>Message/Notification</th>
                                                <th>Date of Message/Notification</th>
                                                {{--  <th>Message/Notification By</th>  --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($messages as $key => $message)
                                            <tr>
                                                <td>{{ $key + 1  }}</td>
                                                <td>{{ $message->subject }}</td>
                                                <td>{!! $message->message  !!}</td>
                                                <td>{{ $message->created_at  }}</td>
                                                {{--  <td>{{ $message->userAccount->role_id  }}</td>  --}}
                                                <td><a href="{{ route('message.notification.detail', $message->id) }}" class="btn btn-primary">Detail</a></td>
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
