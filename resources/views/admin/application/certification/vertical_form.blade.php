<div class="pnac-vertical-form w-100">
    @php
        $currentEditSection = request('edit_section');
        $failedSection = old('section');
        $openSection = session('open_section') ?: $failedSection;

        $sectionShouldEdit = function (string $sectionKey, bool $isSaved) use ($currentEditSection, $failedSection) {
            if ($currentEditSection === $sectionKey) {
                return true;
            }
            if ($failedSection === $sectionKey) {
                return true;
            }
            if (!$isSaved) {
                return true;
            }
            return false;
        };

        $isSectionSaved = function (string $sectionKey) use ($savedSections) {
            return (bool) ($savedSections[$sectionKey] ?? false);
        };

        $isOwnershipSelected = function ($field) use ($labApplication) {
            return !empty($labApplication->{$field});
        };
    @endphp

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h4 class="mb-0 text-success">Application For Laboratory Accreditation ISO/IEC 17025</h4>
        <span class="badge bg-success">{{ urldecode(request()->query('scheme_name')) }}</span>
    </div>

    <div id="pnacVerticalForm" class="w-100">
        @php $basicSaved = $isSectionSaved('basic_info'); $editingBasic = $sectionShouldEdit('basic_info', $basicSaved); @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white w-100 pnac-basic-card" data-section="basic_info" data-open="{{ $openSection === 'basic_info' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Basic Application / Laboratory Information</h5>
                    <p class="text-muted mb-0">General application details captured before Part 1.</p>
                </div>
                <span class="badge {{ $basicSaved ? 'bg-success' : 'bg-warning text-dark' }}" id="status-basic">{{ $basicSaved ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if($editingBasic)
                <form method="POST" class="js-card-form" novalidate action="{{ route('application.saveBasicInfo', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                    @csrf
                    <input type="hidden" name="section" value="basic_info">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Accreditation Scheme</label><input class="form-control @error('scheme') is-invalid @enderror" name="scheme" data-label="Accreditation Scheme" data-error="Please enter accreditation scheme." required maxlength="255" placeholder="Enter accreditation scheme" value="{{ old('scheme', $general->scheme ?? request('scheme_name')) }}"><small class="field-error text-danger" data-error-for="scheme">@error('scheme'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">CAB Name</label><input class="form-control @error('cab_name') is-invalid @enderror" name="cab_name" data-label="CAB Name" data-error="Please enter CAB name." required maxlength="255" placeholder="Enter CAB name" value="{{ old('cab_name', $general->cab_name ?? '') }}"><small class="field-error text-danger" data-error-for="cab_name">@error('cab_name'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">Address of Laboratory</label><textarea class="form-control @error('address') is-invalid @enderror" name="address" data-label="Laboratory Address" data-error="Please enter laboratory address." required maxlength="1000" rows="2" placeholder="Enter complete laboratory address">{{ old('address', $general->address ?? '') }}</textarea><small class="field-error text-danger" data-error-for="address">@error('address'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">Telephone</label><input type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" data-label="Telephone" data-error="Please enter telephone number." data-error-type="Please enter a valid telephone number." pattern="^[0-9+\-\s]+$" required minlength="7" maxlength="30" placeholder="e.g. +92-300-1234567" value="{{ old('telephone', $general->telephone ?? '') }}"><small class="field-error text-danger" data-error-for="telephone">@error('telephone'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" name="email" data-label="Email" data-error="Please enter email address." data-error-type="Please enter a valid email address." required maxlength="255" placeholder="e.g. info@example.com" value="{{ old('email', $general->email ?? '') }}"><small class="field-error text-danger" data-error-for="email">@error('email'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">NTN/FTN</label><input class="form-control @error('ntn_ftn') is-invalid @enderror" name="ntn_ftn" data-label="NTN/FTN" data-error="Please enter NTN/FTN." pattern="^[A-Za-z0-9\\-/]+$" required maxlength="100" placeholder="Enter NTN/FTN number" value="{{ old('ntn_ftn', $general->ntn_ftn ?? '') }}"><small class="field-error text-danger" data-error-for="ntn_ftn">@error('ntn_ftn'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">Website</label><input type="url" class="form-control @error('website') is-invalid @enderror" name="website" data-label="Website" data-error="Please enter website URL." data-error-type="Please enter a valid website URL." required maxlength="255" placeholder="e.g. https://example.com" value="{{ old('website', $general->website ?? '') }}"><small class="field-error text-danger" data-error-for="website">@error('website'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">City</label><input class="form-control @error('city') is-invalid @enderror" name="city" data-label="City" data-error="Please enter city." required maxlength="255" placeholder="Enter city" value="{{ old('city', $general->city ?? '') }}"><small class="field-error text-danger" data-error-for="city">@error('city'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">Country</label><input class="form-control @error('country') is-invalid @enderror" name="country" data-label="Country" data-error="Please enter country." required maxlength="255" placeholder="Enter country" value="{{ old('country', $general->country ?? '') }}"><small class="field-error text-danger" data-error-for="country">@error('country'){{ $message }}@enderror</small></div>
                        <div class="col-md-4"><label class="form-label">Postal Code</label><input class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" data-label="Postal Code" data-error="Please enter postal code." pattern="^[A-Za-z0-9\\s-]+$" required maxlength="20" placeholder="Enter postal code" value="{{ old('postal_code', $general->postal_code ?? '') }}"><small class="field-error text-danger" data-error-for="postal_code">@error('postal_code'){{ $message }}@enderror</small></div>
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button type="submit" class="btn btn-success btn-sm">Save Basic Info</button></div>
                </form>
            @else
                <div class="details-grid">
                    <div class="detail-item"><span class="detail-label">Accreditation Scheme:</span><span class="detail-value">{{ $general->scheme ?? '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">CAB Name:</span><span class="detail-value">{{ $general->cab_name ?? '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Address of Laboratory:</span><span class="detail-value">{{ $general->address ?? '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Telephone:</span><span class="detail-value">{{ $general->telephone ?? '-' }}</span></div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">
                            @if(!empty($general->email))
                                <a href="mailto:{{ $general->email }}">{{ $general->email }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="detail-item"><span class="detail-label">NTN/FTN:</span><span class="detail-value">{{ $general->ntn_ftn ?? '-' }}</span></div>
                    <div class="detail-item">
                        <span class="detail-label">Website:</span>
                        <span class="detail-value">
                            @if(!empty($general->website))
                                <a href="{{ \Illuminate\Support\Str::startsWith($general->website, ['http://', 'https://']) ? $general->website : 'https://' . $general->website }}" target="_blank" rel="noopener noreferrer">{{ $general->website }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="detail-item"><span class="detail-label">City:</span><span class="detail-value">{{ $general->city ?? '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Country:</span><span class="detail-value">{{ $general->country ?? '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Postal Code:</span><span class="detail-value">{{ $general->postal_code ?? '-' }}</span></div>
                </div>
                <div class="d-flex justify-content-end mt-3"><a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'basic_info']) }}" class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        @php $aboutSaved = $isSectionSaved('about_yourself'); $editingAbout = $sectionShouldEdit('about_yourself', $aboutSaved); @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="1" data-section="about_yourself" data-open="{{ $openSection === 'about_yourself' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div><h5 class="mb-1">Step 1: About Yourselves</h5><p class="text-muted mb-0">Part 1 - About yourselves</p></div>
                <span class="badge {{ $aboutSaved ? 'bg-success' : 'bg-warning text-dark' }}" id="status-step-1">{{ $aboutSaved ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if($editingAbout)
            <form method="POST" class="js-card-form" novalidate action="{{ route('application.saveAboutYourself', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                @csrf
                <input type="hidden" name="section" value="about_yourself">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Title</label><input class="form-control @error('selves_title') is-invalid @enderror" name="selves_title" required maxlength="100" placeholder="Mr / Ms / Dr" value="{{ old('selves_title', $labApplication->selves_title) }}"><small class="field-error text-danger">@error('selves_title'){{ $message }}@enderror</small></div>
                    <div class="col-md-4"><label class="form-label">Name</label><input class="form-control @error('selves_name') is-invalid @enderror" name="selves_name" required maxlength="255" placeholder="Enter full name" value="{{ old('selves_name', $labApplication->selves_name) }}"><small class="field-error text-danger">@error('selves_name'){{ $message }}@enderror</small></div>
                    <div class="col-md-4"><label class="form-label">Position</label><input class="form-control @error('selves_position') is-invalid @enderror" name="selves_position" required maxlength="255" placeholder="Enter position/designation" value="{{ old('selves_position', $labApplication->selves_position) }}"><small class="field-error text-danger">@error('selves_position'){{ $message }}@enderror</small></div>
                    <div class="col-md-6"><label class="form-label">Parent Organization</label><input class="form-control @error('selves_parent_organization') is-invalid @enderror" name="selves_parent_organization" required maxlength="255" placeholder="Enter parent organization" value="{{ old('selves_parent_organization', $labApplication->selves_parent_organization) }}"><small class="field-error text-danger">@error('selves_parent_organization'){{ $message }}@enderror</small></div>
                    <div class="col-md-6"><label class="form-label">Relationship</label><input class="form-control @error('selves_relationship') is-invalid @enderror" name="selves_relationship" required maxlength="255" placeholder="Describe relationship with parent organization" value="{{ old('selves_relationship', $labApplication->selves_relationship) }}"><small class="field-error text-danger">@error('selves_relationship'){{ $message }}@enderror</small></div>
                    <div class="col-12"><label class="form-label">Address</label><textarea class="form-control @error('selves_address') is-invalid @enderror" name="selves_address" required rows="2" placeholder="Enter address">{{ old('selves_address', $labApplication->selves_address) }}</textarea><small class="field-error text-danger">@error('selves_address'){{ $message }}@enderror</small></div>
                    <div class="col-md-4"><label class="form-label">Postcode</label><input class="form-control @error('selves_postcode') is-invalid @enderror" name="selves_postcode" required maxlength="100" placeholder="Enter postcode" value="{{ old('selves_postcode', $labApplication->selves_postcode) }}"><small class="field-error text-danger">@error('selves_postcode'){{ $message }}@enderror</small></div>
                    <div class="col-md-4"><label class="form-label">Telephone</label><input type="tel" class="form-control @error('selves_tel') is-invalid @enderror" name="selves_tel" pattern="^[0-9+\\-\\s]+$" required maxlength="100" placeholder="e.g. +92-300-1234567" value="{{ old('selves_tel', $labApplication->selves_tel) }}"><small class="field-error text-danger">@error('selves_tel'){{ $message }}@enderror</small></div>
                    <div class="col-md-4"><label class="form-label">Fax</label><input type="tel" class="form-control @error('selves_fax') is-invalid @enderror" name="selves_fax" pattern="^[0-9+\\-\\s]+$" required maxlength="100" placeholder="Enter fax number" value="{{ old('selves_fax', $labApplication->selves_fax) }}"><small class="field-error text-danger">@error('selves_fax'){{ $message }}@enderror</small></div>
                    <div class="col-12">
                        <label class="form-label">Ownership Type</label>
                        <select class="form-select" name="ownership_type">
                            <option value="">Select</option>
                            <option value="Owned by an individual" @selected(old('ownership_type', $isOwnershipSelected('selves_individual') ? 'Owned by an individual' : '') === 'Owned by an individual')>Owned by an individual</option>
                            <option value="Owned by public limited company" @selected(old('ownership_type', $isOwnershipSelected('selves_public') ? 'Owned by public limited company' : '') === 'Owned by public limited company')>Owned by public limited company</option>
                            <option value="Owned by a private company / partnership" @selected(old('ownership_type', $isOwnershipSelected('selves_private') ? 'Owned by a private company / partnership' : '') === 'Owned by a private company / partnership')>Owned by a private company / partnership</option>
                            <option value="Part of learned / technical institution" @selected(old('ownership_type', $isOwnershipSelected('selves_learned') ? 'Part of learned / technical institution' : '') === 'Part of learned / technical institution')>Part of learned / technical institution</option>
                            <option value="Owned by a public body / nationalised industry" @selected(old('ownership_type', $isOwnershipSelected('selves_industry') ? 'Owned by a public body / nationalised industry' : '') === 'Owned by a public body / nationalised industry')>Owned by a public body / nationalised industry</option>
                            <option value="Part of an academic institution" @selected(old('ownership_type', $isOwnershipSelected('selves_academic') ? 'Part of an academic institution' : '') === 'Part of an academic institution')>Part of an academic institution</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-12"><label class="form-label">Other ownership description</label><textarea class="form-control @error('selves_other_describe') is-invalid @enderror" name="selves_other_describe" required rows="2" placeholder="If Other, please describe">{{ old('selves_other_describe', $labApplication->selves_other_describe) }}</textarea><small class="field-error text-danger">@error('selves_other_describe'){{ $message }}@enderror</small></div>
                    <div class="col-md-6"><label class="form-label">Parent Main Activity</label><select class="form-select @error('parent_main_activity') is-invalid @enderror" name="parent_main_activity" required><option value="">Select main activity</option><option value="yes" @selected(old('parent_main_activity', $labApplication->selves_with_parent) === 'yes')>Yes</option><option value="no" @selected(old('parent_main_activity', $labApplication->selves_with_parent) === 'no')>No</option></select><small class="field-error text-danger">@error('parent_main_activity'){{ $message }}@enderror</small></div>
                    <div class="col-md-6"><label class="form-label">Activities Description</label><textarea class="form-control @error('selves_activities') is-invalid @enderror" name="selves_activities" required rows="2" placeholder="Describe activities">{{ old('selves_activities', $labApplication->selves_activities) }}</textarea><small class="field-error text-danger">@error('selves_activities'){{ $message }}@enderror</small></div>
                </div>
                <div class="d-flex justify-content-end mt-3"><button type="submit" class="btn btn-success btn-sm">Save About Yourselves</button></div>
            </form>
            @else
                <div class="details-grid">
                    <div class="detail-item"><span class="detail-label">Title:</span><span class="detail-value">{{ $labApplication->selves_title ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Name:</span><span class="detail-value">{{ $labApplication->selves_name ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Position:</span><span class="detail-value">{{ $labApplication->selves_position ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Parent Organization:</span><span class="detail-value">{{ $labApplication->selves_parent_organization ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Relationship:</span><span class="detail-value">{{ $labApplication->selves_relationship ?: '-' }}</span></div>
                </div>
                <div class="d-flex justify-content-end mt-3"><a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'about_yourself']) }}" class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        @php
            $schemeName = urldecode(request()->query('scheme_name', ''));
            $cards = [
                ['key' => 'about_staff', 'title' => 'About Your Staff', 'subtitle' => 'Technical management and quality manager details.', 'fields' => [['staff_name','Staff Name'],['staff_qualifications','Qualifications'],['staff_experience','Relevant Experience'],['staff_quality_name','Quality Manager Name'],['staff_quality_qualifications','Quality Manager Qualifications'],['staff_quality_experience','Quality Manager Experience']], 'route' => 'application.saveAboutStaff'],
                ['key' => 'calibration_scope', 'title' => 'Scope of Application - Calibration', 'subtitle' => 'Field of measurement and calibration scope rows.', 'fields' => [['scop_calib_measurement','Field of Measurement'],['scop_calib_range','Range'],['scop_calib_expanded','Expanded Uncertainty'],['scop_calib_technique','Technique / Equipment']], 'route' => 'application.saveCalibrationScope'],
                ['key' => 'testing_scope', 'title' => 'Scope of Application - Testing', 'subtitle' => 'Testing scope and major equipment records.', 'fields' => [['scop_materials','Materials / Products Tested'],['scop_types','Types of Test'],['scop_range','Range'],['scop_detection','Minimum Detection Limit'],['scop_uncertainty','Uncertainty'],['scop_standard','Standard / Techniques'],['scop_description','Equipment Description'],['scop_working','Working Range'],['scop_limit','Limit']], 'route' => 'application.saveTestingScope'],
                ['key' => 'calibration_facility', 'title' => 'Calibration Facility', 'subtitle' => 'Facility readiness and compliance checks.', 'fields' => [['calibration_fully','Calibration Program Exists'],['calibration_fully_comment','Calibration Program Comment'],['calibration_record','Records Maintained'],['calibration_record_comment','Records Comment'],['calibration_adequate','Adequate Facilities'],['calibration_adequate_comment','Facilities Comment'],['calibration_procedures','Documented Procedures'],['calibration_procedures_comment','Procedures Comment'],['calibration_internal','Internal Traceability'],['calibration_internal_comment','Internal Traceability Comment'],['calibration_pnac','PNAC Traceability'],['calibration_pnac_comment','PNAC Traceability Comment'],['calibration_other_comment','Other Bodies Traceability'],['calibration_lab_comment','PT Participation'],['calibration_compliance','ISO/IEC 17025 Compliance'],['calibration_rectified','Rectified By Date']], 'route' => 'application.saveCalibrationFacility'],
                ['key' => 'other_approvals', 'title' => 'Other Approvals', 'subtitle' => 'Current approvals and validity.', 'fields' => [['approvals_name','Approval Body Name'],['approvals_scope','Scope'],['approvals_start_date','Start Date'],['approvals_end_date','Expiry Date']], 'route' => 'application.saveOtherApprovals'],
                ['key' => 'declaration', 'title' => 'Declaration', 'subtitle' => 'Applicant declaration and accreditation selection.', 'fields' => [['declaration_calibration','Calibration'],['declaration_testing','Testing'],['declaration_extension','Extension'],['declaration_laboratory','Laboratory'],['declaration_test_lab','Test Lab'],['signed','Signed By'],['date','Date']], 'route' => 'application.saveDeclaration'],
            ];

            if ($schemeName === 'Testing') {
                $cards = array_values(array_filter($cards, fn ($card) => $card['key'] !== 'calibration_scope'));
            } elseif ($schemeName === 'Calibration') {
                $cards = array_values(array_filter($cards, fn ($card) => $card['key'] !== 'testing_scope'));
            }
        @endphp

        @foreach($cards as $index => $card)
            @php
                $saved = $isSectionSaved($card['key']);
                $editing = $sectionShouldEdit($card['key'], $saved);
            @endphp
            <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="{{ $index + 2 }}" data-section="{{ $card['key'] }}" data-open="{{ $openSection === $card['key'] ? '1' : '0' }}">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div><h5 class="mb-1">Step {{ $index + 2 }}: {{ $card['title'] }}</h5><p class="text-muted mb-0">{{ $card['subtitle'] }}</p></div>
                    <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">{{ $saved ? 'Saved' : 'Unsaved' }}</span>
                </div>

                @if($editing)
                    <form method="POST" class="js-card-form" novalidate action="{{ route($card['route'], ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                        @csrf
                        <input type="hidden" name="section" value="{{ $card['key'] }}">
                        <div class="row g-3">
                            @foreach($card['fields'] as [$fieldName, $fieldLabel])
                                <div class="col-md-6">
                                    <label class="form-label">{{ $fieldLabel }}</label>
                                    @php
                                        $inputType = 'text';
                                        if (str_contains($fieldName, 'date')) {
                                            $inputType = 'date';
                                        } elseif ($fieldName === 'calibration_rectified') {
                                            $inputType = 'date';
                                        } elseif (str_contains($fieldName, 'email')) {
                                            $inputType = 'email';
                                        } elseif (str_contains($fieldName, 'tel') || str_contains($fieldName, 'phone') || str_contains($fieldName, 'fax')) {
                                            $inputType = 'tel';
                                        } elseif (str_contains($fieldName, 'website') || str_contains($fieldName, 'url')) {
                                            $inputType = 'url';
                                        } elseif (str_contains($fieldName, 'time')) {
                                            $inputType = 'time';
                                        }

                                        $useTextarea = str_contains($fieldName, 'comment')
                                            || str_contains($fieldName, 'description')
                                            || str_contains($fieldName, 'scope')
                                            || str_contains($fieldName, 'materials')
                                            || str_contains($fieldName, 'standard')
                                            || str_contains($fieldName, 'technique')
                                            || str_contains($fieldName, 'laboratory')
                                            || str_contains($fieldName, 'extension');
                                    @endphp
                                    @if($useTextarea)
                                        <textarea class="form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}" required data-label="{{ $fieldLabel }}" data-error="Please enter {{ strtolower($fieldLabel) }}." rows="2" placeholder="Enter {{ strtolower($fieldLabel) }}">{{ old($fieldName, $labApplication->{$fieldName}) }}</textarea>
                                    @else
                                        <input type="{{ $inputType }}" class="form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}" required data-label="{{ $fieldLabel }}" data-error="Please enter {{ strtolower($fieldLabel) }}." placeholder="Enter {{ strtolower($fieldLabel) }}" value="{{ old($fieldName, $labApplication->{$fieldName}) }}">
                                    @endif
                                    <small class="field-error text-danger" data-error-for="{{ $fieldName }}">@error($fieldName){{ $message }}@enderror</small>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end mt-3"><button type="submit" class="btn btn-success btn-sm">Save</button></div>
                    </form>
                @else
                    <div class="details-grid">
                        @foreach($card['fields'] as [$fieldName, $fieldLabel])
                            <div class="detail-item">
                                <span class="detail-label">{{ $fieldLabel }}:</span>
                                <span class="detail-value">{{ $labApplication->{$fieldName} ?: '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end mt-3"><a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => $card['key']]) }}" class="btn btn-outline-success btn-sm">Edit</a></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
