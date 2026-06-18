<div class="pnac-vertical-form w-100">
    @php
        $currentEditSection = request('edit_section');
        $failedSection = old('section');
        $openSection = session('open_section') ?: $failedSection;
        $cbSavedSections = $cbSavedSections ?? [];
        $generalId = $general->id ?? null;

        $isSectionSaved = fn(string $key) => (bool) ($cbSavedSections[$key] ?? false);
        $sectionShouldEdit = function (string $key, bool $saved) use ($currentEditSection, $failedSection) {
            if ($currentEditSection === $key || $failedSection === $key) return true;
            return !$saved;
        };
    @endphp

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h4 class="mb-0 text-success">Application For Certification Body Accreditation ISO/IEC 17021-1</h4>
        <span class="badge bg-success">Certification Bodies</span>
    </div>

    <div id="pnacVerticalForm" class="w-100">
        @php $saved = $isSectionSaved('basic_info'); $editing = $sectionShouldEdit('basic_info', $saved); @endphp
        <div class="border rounded p-3 p-md-4 mb-3 bg-white w-100 pnac-basic-card" data-section="basic_info" data-open="{{ $openSection === 'basic_info' ? '1' : '0' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div><h5 class="mb-1">Section 0: Basic Certification Body Information</h5></div>
                <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">{{ $saved ? 'Saved' : 'Unsaved' }}</span>
            </div>
            @if($editing)
                <form method="POST" class="js-card-form" action="{{ route('application.certificationBodies.saveBasicInfo') }}">
                    @csrf
                    <input type="hidden" name="section" value="basic_info">
                    <input type="hidden" name="general_id" value="{{ $generalId }}">
                    <input type="hidden" name="application" value="{{ request('application') }}">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Accreditation Scheme</label><input class="form-control" name="scheme" value="{{ old('scheme', $general->scheme ?? 'Certification Bodies') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Certification Body Name</label><input class="form-control" name="cab_name" value="{{ old('cab_name', $general->cab_name ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Certification Body Address</label><input class="form-control" name="address" value="{{ old('address', $general->address ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Telephone</label><input class="form-control" name="telephone" value="{{ old('telephone', $general->telephone ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ old('email', $general->email ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">NTN/FTN</label><input class="form-control" name="ntn_ftn" value="{{ old('ntn_ftn', $general->ntn_ftn ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Website</label><input class="form-control" name="website" value="{{ old('website', $general->website ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">City</label><input class="form-control" name="city" value="{{ old('city', $general->city ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Country</label><input class="form-control" name="country" value="{{ old('country', $general->country ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Postal Code</label><input class="form-control" name="postal_code" value="{{ old('postal_code', $general->postal_code ?? '') }}"></div>
                    </div>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Contact Name</label><input class="form-control" name="contact_name" value="{{ old('contact_name', $cbApplication->contact_name ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Contact Designation</label><input class="form-control" name="contact_designation" value="{{ old('contact_designation', $cbApplication->contact_designation ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Contact Email</label><input type="email" class="form-control" name="contact_email" value="{{ old('contact_email', $cbApplication->contact_email ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Contact Address</label><input class="form-control" name="contact_address" value="{{ old('contact_address', $cbApplication->contact_address ?? '') }}"></div>
                        <div class="col-md-3"><label class="form-label">Contact Postcode</label><input class="form-control" name="contact_postcode" value="{{ old('contact_postcode', $cbApplication->contact_postcode ?? '') }}"></div>
                        <div class="col-md-3"><label class="form-label">Contact Tel</label><input class="form-control" name="contact_tel" value="{{ old('contact_tel', $cbApplication->contact_tel ?? '') }}"></div>
                        <div class="col-md-3"><label class="form-label">Contact Fax</label><input class="form-control" name="contact_fax" value="{{ old('contact_fax', $cbApplication->contact_fax ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Sub Offices Details</label><textarea class="form-control" name="sub_offices_details">{{ old('sub_offices_details', $cbApplication->sub_offices_details ?? '') }}</textarea></div>
                    </div>
                    <div class="mt-3">
                        <label class="me-3"><input type="checkbox" name="is_new_accreditation" value="1" @checked(old('is_new_accreditation', $cbApplication->is_new_accreditation ?? false))> New accreditation as certification body</label>
                        <label><input type="checkbox" name="is_extension_scope" value="1" @checked(old('is_extension_scope', $cbApplication->is_extension_scope ?? false))> Extension of Scope</label>
                    </div>
                    <div class="mt-2">
                        @foreach(['qms'=>'QMS','ems'=>'EMS','fsms'=>'FSMS','iso_45001'=>'ISO 45001','iso_13485'=>'ISO 13485','other_management_system'=>'Other Management System'] as $k => $lbl)
                            <label class="me-3"><input type="checkbox" name="{{ $k }}" value="1" @checked(old($k, $cbApplication->{$k} ?? false))> {{ $lbl }}</label>
                        @endforeach
                        <input class="form-control mt-2" name="other_management_system_detail" placeholder="Other management system detail" value="{{ old('other_management_system_detail', $cbApplication->other_management_system_detail ?? '') }}">
                    </div>
                    <div class="mt-2">
                        @foreach(['enclosed_quality_manual'=>'Quality Manual','enclosed_quality_procedures'=>'Quality Procedures','enclosed_staff_list'=>'List of Staff','enclosed_certified_organizations'=>'List of Certified Organizations','enclosed_applicant_fee'=>'Applicant Fee','enclosed_legal_entity'=>'Proof of Legal Entity','enclosed_f0229_document_review'=>'Filled Form F-02/29'] as $k => $lbl)
                            <label class="me-3"><input type="checkbox" name="{{ $k }}" value="1" @checked(old($k, $cbApplication->{$k} ?? false))> {{ $lbl }}</label>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end mt-3"><button type="submit" class="btn btn-success btn-sm">Save Section 0</button></div>
                </form>
            @else
                <div class="details-grid">
                    <div class="detail-item"><span class="detail-label">Certification Body Name:</span><span class="detail-value">{{ $general->cab_name ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Address:</span><span class="detail-value">{{ $general->address ?: '-' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Contact Name:</span><span class="detail-value">{{ $cbApplication->contact_name ?? '-' }}</span></div>
                </div>
                <div class="d-flex justify-content-end mt-3"><a href="{{ route('application.create', ['scheme_name'=>request('scheme_name'),'application'=>request('application'),'edit_section'=>'basic_info']) }}" class="btn btn-outline-success btn-sm">Edit</a></div>
            @endif
        </div>

        @php
            $cards = [
                ['key'=>'about_yourselves','title'=>'Part 1: About Yourselves','route'=>'application.certificationBodies.saveAboutYourselves'],
                ['key'=>'staff','title'=>'Part 2: About Your Staff','route'=>'application.certificationBodies.saveStaff'],
                ['key'=>'scope','title'=>'Part 3: Scope of Application','route'=>'application.certificationBodies.saveScope'],
                ['key'=>'quality_system','title'=>'Part 4: About Your Quality System','route'=>'application.certificationBodies.saveQualitySystem'],
                ['key'=>'approvals','title'=>'Part 5: Other Approvals','route'=>'application.certificationBodies.saveApprovals'],
                ['key'=>'declaration','title'=>'Part 6: Declaration','route'=>'application.certificationBodies.saveDeclaration'],
            ];
        @endphp

        @foreach($cards as $card)
            @php $saved = $isSectionSaved($card['key']); $editing = $sectionShouldEdit($card['key'], $saved); @endphp
            <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-section="{{ $card['key'] }}" data-open="{{ $openSection === $card['key'] ? '1' : '0' }}">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div><h5 class="mb-1">{{ $card['title'] }}</h5></div>
                    <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">{{ $saved ? 'Saved' : 'Unsaved' }}</span>
                </div>
                @if($editing)
                    <form method="POST" class="js-card-form" action="{{ route($card['route'], $generalId) }}">
                        @csrf
                        <input type="hidden" name="section" value="{{ $card['key'] }}">
                        <input type="hidden" name="application" value="{{ request('application') }}">
                        @if($card['key'] === 'about_yourselves')
                            <div class="row g-3">
                                <div class="col-md-4"><label class="form-label">Director Title</label><input class="form-control" name="director_title" value="{{ old('director_title', $cbApplication->director_title ?? '') }}"></div>
                                <div class="col-md-4"><label class="form-label">Director Name</label><input class="form-control" name="director_name" required value="{{ old('director_name', $cbApplication->director_name ?? '') }}"></div>
                                <div class="col-md-4"><label class="form-label">Director Position</label><input class="form-control" name="director_position" required value="{{ old('director_position', $cbApplication->director_position ?? '') }}"></div>
                                <div class="col-md-6"><label class="form-label">Parent Organization</label><input class="form-control" name="parent_organization" value="{{ old('parent_organization', $cbApplication->parent_organization ?? '') }}"></div>
                                <div class="col-md-6"><label class="form-label">Parent Relationship</label><input class="form-control" name="parent_relationship" value="{{ old('parent_relationship', $cbApplication->parent_relationship ?? '') }}"></div>
                            </div>
                        @elseif($card['key'] === 'staff')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead><tr><th>Type</th><th>Name</th><th>Qualifications</th><th>Experience / Auditing Field</th></tr></thead>
                                    <tbody>
                                        @foreach(['chief_executive','quality_management_representative','management','permanent_auditor','subcontracted_auditor'] as $t)
                                            <tr>
                                                <td>{{ $t }}</td>
                                                <td><input class="form-control" name="staff[{{ $t }}][0][name]"></td>
                                                <td><input class="form-control" name="staff[{{ $t }}][0][qualifications]"></td>
                                                <td>
                                                    <input class="form-control mb-1" name="staff[{{ $t }}][0][relevant_experience]" placeholder="Relevant experience">
                                                    <input class="form-control mb-1" name="staff[{{ $t }}][0][auditing_field]" placeholder="Auditing field">
                                                    <input class="form-control" name="staff[{{ $t }}][0][audit_experience]" placeholder="Audit experience">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($card['key'] === 'scope')
                            @foreach(['ISO9001','ISO14001','ISO45001','ISO22000','ISO13485'] as $scopeType)
                                <h6>{{ $scopeType }}</h6>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-2"><input class="form-control" name="scopes[{{ $scopeType }}][0][technical_cluster_id]" placeholder="Technical cluster id"></div>
                                    <div class="col-md-2"><input class="form-control" name="scopes[{{ $scopeType }}][0][iaf_code]" placeholder="IAF code"></div>
                                    <div class="col-md-2"><input class="form-control" name="scopes[{{ $scopeType }}][0][cluster_id]" placeholder="Cluster id"></div>
                                    <div class="col-md-2"><input class="form-control" name="scopes[{{ $scopeType }}][0][cluster_cat]" placeholder="Category id"></div>
                                    <div class="col-md-2"><input class="form-control" name="scopes[{{ $scopeType }}][0][cluster_sub_cat]" placeholder="Sub category id"></div>
                                    <div class="col-md-2"><input class="form-control" name="scopes[{{ $scopeType }}][0][main_technical_id]" placeholder="Main technical id"></div>
                                    <div class="col-md-12"><textarea class="form-control" name="scopes[{{ $scopeType }}][0][description]" placeholder="Description"></textarea></div>
                                </div>
                            @endforeach
                        @elseif($card['key'] === 'quality_system')
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Complies with ISO/IEC 17021-1 and PNAC requirements</label>
                                    <select class="form-control" name="quality_system_complies">
                                        <option value="">Select</option>
                                        <option value="yes" @selected(old('quality_system_complies', $cbApplication->quality_system_complies ?? '') === 'yes')>Yes</option>
                                        <option value="no" @selected(old('quality_system_complies', $cbApplication->quality_system_complies ?? '') === 'no')>No</option>
                                    </select>
                                </div>
                                <div class="col-md-5"><label class="form-label">Area of non-compliance</label><input class="form-control" name="non_compliance_area" value="{{ old('non_compliance_area', $cbApplication->non_compliance_area ?? '') }}"></div>
                                <div class="col-md-3"><label class="form-label">Rectified by date</label><input type="date" class="form-control" name="rectified_by_date" value="{{ old('rectified_by_date', $cbApplication->rectified_by_date ?? '') }}"></div>
                            </div>
                        @elseif($card['key'] === 'approvals')
                            <div class="row g-2">
                                <div class="col-md-5"><input class="form-control" name="approvals[0][approval_body_name_address]" placeholder="Approval body name/address"></div>
                                <div class="col-md-3"><input class="form-control" name="approvals[0][scope_certificate_no]" placeholder="Scope / certificate no"></div>
                                <div class="col-md-2"><input type="date" class="form-control" name="approvals[0][start_date]"></div>
                                <div class="col-md-2"><input type="date" class="form-control" name="approvals[0][expiry_date]"></div>
                            </div>
                        @elseif($card['key'] === 'declaration')
                            <div class="row g-3">
                                <div class="col-md-12"><label class="form-label">6.1 Scope applied</label><input class="form-control" name="declaration_scope_applied" value="{{ old('declaration_scope_applied', $cbApplication->declaration_scope_applied ?? '') }}"></div>
                                <div class="col-md-6"><label class="form-label">Application Fee</label><input class="form-control" name="application_fee" value="{{ old('application_fee', $cbApplication->application_fee ?? '') }}"></div>
                                <div class="col-md-3"><label class="form-label">Signed</label><input class="form-control" required name="signed" value="{{ old('signed', $cbApplication->signed ?? '') }}"></div>
                                <div class="col-md-3"><label class="form-label">Signed Date</label><input type="date" class="form-control" required name="signed_date" value="{{ old('signed_date', $cbApplication->signed_date ?? '') }}"></div>
                            </div>
                        @endif
                        <div class="d-flex justify-content-end mt-3"><button type="submit" class="btn btn-success btn-sm">Save</button></div>
                    </form>
                @else
                    <div class="details-grid"><div class="detail-item"><span class="detail-label">Status:</span><span class="detail-value">Saved</span></div></div>
                    <div class="d-flex justify-content-end mt-3"><a href="{{ route('application.create', ['scheme_name'=>request('scheme_name'),'application'=>request('application'),'edit_section'=>$card['key']]) }}" class="btn btn-outline-success btn-sm">Edit</a></div>
                @endif
            </div>
        @endforeach
    </div>
</div>

