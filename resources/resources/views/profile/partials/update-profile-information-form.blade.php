<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
    @csrf
    @method('patch')
    <div class="row">
        <div class="flex items-center gap-4">

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm alert alert-success">{{ __('Profile Update Successfully.') }}</p>
            @endif

            @if(session('error'))
            <div class="alert alert-danger w-100">{{ session('error') }}</div>
            @endif
        </div>

        <div class="card-header">
            <h6>General information</h6>
        </div>

        <div class="col-12 col-md-4 col-lg-4">
            <div class="card m-0">
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <x-text-input type="text" name="name" :value="old('name', $user->name)" class="form-control" />
                    </div>
                      <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </div>
                        </div>
                        <x-text-input type="text" name="phone_number" :value="old('phone_number', $user_detail->phone_number ?? '')" class="form-control numericValue" />
                    </div>
                </div>
  
                   <div class="form-group">
                    <label>Designation</label>
                    <x-text-input type="text" name="designation" :value="old('designation', $user_detail->designation ?? '')" class="form-control" />
                </div>

                    <div class="form-group">
                        <label>Fax No</label>
                        <x-text-input type="text" name="fax_no" :value="old('fax_no', $user_detail->fax_no ?? '')" class="form-control numericValue" />
                    </div>

             

                    <div class="card-body pb-0">
                        <div class="form-group m-0">
                            <div class="control-label">Gender</div>
                            <div class="custom-switches-stacked d-flex mt-2">
                                <label class="custom-switch">
                                    <input type="radio" name="gender" value="male" class="custom-switch-input" {{ old('gender', $user_detail->gender ?? '') === 'male' ? 'checked' : '' }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Male</span>
                                </label>
                                <label class="custom-switch">
                                    <input type="radio" name="gender" value="female" class="custom-switch-input" {{ old('gender', $user_detail->gender ?? '') === 'female' ? 'checked' : '' }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Female</span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 col-lg-4">
            <div class="card-body">
                <div class="form-group">
                    <label>Full name</label>
                    <x-text-input type="text" name="full_name" :value="old('full_name', $user_detail->full_name ?? '')" class="form-control" />
                </div>
           

           <div class="form-group">
                        <label>Date of Birth</label>
                        <x-text-input type="text" name="dob" :value="old('dob', $user_detail->dob ?? '')" class="form-control datepicker" />
                    </div>

                <div class="form-group">
                    <label>Office No</label>
                    <x-text-input type="text" name="office_no" :value="old('office_no', $user_detail->office_no ?? '')" class="form-control numericValue" />
                </div>
            </div>
        </div>
           <div class="col-12 col-md-4 col-lg-4">
            <div class="card-body">
                 <div class="form-group">
    <label for="image">Profile Image</label>
    <input type="file" name="image" id="image" class="form-control">
</div>

   
      <div class="form-group">
                        <label>Relationship</label>
                        <x-text-input type="text" name="relationship" :value="old('relationship', $user_detail->relationship ?? '')" class="form-control" />
                    </div>
       <div class="form-group">
                        <label>Home Address</label>
                        <x-text-input type="text" name="home_address" :value="old('home_address', $user_detail->home_address ?? '')" class="form-control" />
                    </div>

                      </div>
        </div>
    </div>

<div class="col-md-12 d-flex justify-content-end ">
        <button type="submit" class="btn btn-success me-2">Submit</button>
    <a href="{{ route('dashboard') }}" class="btn btn-danger">Back</a>
</div>
    {{-- <a href="{{ route('change.password') }}" class="btn btn-primary">Change Password</a> --}}
</form>
