@extends('admin.layouts.adminlayout')
@section('main-content')

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">

                <div class="row">
                    <div class="mb-2">
                        <a href="{{ route('message.notification.index') }}" class="btn btn-danger mb-1 float-right">Back</a>
                    </div>
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4>Notification Detail</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Application Subject</label>
                                        </div>
                                        <div class="form-group col-6">
                                            <small>{{ $message->subject }}</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Message/Notification</label>
                                        </div>
                                        <div class="form-group col-6">
                                            <small>{!! $message->message !!}</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Message Date:</label>
                                        </div>
                                        <div class="form-group col-6">
                                            <small>{{ $message->created_at }}</small>
                                        </div>
                                    </div>
                                    {{--  <div class="row">
                                        <div class="form-group col-6">
                                            <label>By User From PNAC Date:</label>
                                        </div>
                                        <div class="form-group col-6">
                                            <small>{{ $message->userAccount->role_id }}</small>
                                        </div>
                                    </div>  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

@endsection
