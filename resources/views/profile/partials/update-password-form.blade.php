@extends('admin.layouts.adminlayout')
@section('main-content')

<!-- Start app main Content -->
<div class="main-content">
    <section class="section">

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')
            <div class="row d-flex justify-content-center">

                <div class="col-12 col-md-10 col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                    <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
                            </div>
                            <div class="form-group">
                                <x-input-label for="update_password_password" :value="__('New Password')" />
                                <x-text-input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
                            </div>
                            <div class="form-group">
                                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
                            </div>
                             <div class="d-flex justify-content-end gap-4">
                {{-- <x-primary-button>{{ __('Change Password') }}</x-primary-button> --}}
                <button type="submit" class="btn btn-success">Change Password</button>
                <a href="{{ route('dashboard') }}" class="btn btn-danger">Back</a>
            </div>
                        </div>
                    </div>
                </div>

            </div>

           
                {{-- <button type="submit" class="btn btn-success">Submit</button> --}}
        </form>

    </section>
</div>
@endsection
