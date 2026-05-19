<form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">

        {{-- General --}}
        <div class="row section-form proficiency-testing-section-form" id="GeneralInfo-ProficiencyTesting-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5>Application For Proficiency Testing Provider Accreditation</h5>
                            <h6>Please type or use BLOCK LETTERS</h6>
                        </div>

                        <div class="form-group">
                            <label>Organisation</label>
                            <input type="text" value="{{ $proficiency->organisation }}" name="organisation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address of Proficiency Testing Provider</label>
                            <input type="text" value="{{ $proficiency->address }}" name="address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $proficiency->postcode }}" name="postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $proficiency->tel }}" name="tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $proficiency->fax }}" name="fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" value="{{ $proficiency->contact_name }}" name="contact_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="{{ $proficiency->designation }}" name="designation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" value="{{ $proficiency->person_address }}" name="person_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{ $proficiency->person_postcode }}" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{ $proficiency->person_tel }}" name="person_tel" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{ $proficiency->person_fax }}" name="person_fax" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" value="{{ $proficiency->person_email }}" name="person_email" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_accreditation== 'on') checked @endif name="chack_accreditation">
                            <label for="">New accreditation as a Proficiency Testing Provider</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_extension == 'on') checked @endif name="chack_extension">
                            <label for=""> Extension of scope</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_chemical == 'on') checked @endif name="chack_chemical">
                            <label for="">Chemical analysis</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_textile == 'on') checked @endif name="chack_textile">
                            <label for="">Textile testing</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_environment == 'on') checked @endif name="chack_environment">
                            <label for="">Environmental analysis</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_biological == 'on') checked @endif name="chack_biological">
                            <label for="">Biological testing</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_clinical == 'on') checked @endif name="chack_clinical">
                            <label for="">Clinical/Medical testing</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_dimensional == 'on') checked @endif name="chack_dimensional">
                            <label for="">Dimensional measurement and inspection</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_mechanical == 'on') checked @endif name="chack_mechanical">
                            <label for="">Dimensional, mechanical, thermodynamic, electrical calibration</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_materials == 'on') checked @endif name="chack_materials">
                            <label for="">Materials testing</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_metallurgical == 'on') checked @endif name="chack_metallurgical">
                            <label for="">Metallurgical testing </label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_others == 'on') checked @endif name="chack_others">
                            <label for="">Others</label>
                        </div>


                        <div class="form-group">
                            <h5>I enclosed (tick boxes);</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_manual == 'on') checked @endif name="chack_manual">
                            <label for="">A copy of the Proficiency Testing Provider's Quality Manual </label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_procedures == 'on') checked @endif name="chack_procedures">
                            <label for="">A copy of the Proficiency Testing Provider's Quality Procedures</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_technical == 'on') checked @endif name="chack_technical">
                            <label for=""> A copy of the Proficiency Testing Provider's Technical Procedures and work </label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_testing == 'on') checked @endif name="chack_testing">
                            <label for=""> A copy of the Proficiency Testing Provider's Technical Procedures and work instructions required by the standard.</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_complete == 'on') checked @endif name="chack_complete">
                            <label for=""> A complete set of information pack provided to the applicant laboratories for each scheme</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_staff == 'on') checked @endif name="chack_staff">
                            <label for="">List of Proficiency Testing Provider's staff</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_relevant == 'on') checked @endif name="chack_relevant">
                            <label for="">List of all relevant experts and subcontractors, if applicable</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_suppliers == 'on') checked @endif name="chack_suppliers">
                            <label for="">List of artifact suppliers</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_calibration == 'on') checked @endif name="chack_calibration">
                            <label for="">  List of suppliers of calibration services</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_report == 'on') checked @endif name="chack_report">
                            <label for="">Example report for each proficiency test for which accreditation is sought</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->chack_report == 'on') checked @endif name="chack_report">
                            <label for="">Applicant fee-see note below</label>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <h5>Before completing the rest of this form, please read the following notes</h5>
                        <h6>Notes on completing this form</h6>
                    </div>
                    <div class="footer">
                        <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                            <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-success next-btn">Next</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Parts 1 --}}
        <div class="row section-form proficiency-testing-section-form" id="AboutYourselves-ProficiencyTesting-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 1 - About yourselves</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please type or use BLOCK LETTERS</h5>
                        </div>
                        <div class="form-group">
                            <h5>1.1	Name and position (Director level) of person authorising this application</h5>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" value="{{ $proficiency->selves_title }}" name="selves_title" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" value="{{ $proficiency->selves_name }}" name="selves_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" value="{{ $proficiency->selves_position }}" name="selves_position" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2	Name and address of parent organisation (if different from Proficiency Testing Provider address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $proficiency->selves_parent_organization }}" name="selves_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $proficiency->selves_address }}" name="selves_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $proficiency->selves_postcode }}" name="selves_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $proficiency->selves_tel }}" name="selves_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $proficiency->selves_fax }}" name="selves_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.3	Address for invoicing (if different from Proficiency Testing Provider address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $proficiency->selves_invoicing_organization }}" name="selves_invoicing_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $proficiency->selves_invoicing_address }}" name="selves_invoicing_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $proficiency->selves_postcode }}" name="selves_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $proficiency->selves_invoicing_tel }}" name="selves_invoicing_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $proficiency->selves_invoicing_fax }}" name="selves_invoicing_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4	Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_individual == 'on') checked @endif name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_public == 'on') checked @endif name="selves_public">
                                <label>Owned by public limited Company</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_private == 'on') checked @endif name="selves_private">
                                <label>Owned by a private company/partnership</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_learned == 'on') checked @endif name="selves_learned">
                                <label>Part of learned/tech institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_industry == 'on') checked @endif name="selves_industry">
                                <label>Owned by a public body/nationalised industry</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" value="{{ $proficiency->selves_other_describe }}" name="selves_other_describe" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5	Is calibration/testing the main activity of the parent company?</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" @if($proficiency->selves_activity == 'Yes') checked @endif name="selves_activity" value="Yes">
                            <label>Yes</label>
                            <input type="radio" @if($proficiency->selves_activity == 'No') checked @endif name="selves_activity" value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>scribe the main activities of the parent company</label>
                            <input type="text" value="{{ $proficiency->selves_cab_activity }}" name="selves_cab_activity" class="form-control">

                        </div>
                        <div class="form-group">
                            <h5>1.6.	For whom does the Proficiency Testing Provider undertake calibration/testing</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_own_org == 'on') checked @endif name="selves_own_org">
                                <label>Own organisation</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($proficiency->selves_other_org == 'on') checked @endif name="selves_other_org">
                                <label>Other organisations</label>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Parts 2 --}}
        <div class="row section-form proficiency-testing-section-form" id="AboutYourStaff-ProficiencyTesting-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 2 - About your staff</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please type or use BLOCK LETTERS</h5>
                        </div>
                        <div class="form-group">
                            <h6>2.1	Please list the names, technical qualifications and relevant experience of the following staff</h6>
                        </div>
                        <div class="form-group">
                            <h6><b>Technical Management (if more than three members please attach extra sheet):</b>
                                Technical Management are facility staff who make evaluation of proficiency test results and whom is responsible for the adequacy of the PT reports.  Please provide the list of Key Personnel with their particulars and items under the scope of application to be covered by each personnel.  Please also furnish their CVs.
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $proficiency->staff_name }}" name="staff_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $proficiency->staff_qualifications }}" name="staff_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $proficiency->staff_relevant }}" name="staff_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $proficiency->staff_exp }}" name="staff_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>A.	Quality Manger</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $proficiency->staff_quality_name }}" name="staff_quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $proficiency->staff_quality_qualifications }}" name="staff_quality_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $proficiency->staff_quality_relevant }}" name="staff_quality_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $proficiency->staff_quality_exp }}" name="staff_quality_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>B.	Coordinator of Proficiency Testing scheme</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $proficiency->staff_coordinator_name }}" name="staff_coordinator_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $proficiency->staff_coordinator_qualifications }}" name="staff_coordinator_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $proficiency->staff_coordinator_relevant }}" name="staff_coordinator_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $proficiency->staff_coordinator_exp }}" name="staff_coordinator_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>C.	Statistian</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $proficiency->staff_statistian_name }}" name="staff_statistian_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $proficiency->staff_statistian_qualifications }}" name="staff_statistian_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $proficiency->staff_statistian_relevant }}" name="staff_statistian_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $proficiency->staff_statistian_exp }}" name="staff_statistian_exp" required class="form-control">
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Parts 3 --}}
        <div class="row section-form proficiency-testing-section-form" id="ScopeApplication-ProficiencyTesting-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope of application</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Proficiency Testing Field or Area or Parameter (eg Tensile Testing)</label>
                            <input type="text" value="{{ $proficiency->scop_parameter }}" name="scop_parameter" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Proficiency Testing Items/ Materials/ Matrix/Products (eg Reinforced Steel Bars)</label>
                            <input type="text" value="{{ $proficiency->scop_testing }}" name="scop_testing" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Number of Proficiency Test Item Round (e.g 5 nos)</label>
                            <input type="text" value="{{ $proficiency->scop_round }}" name="scop_round" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>3.2	List the major items of equipment (For PT providers preparing samples)</h5>
                        </div>
                        <div class="form-group">
                            <h6>(Use of photocopy of this page, if the space given is found insufficient)</h6>
                        </div>
                        <div class="form-group">
                            <label>Equipment, (model, range, etc)</label>
                            <input type="text" value="{{ $proficiency->scop_equipment }}" name="scop_equipment" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of last calibration</label>
                            <input type="text" value="{{ $proficiency->scop_last_date }}" name="scop_last_date" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of next calibration</label>
                            <input type="text" value="{{ $proficiency->scop_next_date }}" name="scop_next_date" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Calibration Organization</label>
                            <input type="text" value="{{ $proficiency->scop_calibration }}" name="scop_calibration" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Details of in-house Checks performed</label>
                            <input type="text" value="{{ $proficiency->scop_details }}" name="scop_details" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tests for which used and other comments</label>
                            <input type="text" value="{{ $proficiency->scop_comments }}" name="scop_comments" required class="form-control">
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- parts 5 --}}
        <div class="row section-form proficiency-testing-section-form" id="OtherApprovals-ProficiencyTesting-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 5 - Other approvals (certifications/ accreditations)</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please detail current accreditation/approval held by your Proficiency Testing Provider's facility</h5>
                        </div>
                        <div class="form-group">
                            <label>Name & address of approval body</label>
                            <textarea name="approvals_name" class="form-control">{{ $proficiency->approvals_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Scope of accreditation/approval and number of certificate (if any)</label>
                            <textarea name="approvals_scope" class="form-control">{{ $proficiency->approvals_scope }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Period of accreditation/approval</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Start</label>
                                <input type="date" name="approvals_start_date" value="{{ $proficiency->approvals_start_date }}" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Expiry Date</label>
                                <input type="date" name="approvals_end_date" value="{{ $proficiency->approvals_end_date }}" class="form-control">
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- parts 6 --}}
        <div class="row section-form proficiency-testing-section-form" id="Declaration-ProficiencyTesting-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 6 - Declaration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>This declaration should be made by the person named in Section 1.1 </h5>
                        </div>
                        <div class="form-group">
                            <label>6.1 	The Proficiency Testing Provider applies for accreditation by PNAC as a</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->declaration_applicant == 'on') checked @endif name="declaration_applicant">
                            <label>New applicant</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($proficiency->declaration_extension == 'on') checked @endif name="declaration_extension">
                            <label>An extension in scope of existing accreditation for a:</label>
                        </div>
                        <div class="form-group">
                            <label>6.2. 	The organisation/Proficiency Testing Provider agrees to conform, upon accreditation, to PNAC requirements as detailed in the Agreement [F-01/20].</label>
                        </div>
                        <div class="form-group">
                            <label>6.3. 	I enclose a copy of Quality Manual and Quality Procedures (see Note below)</label>
                        </div>
                        <div class="form-group">
                            <label>6.4. 	I enclose a cheque (payable to PNAC) for the Applicant fee of ________.I understand that this fee is non-refundable. (see Note below). </label>
                        </div>
                        <div class="form-group">
                            <label>6.5. 	I understand the manner in which the accreditation system functions.</label>
                        </div>
                        <div class="form-group">
                            <label>6.6. 	I declare that the information given in this form is correct to the best of my knowledge and belief</label>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label>Signed</label>
                                <input type="file" name="declaration_signed" value="{{ $proficiency->declaration_signed }}" class="form-control">
                                <img src="{{ asset('storage/'.$proficiency->declaration_signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="declaration_date" value="{{ $proficiency->declaration_date }}" class="form-control">
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn" id="NextBtn">Next</button>
                                <div class="submit-btn-wrapper d-none">
                                    <button type="submit" class="btn btn-success">Save Change</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>
</form>
