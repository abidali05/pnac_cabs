<form method="POST" action="{{ route('inspection-body.step4.save', ['application' => $application->id]) }}"
      class="js-card-form ib-js-card-form">
    @csrf
    <div class="row g-3">
        {{-- Type Declaration --}}
        <div class="col-12">
            <h6 class="fw-bold">{{ $getSection('Inspection Body Type Declaration') ? $getSection('Inspection Body Type Declaration')['title'] : 'Inspection Body Type Declaration' }}</h6>
            <p class="text-muted small mb-2">
                Type A – Third party inspection body independent from design, manufacture, supply, installation, purchase, ownership, use, or maintenance.<br>
                Type B – Integral part of organisation which designs, manufactures or supplies goods or services it inspects.<br>
                Type C – Provides inspection services to clients having significant commercial links.
            </p>
        </div>
        @foreach([['type_a','Type A'],['type_b','Type B'],['type_c','Type C']] as [$field,$label])
        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1"
                       id="{{ $field }}" @if(old($field, $declaration->{$field} ?? false)) checked @endif>
                <label class="form-check-label" for="{{ $field }}">{{ $getLabel('Inspection Body Type Declaration', $field, $label) }}</label>
            </div>
        </div>
        @endforeach

        {{-- Declarations --}}
        <div class="col-12 mt-3"><h6 class="fw-bold">{{ $getSection('Declarations') ? $getSection('Declarations')['title'] : 'Declarations' }}</h6></div>
        @php
            $declChecks = [
                ['iso17020_compliance',     'I declare that the inspection body complies / intends to comply with ISO/IEC 17020.'],
                ['assessment_understanding','I understand the requirements and process of PNAC assessment.'],
                ['agreement_acceptance',    'I agree to comply with PNAC accreditation requirements and conditions. (Required for submission)'],
                ['quality_manual_attached', 'Quality Manual is attached with this application.'],
                ['document_review_attached','F-02/30 Document Review Checklist is attached.'],
            ];
        @endphp
        @foreach($declChecks as [$field,$label])
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1"
                       id="{{ $field }}"
                       @if(old($field, $declaration->{$field} ?? false)) checked @endif
                       @if($field==='agreement_acceptance') required @endif>
                <label class="form-check-label" for="{{ $field }}">{{ $getLabel('Declarations', $field, $label) }}</label>
            </div>
        </div>
        @endforeach

        {{-- Fee & Signature --}}
        <div class="col-12 mt-3"><h6 class="fw-bold">{{ $getSection('Applicant Fee & Signature') ? $getSection('Applicant Fee & Signature')['title'] : 'Applicant Fee & Signature' }}</h6></div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Applicant Fee & Signature', 'applicant_fee', 'Applicant Fee (PKR)') }}</label>
            <input class="form-control" name="applicant_fee"
                   value="{{ old('applicant_fee', $declaration->applicant_fee ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Applicant Fee & Signature', 'declaration_name', 'Name (Signature)') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="declaration_name"
                   value="{{ old('declaration_name', $declaration->declaration_name ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $getLabel('Applicant Fee & Signature', 'declaration_date', 'Date') }} <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="declaration_date"
                   value="{{ old('declaration_date', $declaration->declaration_date ?? now()->format('Y-m-d')) }}" required>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button class="btn btn-success btn-sm" type="submit">Save Draft</button>
        @if(!$isLocked)
        <button class="btn btn-primary btn-sm" name="final_submit" value="1" type="submit">Final Submit</button>
        @endif
    </div>
</form>
