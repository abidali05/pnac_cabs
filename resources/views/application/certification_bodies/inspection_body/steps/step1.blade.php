<form method="POST" action="{{ $stepUrl }}" class="js-card-form ib-js-card-form">
    @csrf
    <div class="row g-3">
        {{-- Inspection Body Info --}}
        <div class="col-12">
            <h6 class="fw-bold">Inspection Body Information</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">Inspection Body Name <span class="text-danger">*</span></label>
            <input class="form-control" name="inspection_body_name"
                value="{{ old('inspection_body_name', $org->inspection_body_name ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control" name="address" rows="2" required>{{ old('address', $org->address ?? '') }}</textarea>
        </div>
        {{-- <div class="col-md-4">
            <label class="form-label">Postcode</label>
            <input class="form-control" name="postcode" value="{{ old('postcode', $org->postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Telephone</label>
            <input class="form-control" name="telephone" value="{{ old('telephone', $org->telephone ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Fax</label>
            <input class="form-control" name="fax" value="{{ old('fax', $org->fax ?? '') }}">
        </div>

        {{-- Contact Person --}}
        {{-- <div class="col-12 mt-3">
            <h6 class="fw-bold">Contact Person</h6>
        </div>
        <div class="col-md-4">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input class="form-control" name="contact_name" value="{{ old('contact_name', $org->contact_name ?? '') }}"
                required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Designation</label>
            <input class="form-control" name="designation" value="{{ old('designation', $org->designation ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="contact_email"
                value="{{ old('contact_email', $org->contact_email ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">Contact Address</label>
            <textarea class="form-control" name="contact_address" rows="2">{{ old('contact_address', $org->contact_address ?? '') }}</textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">Contact Postcode</label>
            <input class="form-control" name="contact_postcode"
                value="{{ old('contact_postcode', $org->contact_postcode ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Contact Tel</label>
            <input class="form-control" name="contact_tel" value="{{ old('contact_tel', $org->contact_tel ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Contact Fax</label>
            <input class="form-control" name="contact_fax" value="{{ old('contact_fax', $org->contact_fax ?? '') }}">
        </div> --}}

        {{-- Sub Offices --}}
        {{-- <div class="col-12 mt-3">
            <h6 class="fw-bold">Sub Offices (if any)</h6>
        </div>
        <div class="col-md-12">
            <label class="form-label">Office Details</label>
            <textarea class="form-control" name="office_details" rows="3">{{ old('office_details', $org->office_details ?? '') }}</textarea>
        </div> --}}

        {{-- Application Type --}}
        {{-- <div class="col-12 mt-3">
            <h6 class="fw-bold">Application Type</h6>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="new_accreditation" value="1"
                    id="new_accreditation" @if (old('new_accreditation', $org->new_accreditation ?? false)) checked @endif>
                <label class="form-check-label" for="new_accreditation">New Accreditation</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extension_scope" value="1"
                    id="extension_scope" @if (old('extension_scope', $org->extension_scope ?? false)) checked @endif>
                <label class="form-check-label" for="extension_scope">Extension of Scope</label>
            </div>
        </div> --}}




        {{-- Parent Organization --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">Parent Organization (if any)</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">Parent Organization</label>
            <input class="form-control" name="parent_organization"
                value="{{ old('parent_organization', $org->parent_organization ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Relationship</label>
            <input class="form-control" name="relationship" value="{{ old('relationship', $org->relationship ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">Parent Address</label>
            <textarea class="form-control" name="parent_address" rows="2">{{ old('parent_address', $org->parent_address ?? '') }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Parent Postcode</label>
            <input class="form-control" name="parent_postcode"
                value="{{ old('parent_postcode', $org->parent_postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Parent Tel</label>
            <input class="form-control" name="parent_tel" value="{{ old('parent_tel', $org->parent_tel ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Parent Fax</label>
            <input class="form-control" name="parent_fax" value="{{ old('parent_fax', $org->parent_fax ?? '') }}">
        </div>

        {{-- Invoice Address --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">Invoice Address (if different)</h6>
        </div>
        <div class="col-md-12">
            <label class="form-label">Organization</label>
            <input class="form-control" name="invoice_organization"
                value="{{ old('invoice_organization', $org->invoice_organization ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="invoice_address" rows="2">{{ old('invoice_address', $org->invoice_address ?? '') }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Postcode</label>
            <input class="form-control" name="invoice_postcode"
                value="{{ old('invoice_postcode', $org->invoice_postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Tel</label>
            <input class="form-control" name="invoice_tel" value="{{ old('invoice_tel', $org->invoice_tel ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Fax</label>
            <input class="form-control" name="invoice_fax" value="{{ old('invoice_fax', $org->invoice_fax ?? '') }}">
        </div>

        {{-- Establishment & Legal --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">Establishment &amp; Legal Status</h6>
        </div>
        <div class="col-md-4">
            <label class="form-label">Date of Establishment</label>
            <input type="date" class="form-control" name="date_of_establishment"
                value="{{ old('date_of_establishment', $org->date_of_establishment ?? '') }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">Legal Status</label>
            <input class="form-control" name="legal_status"
                value="{{ old('legal_status', $org->legal_status ?? '') }}">
        </div>

        {{-- Outside Pakistan --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">Outside Pakistan Work</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">Do you carry out work outside Pakistan?</label>
            <div>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="outside_pakistan" value="yes"
                        @if (old('outside_pakistan', $org->outside_pakistan ?? '') === 'yes') checked @endif> Yes
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="outside_pakistan" value="no"
                        @if (old('outside_pakistan', $org->outside_pakistan ?? '') === 'no') checked @endif> No
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">If yes, which countries?</label>
            <textarea class="form-control" name="countries_description" rows="2">{{ old('countries_description', $org->countries_description ?? '') }}</textarea>
        </div>

        {{-- Inspection Main Activity --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">Is Inspection the Main Activity?</h6>
        </div>
        <div class="col-md-6">
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inspection_main_activity" value="yes"
                    @if (old('inspection_main_activity', $org->inspection_main_activity ?? '') === 'yes') checked @endif> Yes
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inspection_main_activity" value="no"
                    @if (old('inspection_main_activity', $org->inspection_main_activity ?? '') === 'no') checked @endif> No
            </label>
        </div>
        <div class="col-md-6">
            <label class="form-label">If No, describe main activity</label>
            <textarea class="form-control" name="activity_description" rows="2">{{ old('activity_description', $org->activity_description ?? '') }}</textarea>
        </div>

        {{-- Consultant --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">Consultant / Consultancy Firm (if any)</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input class="form-control" name="consultant_name"
                value="{{ old('consultant_name', $org->consultant_name ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Organization</label>
            <input class="form-control" name="consultant_organization"
                value="{{ old('consultant_organization', $org->consultant_organization ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="consultant_address" rows="2">{{ old('consultant_address', $org->consultant_address ?? '') }}</textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">Postcode</label>
            <input class="form-control" name="consultant_postcode"
                value="{{ old('consultant_postcode', $org->consultant_postcode ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tel</label>
            <input class="form-control" name="consultant_tel"
                value="{{ old('consultant_tel', $org->consultant_tel ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Fax</label>
            <input class="form-control" name="consultant_fax"
                value="{{ old('consultant_fax', $org->consultant_fax ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="consultant_email"
                value="{{ old('consultant_email', $org->consultant_email ?? '') }}">
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
