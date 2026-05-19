<form action="{{ route('application.update', $certification->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">

        <input type="hidden" name="category" value="{{ $scheme_name }}">


        {{-- General Info --}}
        <div class="row section-form certification-section-form" id="GeneralInfo-Certification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5> Application For Certification Body Accreditation (ISO/IEC 17021-1)</h5>
                            <h6>Please type or use BLOCK LETTERS</h6>
                        </div>
                        <div class="form-group">
                            <label>Certification Body (CB)</label>
                            <input type="text" value="{{  $certification->certification_body }}" name="certification_body" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{  $certification->general_address }}" name="general_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{  $certification->postcode }}" name="postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{  $certification->tel }}" name="tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{  $certification->fax }}" name="fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" value="{{  $certification->contact_name }}" name="contact_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="{{  $certification->designation }}" name="designation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" value="{{  $certification->person_address }}" name="person_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{  $certification->person_postcode }}" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{  $certification->person_tel }}" name="person_tel" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{  $certification->person_fax }}" name="person_fax" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" name="person_email" value="{{  $certification->person_email }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Details of sub-offices/marketing</label>
                            <input type="text" name="sub_offices" value="{{  $certification->sub_offices }}" required class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label>offices in other cities</label>
                            <input type="text" name="offices_cities" value="{{  $certification->offices_cities }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($certification->chack_calibration == 'on') checked @endif name="new_accreditation">
                            <label for="">New accreditation as a certification body for;</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-2">
                                <input type="checkbox" @if($certification->qms == 'on') checked @endif name="qms">
                                <label for="">QMS</label>
                            </div>
                            <div class="form-group col-2">
                                <input type="checkbox" @if($certification->EMS == 'on') checked @endif name="EMS">
                                <label for="">EMS</label>
                            </div>
                            <div class="form-group col-2">
                                <input type="checkbox" @if($certification->FSMS == 'on') checked @endif name="FSMS">
                                <label for="">FSMS</label>
                            </div>
                            <div class="form-group col-2">
                                <input type="checkbox" @if($certification->ISO_45001 == 'on') checked @endif name="ISO_45001">
                                <label for="">ISO 45001</label>
                            </div>
                            <div class="form-group col-2">
                                <input type="checkbox" @if($certification->ISO_13485 == 'on') checked @endif name="ISO_13485">
                                <label for="">ISO 13485</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($certification->other_management == 'on') checked @endif name="other_management">
                            <label for="">Other type of Management System _______(under the scope of ISO/IEC 17021-1)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($certification->extension_scope == 'on') checked @endif name="extension_scope">
                            <label for="">Extension of scope</label>
                        </div>


                        <div class="form-group">
                            <h5>For new accreditation only: I enclosed (tick boxes)</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_quality_manual == 'on') checked @endif name="chack_quality_manual">
                                <label for="">A copy of the CBs Quality Manual</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_procedures == 'on') checked @endif name="chack_procedures">
                                <label for="">A copy of the CBs Quality Procedures</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_list_staff == 'on') checked @endif name="chack_list_staff">
                                <label for="">List of staff</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_list_certified == 'on') checked @endif name="chack_list_certified">
                                <label for="">List of certified organizations</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_applicant == 'on') checked @endif name="chack_applicant">
                                <label for="">Applicant fee-see note below</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_proof == 'on') checked @endif name="chack_proof">
                                <label for="">Proof of legal entity</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($certification->chack_filled_form == 'on') checked @endif name="chack_filled_form">
                            <label for="">Filled form F-02/29-Document Review and Preassessment ISO/IEC 17021-1:2015</label>
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

        {{-- Part 1 --}}
        <div class="row section-form certification-section-form" id="AboutYourselves-Certification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>About yourselves</h4>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <h4>Please type or use BLOCK LETTERS</h4>
                        </div>
                        <div class="form-group">
                            <h5>1.1 Name and position (Director level) of person authorising this application</h5>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" value="{{  $certification->selves_title }}" name="selves_title" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" value="{{  $certification->selves_name }}" name="selves_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" value="{{  $certification->selves_position }}" name="selves_position" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2 Name and address of the parent organisation (if any) of the CB</h5>
                        </div>
                        <div class="form-group">
                            <label>Parent Organization</label>
                            <input type="text" value="{{  $certification->selves_parent_organization }}" name="selves_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relationship with Parent Organization</label>
                            <input type="text" value="{{  $certification->selves_parent_relationship }}" name="selves_parent_relationship" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{  $certification->selves_parent_address }}" name="selves_parent_address" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Postcode</label>
                            <input type="text" value="{{  $certification->selves_parent_postcode }}" name="selves_parent_postcode" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tel</label>
                            <input type="text" value="{{  $certification->selves_parent_tel }}" name="selves_parent_tel" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fax</label>
                            <input type="text" value="{{  $certification->selves_parent_fax }}" name="selves_parent_fax" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>1.3 Address for invoicing (if different from CB address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{  $certification->selves_invoicing_organization }}" name="selves_invoicing_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{  $certification->selves_invoicing_address }}" name="selves_invoicing_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{  $certification->selves_invoicing_postcode }}" name="selves_invoicing_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{  $certification->selves_invoicing_tel }}" name="selves_invoicing_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{  $certification->selves_invoicing_fax }}" name="selves_invoicing_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4 Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->selves_individual == 'on') checked @endif name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->selves_public == 'on') checked @endif name="selves_public">
                                <label>Owned by public limited Company</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->chack_calibration == 'on') checked @endif name="selves_private">
                                <label>Owned by a private company/partnership</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->selves_tech == 'on') checked @endif name="selves_tech">
                                <label>Part of learned/tech institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->selves_nationalised == 'on') checked @endif name="selves_nationalised">
                                <label>Owned by a public body/nationalised industry</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($certification->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" value="{{  $certification->selves_other_describe }}" name="selves_other_describe" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5 Is certification the main activity of the company</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="selves_activities" @if($certification->selves_activities == 'Yes') checked @endif value="Yes">
                            <label>Yes</label>
                            <input type="radio" name="selves_activities" @if($certification->selves_activities == 'No') checked @endif value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the company</label>
                            <input type="text" value="{{  $certification->selves_main_activities }}" name="selves_main_activities" required class="form-control">

                        </div>


                        <div class="form-group">
                            <h5>1.6 Name of Consultant / Consultancy Firm (if any)</h5>
                        </div>
                        <div class="row">

                            <div class="form-group col-6">
                                <label>Name</label>
                                <input type="text" value="{{  $certification->selves_consultant_name }}" name="selves_consultant_name" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Organisation(if any)</label>
                                <input type="text" value="{{  $certification->selves_consultant_Org }}" name="selves_consultant_Org" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Address</label>
                                <input type="text" value="{{  $certification->selves_consultant_address }}" name="selves_consultant_address" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{  $certification->selves_consultant_postcode }}" name="selves_consultant_postcode" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{  $certification->selves_consultant_tel }}" name="selves_consultant_tel" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{  $certification->selves_consultant_fax }}" name="selves_consultant_fax" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" name="selves_consultant_email" value="{{  $certification->selves_consultant_email }}" class="form-control">
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

        {{-- Part 2 --}}
        <div class="row section-form certification-section-form" id="AboutYourStaff-Certification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>About Your Staff</h4>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <h5>Please type or use BLOCK LETTERS</h5>
                        </div>
                        <div class="form-group">
                            <h5>2.1 Please list the names, qualifications and relevant experience of the following staff</h5>
                        </div>
                        <div class="form-group">
                            <h6>A. Chief Executive</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{  $certification->staff_chief_name }}" name="staff_chief_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{  $certification->staff_chief_qualifications }}" name="staff_chief_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{  $certification->staff_chief_relevant }}" name="staff_chief_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{  $certification->staff_chief_exp }}" name="staff_chief_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>B. Quality Management Representative </h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{  $certification->staff_quality_name }}" name="staff_quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{  $certification->staff_quality_qualifications }}" name="staff_quality_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{  $certification->staff_quality_relevant }}" name="staff_quality_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{  $certification->staff_quality_exp }}" name="staff_quality_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>C. Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{  $certification->staff_manag_name }}" name="staff_manag_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{  $certification->staff_manag_qualifications }}" name="staff_manag_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{  $certification->staff_manag_relevant }}" name="staff_manag_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{  $certification->staff_manag_exp }}" name="staff_manag_exp" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>2.2 Please list the names, qualifications, relevant auditing fields (e.g., QMS/EMS) and experience of the Assessors/Auditors who are permanent employees of the company.</h5>
                        </div>
                        <div class="form-group">
                            <h5>A. Assessors/Auditors (if required please attach extra sheets)</h5>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{  $certification->staff_assessor_name }}" name="staff_assessor_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{  $certification->staff_assessor_qualifications }}" name="staff_assessor_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" value="{{  $certification->staff_assessor_auditing }}" name="staff_assessor_auditing" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Experience</label>
                            <input type="text" value="{{  $certification->staff_assessor_exp }}" name="staff_assessor_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>2.2 Please list the names, qualifications, relevant auditing fields (e.g., QMS/EMS) and experience of the Assessors/Auditors who are not the permanent employees of the company</h5>
                        </div>
                        <div class="form-group">
                            <h5>B. Sub-contracted/Free lance/Empanelled Assessors/Auditors(if required please attach extra sheets)</h5>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{  $certification->staff_sub_name }}" name="staff_sub_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{  $certification->staff_sub_qualifications }}" name="staff_sub_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" value="{{  $certification->staff_sub_auditing }}" name="staff_sub_auditing" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Experience</label>
                            <input type="text" value="{{  $certification->staff_sub_exp }}" name="staff_sub_exp" required class="form-control">
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

        {{-- Part 3 --}}
        <div class="row section-form certification-section-form" id="ScopeApplication-Certification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope Application</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>
                                A: Quality Management System ISO 9001:2015
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if required please attach extra sheets)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 17)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Technical Cluster</label>
                            <textarea name="scop_technical_a" required class="form-control">{{  $certification->scop_technical_a }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>IAF code</label>
                            <textarea name="scop_iaf_a" required class="form-control">{{  $certification->scop_iaf_a }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Description of economic sector/activity, according to IAF ID1</label>
                            <textarea name="scop_economic_a" required class="form-control">{{  $certification->scop_economic_a }}</textarea>
                        </div>
                        <div class="form-group">
                            <h5>
                                B: Quality Management System ISO 14001:2015
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if required please attach extra sheets)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 17)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Technical Cluster</label>
                            <textarea name="scop_technical_b" required class="form-control">{{  $certification->scop_technical_b }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>IAF code</label>
                            <textarea name="scop_iaf_b" required class="form-control">{{  $certification->scop_iaf_b }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Description of economic sector/activity, according to IAF ID1</label>
                            <textarea name="scop_economic_b" required class="form-control">{{  $certification->scop_economic_b }}</textarea>
                        </div>
                        <div class="form-group">
                            <h5>
                                C: Quality Management System ISO 45001:2018
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if required please attach extra sheets)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 17)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Technical Cluster</label>
                            <textarea name="scop_technical_c" required class="form-control">{{  $certification->scop_technical_c }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>IAF code</label>
                            <textarea name="scop_iaf_c" required class="form-control">{{  $certification->scop_iaf_c }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Description of economic sector/activity, according to IAF ID1</label>
                            <textarea name="scop_economic_c" required class="form-control">{{  $certification->scop_economic_c }}</textarea>
                        </div>

                        <div class="form-group">
                            <h5>
                                D: Food Safety Management System (FSMS)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if required please attach extra sheets)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                As per the requirements id IAF-MD 16
                            </h6>
                        </div>

                        <div class="form-group">
                            <label>Cluster</label>
                            <input type="text" value="{{  $certification->scop_cluster }}" name="scop_cluster" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" value="{{  $certification->scop_category }}" name="scop_category" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sub-Category</label>
                            <input type="text" value="{{  $certification->scop_subcategory }}" name="scop_subcategory" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Activities</label>
                            <input type="text" value="{{  $certification->scop_activity }}" name="scop_activity" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>
                                E: Medical Device Quality Management Systems (ISO 13485)
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                List all the sectors/areas which you seek accreditation. (if required please attach extra sheets).
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (As defined in IAF MD 8)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Main Technical Areas</label>
                            <input type="text" value="{{  $certification->scop_main_tech }}" name="scop_main_tech" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Technical Areas</label>
                            <input type="text" value="{{  $certification->scop_areas }}" name="scop_areas" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Product Categories Covered by the Technical Areas</label>
                            <input type="text" value="{{  $certification->scop_product }}" name="scop_product" required class="form-control">
                        </div>


                        <div class="form-group">
                            <label>Uncertainty of Measurement (where applicable)
                                ( + )
                            </label>
                            <textarea name="scop_uncertainty" required class="form-control">{{  $certification->scop_uncertainty }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Standard specification/Techniques/equipment used</label>
                            <textarea name="scop_standard" required class="form-control">{{  $certification->scop_standard }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>*Quality Control Measures</label>
                            <textarea name="scop_quality" required class="form-control">{{  $certification->scop_quality }}</textarea>
                        </div>
                        <div class="form-group">
                            <h6>
                                *Mention all measures in practice for quality control </h6>
                        </div>
                        <div class="form-group">
                            <h5>
                                1. Proficiency Testing
                                2. Inter Lab Comparison
                                3. Use of CRM/SRM
                                4. Repeatability / Reproducibility
                                5. Control Charts
                            </h5>
                        </div>
                        <div class="form-group">
                            <h5>
                                3B List the major items of equipment currently used for the types of test listed in 3A
                            </h5>
                            <h6>
                                (Use extra sheet, if the space given is found insufficient)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Name of Equipment</label>
                            <textarea name="scop_major_name" required class="form-control">{{  $certification->scop_major_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Model/Type/year of make</label>
                            <textarea name="scop_major_model" required class="form-control">{{  $certification->scop_major_model }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Working Range/capacity of equipment</label>
                            <textarea name="scop_major_working" required class="form-control">{{  $certification->scop_major_working }}</textarea>
                            <div class="form-group">
                                <label>Minimum detection limit</label>
                                <textarea name="scop_major_minimum" required class="form-control">{{  $certification->scop_major_minimum }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Last date of calibration</label>
                                <textarea name="scop_major_lastdate" required class="form-control">{{  $certification->scop_major_lastdate }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Calibration due date</label>
                                <textarea name="scop_major_duedate" required class="form-control">{{  $certification->scop_major_duedate }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Test for which used and other relevant information</label>
                                <textarea name="scop_major_test" required class="form-control">{{  $certification->scop_major_test }}</textarea>
                            </div>

                            <div class="form-group">
                                <h5>
                                    3C. List of Reference Standard/Material. </h5>
                                <h6>
                                    (Use extra sheet, if the space given is found insufficient)
                                </h6>
                            </div>
                            <div class="form-group">
                                <label>Name of Equipment</label>
                                <textarea name="scop_reference_name" required class="form-control">{{  $certification->scop_reference_name }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Source/Supplier’s name</label>
                                <textarea name="scop_reference_source" required class="form-control">{{  $certification->scop_reference_source }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Date of expiry/validity</label>
                                <textarea name="scop_reference_date_ex" required class="form-control">{{  $certification->scop_reference_date_ex }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Traceability</label>
                                <textarea name="scop_reference_traceability" required class="form-control">{{  $certification->scop_reference_traceability }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Purpose of use</label>
                                <textarea name="scop_reference_purpose" required class="form-control">{{  $certification->scop_reference_purpose }}</textarea>
                            </div>

                            <div class="form-group">
                                <h5>
                                    3D: Proficiency Testing:
                                </h5>
                                <h6>
                                    Participation in recognised proficiency testing (for further details and requirements please refer to ISO/IEC 17043, PNAC Guide 02/13.
                                </h6>
                                <h6>
                                    <b>(Use extra sheet, if the space given is found insufficient)</b>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label>Product / Material/Sample Type</label>
                                <textarea name="scop_proficiency_product" required class="form-control">{{  $certification->scop_proficiency_product }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Details of Test(s)/examination</label>
                                <textarea name="scop_proficiency_details" required class="form-control">{{  $certification->scop_proficiency_details }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Date of testing/examination</label>
                                <textarea name="scop_proficiency_date" required class="form-control">{{  $certification->scop_proficiency_date }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Organizing body</label>
                                <textarea name="scop_proficiency_organizing" required class="form-control">{{  $certification->scop_proficiency_organizing }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Performance in term of Z -score or any other criteria</label>
                                <textarea name="scop_proficiency_performance" required class="form-control">{{  $certification->scop_proficiency_performance }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Corrective actions taken (if required)</label>
                                <textarea name="scop_proficiency_corrective" required class="form-control">{{  $certification->scop_proficiency_corrective }}</textarea>
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
        </div>

        {{-- Part 4 --}}
        <div class="row section-form certification-section-form" id="AboutQuality-Certification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 4 - About your quality system</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                Please provide the filled form F-02/29 answer every question, adding comments as necessary
                            </p>
                        </div>
                        <div class="form-group">
                            <b>
                                A. Equipment and calibration
                            </b>
                        </div>
                        <div class="form-group">
                            <label>Compliance with ISO/IEC 17021-1:2015 and PNAC Accreditation Requirements</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">1. Do you consider that your Certification Body complies with ISO/IEC 17021-1 and PNAC accreditation requirements?</label>
                                <input type="radio" name="quality_consider" @if($certification->quality_consider == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_consider" @if($certification->quality_consider == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="">"No" in which specific areas does it not comply, and when do you expect non-compliance be rectified?</label>
                        </div>
                        <div class="form-group">
                            <label for="">Area of non-compliance</label>
                            <input type="text" value="{{  $certification->quality_noncompliance }}" name="quality_noncompliance" required class="form-control">

                        </div>
                        <div class="form-group">
                            <label for="">Rectified by (date)</label>
                            <input type="date" name="quality_rect_date" value="{{  $certification->quality_rect_date }}" required class="form-control">
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

        {{-- Part 5 --}}
        <div class="row section-form certification-section-form" id="OtherApprovals-Certification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 5 - Other approvals (certifications/ accreditations)</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <p>
                                Please detail current approvals held by your Certification Body
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="">Name & address of approval body</label>
                            <input type="text" value="{{  $certification->quality_name }}" name="quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Scope of accreditation/approval and number of certificate (if any)</label>
                            <input type="text" value="{{  $certification->quality_accreditation }}" name="quality_accreditation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Period of accreditation/approval</label>
                        </div>
                        <div class="form-group">
                            <label for="">Start</label>
                            <input type="date" name="quality_start_date" value="{{  $certification->quality_start_date }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Expiry Date</label>
                            <input type="date" name="quality_expiry_date" value="{{  $certification->quality_expiry_date }}" required class="form-control">
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

        {{-- Part 6 --}}
        <div class="row section-form certification-section-form" id="Declaration-Certification-form">
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
                            <label>6.1 The Certification Body applies for accreditation by PNAC for above mentioned scope.</label>
                        </div>


                        <div class="form-group">
                            <h6>
                                6.2. The CB/organisation agrees to conform, upon accreditation, with PNAC requirements as detailed in the Agreement [F-01/08].
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                6.3. I enclose a copy of Quality Manual and other documents/information (see Note below)
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>6.4. I enclose a cheque (payable to PNAC) for the Applicant fee of ________. I understand that this fee is non-refundable. (see Note below).</h6>
                        </div>
                        <div class="form-group">
                            <h6>6.5. I understand the manner in which the accreditation system functions.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                I declare that the information given in this form is correct to the best of my knowledge and belief
                            </h6>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label>Signed</label>
                                <input type="file" name="signed" value="{{  $certification->signed }}" class="form-control">
                                <img src="{{ asset('storage/'.$certification->signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="date" value="{{  $certification->date }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>
                                <b>Note:</b> PNAC will not process your application until it has received your Quality Manual, procedures, other documents/information and application fee.
                            </h6>
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

