<form method="POST" action="{{ $stepUrl('step2') }}" class="js-card-form hcb-js-card-form">
    @csrf

    <div class="row g-3">

        {{-- Authorized Person --}}
        <div class="col-12">
            <h6 class="fw-bold border-bottom pb-1">2.1 Authorized Person</h6>
        </div>

        <div class="col-md-2">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input class="form-control" name="title" value="{{ old('title', $aboutHcb->title ?? '') }}">
        </div>

        <div class="col-md-5">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ old('name', $aboutHcb->name ?? '') }}" required>
        </div>

        <div class="col-md-5">
            <label class="form-label">Position <span class="text-danger">*</span></label>
            <input class="form-control" name="position" value="{{ old('position', $aboutHcb->position ?? '') }}">
        </div>

        {{-- Parent Organization --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">2.2 Parent Organization (if any)</h6>
        </div>

        <div class="col-md-6">
            <label class="form-label">Parent Organization <span class="text-danger">*</span></label>
            <input class="form-control" name="parent_organization"
                value="{{ old('parent_organization', $aboutHcb->parent_organization ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Relationship <span class="text-danger">*</span></label>
            <input class="form-control" name="relationship"
                value="{{ old('relationship', $aboutHcb->relationship ?? '') }}">
        </div>

        <div class="col-md-12">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="parent_address" rows="2">{{ old('parent_address', $aboutHcb->parent_address ?? '') }}</textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Postcode <span class="text-danger">*</span></label>
            <input class="form-control" name="parent_postcode"
                value="{{ old('parent_postcode', $aboutHcb->parent_postcode ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Telephone <span class="text-danger">*</span></label>
            <input class="form-control" name="parent_telephone"
                value="{{ old('parent_telephone', $aboutHcb->parent_telephone ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Fax <span class="text-danger">*</span></label>
            <input class="form-control" name="parent_fax" value="{{ old('parent_fax', $aboutHcb->parent_fax ?? '') }}">
        </div>

        {{-- Invoice Address --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">2.3 Invoice Address (if different)</h6>
        </div>

        <div class="col-md-6">
            <label class="form-label">Organization <span class="text-danger">*</span></label>
            <input class="form-control" name="invoice_organization"
                value="{{ old('invoice_organization', $aboutHcb->invoice_organization ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="invoice_address" rows="2">{{ old('invoice_address', $aboutHcb->invoice_address ?? '') }}</textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Postcode <span class="text-danger">*</span></label>
            <input class="form-control" name="invoice_postcode"
                value="{{ old('invoice_postcode', $aboutHcb->invoice_postcode ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Telephone <span class="text-danger">*</span></label>
            <input class="form-control" name="invoice_telephone"
                value="{{ old('invoice_telephone', $aboutHcb->invoice_telephone ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Fax <span class="text-danger">*</span></label>
            <input class="form-control" name="invoice_fax"
                value="{{ old('invoice_fax', $aboutHcb->invoice_fax ?? '') }}">
        </div>

        {{-- Ownership --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">2.4 Ownership</h6>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ownership Type <span class="text-danger">*</span></label>
            <select class="form-select" name="ownership_type">
                <option value="">Select</option>
                @foreach (['Individual', 'Public Limited Company', 'Private Company', 'Partnership', 'Academic Institution', 'Public Body', 'Other'] as $ot)
                    <option value="{{ $ot }}" @selected(old('ownership_type', $aboutHcb->ownership_type ?? '') === $ot)>{{ $ot }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Other Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="other_description" rows="2">{{ old('other_description', $aboutHcb->other_description ?? '') }}</textarea>
        </div>

        {{-- Main Activity --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">2.5 Main Activity</h6>
        </div>

        <div class="col-md-6">
            <label class="form-label">Is Halal Certification the main activity? <span
                    class="text-danger">*</span></label>

            <div class="mt-1">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_halal_main_activity" value="yes"> Yes
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_halal_main_activity" value="no"> No
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Activity Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="activity_description" rows="2"></textarea>
        </div>

        {{-- Consultant --}}
        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">2.6 Consultant / Consultancy Firm</h6>
        </div>

        <div class="col-md-6">
            <label class="form-label">Consultant Name <span class="text-danger">*</span></label>
            <input class="form-control" name="consultant_name">
        </div>

        <div class="col-md-6">
            <label class="form-label">Organization <span class="text-danger">*</span></label>
            <input class="form-control" name="consultant_organization">
        </div>

        <div class="col-md-12">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="consultant_address" rows="2"></textarea>
        </div>

        <div class="col-md-3">
            <label class="form-label">Postcode <span class="text-danger">*</span></label>
            <input class="form-control" name="consultant_postcode">
        </div>

        <div class="col-md-3">
            <label class="form-label">Tel <span class="text-danger">*</span></label>
            <input class="form-control" name="consultant_tel">
        </div>

        <div class="col-md-3">
            <label class="form-label">Fax <span class="text-danger">*</span></label>
            <input class="form-control" name="consultant_fax">
        </div>

        <div class="col-md-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="consultant_email">
        </div>

    </div>

    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
