<form method="POST" action="{{ $stepUrl('step1') }}" class="js-card-form hcb-js-card-form">
    @csrf
    <div class="row g-3">
        {{-- HCB Information --}}
        <div class="col-12">
            <h6 class="fw-bold border-bottom pb-1">1.1 HCB Information</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">Organization Name <span class="text-danger">*</span></label>
            <input class="form-control" name="organization_name"
                value="{{ old('organization_name', $basicInfo->organization_name ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="address" rows="2" required>{{ old('address', $basicInfo->address ?? '') }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Postcode</label>
            <input class="form-control" name="postcode" value="{{ old('postcode', $basicInfo->postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Telephone</label>
            <input class="form-control" name="telephone" value="{{ old('telephone', $basicInfo->telephone ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Fax</label>
            <input class="form-control" name="fax" value="{{ old('fax', $basicInfo->fax ?? '') }}">
        </div>

        {{-- Contact Person --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">1.2 Contact Person</h6>
        </div>
        <div class="col-md-4">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input class="form-control" name="contact_name"
                value="{{ old('contact_name', $basicInfo->contact_name ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Designation</label>
            <input class="form-control" name="designation"
                value="{{ old('designation', $basicInfo->designation ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="contact_email"
                value="{{ old('contact_email', $basicInfo->contact_email ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">Contact Address</label>
            <textarea class="form-control" name="contact_address" rows="2">{{ old('contact_address', $basicInfo->contact_address ?? '') }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Contact Postcode</label>
            <input class="form-control" name="contact_postcode"
                value="{{ old('contact_postcode', $basicInfo->contact_postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Contact Tel</label>
            <input class="form-control" name="contact_tel"
                value="{{ old('contact_tel', $basicInfo->contact_tel ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Contact Fax</label>
            <input class="form-control" name="contact_fax"
                value="{{ old('contact_fax', $basicInfo->contact_fax ?? '') }}">
        </div>


    </div>
    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
