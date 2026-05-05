<div class="pnac-vertical-form w-100">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h4 class="mb-0 text-success">Application For Laboratory Accreditation ISO/IEC 17025</h4>
                    <span class="badge bg-success">{{ urldecode(request()->query('scheme_name')) }}</span>
                </div>

                <form id="pnacVerticalForm" class="w-100" novalidate>
                    @csrf
                    <div class="border rounded p-3 p-md-4 mb-3 bg-white w-100 pnac-basic-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <h5 class="mb-1">Basic Application / Laboratory Information</h5>
                                <p class="text-muted mb-0">General application details captured before Part 1.</p>
                            </div>
                            <span class="badge bg-warning text-dark" id="status-basic">Unsaved</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Accreditation Scheme</label><input class="form-control" name="basic[scheme]" value="{{ urldecode(request()->query('scheme_name')) }}" required></div>
                            <div class="col-md-4"><label class="form-label">CAB Name</label><input class="form-control" name="basic[cab_name]" required></div>
                            <div class="col-md-4"><label class="form-label">Address of Laboratory</label><textarea class="form-control" name="basic[address]" rows="2" required></textarea></div>
                            <div class="col-md-4"><label class="form-label">Telephone</label><input class="form-control" name="basic[telephone]" required></div>
                            <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="basic[email]" required></div>
                            <div class="col-md-4"><label class="form-label">NTN/FTN</label><input class="form-control" name="basic[ntn_ftn]"></div>
                            <div class="col-md-4"><label class="form-label">Website</label><input class="form-control" name="basic[website]"></div>
                            <div class="col-md-4"><label class="form-label">City</label><input class="form-control" name="basic[city]" required></div>
                            <div class="col-md-4"><label class="form-label">Country</label><input class="form-control" name="basic[country]" required></div>
                            <div class="col-md-4"><label class="form-label">Postal Code</label><input class="form-control" name="basic[postal_code]"></div>
                        </div>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm" id="saveBasicInfo">Save Basic Info</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div><h5 class="mb-1">Step 1: About Yourselves</h5><p class="text-muted mb-0">Part 1 - About yourselves</p></div>
                            <span class="badge bg-warning text-dark" id="status-step-1">Unsaved</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-12"><h6 class="fw-bold mb-1">1.1 Person Authorising This Application</h6></div>
                            <div class="col-md-4"><label class="form-label">Title</label><input class="form-control" name="step1[person_authorising][title]" required></div>
                            <div class="col-md-4"><label class="form-label">Name</label><input class="form-control" name="step1[person_authorising][name]" required></div>
                            <div class="col-md-4"><label class="form-label">Position</label><input class="form-control" name="step1[person_authorising][position]" required></div>

                            <div class="col-12 mt-2"><h6 class="fw-bold mb-1">1.2 Parent Organisation Details</h6></div>
                            <div class="col-md-6"><label class="form-label">Parent Organization</label><input class="form-control" name="step1[parent_organisation][parent_organization]" required></div>
                            <div class="col-md-6"><label class="form-label">Relationship with Parent Organization</label><input class="form-control" name="step1[parent_organisation][relationship]" required></div>
                            <div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="step1[parent_organisation][address]" rows="2" required></textarea></div>
                            <div class="col-md-4"><label class="form-label">Postcode</label><input class="form-control" name="step1[parent_organisation][postcode]" required></div>
                            <div class="col-md-4"><label class="form-label">Telephone</label><input class="form-control" name="step1[parent_organisation][telephone]" required></div>
                            <div class="col-md-4"><label class="form-label">Fax</label><input class="form-control" name="step1[parent_organisation][fax]"></div>

                            <div class="col-12 mt-2"><h6 class="fw-bold mb-1">1.3 Address for Invoicing</h6></div>
                            <div class="col-md-6"><label class="form-label">Organisation</label><input class="form-control" name="step1[invoicing][organisation]" required></div>
                            <div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="step1[invoicing][address]" rows="2" required></textarea></div>
                            <div class="col-md-4"><label class="form-label">Postcode</label><input class="form-control" name="step1[invoicing][postcode]" required></div>
                            <div class="col-md-4"><label class="form-label">Telephone</label><input class="form-control" name="step1[invoicing][telephone]" required></div>
                            <div class="col-md-4"><label class="form-label">Fax</label><input class="form-control" name="step1[invoicing][fax]"></div>

                            <div class="col-12 mt-2"><h6 class="fw-bold mb-1">1.4 Ownership Information</h6></div>
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own1" value="Owned by an individual" required><label class="form-check-label" for="own1">Owned by an individual</label></div></div>
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own2" value="Owned by public limited company" required><label class="form-check-label" for="own2">Owned by public limited company</label></div></div>
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own3" value="Owned by a private company / partnership" required><label class="form-check-label" for="own3">Owned by a private company / partnership</label></div></div>
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own4" value="Part of learned / technical institution" required><label class="form-check-label" for="own4">Part of learned / technical institution</label></div></div>
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own5" value="Owned by a public body / nationalised industry" required><label class="form-check-label" for="own5">Owned by a public body / nationalised industry</label></div></div>
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own6" value="Part of an academic institution" required><label class="form-check-label" for="own6">Part of an academic institution</label></div></div>
                                    <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="radio" name="step1[ownership][type]" id="own7" value="Other" required><label class="form-check-label" for="own7">Other</label></div></div>
                                </div>
                            </div>
                            <div class="col-12 d-none" id="ownershipOtherWrap"><label class="form-label">Other ownership description</label><textarea class="form-control" name="step1[ownership][other_description]" id="ownershipOtherDescription" rows="2"></textarea></div>

                            <div class="col-12 mt-2"><h6 class="fw-bold mb-1">1.5 Main Activity of Parent Company</h6></div>
                            <div class="col-12">
                                <label class="form-label d-block">Is calibration/testing the main activity of the parent company?</label>
                                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="step1[parent_main_activity][is_main]" id="mainYes" value="yes" required><label class="form-check-label" for="mainYes">Yes</label></div>
                                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="step1[parent_main_activity][is_main]" id="mainNo" value="no" required><label class="form-check-label" for="mainNo">No</label></div>
                            </div>
                            <div class="col-12 d-none" id="parentActivityDescriptionWrap"><label class="form-label">Description of main activities of the parent company</label><textarea class="form-control" name="step1[parent_main_activity][description]" id="parentActivityDescription" rows="2"></textarea></div>

                            <div class="col-12 mt-2"><h6 class="fw-bold mb-1">1.6 Laboratory Undertakes Calibration/Testing For</h6></div>
                            <div class="col-12">
                                <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="undertakesOwn" name="step1[laboratory_undertakes_for][]" value="Own organisation"><label class="form-check-label" for="undertakesOwn">Own organisation</label></div>
                                <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="undertakesOther" name="step1[laboratory_undertakes_for][]" value="Other organisations"><label class="form-check-label" for="undertakesOther">Other organisations</label></div>
                            </div>

                            <div class="col-12 mt-2"><h6 class="fw-bold mb-1">1.7 Consultant / Consultancy Firm</h6></div>
                            <div class="col-md-4"><label class="form-label">Name</label><input class="form-control" name="step1[consultant][name]"></div>
                            <div class="col-md-4"><label class="form-label">Organisation, if any</label><input class="form-control" name="step1[consultant][organisation]"></div>
                            <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="step1[consultant][email]"></div>
                            <div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="step1[consultant][address]" rows="2"></textarea></div>
                            <div class="col-md-4"><label class="form-label">Postcode</label><input class="form-control" name="step1[consultant][postcode]"></div>
                            <div class="col-md-4"><label class="form-label">Telephone</label><input class="form-control" name="step1[consultant][telephone]"></div>
                            <div class="col-md-4"><label class="form-label">Fax</label><input class="form-control" name="step1[consultant][fax]"></div>
                        </div>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="1">Save Step</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="2">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3"><div><h5 class="mb-1">Step 2: About Your Staff</h5><p class="text-muted mb-0">Technical management and quality manager details.</p></div><span class="badge bg-warning text-dark" id="status-step-2">Unsaved</span></div>
                        <div class="table-responsive mb-2"><table class="table table-bordered align-middle mb-2"><thead><tr><th>Name</th><th>Qualifications</th><th>Relevant Experience</th></tr></thead><tbody id="staffRows"><tr><td><input class="form-control" name="step2[staff][0][name]" required></td><td><input class="form-control" name="step2[staff][0][qualifications]" required></td><td><input class="form-control" name="step2[staff][0][experience]" required></td></tr></tbody></table></div>
                        <button type="button" class="btn btn-outline-success btn-sm mb-3" id="addStaffRow">Add Staff Member</button>
                        <div class="row g-3"><div class="col-md-4"><label class="form-label">Quality Manager Name</label><input class="form-control" name="step2[quality_manager][name]" required></div><div class="col-md-4"><label class="form-label">Qualifications</label><input class="form-control" name="step2[quality_manager][qualifications]" required></div><div class="col-md-4"><label class="form-label">Relevant Experience</label><input class="form-control" name="step2[quality_manager][experience]" required></div></div>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="2">Save Step</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="3">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3"><div><h5 class="mb-1">Step 3: Scope of Application - Calibration</h5><p class="text-muted mb-0">Field of measurement and calibration scope rows.</p></div><span class="badge bg-warning text-dark" id="status-step-3">Unsaved</span></div>
                        <div class="row g-3 mb-3"><div class="col-md-6"><label class="form-label">Field of Measurement</label><input class="form-control" name="step3[field_of_measurement]" required></div></div>
                        <div class="table-responsive mb-2"><table class="table table-bordered align-middle mb-2"><thead><tr><th>Measured Quantity</th><th>Range</th><th>Expanded Uncertainty</th><th>Technique / Reference Standard / Equipment</th></tr></thead><tbody id="calibrationRows"><tr><td><input class="form-control" name="step3[rows][0][quantity]" required></td><td><input class="form-control" name="step3[rows][0][range]" required></td><td><input class="form-control" name="step3[rows][0][uncertainty]" required></td><td><input class="form-control" name="step3[rows][0][technique]" required></td></tr></tbody></table></div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="addCalibrationRow">Add Calibration Scope Row</button>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="3">Save Step</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3"><div><h5 class="mb-1">Step 4: Scope of Application - Testing</h5><p class="text-muted mb-0">Testing scope and major equipment records.</p></div><span class="badge bg-warning text-dark" id="status-step-4">Unsaved</span></div>
                        <div class="table-responsive mb-2"><table class="table table-bordered align-middle mb-2"><thead><tr><th>Materials / Products Tested</th><th>Types of Test / Properties Measured</th><th>Range</th><th>Minimum Detection Limit</th><th>Uncertainty</th><th>Standard / Techniques / Equipment</th></tr></thead><tbody id="testingRows"><tr><td><input class="form-control" name="step4[testing][0][materials]" required></td><td><input class="form-control" name="step4[testing][0][types]" required></td><td><input class="form-control" name="step4[testing][0][range]" required></td><td><input class="form-control" name="step4[testing][0][mdl]"></td><td><input class="form-control" name="step4[testing][0][uncertainty]"></td><td><input class="form-control" name="step4[testing][0][standard]"></td></tr></tbody></table></div>
                        <button type="button" class="btn btn-outline-success btn-sm mb-3" id="addTestingRow">Add Testing Row</button>
                        <div class="table-responsive mb-2"><table class="table table-bordered align-middle mb-2"><thead><tr><th>Description</th><th>Working Range / Capacity</th><th>Minimum Detection Limit</th></tr></thead><tbody id="equipmentRows"><tr><td><input class="form-control" name="step4[equipment][0][description]" required></td><td><input class="form-control" name="step4[equipment][0][working_range]" required></td><td><input class="form-control" name="step4[equipment][0][mdl]"></td></tr></tbody></table></div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="addEquipmentRow">Add Equipment Row</button>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="4">Save Step</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="5">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3"><div><h5 class="mb-1">Step 5: Calibration Facility</h5><p class="text-muted mb-0">Answer facility readiness and compliance checks.</p></div><span class="badge bg-warning text-dark" id="status-step-5">Unsaved</span></div>
                        @php $facilityQuestions = ['Calibration program exists','Equipment records maintained','Adequate facilities and environment','Documented calibration procedures','Traceability to PNAC accredited bodies','Traceability to other bodies','PT participation for calibration activities']; @endphp
                        <div class="row g-3">
                            @foreach($facilityQuestions as $index => $question)
                                <div class="col-12 border rounded p-2">
                                    <label class="form-label fw-semibold mb-1">{{ $question }}</label>
                                    <div class="row g-2">
                                        <div class="col-md-3"><select class="form-select" name="step5[question_{{ $index }}][answer]" required><option value="">Select</option><option value="yes">Yes</option><option value="no">No</option></select></div>
                                        <div class="col-md-9"><input class="form-control" name="step5[question_{{ $index }}][comment]" placeholder="Reference / Comment"></div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-4"><label class="form-label">ISO/IEC 17025 Compliance</label><select class="form-select" name="step5[iso_compliance]" required><option value="">Select</option><option value="yes">Yes</option><option value="no">No</option></select></div>
                            <div class="col-md-4"><label class="form-label">Non-compliance Area</label><input class="form-control" name="step5[non_compliance_area]"></div>
                            <div class="col-md-4"><label class="form-label">Rectified By Date</label><input type="date" class="form-control" name="step5[rectified_by_date]"></div>
                        </div>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="5">Save Step</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="6">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3"><div><h5 class="mb-1">Step 6: Other Approvals</h5><p class="text-muted mb-0">Current approvals, certificate numbers and validity.</p></div><span class="badge bg-warning text-dark" id="status-step-6">Unsaved</span></div>
                        <div class="table-responsive mb-2"><table class="table table-bordered align-middle mb-2"><thead><tr><th>Approval Body Name / Address</th><th>Scope</th><th>Certificate Number</th><th>Start Date</th><th>Expiry Date</th></tr></thead><tbody id="approvalRows"><tr><td><input class="form-control" name="step6[rows][0][body]" required></td><td><input class="form-control" name="step6[rows][0][scope]" required></td><td><input class="form-control" name="step6[rows][0][certificate]" required></td><td><input type="date" class="form-control" name="step6[rows][0][start_date]" required></td><td><input type="date" class="form-control" name="step6[rows][0][expiry_date]" required></td></tr></tbody></table></div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="addApprovalRow">Add Approval</button>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="6">Save Step</button></div>
                    </div>

                    <div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-step="7">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3"><div><h5 class="mb-1">Step 7: Declaration</h5><p class="text-muted mb-0">Applicant declaration and accreditation selection.</p></div><span class="badge bg-warning text-dark" id="status-step-7">Unsaved</span></div>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">Accreditation Type</label><div class="row g-2"><div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="ac1" name="step7[accreditation_type][]" value="Calibration"><label class="form-check-label" for="ac1">Calibration</label></div></div><div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="ac2" name="step7[accreditation_type][]" value="Testing"><label class="form-check-label" for="ac2">Testing</label></div></div><div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="ac3" name="step7[accreditation_type][]" value="Extension in scope for calibration laboratory"><label class="form-check-label" for="ac3">Extension in scope for calibration laboratory</label></div></div><div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="ac4" name="step7[accreditation_type][]" value="Extension in scope for testing laboratory"><label class="form-check-label" for="ac4">Extension in scope for testing laboratory</label></div></div></div></div>
                            <div class="col-md-4"><label class="form-label">Applicant Fee</label><input class="form-control" name="step7[applicant_fee]" required></div>
                            <div class="col-md-4"><label class="form-label">Signed By</label><input class="form-control" name="step7[signed_by]" required></div>
                            <div class="col-md-4"><label class="form-label">Date</label><input type="date" class="form-control" name="step7[signed_date]" required></div>
                            <div class="col-12"><div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="ag1" name="step7[agreement_confirmation]" required><label class="form-check-label" for="ag1">The organization agrees to PNAC requirements.</label></div><div class="form-check"><input class="form-check-input" type="checkbox" id="ag2" name="step7[correct_information_declaration]" required><label class="form-check-label" for="ag2">I declare the information provided is correct.</label></div></div>
                        </div>
                        <div class="d-flex justify-content-end mt-3"><button type="button" class="btn btn-success btn-sm save-step-btn" data-step="7">Save Step</button></div>
                    </div>

                    <div class="d-flex justify-content-end mb-4"><button type="button" class="btn btn-secondary" id="submitApplicationBtn">Submit Application</button></div>
                    <div id="stepSaveMessage" class="alert d-none" role="alert"></div>
                </form>
        </div>
</div>
