<form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">

        <div class="row section-form halal-section-form" id="GeneralInfo-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5>Application form for the Accreditation of Halal Certification Body</h5>
                            <h6>Please type or write clearly</h6>
                        </div>

                        <div class="form-group">
                            <label>Halal Certification Body (HCB)</label>
                            <input type="text" name="hala_body" value="{{ $halal->hala_body }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $halal->address }}" name="address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $halal->postcode }}" name="postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $halal->tel }}" name="tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $halal->fax }}" name="fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" value="{{ $halal->contact_name }}" name="contact_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="{{ $halal->designation }}" name="designation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" value="{{ $halal->person_address }}" name="person_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{ $halal->person_postcode }}" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{ $halal->person_tel }}" name="person_tel" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{ $halal->person_fax }}" name="person_fax" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" value="{{ $halal->person_email }}" name="person_email" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Details of sub-offices/marketing offices in other cities</label>
                            <input type="text" value="{{ $halal->person_detail }}" name="person_detail" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($halal->chack_accreditation == 'on') checked @endif name="chack_accreditation">
                            <label for="">New accreditation as a Halal Certification Body for;</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($halal->chack_laboratory == 'on') checked @endif name="chack_laboratory">
                            <label for="">Halal (scope)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($halal->chack_extension == 'on') checked @endif name="chack_extension">
                            <label for=""> Extension of scope</label>
                        </div>
                        <div class="form-group">
                            <h5>For new accreditation only: I enclosed (tick boxes)</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->chack_hcb == 'on') checked @endif name="chack_hcb">
                                <label for="">A copy of the HCBs Quality Manual</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->chack_Applicant == 'on') checked @endif name="chack_Applicant">
                                <label for="">Applicant fee-see note below</label>
                            </div>
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

        <div class="row section-form halal-section-form" id="AboutYourselves-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>About HCB</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please type or write clearly</h5>
                        </div>
                        <div class="form-group">
                            <h5>1.1	Name and position (Director level) of person authorising this application</h5>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" value="{{ $halal->selves_title }}" name="selves_title" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" value="{{ $halal->selves_name }}" name="selves_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" value="{{ $halal->selves_position }}" name="selves_position" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2	Name and address of parent organisation (if different from HCB address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $halal->selves_parent_organization }}" name="selves_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $halal->selves_address }}" name="selves_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $halal->selves_postcode }}" name="selves_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $halal->selves_tel }}" name="selves_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $halal->selves_fax }}" name="selves_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.3	Address for invoicing (if different from HCB address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $halal->selves_invoicing_organization }}" name="selves_invoicing_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $halal->selves_invoicing_address }}" name="selves_invoicing_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $halal->selves_postcode }}" name="selves_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $halal->selves_invoicing_tel }}" name="selves_invoicing_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $halal->selves_invoicing_fax }}" name="selves_invoicing_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4	Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->selves_individual == 'on') checked @endif name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->selves_public == 'on') checked @endif name="selves_public">
                                <label>Owned by public limited Company</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->selves_private == 'on') checked @endif name="selves_private">
                                <label>Owned by a private company/partnership</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->selves_learned == 'on') checked @endif name="selves_learned">
                                <label>Part of learned/tech institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->selves_industry == 'on') checked @endif name="selves_industry">
                                <label>Owned by a public body/nationalised industry</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($halal->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" value="{{ $halal->selves_other_describe }}" name="selves_other_describe" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5	Is Halal Certification the main activity of the CAB?</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" @if($halal->selves_activities == 'Yes') checked @endif name="selves_activities" value="Yes">
                            <label>Yes</label>
                            <input type="radio" @if($halal->selves_activities == 'No') checked @endif name="selves_activities" value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the CAB</label>
                            <input type="text" value="{{ $halal->selves_cab_activities }}" name="selves_cab_activities" class="form-control">

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

        <div class="row section-form halal-section-form" id="AboutYourStaff-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 2 – HCB Staff</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please type or write clearly</h5>
                        </div>
                        <div class="form-group">
                            <h6>2.1	Please list the names, qualifications and relevant experience of the following staff</h6>
                        </div>

                        <div class="form-group">
                            <h6>A.	Chief Executive</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $halal->staff_chief_name }}" name="staff_chief_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" value="{{ $halal->staff_chief_religion }}" name="staff_chief_religion" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $halal->staff_chief_qualifications }}" name="staff_chief_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $halal->staff_chief_relevant }}" name="staff_chief_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $halal->staff_chief_exp }}" name="staff_chief_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>B.	Shariah Expert/Adviser</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $halal->staff_shariah_name }}" name="staff_shariah_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" value="{{ $halal->staff_shariah_religion }}" name="staff_shariah_religion" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $halal->staff_shariah_qualifications }}" name="staff_shariah_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $halal->staff_shariah_relevant }}" name="staff_shariah_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $halal->staff_shariah_exp }}" name="staff_shariah_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>Quality Management Representative</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $halal->staff_quality_name }}" name="staff_quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" value="{{ $halal->staff_quality_religion }}" name="staff_quality_religion" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $halal->staff_quality_qualifications }}" name="staff_quality_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $halal->staff_quality_relevant }}" name="staff_quality_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $halal->staff_quality_exp }}" name="staff_quality_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>D.	Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $halal->staff_manage_name }}" name="staff_manage_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" value="{{ $halal->staff_manage_religion }}" name="staff_manage_religion" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $halal->staff_manage_qualifications }}" name="staff_manage_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $halal->staff_manage_relevant }}" name="staff_manage_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $halal->staff_manage_exp }}" name="staff_manage_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <p>2.2	Please list the names, qualifications, relevant auditing fields and experience of the Auditors/Experts/Technologists who are permanent employees of the company.</p>
                        </div>
                        <div class="form-group">
                            <h6>A.	Auditors/Experts (if required please attach extra sheets)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $halal->staff_audit_name }}" name="staff_audit_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" value="{{ $halal->staff_audit_religion }}" name="staff_audit_religion" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $halal->staff_audit_qualifications }}" name="staff_audit_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Field</label>
                            <input type="text" value="{{ $halal->staff_audit_field }}" name="staff_audit_field" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Experience</label>
                            <input type="text" value="{{ $halal->staff_audit_exp }}" name="staff_audit_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <p>
                                B.	 Please list the name, qualification, relevant auditing field and experience of the Auditors/Experts who are not the permanent employees of the company like Sub-contracted/Free lance/Empanelled Auditors/Experts (if required please attach extra sheets)
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $halal->staff_list_name }}" name="staff_list_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" value="{{ $halal->staff_list_religion }}" name="staff_list_religion" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $halal->staff_list_qualifications }}" name="staff_list_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Field</label>
                            <input type="text" value="{{ $halal-> staff_list_field}}" name="staff_list_field" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Experience</label>
                            <input type="text" value="{{ $halal->staff_list_exp }}" name="staff_list_exp" required class="form-control">
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

        <div class="row section-form halal-section-form" id="ScopeApplication-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope of application</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                (For ref please see Annex-(A) in Accreditation Conditions for HCB)
                                List all the sectors/areas required for accreditation (if required please attach extra sheets)
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Cat. Code</label>
                            <input type="text" value="{{ $halal->scop_cat_code }}" name="scop_cat_code" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" value="{{ $halal->scop_category }}" name="scop_category" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Category Example</label>
                            <input type="text" value="{{ $halal->scop_cat_exap }}" name="scop_cat_exap" required class="form-control">
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

        {{-- parts 4 --}}
        <div class="row section-form halal-section-form" id="AboutQuality-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 4 - Quality System</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                Please answer every question, adding comments as necessary
                            </p>
                        </div>
                        <div class="form-group">
                            <b>
                                A. Organisation & Management
                            </b>
                        </div>
                        <div class="form-group">
                            <label>1.   Has the copy of the Quality Manual provided with this application? If "No" give reason </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_quality == 'Yes') checked @endif name="org_quality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_quality == 'No') checked @endif name="org_quality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="org_quality_comment" required class="form-control">{{ $halal->org_quality_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Has the policy and procedures for the operation of the HCB identified in the Quality Manual?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_policy == 'Yes') checked @endif name="org_policy" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_policy == 'No') checked @endif name="org_policy" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_policy_comment" class="form-control">{{ $halal->org_policy_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Have the documented procedures for control of the changes to the Quality System Documentation provided?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_procedures == 'Yes') checked @endif name="org_procedures" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_procedures == 'No') checked @endif name="org_procedures" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_procedures_comment" class="form-control">{{ $halal->org_procedures_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                4. Has the Quality Manual contain charts showing
                                •	The organisation structure of      HCB.
                                •	The relationship to any parent organisation?
                                •	Availability of resources to carry out the task?

                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_manual == 'Yes') checked @endif name="org_manual" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_manual == 'No') checked @endif name="org_manual" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_manual_comment" class="form-control">{{ $halal->org_manual_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                5. Has the Shariah expert held the responsibility alone and with authority to identify and accept/reject related Halal matters according to Shariah?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_shariah == 'Yes') checked @endif name="org_shariah" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_shariah == 'No') checked @endif name="org_shariah" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_shariah_comment" class="form-control">{{ $halal->org_shariah_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                6. Has the QMR the responsibility and authority to identify quality problems and initiate effective solutions?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_qmr == 'Yes') checked @endif name="org_qmr" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_qmr == 'No') checked @endif name="org_qmr" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_qmr_comment" class="form-control">{{ $halal->org_qmr_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                7. Has the HCB been held legally responsible for its activities?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_hcb == 'Yes') checked @endif name="org_hcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_hcb == 'No') checked @endif name="org_hcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_hcb_comment" class="form-control">{{ $halal->org_hcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                8. Has the quality manual referred to the availability of financial resources to carry out the Halal Certification activities?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->org_referred == 'Yes') checked @endif name="org_referred" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->org_referred == 'No') checked @endif name="org_referred" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_referred_comment" class="form-control">{{ $halal->org_referred_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>
                                B. Quality audit and review
                            </h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Has the documented quality procedures identified for auditing all HCB systems?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->quality_doc == 'Yes') checked @endif name="quality_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->quality_doc == 'No') checked @endif name="quality_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_doc_comment" class="form-control">{{ $halal->quality_doc_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. How frequently quality audits are held?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->quality_frequently == 'Yes') checked @endif name="quality_frequently" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->quality_frequently == 'No') checked @endif name="quality_frequently" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_frequently_comment" class="form-control">{{ $halal->quality_frequently_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                3. Has the records of quality audits maintained?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->quality_records == 'Yes') checked @endif name="quality_records" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->quality_records == 'No') checked @endif name="quality_records" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_records_comment" class="form-control">{{ $halal->quality_records_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                4. Has the HCB's quality system reviewed at regular intervals?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->quality_hcb == 'Yes') checked @endif name="quality_hcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->quality_hcb == 'No') checked @endif name="quality_hcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_hcb_comment" class="form-control">{{ $halal->quality_hcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                5. How frequently review of the quality system is conducted?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->quality_review == 'Yes') checked @endif name="quality_review" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->quality_review == 'No') checked @endif name="quality_review" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_review_comment" class="form-control">{{ $halal->quality_review_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>C. Halal Certification Body staff</h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Has the Quality System identified the provisions for the proper supervision of qualified/unqualified staff?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->halal_quality == 'Yes') checked @endif name="halal_quality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->halal_quality == 'Yes') checked @endif name="halal_quality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="halal_quality_comment" class="form-control">{{ $halal->halal_quality_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. Have appropriate standards of professional ability, Islamic knowledge, qualifications and experience been prescribed for managerial posts?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->halal_appropriate == 'Yes') checked @endif name="halal_appropriate" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->halal_appropriate == 'No') checked @endif name="halal_appropriate" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="halal_appropriate_comment" class="form-control">{{ $halal->halal_appropriate_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                3. Are documented training arrangements and records available?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->halal_doc == 'Yes') checked @endif name="halal_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->halal_doc == 'No') checked @endif name="halal_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="halal_doc_comment" class="form-control">{{ $halal->halal_doc_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>D.  Procedures</h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Are all procedures fully documented?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->proced_doc == 'Yes') checked @endif name="proced_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->proced_doc == 'No') checked @endif name="proced_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="proced_doc_comment" class="form-control">{{ $halal->proced_doc_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. Are the documents referred above made available to all concerned sections?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->proced_referred == 'Yes') checked @endif name="proced_referred" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->proced_referred == 'No') checked @endif name="proced_referred" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="proced_referred_comment" class="form-control">{{ $halal->proced_referred_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>E. 	Records</h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Is there a prescribed system for maintaining records?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->record_prescribed == 'Yes') checked @endif name="record_prescribed" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->record_prescribed == 'No') checked @endif name="record_prescribed" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="record_prescribed_comment" class="form-control">{{ $halal->record_prescribed_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. Are there arrangements for ensuring the accuracy, completeness and confidentiality of all records?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->record_arrang == 'Yes') checked @endif name="record_arrang" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->record_arrang == 'No') checked @endif name="record_arrang" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="record_arrang_comment" class="form-control">{{ $halal->record_arrang_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                4. Does and how long the HCB retains the original recorded observations and derived data?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->record_hcb == 'Yes') checked @endif name="record_hcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->record_hcb == 'No') checked @endif name="record_hcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="record_hcb_comment" class="form-control">{{ $halal->record_hcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>
                                F. 	Complaints and anomalies
                            </h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Has the HCB documented procedure for handling complaints/anomalies?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->complaint_hcb == 'Yes') checked @endif name="complaint_hcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->complaint_hcb == 'No') checked @endif name="complaint_hcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="complaint_hcb_comment" class="form-control">{{ $halal->complaint_hcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. Does the HCB keep records of complaints/anomalies and actions taken?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->complaint_record == 'Yes') checked @endif name="complaint_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->complaint_record == 'No') checked @endif name="complaint_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="complaint_record_comment" class="form-control">{{ $halal->complaint_record_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>
                                G. 	Sub-contracting
                            </h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Does the HCB sub-contract assessments/audits
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->subcontract_hcb == 'Yes') checked @endif name="subcontract_hcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->subcontract_hcb == 'No') checked @endif name="subcontract_hcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="subcontract_hcb_comment" class="form-control">{{ $halal->subcontract_hcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. Does the CB has a documented policy on sub-contracting?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->subcontract_cb == 'Yes') checked @endif name="subcontract_cb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->subcontract_cb == 'No') checked @endif name="subcontract_cb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="subcontract_cb_comment" class="form-control">{{ $halal->subcontract_cb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                3. Does the HCB have a register of all sub-contractors used and a record of sub-contracted work?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->subcontract_register == 'Yes') checked @endif name="subcontract_register" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->subcontract_register == 'No') checked @endif name="subcontract_register" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="subcontract_register_comment" class="form-control">{{ $halal->subcontract_register_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>
                                H. 	Outside Support Services
                            </h5>
                        </div>
                        <div class="form-group">
                            <label>
                                1. Does the HCB have a documented policy on the procurement of supplies and support services?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->outside_doc == 'Yes') checked @endif name="outside_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->outside_doc == 'No') checked @endif name="outside_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="outside_doc_comment" class="form-control">{{ $halal->outside_doc_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                2. Does the HCB keep records of such suppliers?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->outside_hcb == 'Yes') checked @endif name="outside_hcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->outside_hcb == 'No') checked @endif name="outside_hcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="outside_hcb_comment" class="form-control">{{ $halal->outside_hcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                I. 	Compliance with PS 4992:2010, PNAC Accreditation Requirements and guidelines
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($halal->compliance_check == 'Yes') checked @endif name="compliance_check" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($halal->compliance_check == 'No') checked @endif name="compliance_check" value="No">
                                <label for="">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                If "No" then in which specific areas do not comply, and when non-compliance will be rectified?
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Area of non-compliance </label>
                            <input type="text" value="{{ $halal->compliance_check }}" name="compliance_check" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Rectified by (date)</label>
                            <input type="date" value="{{ $halal->rectified_date }}" name="rectified_date" class="form-control">
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
        <div class="row section-form halal-section-form" id="OtherApprovals-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 5 - Other Approvals (Accreditation / Certification)</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please provide detail current approvals held by your Certification Body</h5>
                        </div>
                        <div class="form-group">
                            <label>Name & address of approval body</label>
                            <textarea name="approvals_name" class="form-control">{{ $halal->approvals_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Scope of accreditation/approval and number of certificate (if any)</label>
                            <textarea name="approvals_scope" class="form-control">{{ $halal->approvals_scope }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Period of accreditation/approval</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Start</label>
                                <input type="date" name="approvals_start_date" value="{{ $halal->approvals_start_date }}" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Expiry Date</label>
                                <input type="date" name="approvals_end_date" value="{{ $halal->approvals_end_date }}" class="form-control">
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
        <div class="row section-form halal-section-form" id="Declaration-Halal-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 6 - Declaration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>This declaration should be made by the person named in Section 1.1</h5>
                        </div>
                        <div class="form-group">
                            <label>6.1 	That the Certification Body applies to PNAC for accreditation for (please tick appropriate boxes)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($halal->declaration_halal == 'on') checked @endif name="declaration_halal">
                            <label>Halal(Scope as per Annex A)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($halal->declaration_extension == 'on') checked @endif name="declaration_extension">
                            <label>An extension in scope of existing accreditation</label>
                        </div>
                        <div class="form-group">
                            <label>6.2. 	That the organisation agrees to conform with PNAC requirements, upon accreditation, as detailed in the Agreement [F-01/18].</label>
                        </div>
                        <div class="form-group">
                            <label>6.3. 	That I enclose a copy of Quality Manual (see Note below)</label>
                        </div>
                        <div class="form-group">
                            <label>6.4. 	That I enclose a cheque (payable to PNAC) as the Applicant fee  ________  and I understand that this fee is non-refundable. (See Note below).</label>
                        </div>
                        <div class="form-group">
                            <label>6.5. 	That I understand the procedures of accreditation system and functions</label>
                        </div>
                        <div class="form-group">
                            <label>6.6. 	That I declare that the information given in this form is correct to the best of my knowledge and belief</label>
                        </div>


                        <div class="row">
                            <div class="form-group col-6">
                                <label>Signed</label>
                                <input type="file" name="declaration_signed" value="{{ $halal->declaration_signed }}" class="form-control">
                                <img src="{{ asset('storage/'.$halal->declaration_signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="declaration_date" value="{{ $halal->declaration_date }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <h5>
                                Note: PNAC will not process application until it has received Quality Manual, procedures of the CAB and application fee of PNAC.
                            </h5>
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
