<form method="POST" action="{{ $stepUrl('step7') }}" class="js-card-form hcb-js-card-form">
    @csrf
    <div class="row g-3">

        <div class="col-12">
            <h6 class="fw-bold border-bottom pb-1">
                {{ $getSection('7.1 Application Type') ? $getSection('7.1 Application Type')['title'] : '7.1 Application Type' }}
            </h6>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="halal_scope" value="1" id="decl_halal_scope"
                    @if (old('halal_scope', $declaration->halal_scope ?? false)) checked @endif>
                <label class="form-check-label" for="decl_halal_scope">
                    {{ $getLabel('7.1 Application Type', 'halal_scope', 'Halal Certification (Scope as per Annex A)') }}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extension_scope" value="1"
                    id="decl_ext_scope" @if (old('extension_scope', $declaration->extension_scope ?? false)) checked @endif>
                <label class="form-check-label" for="decl_ext_scope">
                    {{ $getLabel('7.1 Application Type', 'extension_scope', 'Extension of Scope of Existing Accreditation') }}
                </label>
            </div>
        </div>

        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">
                {{ $getSection('7.2 Declarations') ? $getSection('7.2 Declarations')['title'] : '7.2 Declarations' }}
            </h6>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="quality_manual_confirmed" value="1"
                    id="qm_confirmed" @if (old('quality_manual_confirmed', $declaration->quality_manual_confirmed ?? false)) checked @endif>
                <label class="form-check-label" for="qm_confirmed">
                    {{ $getLabel('7.2 Declarations', 'quality_manual_confirmed', 'I enclose a copy of the Quality Manual (see Note below).') }}
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="declaration_accepted" value="1"
                    id="decl_accepted" @if (old('declaration_accepted', $declaration->declaration_accepted ?? false)) checked @endif required>
                <label class="form-check-label" for="decl_accepted">
                    {{ $getLabel('7.2 Declarations', 'declaration_accepted', 'I declare that the information given in this form is correct to the best of my knowledge and belief. The organisation agrees to conform, upon accreditation, with PNAC requirements as detailed in the Agreement [F-01/18].') }}
                    <span class="text-danger">*</span>
                </label>
            </div>
        </div>

        <div class="col-12 mt-2">
            <h6 class="fw-bold border-bottom pb-1">
                {{ $getSection('7.3 Applicant Fee & Signature') ? $getSection('7.3 Applicant Fee & Signature')['title'] : '7.3 Applicant Fee & Signature' }}
            </h6>
        </div>

        <div class="col-md-4">
            <label
                class="form-label">{{ $getLabel('7.3 Applicant Fee & Signature', 'applicant_fee_amount', 'Applicant Fee (PKR)') }}</label>
            <input class="form-control" name="applicant_fee_amount"
                value="{{ old('applicant_fee_amount', $declaration->applicant_fee_amount ?? '') }}">
            <small class="text-muted">I understand this fee is non-refundable.</small>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('7.3 Applicant Fee & Signature', 'signed_by', 'Signed By') }} <span
                    class="text-danger">*</span></label>
            <input class="form-control" name="signed_by" value="{{ old('signed_by', $declaration->signed_by ?? '') }}"
                required>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('7.3 Applicant Fee & Signature', 'signed_date', 'Date') }} <span
                    class="text-danger">*</span></label>
            <input type="date" class="form-control" name="signed_date"
                value="{{ old('signed_date', $declaration->signed_date ?? now()->format('Y-m-d')) }}" required>
        </div>

        <div class="col-12">
            <p class="text-muted small mb-0">
                <strong>Note:</strong> PNAC will not process your application until it has received your Quality Manual,
                procedures and application fee.
            </p>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="submit" class="btn btn-success btn-sm">Save Draft</button>

    </div>
</form>
