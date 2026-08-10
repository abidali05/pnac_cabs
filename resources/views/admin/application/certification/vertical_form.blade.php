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

        // Helpers to load dynamic form schema from $form
        $formSchema =
            isset($form) && $form->form_schema
                ? (is_array($form->form_schema)
                    ? $form->form_schema
                    : json_decode($form->form_schema, true))
                : null;

        $getSectionTitle = function (int $sectionIndex, string $defaultTitle) use ($formSchema) {
            return $formSchema['sections'][$sectionIndex]['title'] ?? $defaultTitle;
        };

        $getFieldLabel = function (int $sectionIndex, int $fieldIndex, string $defaultLabel) use ($formSchema) {
            return $formSchema['sections'][$sectionIndex]['fields'][$fieldIndex]['label'] ?? $defaultLabel;
        };

        $getFieldName = function (int $sectionIndex, int $fieldIndex, string $defaultName) use ($formSchema) {
            return $formSchema['sections'][$sectionIndex]['fields'][$fieldIndex]['name'] ?? $defaultName;
        };

        $getFieldType = function (int $sectionIndex, int $fieldIndex, string $defaultType) use ($formSchema) {
            return $formSchema['sections'][$sectionIndex]['fields'][$fieldIndex]['type'] ?? $defaultType;
        };

        $basicInfoSection = [
            'title' => $getSectionTitle(0, 'Basic Application / Laboratory Information'),
            'fields' => [
                0 => [
                    'label' => $getFieldLabel(0, 0, 'Organization'),
                    'name' => $getFieldName(0, 0, 'organisation'),
                    'type' => $getFieldType(0, 0, 'text'),
                ],
            ],
        ];

        // Build a section-title lookup by matching section index from JSON.
        $findSectionIndex = function(array $keywords, int $defaultIndex) use ($formSchema) {
            if (!$formSchema || !isset($formSchema['sections'])) {
                return $defaultIndex;
            }
            foreach ($formSchema['sections'] as $index => $sec) {
                if (isset($sec['title'])) {
                    foreach ($keywords as $keyword) {
                        if (stripos($sec['title'], $keyword) !== false) {
                            return $index;
                        }
                    }
                }
            }
            return $defaultIndex;
        };

        $basicInfoIndex = $findSectionIndex(['basic', 'laboratory information'], 0);
        $aboutYourselfIndex = $findSectionIndex(['about yourself', 'about yourselves'], 1);
        $aboutStaffIndex = $findSectionIndex(['about your staff', 'staff information'], 2);
        
        $calibScopeIndex = $findSectionIndex(['scope of application - calibration', 'calibration scope'], 3);
        $testingScopeIndex = $findSectionIndex(['scope of application - testing', 'testing scope'], 4);
        
        $ptpScopeIndex = $findSectionIndex(['proficiency testing provider', 'ptp'], 3);
        $pcbScopeIndex = $findSectionIndex(['product certification', 'pcb'], 3);
        $personnelScopeIndex = $findSectionIndex(['personnel certification', 'personnel scope'], 3);
        
        $calibFacilityIndex = $findSectionIndex(['calibration facility', 'facility form'], 5);
        $otherApprovalsIndex = $findSectionIndex(['other approvals'], 6);
        $declarationIndex = $findSectionIndex(['declaration'], 7);

        $aboutYourselfSection = [
            'title' => $getSectionTitle($aboutYourselfIndex, 'About Yourselves'),
        ];

        $aboutStaffSection = [
            'title' => $getSectionTitle($aboutStaffIndex, 'About Your Staff'),
        ];

        $calibScopeSection = [
            'title' => $getSectionTitle($calibScopeIndex, 'Scope of Application - Calibration'),
        ];

        $testingScopeSection = [
            'title' => $getSectionTitle($testingScopeIndex, 'Scope of Application - Testing'),
        ];

        $ptpScopeSection = [
            'title' => $getSectionTitle($ptpScopeIndex, 'Scope of Proficiency Testing Provider'),
        ];

        $pcbScopeSection = [
            'title' => $getSectionTitle($pcbScopeIndex, 'Scope of Product Certification Body (PCB)'),
        ];

        $personnelScopeSection = [
            'title' => $getSectionTitle($personnelScopeIndex, 'Scope of Personnel Certification – Categories'),
        ];

        $calibFacilitySection = [
            'title' => $getSectionTitle($calibFacilityIndex, 'Calibration Facility'),
        ];

        $otherApprovalsSection = [
            'title' => $getSectionTitle($otherApprovalsIndex, 'Other Approvals'),
        ];

        $declarationSection = [
            'title' => $getSectionTitle($declarationIndex, 'Declaration'),
        ];
    @endphp
    {{-- @php
        $calibrationRows = json_decode($labApplication->scop_calib_field ?? '[]', true);

    @endphp --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h4 class="mb-0 text-success">Application For
            {{ urldecode(request()->query('scheme_name') ?: 'Laboratory Accreditation') }}</h4>
        <span class="badge bg-success">{{ urldecode(request()->query('scheme_name')) }}</span>
    </div>
    <div id="pnacVerticalForm" class="w-100">
        @php
            $basicSaved = $isSectionSaved('basic_info');
            $editingBasic = $sectionShouldEdit('basic_info', $basicSaved);
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white w-100 pnac-basic-card" data-section="basic_info"
            data-open="{{ $openSection === 'basic_info' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">{{ $basicInfoSection['title'] }}</h5>
                    <p class="text-muted mb-0">General application details captured before Part 1.</p>
                </div>
                <span class="badge {{ $basicSaved ? 'bg-success' : 'bg-warning text-dark' }}"
                    id="status-basic">{{ $basicSaved ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($editingBasic)
                <form method="POST" class="js-card-form" novalidate
                    action="{{ route('application.saveBasicInfo', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">

                    @csrf
                    <input type="hidden" name="section" value="basic_info">
                    <div class="row g-3">
                        <div class="col-md-4"><label
                                class="form-label">{{ $basicInfoSection['fields'][0]['label'] }}</label><input
                                class="form-control @error($basicInfoSection['fields'][0]['name']) is-invalid @enderror"
                                name="{{ $basicInfoSection['fields'][0]['name'] }}"
                                type="{{ $basicInfoSection['fields'][0]['type'] }}"
                                data-label="{{ $basicInfoSection['fields'][0]['label'] }}"
                                data-error="Please enter {{ strtolower($basicInfoSection['fields'][0]['label']) }}."
                                required maxlength="255"
                                placeholder="Enter {{ strtolower($basicInfoSection['fields'][0]['label']) }}"
                                value="{{ old($basicInfoSection['fields'][0]['name'], $labApplication->certificationGeneral?->scheme) }}"><small
                                class="field-error text-danger"
                                data-error-for="{{ $basicInfoSection['fields'][0]['name'] }}">
                                @error($basicInfoSection['fields'][0]['name'])
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 1, 'CAB Name') }}</label><input
                                class="form-control @error('cab_name') is-invalid @enderror" name="cab_name"
                                data-label="{{ $getFieldLabel(0, 1, 'CAB Name') }}" data-error="Please enter CAB name." required maxlength="255"
                                placeholder="Enter CAB name"
                                value="{{ old('cab_name', $labApplication->certificationGeneral?->cab_name) }}"><small
                                class="field-error text-danger" data-error-for="cab_name">
                                @error('cab_name')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 2, 'Address of Laboratory') }}</label>
                            <textarea class="form-control @error('address_laboratory') is-invalid @enderror" name="address_laboratory"
                                data-label="{{ $getFieldLabel(0, 2, 'Address of Laboratory') }}" data-error="Please enter laboratory address." required maxlength="1000"
                                rows="2" placeholder="Enter complete laboratory address">{{ old('address_laboratory', $labApplication->certificationGeneral?->address) }}</textarea><small class="field-error text-danger"
                                data-error-for="address_laboratory">
                                @error('address_laboratory')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 3, 'Telephone') }}</label><input type="tel"
                                class="form-control @error('tel') is-invalid @enderror" name="tel"
                                data-label="{{ $getFieldLabel(0, 3, 'Telephone') }}" data-error="Please enter telephone number."
                                data-error-type="Please enter a valid telephone number." pattern="^[0-9+\-\s]+$"
                                required minlength="7" maxlength="30" placeholder="e.g. +92-300-1234567"
                                value="{{ old('tel', $labApplication->certificationGeneral?->telephone) }}"><small
                                class="field-error text-danger" data-error-for="tel">
                                @error('tel')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 4, 'Email') }}</label><input type="email"
                                class="form-control @error('person_email') is-invalid @enderror" name="person_email"
                                data-label="{{ $getFieldLabel(0, 4, 'Email') }}" data-error="Please enter email address."
                                data-error-type="Please enter a valid email address." required maxlength="255"
                                placeholder="e.g. info@example.com"
                                value="{{ old('person_email', $labApplication->certificationGeneral?->email) }}"><small
                                class="field-error text-danger" data-error-for="person_email">
                                @error('person_email')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 5, 'NTN/FTN') }}</label><input
                                class="form-control @error('ntn_ftn') is-invalid @enderror" name="ntn_ftn"
                                data-label="{{ $getFieldLabel(0, 5, 'NTN/FTN') }}" data-error="Please enter NTN/FTN." pattern="^[A-Za-z0-9\\-/]+$"
                                required maxlength="100" placeholder="Enter NTN/FTN number"
                                value="{{ old('ntn_ftn', $labApplication->certificationGeneral?->ntn_ftn) }}"><small
                                class="field-error text-danger" data-error-for="ntn_ftn">
                                @error('ntn_ftn')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 6, 'Website') }}</label><input type="url"
                                class="form-control @error('website') is-invalid @enderror" name="website"
                                data-label="{{ $getFieldLabel(0, 6, 'Website') }}" data-error="Please enter website URL."
                                data-error-type="Please enter a valid website URL." required maxlength="255"
                                placeholder="e.g. https://example.com"
                                value="{{ old('website', $labApplication->certificationGeneral?->website) }}"><small
                                class="field-error text-danger" data-error-for="website">
                                @error('website')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 7, 'City') }}</label><input
                                class="form-control @error('city') is-invalid @enderror" name="city"
                                data-label="{{ $getFieldLabel(0, 7, 'City') }}" data-error="Please enter city." required maxlength="255"
                                placeholder="Enter city"
                                value="{{ old('city', $labApplication->certificationGeneral?->city) }}"><small
                                class="field-error text-danger" data-error-for="city">
                                @error('city')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 8, 'Country') }}</label><input
                                class="form-control @error('country') is-invalid @enderror" name="country"
                                data-label="{{ $getFieldLabel(0, 8, 'Country') }}" data-error="Please enter country." required maxlength="255"
                                placeholder="Enter country"
                                value="{{ old('country', $labApplication->certificationGeneral?->country) }}"><small
                                class="field-error text-danger" data-error-for="country">
                                @error('country')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(0, 9, 'Postal Code') }}</label><input
                                class="form-control @error('postcode') is-invalid @enderror" name="postcode"
                                data-label="{{ $getFieldLabel(0, 9, 'Postal Code') }}" data-error="Please enter postal code."
                                pattern="^[A-Za-z0-9\\s-]+$" required maxlength="20" placeholder="Enter postal code"
                                value="{{ old('postcode', $labApplication->certificationGeneral?->postal_code) }}"><small
                                class="field-error text-danger" data-error-for="postcode">
                                @error('postcode')
                                    {{ $message }}
                                @enderror
                            </small></div>
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button type="submit"
                            class="btn btn-success btn-sm">Save Basic Info</button></div>
                </form>
            @else
                <div class="details-grid">
                    <div class="detail-item"><span
                            class="detail-label">{{ $basicInfoSection['fields'][0]['label'] }}:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->scheme ?: '-' }}</span>
                    </div>
                    <div class="detail-item"><span class="detail-label">CAB Name:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->cab_name ?: '-' }}</span>
                    </div>
                    <div class="detail-item"><span class="detail-label">Address of Laboratory:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->address ?: '-' }}</span>
                    </div>
                    <div class="detail-item"><span class="detail-label">Telephone:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->telephone ?: '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">
                            @if (!empty($labApplication->certificationGeneral->email))
                                <a
                                    href="mailto:{{ $labApplication->certificationGeneral->email }}">{{ $labApplication->certificationGeneral->email }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="detail-item"><span class="detail-label">NTN/FTN:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->ntn_ftn ?: '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Website:</span>
                        <span class="detail-value">
                            @if (!empty($labApplication->certificationGeneral->website))
                                <a href="{{ \Illuminate\Support\Str::startsWith($labApplication->certificationGeneral->website, ['http://', 'https://']) ? $labApplication->certificationGeneral->website : 'https://' . $labApplication->certificationGeneral->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer">{{ $labApplication->certificationGeneral->website }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="detail-item"><span class="detail-label">City:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->city ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Country:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->country ?: '-' }}</span>
                    </div>
                    <div class="detail-item"><span class="detail-label">Postal Code:</span><span
                            class="detail-value">{{ $labApplication->certificationGeneral->postal_code ?: '-' }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3"><a
                        href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'basic_info']) }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>
        @php
            $aboutSaved = $isSectionSaved('about_yourself');
            $editingAbout = $sectionShouldEdit('about_yourself', $aboutSaved);
        @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="1"
            data-section="about_yourself" data-open="{{ $openSection === 'about_yourself' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Step 1: {{ $aboutYourselfSection['title'] }}</h5>
                    <p class="text-muted mb-0">Part 1 - About yourselves</p>
                </div>
                <span class="badge {{ $aboutSaved ? 'bg-success' : 'bg-warning text-dark' }}"
                    id="status-step-1">{{ $aboutSaved ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if ($editingAbout)
                <form method="POST" class="js-card-form" novalidate
                    action="{{ route('application.saveAboutYourself', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                    @csrf
                    <input type="hidden" name="section" value="about_yourself">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(1, 0, 'Title') }}</label><input
                                class="form-control @error('selves_title') is-invalid @enderror" name="selves_title"
                                required maxlength="100" placeholder="Mr / Ms / Dr"
                                value="{{ old('selves_title', $labApplication->selves_title) }}"><small
                                class="field-error text-danger">
                                @error('selves_title')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(1, 1, 'Name') }}</label><input
                                class="form-control @error('selves_name') is-invalid @enderror" name="selves_name"
                                required maxlength="255" placeholder="Enter full name"
                                value="{{ old('selves_name', $labApplication->selves_name) }}"><small
                                class="field-error text-danger">
                                @error('selves_name')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(1, 2, 'Position') }}</label><input
                                class="form-control @error('selves_position') is-invalid @enderror"
                                name="selves_position" required maxlength="255"
                                placeholder="Enter position/designation"
                                value="{{ old('selves_position', $labApplication->selves_position) }}"><small
                                class="field-error text-danger">
                                @error('selves_position')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-6"><label class="form-label">{{ $getFieldLabel(1, 3, 'Parent Organization') }}</label><input
                                class="form-control @error('selves_parent_organization') is-invalid @enderror"
                                name="selves_parent_organization" required maxlength="255"
                                placeholder="Enter parent organization"
                                value="{{ old('selves_parent_organization', $labApplication->selves_parent_organization) }}"><small
                                class="field-error text-danger">
                                @error('selves_parent_organization')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-6"><label class="form-label">{{ $getFieldLabel(1, 4, 'Relationship') }}</label><input
                                class="form-control @error('selves_relationship') is-invalid @enderror"
                                name="selves_relationship" required maxlength="255"
                                placeholder="Describe relationship with parent organization"
                                value="{{ old('selves_relationship', $labApplication->selves_relationship) }}"><small
                                class="field-error text-danger">
                                @error('selves_relationship')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-12"><label class="form-label">{{ $getFieldLabel(1, 5, 'Address') }}</label>
                            <textarea class="form-control @error('selves_address') is-invalid @enderror" name="selves_address" required
                                rows="2" placeholder="Enter address">{{ old('selves_address', $labApplication->selves_address) }}</textarea><small class="field-error text-danger">
                                @error('selves_address')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(1, 6, 'Postcode') }}</label><input
                                class="form-control @error('selves_postcode') is-invalid @enderror"
                                name="selves_postcode" required maxlength="100" placeholder="Enter postcode"
                                value="{{ old('selves_postcode', $labApplication->selves_postcode) }}"><small
                                class="field-error text-danger">
                                @error('selves_postcode')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(1, 7, 'Telephone') }}</label><input type="tel"
                                class="form-control @error('selves_tel') is-invalid @enderror" name="selves_tel"
                                pattern="^[0-9+\\-\\s]+$" required maxlength="100" placeholder="e.g. +92-300-1234567"
                                value="{{ old('selves_tel', $labApplication->selves_tel) }}"><small
                                class="field-error text-danger">
                                @error('selves_tel')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-4"><label class="form-label">{{ $getFieldLabel(1, 8, 'Fax') }}</label><input type="tel"
                                class="form-control @error('selves_fax') is-invalid @enderror" name="selves_fax"
                                pattern="^[0-9+\\-\\s]+$" required maxlength="100" placeholder="Enter fax number"
                                value="{{ old('selves_fax', $labApplication->selves_fax) }}"><small
                                class="field-error text-danger">
                                @error('selves_fax')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-12">
                            <label class="form-label">{{ $getFieldLabel(1, 9, 'Ownership Type') }}</label>
                            <select class="form-select" name="ownership_type">
                                <option value="">Select</option>
                                <option value="Owned by an individual" @selected(old('ownership_type', $isOwnershipSelected('selves_individual') ? 'Owned by an individual' : '') === 'Owned by an individual')>Owned by an
                                    individual</option>
                                <option value="Owned by public limited company" @selected(old('ownership_type', $isOwnershipSelected('selves_public') ? 'Owned by public limited company' : '') === 'Owned by public limited company')>Owned by
                                    public limited company</option>
                                <option value="Owned by a private company / partnership" @selected(old('ownership_type', $isOwnershipSelected('selves_private') ? 'Owned by a private company / partnership' : '') === 'Owned by a private company / partnership')>
                                    Owned by a private company / partnership</option>
                                <option value="Part of learned / technical institution" @selected(old('ownership_type', $isOwnershipSelected('selves_learned') ? 'Part of learned / technical institution' : '') === 'Part of learned / technical institution')>
                                    Part of learned / technical institution</option>
                                <option value="Owned by a public body / nationalised industry"
                                    @selected(old('ownership_type', $isOwnershipSelected('selves_industry') ? 'Owned by a public body / nationalised industry' : '') === 'Owned by a public body / nationalised industry')>Owned by a public body / nationalised industry</option>
                                <option value="Part of an academic institution" @selected(old('ownership_type', $isOwnershipSelected('selves_academic') ? 'Part of an academic institution' : '') === 'Part of an academic institution')>Part of an
                                    academic institution</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-12"><label class="form-label">{{ $getFieldLabel(1, 10, 'Other ownership description') }}</label>
                            <textarea class="form-control @error('selves_other_describe') is-invalid @enderror" name="selves_other_describe"
                                required rows="2" placeholder="If Other, please describe">{{ old('selves_other_describe', $labApplication->selves_other_describe) }}</textarea><small class="field-error text-danger">
                                @error('selves_other_describe')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-md-6"><label class="form-label">{{ $getFieldLabel(1, 11, 'Parent Main Activity') }}</label><select
                                class="form-select @error('parent_main_activity') is-invalid @enderror"
                                name="parent_main_activity" required>
                                <option value="">Select main activity</option>
                                <option value="yes" @selected(old('parent_main_activity', $labApplication->selves_with_parent) === 'yes')>Yes</option>
                                <option value="no" @selected(old('parent_main_activity', $labApplication->selves_with_parent) === 'no')>No</option>
                            </select><small class="field-error text-danger">
                                @error('parent_main_activity')
                                    {{ $message }}
                                @enderror
                            </small></div>
                        <div class="col-md-6"><label class="form-label">{{ $getFieldLabel(1, 12, 'Activities Description') }}</label>
                            <textarea class="form-control @error('selves_activities') is-invalid @enderror" name="selves_activities" required
                                rows="2" placeholder="Describe activities">{{ old('selves_activities', $labApplication->selves_activities) }}</textarea><small class="field-error text-danger">
                                @error('selves_activities')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button type="submit"
                            class="btn btn-success btn-sm">Save About Yourselves</button></div>
                </form>
            @else
                <div class="details-grid">
                    <div class="detail-item"><span class="detail-label">Title:</span><span
                            class="detail-value">{{ $labApplication->selves_title ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Name:</span><span
                            class="detail-value">{{ $labApplication->selves_name ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Position:</span><span
                            class="detail-value">{{ $labApplication->selves_position ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Parent Organization:</span><span
                            class="detail-value">{{ $labApplication->selves_parent_organization ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Relationship:</span><span
                            class="detail-value">{{ $labApplication->selves_relationship ?: '-' }}</span></div>
                </div>
                <div class="d-flex justify-content-end mt-3"><a
                        href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'about_yourself']) }}"
                        class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>
        @php
            $schemeName = urldecode(request()->query('scheme_name', ''));
            $cards = [
                'about_staff' => [
                    'title' => $aboutStaffSection['title'],
                    'subtitle' => 'Technical management and quality manager details.',
                    'fields' => [
                        ['staff_name',                 $getFieldLabel($aboutStaffIndex, 0, 'Staff Name')],
                        ['staff_qualifications',       $getFieldLabel($aboutStaffIndex, 1, 'Qualifications')],
                        ['staff_experience',           $getFieldLabel($aboutStaffIndex, 2, 'Relevant Experience')],
                        ['staff_quality_name',         $getFieldLabel($aboutStaffIndex, 3, 'Quality Manager Name')],
                        ['staff_quality_qualifications',$getFieldLabel($aboutStaffIndex, 4, 'Quality Manager Qualifications')],
                        ['staff_quality_experience',   $getFieldLabel($aboutStaffIndex, 5, 'Quality Manager Experience')],
                    ],
                    'route' => 'application.saveAboutStaff',
                ],
                'testing_scope' => [
                    'title' => $testingScopeSection['title'],
                    'subtitle' => 'Testing scope and major equipment records.',
                    'fields' => [
                        ['scop_materials',  $getFieldLabel($testingScopeIndex, 0, 'Materials / Products Tested')],
                        ['scop_types',      $getFieldLabel($testingScopeIndex, 1, 'Types of Test')],
                        ['scop_range',      $getFieldLabel($testingScopeIndex, 2, 'Range')],
                        ['scop_detection',  $getFieldLabel($testingScopeIndex, 3, 'Minimum Detection Limit')],
                        ['scop_uncertainty',$getFieldLabel($testingScopeIndex, 4, 'Uncertainty')],
                        ['scop_standard',   $getFieldLabel($testingScopeIndex, 5, 'Standard / Techniques')],
                        ['scop_description',$getFieldLabel($testingScopeIndex, 6, 'Equipment Description')],
                        ['scop_working',    $getFieldLabel($testingScopeIndex, 7, 'Working Range')],
                        ['scop_limit',      $getFieldLabel($testingScopeIndex, 8, 'Limit')],
                    ],
                    'route' => 'application.saveTestingScope',
                ],
                'other_approvals' => [
                    'title' => $otherApprovalsSection['title'],
                    'subtitle' => 'Current approvals and validity.',
                    'fields' => [
                        ['approvals_name',       $getFieldLabel($otherApprovalsIndex, 0, 'Approval Body Name')],
                        ['approvals_scope',      $getFieldLabel($otherApprovalsIndex, 1, 'Scope')],
                        ['approvals_start_date', $getFieldLabel($otherApprovalsIndex, 2, 'Start Date')],
                        ['approvals_end_date',   $getFieldLabel($otherApprovalsIndex, 3, 'Expiry Date')],
                    ],
                    'route' => 'application.saveOtherApprovals',
                ],
            ];
            $orderedSections = [
                'about_staff',
                'calibration_scope',
                'testing_scope',
                'calibration_facility',
                'other_approvals',
                'declaration',
            ];

            if ($schemeName === 'Calibration') {
                $orderedSections = array_values(array_diff($orderedSections, ['testing_scope', 'calibration_facility']));
            } elseif ($schemeName === 'Testing') {
                $orderedSections = array_values(
                    array_diff($orderedSections, ['calibration_scope', 'calibration_facility']),
                );
            } elseif ($schemeName === 'Proficiency Testing Provider') {
                $orderedSections = ['about_staff', 'ptp_scope', 'other_approvals', 'declaration'];
            } elseif ($schemeName === 'Product Certification Bodies') {
                $orderedSections = ['about_staff', 'pcb_scope', 'other_approvals', 'declaration'];
            } elseif ($schemeName === 'Personnel Certification Bodies') {
                $orderedSections = ['about_staff', 'personnel_scope', 'other_approvals', 'declaration'];
            }
            $stepCounter = 2; // Step 1 is already used by "About Yourselves"
        @endphp
        {{-- Calibration Scope - Dynamic Rows --}}
        @foreach ($orderedSections as $sectionKey)
            @php
                $saved = $isSectionSaved($sectionKey);
                $editing = $sectionShouldEdit($sectionKey, $saved);
                $stepNumber = $stepCounter++;
            @endphp

            @if ($sectionKey === 'calibration_scope')
                {{-- ========================================== --}}
                {{-- Step 3: Calibration Scope (custom)        --}}
                {{-- ========================================== --}}
                @php
                    $calibrationRows = json_decode($labApplication->scop_calib_field ?? '[]', true);
                @endphp
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100"
                    data-section="calibration_scope"
                    data-open="{{ $openSection === 'calibration_scope' ? '1' : '0' }}">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step {{ $stepNumber }}: {{ $calibScopeSection['title'] }}</h5>
                            <p class="text-muted mb-0">Field of measurement and calibration scope rows.</p>
                        </div>
                        <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $saved ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>

                    @if ($editing)
                        <form method="POST"
                            action="{{ route('application.saveCalibrationScope', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                            @csrf
                            <input type="hidden" name="section" value="calibration_scope">
                            <button type="button" class="btn btn-warning btn-sm mb-3" id="addCalibrationRowBtn">
                                + Add Calibration Row
                            </button>
                            <div id="calibrationRowsContainer">
                                @if (!empty($calibrationRows))
                                    @foreach ($calibrationRows as $index => $row)
                                        <div class="border rounded p-3 mb-3 bg-light position-relative"
                                            id="calibRow_{{ $index }}">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                onclick="removeCalibRow('{{ $index }}')">Remove</button>
                                            <div class="mb-2">
                                                <label>Field of Measurement</label>
                                                <textarea name="calibration[{{ $index }}][field]" class="form-control ckeditor">{!! $row['field'] ?? '' !!}</textarea>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-3">
                                                    <label>Measured Quantity</label>
                                                    <textarea name="calibration[{{ $index }}][measurement]" class="form-control ckeditor">{!! $row['measurement'] ?? '' !!}</textarea>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Range</label>
                                                    <textarea name="calibration[{{ $index }}][range]" class="form-control ckeditor">{!! $row['range'] ?? '' !!}</textarea>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Expanded Uncertainty</label>
                                                    <textarea name="calibration[{{ $index }}][expanded]" class="form-control ckeditor">{!! $row['expanded'] ?? '' !!}</textarea>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Technique / Equipment</label>
                                                    <textarea name="calibration[{{ $index }}][technique]" class="form-control ckeditor">{!! $row['technique'] ?? '' !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="border rounded p-3 mb-3 bg-light position-relative" id="calibRow_1">
                                        <div class="mb-2">
                                            <label>Field of Measurement</label>
                                            <textarea name="calibration[1][field]" class="form-control ckeditor"></textarea>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label>Measured Quantity</label>
                                                <textarea name="calibration[1][measurement]" class="form-control ckeditor"></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Range</label>
                                                <textarea name="calibration[1][range]" class="form-control ckeditor"></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Expanded Uncertainty</label>
                                                <textarea name="calibration[1][expanded]" class="form-control ckeditor"></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Technique / Equipment</label>
                                                <textarea name="calibration[1][technique]" class="form-control ckeditor"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-success btn-sm">Save Calibration Scope</button>
                            </div>
                        </form>
                    @else
                        @if (!empty($calibrationRows))
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Measurement</th>
                                        <th>Range</th>
                                        <th>Expanded</th>
                                        <th>Technique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calibrationRows as $row)
                                        <tr>
                                            <td>{!! $row['field'] ?? '-' !!}</td>
                                            <td>{!! $row['measurement'] ?? '-' !!}</td>
                                            <td>{!! $row['range'] ?? '-' !!}</td>
                                            <td>{!! $row['expanded'] ?? '-' !!}</td>
                                            <td>{!! $row['technique'] ?? '-' !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No calibration scope saved yet.</p>
                        @endif
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'calibration_scope']) }}"
                                class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>
            @elseif ($sectionKey === 'ptp_scope')
                @include('admin.application.proficiency_testing_provider.sections.ptp_scope')
            @elseif ($sectionKey === 'pcb_scope')
                @include('admin.application.product_certification_bodies.sections.pcb_scope')
            @elseif ($sectionKey === 'personnel_scope')
                @include('admin.application.personnel_certification_bodies.sections.personnel_scope')
            @elseif ($sectionKey === 'calibration_facility')
                {{-- ========================================== --}}
                {{-- Step 5: Calibration Facility (custom)      --}}
                {{-- ========================================== --}}
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100"
                    data-section="calibration_facility"
                    data-open="{{ $openSection === 'calibration_facility' ? '1' : '0' }}">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step {{ $stepNumber }}: {{ $calibFacilitySection['title'] }}</h5>
                            <p class="text-muted mb-0">Facility readiness and compliance checks.</p>
                        </div>
                        <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $saved ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>

                    @if ($editing)
                        <form method="POST" class="js-card-form" novalidate
                            action="{{ route('application.saveCalibrationFacility', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                            @csrf
                            <input type="hidden" name="section" value="calibration_facility">

                            @php
                                $questions = [
                                    [
                                        'field' => 'calibration_fully',
                                        'comment' => 'calibration_fully_comment',
                                        'label' =>
                                            '1. Does a fully documented calibration program exist to ensure that the accuracy of equipment is adequate for the service operated by the laboratory?',
                                    ],
                                    [
                                        'field' => 'calibration_record',
                                        'comment' => 'calibration_record_comment',
                                        'label' =>
                                            '2. Is a record maintained for test equipment, including calibration results?',
                                    ],
                                    [
                                        'field' => 'calibration_adequate',
                                        'comment' => 'calibration_adequate_comment',
                                        'label' =>
                                            '3. Are adequate facilities and environments provided for calibration, handling, control, storage and maintenance of all measuring equipment?',
                                    ],
                                    [
                                        'field' => 'calibration_procedures',
                                        'comment' => 'calibration_procedures_comment',
                                        'label' =>
                                            '4. Are there documented procedures for calibrating all equipment and reference standards which cover the method of calibration and maximum intervals between calibrations?',
                                    ],
                                    [
                                        'field' => 'calibration_internal',
                                        'comment' => 'calibration_internal_comment',
                                        'label' =>
                                            '5. Are the internal laboratory reference standards, and the calibration of key testing equipment traceable to national standard through:',
                                    ],
                                    [
                                        'field' => 'calibration_pnac',
                                        'comment' => 'calibration_pnac_comment',
                                        'label' => '   - PNAC accredited',
                                    ],
                                    [
                                        'field' => null,
                                        'comment' => 'calibration_other_comment',
                                        'label' => '   - Other bodies (specify)',
                                    ],
                                    [
                                        'field' => null,
                                        'comment' => 'calibration_lab_comment',
                                        'label' =>
                                            '6. Does the lab participate in Proficiency Testing for Calibration activities?',
                                    ],
                                ];
                            @endphp

                            @foreach ($questions as $q)
                                <div class="row g-2 mb-3 align-items-start">
                                    <div class="col-md-7">
                                        <label class="fw-semibold">{{ $q['label'] }}</label>
                                        @if ($q['field'] !== null)
                                            <div class="mt-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ $q['field'] }}" value="yes"
                                                        id="{{ $q['field'] }}_yes"
                                                        @if (old($q['field'], $labApplication->{$q['field']}) === 'yes') checked @endif>
                                                    <label class="form-check-label"
                                                        for="{{ $q['field'] }}_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ $q['field'] }}" value="no"
                                                        id="{{ $q['field'] }}_no"
                                                        @if (old($q['field'], $labApplication->{$q['field']}) === 'no') checked @endif>
                                                    <label class="form-check-label"
                                                        for="{{ $q['field'] }}_no">No</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($q['comment'] !== null)
                                        <div class="col-md-5">
                                            <label class="form-label">Comment / Reference</label>
                                            <textarea name="{{ $q['comment'] }}" class="form-control ckeditor" rows="2">{{ old($q['comment'], $labApplication->{$q['comment']}) }}</textarea>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <hr>
                            <h6 class="fw-bold">Compliance with ISO/IEC 17025 and Accreditation Requirements</h6>

                            <div class="row g-2 mb-3 align-items-start">
                                <div class="col-md-7">
                                    <label class="fw-semibold">1. Do you consider that your laboratory complies with
                                        ISO/IEC 17025 and PNAC accreditation requirements?</label>
                                    <div class="mt-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="calibration_compliance" value="yes" id="compliance_yes"
                                                @if (old('calibration_compliance', $labApplication->calibration_compliance) === 'yes') checked @endif>
                                            <label class="form-check-label" for="compliance_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="calibration_compliance" value="no" id="compliance_no"
                                                @if (old('calibration_compliance', $labApplication->calibration_compliance) === 'no') checked @endif>
                                            <label class="form-check-label" for="compliance_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Comment / Reference</label>
                                    <textarea name="calibration_compliance_comment" class="form-control ckeditor" rows="2">{{ old('calibration_compliance_comment', $labApplication->calibration_compliance_comment ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="row g-2 mb-3 align-items-start">
                                <div class="col-md-7">
                                    <label class="fw-semibold">2. Area of non‑compliance (if "No" above, specify areas
                                        and rectification plan)</label>
                                    <textarea name="calibration_non_compliance" class="form-control ckeditor" rows="2">{{ old('calibration_non_compliance', $labApplication->calibration_non_compliance ?? '') }}</textarea>
                                </div>
                                <div class="col-md-5">
                                    <label class="fw-semibold">Rectified by (date)</label>
                                    <input type="date" name="calibration_rectified" class="form-control"
                                        value="{{ old('calibration_rectified', $labApplication->calibration_rectified) }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success btn-sm">Save Calibration
                                    Facility</button>
                            </div>
                        </form>
                    @else
                        @php
                            $questions = [
                                [
                                    'field' => 'calibration_fully',
                                    'comment' => 'calibration_fully_comment',
                                    'label' => '1. Does a fully documented calibration program exist?',
                                ],
                                [
                                    'field' => 'calibration_record',
                                    'comment' => 'calibration_record_comment',
                                    'label' =>
                                        '2. Is a record maintained for test equipment, including calibration results?',
                                ],
                                [
                                    'field' => 'calibration_adequate',
                                    'comment' => 'calibration_adequate_comment',
                                    'label' => '3. Are adequate facilities and environments provided?',
                                ],
                                [
                                    'field' => 'calibration_procedures',
                                    'comment' => 'calibration_procedures_comment',
                                    'label' =>
                                        '4. Are there documented procedures for calibrating all equipment and reference standards?',
                                ],
                                [
                                    'field' => 'calibration_internal',
                                    'comment' => 'calibration_internal_comment',
                                    'label' => '5a. Internal traceability to national standard?',
                                ],
                                [
                                    'field' => 'calibration_pnac',
                                    'comment' => 'calibration_pnac_comment',
                                    'label' => '5b. - PNAC accredited',
                                ],
                                [
                                    'field' => null,
                                    'comment' => 'calibration_other_comment',
                                    'label' => '5c. - Other bodies (specify)',
                                ],
                                [
                                    'field' => null,
                                    'comment' => 'calibration_lab_comment',
                                    'label' => '6. PT participation?',
                                ],
                            ];
                        @endphp
                        <div class="row g-3">
                            @foreach ($questions as $q)
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <strong>{{ $q['label'] }}</strong>
                                            @if ($q['field'] !== null)
                                                <span
                                                    class="ms-2 badge {{ ($labApplication->{$q['field']} ?? '') === 'yes' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($labApplication->{$q['field']} ?? '-') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-5">
                                            @if ($q['comment'] !== null && !empty($labApplication->{$q['comment']}))
                                                <span class="text-muted">Comment:</span>
                                                <span>{!! $labApplication->{$q['comment']} !!}</span>
                                            @else
                                                <span class="text-muted">No comment</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                </div>
                            @endforeach
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-7">
                                        <strong>Compliance with ISO/IEC 17025:</strong>
                                        <span
                                            class="ms-2 badge {{ ($labApplication->calibration_compliance ?? '') === 'yes' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($labApplication->calibration_compliance ?? '-') }}
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                        @if (!empty($labApplication->calibration_compliance_comment))
                                            <span class="text-muted">Comment:</span>
                                            <span>{!! $labApplication->calibration_compliance_comment !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-7">
                                        <strong>Non‑compliance areas:</strong>
                                        <span>{!! $labApplication->calibration_non_compliance ?? '-' !!}</span>
                                    </div>
                                    <div class="col-md-5">
                                        <strong>Rectified by:</strong>
                                        <span>{{ $labApplication->calibration_rectified ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'calibration_facility']) }}"
                                class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>
            @elseif ($sectionKey === 'declaration')
                {{-- ========================================== --}}
                {{-- Step 7: Declaration (custom)              --}}
                {{-- ========================================== --}}
                <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-section="declaration"
                    data-open="{{ $openSection === 'declaration' ? '1' : '0' }}">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Step {{ $stepNumber }}: {{ $declarationSection['title'] }}</h5>
                            <p class="text-muted mb-0">Applicant declaration and accreditation selection.</p>
                        </div>
                        <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $saved ? 'Saved' : 'Unsaved' }}
                        </span>
                    </div>

                    @if ($editing)
                        <form method="POST" class="js-card-form" novalidate
                            action="{{ route('application.saveDeclaration', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="section" value="declaration">

                            {{-- 7.1 Checkboxes --}}
                            <div class="mb-3">
                                <p class="fw-semibold mb-2">7.1 The laboratory applies for accreditation by PNAC for
                                    (please tick appropriate boxes)</p>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="declaration_calibration" value="yes" id="decl_calibration"
                                                @if (old('declaration_calibration', $labApplication->declaration_calibration) === 'yes') checked @endif>
                                            <label class="form-check-label" for="decl_calibration">{{ $getFieldLabel(5, 0, 'Calibration') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="declaration_testing" value="yes" id="decl_testing"
                                                @if (old('declaration_testing', $labApplication->declaration_testing) === 'yes') checked @endif>
                                            <label class="form-check-label" for="decl_testing">{{ $getFieldLabel(5, 1, 'Testing') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="declaration_extension" value="yes" id="decl_extension"
                                                @if (old('declaration_extension', $labApplication->declaration_extension) === 'yes') checked @endif>
                                            <label class="form-check-label" for="decl_extension">{{ $getFieldLabel(5, 2, 'An extension in scope of existing accreditation for a:') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1 ms-3">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="declaration_laboratory" value="yes" id="decl_lab"
                                                @if (old('declaration_laboratory', $labApplication->declaration_laboratory) === 'yes') checked @endif>
                                            <label class="form-check-label" for="decl_lab">{{ $getFieldLabel(5, 3, 'Calibration laboratory') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="declaration_test_lab" value="yes" id="decl_test_lab"
                                                @if (old('declaration_test_lab', $labApplication->declaration_test_lab) === 'yes') checked @endif>
                                            <label class="form-check-label" for="decl_test_lab">{{ $getFieldLabel(5, 4, 'Testing Laboratory') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 7.2 – 7.5 --}}
                            <div class="mb-3">
                                <p><strong>7.2.</strong> The organisation/laboratory agrees to conform, upon
                                    accreditation, with PNAC requirements as detailed in the Agreement [F-01/04].</p>
                                <p><strong>7.3.</strong> I enclose a cheque (payable to PNAC) for the Applicant fee of
                                    <input type="text" name="application_fee"
                                        class="form-control d-inline-block w-auto"
                                        value="{{ old('application_fee', $labApplication->application_fee) }}"
                                        placeholder="Enter amount" style="width: 120px; display: inline-block;">
                                    . I understand that this fee is non-refundable. (see Note below).
                                </p>
                                <p><strong>7.4.</strong> I understand the manner in which the accreditation system
                                    functions.</p>
                                <p><strong>7.5.</strong> I declare that the information given in this form is correct to
                                    the best of my knowledge and belief.</p>
                            </div>

                            {{-- Signed and Date --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">{{ $getFieldLabel(5, 6, 'Signed') }}</label>
                                    <input type="text" name="signed" class="form-control"
                                        value="{{ old('signed', $labApplication->signed) }}"
                                        placeholder="Name of signatory">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">{{ $getFieldLabel(5, 7, 'Date') }}</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ old('date', $labApplication->date) }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success btn-sm">Save Declaration</button>
                            </div>
                        </form>
                    @else
                        <div class="row g-3">
                            <div class="col-12">
                                <p class="fw-semibold"><strong>1</strong> The laboratory applies for accreditation by
                                    PNAC for:</p>
                                <ul class="list-unstyled">
                                    <li>Calibration: <span
                                            class="badge {{ $labApplication->declaration_calibration === 'yes' ? 'bg-success' : 'bg-secondary' }}">{{ $labApplication->declaration_calibration === 'yes' ? '✓' : '✗' }}</span>
                                    </li>
                                    <li>Testing: <span
                                            class="badge {{ $labApplication->declaration_testing === 'yes' ? 'bg-success' : 'bg-secondary' }}">{{ $labApplication->declaration_testing === 'yes' ? '✓' : '✗' }}</span>
                                    </li>
                                    <li>Extension: <span
                                            class="badge {{ $labApplication->declaration_extension === 'yes' ? 'bg-success' : 'bg-secondary' }}">{{ $labApplication->declaration_extension === 'yes' ? '✓' : '✗' }}</span>
                                        @if ($labApplication->declaration_extension === 'yes')
                                            <ul>
                                                <li>Calibration laboratory: <span
                                                        class="badge {{ $labApplication->declaration_laboratory === 'yes' ? 'bg-success' : 'bg-secondary' }}">{{ $labApplication->declaration_laboratory === 'yes' ? '✓' : '✗' }}</span>
                                                </li>
                                                <li>Testing Laboratory: <span
                                                        class="badge {{ $labApplication->declaration_test_lab === 'yes' ? 'bg-success' : 'bg-secondary' }}">{{ $labApplication->declaration_test_lab === 'yes' ? '✓' : '✗' }}</span>
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <p><strong>2</strong> The organisation/laboratory agrees to conform, upon
                                    accreditation, with PNAC requirements as detailed in the Agreement [F-01/04].</p>
                                <p><strong>3</strong> Applicant fee:
                                    <strong>{{ $labApplication->application_fee ?? 'Not specified' }}</strong>
                                </p>
                                <p><strong>4</strong> I understand the manner in which the accreditation system
                                    functions.</p>
                                <p><strong>5</strong> I declare that the information given in this form is correct to
                                    the best of my knowledge and belief.</p>
                            </div>
                            <div class="col-md-6"><strong>Signed:</strong> {{ $labApplication->signed ?? '-' }}</div>
                            <div class="col-md-6"><strong>Date:</strong> {{ $labApplication->date ?? '-' }}</div>
                            @if (!empty($labApplication->upload_file))
                                <div class="col-12">
                                    <strong>Cheque File:</strong>
                                    <a href="{{ asset('storage/' . $labApplication->upload_file) }}"
                                        target="_blank">View</a>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'declaration']) }}"
                                class="btn btn-outline-success btn-sm">Edit</a>
                        </div>
                    @endif
                </div>
            @else
                {{-- ========================================== --}}
                {{-- Generic card (about_staff, testing_scope, other_approvals) --}}
                {{-- ========================================== --}}
                @php
                    $card = $cards[$sectionKey] ?? null;
                @endphp
                @if ($card)
                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100"
                        data-step="{{ $stepNumber }}" data-section="{{ $sectionKey }}"
                        data-open="{{ $openSection === $sectionKey ? '1' : '0' }}">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <h5 class="mb-1">Step {{ $stepNumber }}: {{ $card['title'] }}</h5>
                                <p class="text-muted mb-0">{{ $card['subtitle'] }}</p>
                            </div>
                            <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $saved ? 'Saved' : 'Unsaved' }}
                            </span>
                        </div>

                        @if ($editing)
                            <form method="POST" class="js-card-form" novalidate
                                action="{{ route($card['route'], ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
                                @csrf
                                <input type="hidden" name="section" value="{{ $sectionKey }}">
                                <div class="row g-3">
                                    @foreach ($card['fields'] as [$fieldName, $fieldLabel])
                                        @php
                                            $inputType = 'text';
                                            if (str_contains($fieldName, 'date')) {
                                                $inputType = 'date';
                                            } elseif ($fieldName === 'calibration_rectified') {
                                                $inputType = 'date';
                                            } elseif (str_contains($fieldName, 'email')) {
                                                $inputType = 'email';
                                            } elseif (
                                                str_contains($fieldName, 'tel') ||
                                                str_contains($fieldName, 'phone') ||
                                                str_contains($fieldName, 'fax')
                                            ) {
                                                $inputType = 'tel';
                                            } elseif (
                                                str_contains($fieldName, 'website') ||
                                                str_contains($fieldName, 'url')
                                            ) {
                                                $inputType = 'url';
                                            } elseif (str_contains($fieldName, 'time')) {
                                                $inputType = 'time';
                                            }
                                            $useTextarea =
                                                str_contains($fieldName, 'comment') ||
                                                str_contains($fieldName, 'description') ||
                                                str_contains($fieldName, 'scope') ||
                                                str_contains($fieldName, 'materials') ||
                                                str_contains($fieldName, 'standard') ||
                                                str_contains($fieldName, 'technique') ||
                                                str_contains($fieldName, 'laboratory') ||
                                                str_contains($fieldName, 'extension');
                                        @endphp
                                        <div class="col-md-6">
                                            <label class="form-label">{{ $fieldLabel }}</label>
                                            @if ($useTextarea)
                                                <textarea class="form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}" required
                                                    data-label="{{ $fieldLabel }}" data-error="Please enter {{ strtolower($fieldLabel) }}." rows="2"
                                                    placeholder="Enter {{ strtolower($fieldLabel) }}">{{ old($fieldName, $labApplication->{$fieldName}) }}</textarea>
                                            @else
                                                <input type="{{ $inputType }}"
                                                    class="form-control @error($fieldName) is-invalid @enderror"
                                                    name="{{ $fieldName }}" required
                                                    data-label="{{ $fieldLabel }}"
                                                    data-error="Please enter {{ strtolower($fieldLabel) }}."
                                                    placeholder="Enter {{ strtolower($fieldLabel) }}"
                                                    value="{{ old($fieldName, $labApplication->{$fieldName}) }}">
                                            @endif
                                            <small class="field-error text-danger"
                                                data-error-for="{{ $fieldName }}">
                                                @error($fieldName)
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                </div>
                            </form>
                        @else
                            <div class="details-grid">
                                @foreach ($card['fields'] as [$fieldName, $fieldLabel])
                                    <div class="detail-item">
                                        <span class="detail-label">{{ $fieldLabel }}:</span>
                                        <span class="detail-value">{{ $labApplication->{$fieldName} ?: '-' }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => $sectionKey]) }}"
                                    class="btn btn-outline-success btn-sm">Edit</a>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        @endforeach
    </div>
</div>

</div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    // ----- CKEditor initialization -----
    let calibRowCount = {{ !empty($calibrationRows) ? count($calibrationRows) : 1 }};

    function initEditors(context = document) {
        // Check if CKEditor is loaded
        if (typeof ClassicEditor === 'undefined') {
            console.error('CKEditor 5 is not loaded. Retrying in 500ms...');
            setTimeout(() => initEditors(context), 500);
            return;
        }

        context.querySelectorAll('.ckeditor').forEach((el) => {
            // Avoid re-initializing
            if (el.classList.contains('ckeditor-initialized')) {
                return;
            }
            // Capture the existing content BEFORE CKEditor replaces the element
            const existingContent = el.value || el.innerHTML || '';
            ClassicEditor.create(el)
                .then(editor => {
                    el.classList.add('ckeditor-initialized');
                    el.ckeditorInstance = editor;
                    // Restore the existing content so edit mode shows saved data
                    if (existingContent.trim() !== '') {
                        editor.setData(existingContent);
                    }
                })
                .catch(error => {
                    console.error('CKEditor creation error:', error);
                });
        });
    }

    // Sync CKEditor data to textarea value on form submit
    document.addEventListener('submit', function(event) {
        event.target.querySelectorAll('.ckeditor').forEach(el => {
            if (el.ckeditorInstance) {
                el.value = el.ckeditorInstance.getData();
            }
        });
    });

    // Initial call after DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initEditors();
    });

    // ----- Add Calibration Row -----
    document.getElementById('addCalibrationRowBtn')?.addEventListener('click', function() {
        calibRowCount++;
        let index = calibRowCount;

        let row = `
            <div class="border rounded p-3 mb-3 bg-light position-relative" id="calibRow_${index}">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                    onclick="removeCalibRow('${index}')">Remove</button>

                <div class="mb-2">
                    <label>Field of Measurement</label>
                    <textarea name="calibration[${index}][field]" class="form-control ckeditor"></textarea>
                </div>

                <div class="row g-2">
                    <div class="col-md-3">
                        <label>Measured Quantity</label>
                        <textarea name="calibration[${index}][measurement]" class="form-control ckeditor"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label>Range</label>
                        <textarea name="calibration[${index}][range]" class="form-control ckeditor"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label>Expanded Uncertainty</label>
                        <textarea name="calibration[${index}][expanded]" class="form-control ckeditor"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label>Technique / Equipment</label>
                        <textarea name="calibration[${index}][technique]" class="form-control ckeditor"></textarea>
                    </div>
                </div>
            </div>`;

        let container = document.getElementById('calibrationRowsContainer');
        container.insertAdjacentHTML('beforeend', row);

        // Re-initialize CKEditor for the new row
        initEditors(document.getElementById('calibRow_' + index));
    });

    // ----- Remove Row -----
    function removeCalibRow(index) {
        document.getElementById('calibRow_' + index)?.remove();
    }
</script>
