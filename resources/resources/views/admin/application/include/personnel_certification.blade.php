<form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">

        {{-- General --}}
        <div class="row section-form product-certification-section-form" id="GeneralInfo-PersonnelCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5>Application by Conformity assessment Body for Accreditation in accordance to ISO/IEC
                                17024 (General Requirements for bodies operating certification of persons)</h5>
                            <h6>Please type or use BLOCK LETTERS</h6>
                        </div>

                        <div class="form-group">
                            <label>Name and Address of Certification Body</label>
                            <input type="text" name="name_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" name="postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" name="tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" name="fax" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" name="email" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Website</label>
                                <input type="text" name="website" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact Person:</label>
                            <input type="text" name="contact_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" name="designation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" name="person_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" name="person_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Call No</label>
                                <input type="text" name="person_cal_no" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" name="person_fax" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" name="person_email" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Details of sub-offices in other cities</label>
                            <input type="text" name="person_detail" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_accreditation">
                            <label for="">New accreditation as a body for Certification of Persons</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_extension">
                            <label for="">Extension of scope</label>
                        </div>
                        <div class="form-group">
                            <h5>For new accreditation only: I enclosed (tick boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_manual">
                            <label for="">A copy of Quality Manual</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_procedures">
                            <label for="">A copy of Quality & Technical Procedures</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_applicant">
                            <label for="">Applicant fee-see note below</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_agreement">
                            <label for="">Signed Agreement between PNAC and CB</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_certified">
                            <label for=""> List of certified clients with brief detail of relevant scheme and
                                scope</label>
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
        <div class="row section-form personnel-certification-section-form" id="AboutYourselves-PersonnelCertification-form">
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
                            <h5>1.1 Name and position (Director level) of person authorising this application</h5>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="selves_title" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" name="selves_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" name="selves_position" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2 Name and address of parent organisation (if different from Personnel Certification
                                Body address as given on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" name="selves_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="selves_parent_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" name="selves_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" name="selves_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" name="selves_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.3 Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_public">
                                <label>Owned by public limited Company</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_private">
                                <label>Owned by a private limited Company</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_learned">
                                <label>Part of learned/tech institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_industry">
                                <label>Owned by a public body/nationalised industry</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_govt">
                                <label>Owned by a Govt. directly</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" name="selves_part_academic">
                                <label>Part of Private academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" name="selves_other_describe" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.4 Is certification only the main activity of the organization?</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="selves_activity" value="Yes">
                            <label>Yes</label>
                            <input type="radio" name="selves_activity" value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the organization</label>
                            <input type="text" name="selves_describe_activity" class="form-control">

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
        <div class="row section-form personnel-certification-section-form" id="AboutYourStaff-PersonnelCertification-form">
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
                            <h6>2.1 Please list the names, qualifications and relevant experience of the following staff
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>A. Chief Executive /Managing Director/ Head/ Top Management</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_chief_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_chief_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" name="staff_chief_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" name="staff_chief_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>B. Quality Management Representative</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_quality_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" name="staff_quality_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" name="staff_quality_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>C. Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_manage_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_manage_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" name="staff_manage_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" name="staff_manage_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>2.2 Please list the names, qualifications, relevant fields and experience of the Experts
                                involved in Certification who are permanent employees.</h6>
                        </div>
                        <div class="form-group">
                            <h6>A. Experts (if required please attach extra sheets and Annex)</h6>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_expert_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_expert_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" name="staff_expert_field" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Experience</label>
                            <input type="text" name="staff_expert_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>A. Please list the names, qualifications, relevant fields and experience of the Experts
                                who are not the permanent employees;</h6>
                        </div>
                        <div class="form-group">
                            <h6>B. Sub-contracted/Freelance/Empanelled Experts (if required please attach extra sheets)
                            </h6>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_sub_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_sub_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" name="staff_sub_field" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit Experience</label>
                            <input type="text" name="staff_sub_exp" required class="form-control">
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
        <div class="row section-form personnel-certification-section-form" id="ScopeApplication-PersonnelCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope of application</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <h6>3.1 List all the sectors/areas for which accreditation required. e.g.,</h6>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="scop_check_person">
                            <label>Persons for non-destructive testing (NDT) according to DIN EN 473 </label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_driving">
                            <label>Driving Licence issuing personnel</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_joining">
                            <label>Persons for joining technology and welders according to EN 287-T1, ISO 9606, ISO
                                14731</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_expert">
                            <label>Experts for estimation of damages at vehicles / cars</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_real">
                            <label>Experts for real estate</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_corrosion">
                            <label>Experts for corrosion and corrosion protection; cathodic protection according to DIN
                                EN 15257</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_sensoric">
                            <label>Experts for Sensoric testing</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_it">
                            <label>IT – Experts</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_quality">
                            <label>Quality Management Auditors / - Personnel</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_env">
                            <label>Environmental Management Auditors / - Personnel</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_traffic">
                            <label>Experts for traffic systems</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_trainer">
                            <label>Trainer for traffic systems</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_wound">
                            <label>Experts for wound therapy</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="scop_check_other">
                            <label>Other (please specify):</label>
                        </div>
                        <div class="form-group">
                            <h5>3.2 Which standard are you following?</h5>
                        </div>
                        <div class="form-group">
                            <label>By Whom</label>
                            <input type="radio" name="scop_by_hwom" value="Yes"> Yes
                            <input type="radio" name="scop_by_hwom" value="No"> No
                        </div>
                        <div class="form-group">
                            <label>If No How maintained reliability?</label>
                            <input type="text" name="scop_maintained" class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>3.4 Does the certification of persons is being carried out by any regulatory requirement
                                if yes please specify.</h5>
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
        <div class="row section-form personnel-certification-section-form" id="AboutQuality-PersonnelCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4> Part 4 - About your quality system</h4>
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
                            <label>1. Is a copy of the Quality Manual attached with this application? If "No" give
                                reason </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_manual" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_manual" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_org_manual_comment" required class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>2. Are policy and procedures for the operation of the CBP identified in the Quality
                                Manual?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_policy" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_policy" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_policy_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are there documented procedures for control of changes to Quality System
                                Documentation?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_doc_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Does the Quality Manual contain charts showing
                                • Organisation structure within the CBP?
                                • Relationship to any parent organisation?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_contain" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_contain" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_contain_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Does the CBP is legal entity?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_cbp" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_cbp" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_cbp_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>6. Is the CB responsible for, and does it retain authority for its decisions relating
                                to certification?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_cb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_cb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_cb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>7. Does the CBP act impartiality in relation to its applicants, candidates and
                                certified persons also have Policy and procedure?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_impartiality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_impartiality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_impartiality_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>8. Does the CBP have necessary financial resources to cover liabilities?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_org_necessary" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_org_necessary" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_org_necessary_comment" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>B. Resource Requirements</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does the CBP have sufficient competent personnel available to perform
                                certification functions relating to the type, range and volume of work
                                performed?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_res_cbp" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_res_cbp" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_res_cbp_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does the CBP have defined and maintained duties and responsibilities of persons?
                            </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_res_defined" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_res_defined" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_res_defined_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Does the CBP declared any Requirements for Examiners involved?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_res_declared" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_res_declared" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_res_declared_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Has CBP outsourced any of its tasks?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_res_out" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_res_out" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_res_out_comment" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>C. Records and Information Requirements</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does CBP have sufficient security about the record?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_record_cbp" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_record_cbp" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_record_cbp_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does CBP have maintained confidentiality for records of persons?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_record_maintain" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_record_maintain" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_record_maintain_comment" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>D. Certification Scheme</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does CBP have elaborated process for each certification scheme?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_certified_cbp" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_certified_cbp" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_certified_cbp_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does CBP have a complete Process of Application?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_certified_process" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_certified_process" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_certified_process_comment" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>E. Certification Process Requirements</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does CBP have a complete Process of Application?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_cbp" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_cbp" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_cbp_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does CBP have a complete process of assessment?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_complete" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_complete" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_complete_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Does CBP have a complete process of examination?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_examinat" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_examinat" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_examinat_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Does CBP have complete process of decision on certification?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_decision" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_decision" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_decision_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Does CBP have complete process about suspending, Withdrawing, Reducing the Scope
                                of Certification and Recertification?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_suspend" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_suspend" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_suspend_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>6. Does CBP have a policy about the Use of Certificates, Logos and Marks?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_policy" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_policy" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_policy_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>7. Does CBP have Procedures about appeals and complaints?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_req_appeals" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_req_appeals" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_req_appeals_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>F. Management System Requirements</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does the CBP has complete Management System Documentation</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_manage_cbp" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_manage_cbp" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_manage_cbp_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Are all procedure fully documented</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_manage_fully" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_manage_fully" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_manage_fully_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are all records are maintained</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_manage_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_manage_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_manage_record_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Does the to management of PCB taking Management Review as per defined
                                requirements</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_manage_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_manage_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_manage_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Does the CBP have procedure for internal audits and that is effectively
                                implemented</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_manage_proced" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_manage_proced" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_manage_proced_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>6. Does the CBP have procedure for corrective and preventive action that is
                                effectively implemented and maintained.</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_manage_correct" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_manage_correct" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_manage_correct_comment" class="form-control"></textarea>
                            </div>
                        </div>




                        <div class="form-group">
                            <h5>
                                G. Compliance with ISO/IEC 17024 and PNAC Accreditation Requirements
                            </h5>
                        </div>
                        <div class="row">
                            <label>
                                1. Does the CBP complies with ISO/IEC 17024 and PNAC accreditation requirements?
                            </label>
                            <div class="form-group col-6">
                                <input type="radio" name="quality_complies_check" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_complies_check" value="No">
                                <label for="">No</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                If "No" in which specific areas does it not comply, and when do you expect to close
                                non-compliance?
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Area of non-compliance </label>
                            <input type="text" name="quality_non_compliance" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Rectified by (date)</label>
                            <input type="date" name="quality_rectified_date" class="form-control">
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn">Next</button>
                            </div>
                        </div>
                        </iv>
                    </div>
                </div>

            </div>
        </div>

        {{-- parts 5 --}}
        <div class="row section-form personnel-certification-section-form" id="OtherApprovals-PersonnelCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 5 - Other approvals (Certifications/ Accreditations) if any;</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please detail current approvals held by your Personnel Certification Body (if any)
                            </h5>
                        </div>
                        <div class="form-group">
                            <label>Name & address of approval body</label>
                            <textarea name="approvals_name" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Scope of accreditation/approval and number of certificate (if any)</label>
                            <textarea name="approvals_scope" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Period of accreditation/approval</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Start</label>
                                <input type="date" name="approvals_start_date" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Expiry Date</label>
                                <input type="date" name="approvals_end_date" class="form-control">
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
        <div class="row section-form personnel-certification-section-form" id="Declaration-PersonnelCertification-form">
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
                            <label>6.1 The Certification Body applies for accreditation to PNAC as (please tick
                                appropriate boxes)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="declaration_new_applicant">
                            <label>New Applicant as Certification Body as per the requirements of ISO/IEC
                                17024</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="declaration_extension">
                            <label>An extension in scope of existing accreditation</label>
                        </div>
                        <div class="form-group">
                            <label>6.2. The CBP/organisation agrees to conform, upon accreditation, PNAC
                                requirements as detailed in the Agreement [F-01/08]. Further has gone through all
                                other related policies of PNAC</label>
                        </div>
                        <div class="form-group">
                            <label>6.3. I enclose a copy of Quality Manual and other documents/information (see Note
                                below)</label>
                        </div>
                        <div class="form-group">
                            <label>6.4. I enclose a cheque (payable to PNAC) as Application fee amounting Rs.
                                ________. I understand that this fee is non-refundable. (see Note below).</label>
                        </div>
                        <div class="form-group">
                            <label>6.5. I understand manner in which the accreditation system functions.</label>
                        </div>
                        <div class="form-group">
                            <label>6.6. I declare that the information given in this form is correct to the best of
                                my knowledge and belief</label>
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Signed</label>
                                <input type="file" name="declaration_signed" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Date</label>
                                <input type="date" name="declaration_date" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Name</label>
                                <input type="text" name="declaration_name" class="form-control">
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn" id="NextBtn">Next</button>
                                <div class="submit-btn-wrapper d-none">
                                    <button type="button" class="btn btn-info" id="view-summary-btn">View</button>
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


{{-- view modal --}}
<div class="modal fade" id="formSummaryModal" tabindex="-1" role="dialog" aria-labelledby="formSummaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review Form Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="form-summary-content">
                    <!-- Summary content will be injected here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="submit" class="btn btn-success">Submit</button> --}}
            </div>
        </div>
    </div>
</div>
