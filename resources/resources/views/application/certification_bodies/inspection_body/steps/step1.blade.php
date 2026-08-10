<form method="POST" action="{{ $stepUrl }}" class="js-card-form ib-js-card-form">
    @csrf
    <div class="row g-3">
        {{-- Inspection Body Info --}}
        <div class="col-12">
            <h6 class="fw-bold">{{ $getSection('Inspection Body Information') ? $getSection('Inspection Body Information')['title'] : 'Inspection Body Information' }}</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Inspection Body Information', 'inspection_body_name', 'Inspection Body Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="inspection_body_name"
                value="{{ old('inspection_body_name', $org->inspection_body_name ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Inspection Body Information', 'address', 'Address') }} <span class="text-danger">*</span></label>
            <textarea class="form-control" name="address" rows="2" required>{{ old('address', $org->address ?? '') }}</textarea>
        </div>

        {{-- Parent Organization --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">{{ $getSection('Parent Organization (if any)') ? $getSection('Parent Organization (if any)')['title'] : 'Parent Organization (if any)' }}</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Parent Organization (if any)', 'parent_organization', 'Parent Organization') }}</label>
            <input class="form-control" name="parent_organization"
                value="{{ old('parent_organization', $org->parent_organization ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Parent Organization (if any)', 'relationship', 'Relationship') }}</label>
            <input class="form-control" name="relationship" value="{{ old('relationship', $org->relationship ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">{{ $getLabel('Parent Organization (if any)', 'parent_address', 'Parent Address') }}</label>
            <textarea class="form-control" name="parent_address" rows="2">{{ old('parent_address', $org->parent_address ?? '') }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Parent Organization (if any)', 'parent_postcode', 'Parent Postcode') }}</label>
            <input class="form-control" name="parent_postcode"
                value="{{ old('parent_postcode', $org->parent_postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Parent Organization (if any)', 'parent_tel', 'Parent Tel') }}</label>
            <input class="form-control" name="parent_tel" value="{{ old('parent_tel', $org->parent_tel ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Parent Organization (if any)', 'parent_fax', 'Parent Fax') }}</label>
            <input class="form-control" name="parent_fax" value="{{ old('parent_fax', $org->parent_fax ?? '') }}">
        </div>

        {{-- Invoice Address --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">{{ $getSection('Invoice Address (if different)') ? $getSection('Invoice Address (if different)')['title'] : 'Invoice Address (if different)' }}</h6>
        </div>
        <div class="col-md-12">
            <label class="form-label">{{ $getLabel('Invoice Address (if different)', 'invoice_organization', 'Organization') }}</label>
            <input class="form-control" name="invoice_organization"
                value="{{ old('invoice_organization', $org->invoice_organization ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">{{ $getLabel('Invoice Address (if different)', 'invoice_address', 'Address') }}</label>
            <textarea class="form-control" name="invoice_address" rows="2">{{ old('invoice_address', $org->invoice_address ?? '') }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Invoice Address (if different)', 'invoice_postcode', 'Postcode') }}</label>
            <input class="form-control" name="invoice_postcode"
                value="{{ old('invoice_postcode', $org->invoice_postcode ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Invoice Address (if different)', 'invoice_tel', 'Tel') }}</label>
            <input class="form-control" name="invoice_tel" value="{{ old('invoice_tel', $org->invoice_tel ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Invoice Address (if different)', 'invoice_fax', 'Fax') }}</label>
            <input class="form-control" name="invoice_fax" value="{{ old('invoice_fax', $org->invoice_fax ?? '') }}">
        </div>

        {{-- Establishment & Legal --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">{{ $getSection('Establishment & Legal Status') ? $getSection('Establishment & Legal Status')['title'] : 'Establishment & Legal Status' }}</h6>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Establishment & Legal Status', 'date_of_establishment', 'Date of Establishment') }}</label>
            <input type="date" class="form-control" name="date_of_establishment"
                value="{{ old('date_of_establishment', $org->date_of_establishment ?? '') }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">{{ $getLabel('Establishment & Legal Status', 'legal_status', 'Legal Status') }}</label>
            <input class="form-control" name="legal_status"
                value="{{ old('legal_status', $org->legal_status ?? '') }}">
        </div>

        {{-- Outside Pakistan --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">{{ $getSection('Outside Pakistan Work') ? $getSection('Outside Pakistan Work')['title'] : 'Outside Pakistan Work' }}</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Outside Pakistan Work', 'outside_pakistan', 'Do you carry out work outside Pakistan?') }}</label>
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
            <label class="form-label">{{ $getLabel('Outside Pakistan Work', 'countries_description', 'If yes, which countries?') }}</label>
            <textarea class="form-control" name="countries_description" rows="2">{{ old('countries_description', $org->countries_description ?? '') }}</textarea>
        </div>

        {{-- Inspection Main Activity --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">{{ $getSection('Is Inspection the Main Activity?') ? $getSection('Is Inspection the Main Activity?')['title'] : 'Is Inspection the Main Activity?' }}</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Is Inspection the Main Activity?', 'inspection_main_activity', 'Is Inspection the Main Activity?') }}</label>
            <div>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inspection_main_activity" value="yes"
                        @if (old('inspection_main_activity', $org->inspection_main_activity ?? '') === 'yes') checked @endif> Yes
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inspection_main_activity" value="no"
                        @if (old('inspection_main_activity', $org->inspection_main_activity ?? '') === 'no') checked @endif> No
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Is Inspection the Main Activity?', 'activity_description', 'If No, describe main activity') }}</label>
            <textarea class="form-control" name="activity_description" rows="2">{{ old('activity_description', $org->activity_description ?? '') }}</textarea>
        </div>

        {{-- Consultant --}}
        <div class="col-12 mt-3">
            <h6 class="fw-bold">{{ $getSection('Consultant / Consultancy Firm (if any)') ? $getSection('Consultant / Consultancy Firm (if any)')['title'] : 'Consultant / Consultancy Firm (if any)' }}</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_name', 'Name') }}</label>
            <input class="form-control" name="consultant_name"
                value="{{ old('consultant_name', $org->consultant_name ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_organization', 'Organization') }}</label>
            <input class="form-control" name="consultant_organization"
                value="{{ old('consultant_organization', $org->consultant_organization ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_address', 'Address') }}</label>
            <textarea class="form-control" name="consultant_address" rows="2">{{ old('consultant_address', $org->consultant_address ?? '') }}</textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_postcode', 'Postcode') }}</label>
            <input class="form-control" name="consultant_postcode"
                value="{{ old('consultant_postcode', $org->consultant_postcode ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_tel', 'Tel') }}</label>
            <input class="form-control" name="consultant_tel"
                value="{{ old('consultant_tel', $org->consultant_tel ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_fax', 'Fax') }}</label>
            <input class="form-control" name="consultant_fax"
                value="{{ old('consultant_fax', $org->consultant_fax ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ $getLabel('Consultant / Consultancy Firm (if any)', 'consultant_email', 'Email') }}</label>
            <input type="email" class="form-control" name="consultant_email"
                value="{{ old('consultant_email', $org->consultant_email ?? '') }}">
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-success btn-sm">Save Draft</button>
    </div>
</form>
