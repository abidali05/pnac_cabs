<form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">

    {{-- General --}}
        <div class="row section-form product-certification-section-form" id="GeneralInfo-ProductCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5>Application by Product Certification Body (PCB) For Accreditation</h5>
                            <h6>Please type or use BLOCK LETTERS</h6>
                        </div>

                        <div class="form-group">
                            <label>Product</label>
                            <input type="text" name="product" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Certification Body (PCB),</label>
                            <input type="text" name="certification_body" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Name and Address</label>
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
                            <label>Name of Contact:</label>
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
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" name="person_tel" required class="form-control">
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
                            <label>Details of sub-offices/marketing offices in other cities</label>
                            <input type="text" name="person_detail" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_accreditation">
                            <label for="">New accreditation as a product certification body</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_product">
                            <label for="">New accreditation as a product certification body with GLOBALGAP scheme</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_extension">
                            <label for="">Extension of scope</label>
                        </div>

                        <div class="form-group">
                            <h5><b>For new accreditation only:</b> I enclosed (tick boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_manual">
                            <label for="">A copy of the PCB’s Quality Manual</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_procedures">
                            <label for="">A copy of Quality & Technical Procedures</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_certified">
                            <label for="">List of certified organizations with brief detail of relevant scheme and scope</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_scheme">
                            <label for="">GLOBAL GAP scheme requirements</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="chack_applicant">
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
        <div class="row section-form product-certification-section-form" id="AboutYourselves-ProductCertification-form">
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
                            <h5>1.2	Name and address of parent organisation (if different from Proficiency Testing Provider address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Parent Organization</label>
                            <input type="text" name="selves_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relationship with parent organization</label>
                            <input type="text" name="selves_parent_relationship" required class="form-control">
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
                            <h5>1.3	Address for invoicing (if different from PCB address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" name="selves_invoicing_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="selves_invoicing_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-3">
                                <label>Postcode</label>
                                <input type="text" name="selves_invoicing_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Tel</label>
                                <input type="text" name="selves_invoicing_tel" required class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Fax</label>
                                <input type="text" name="selves_invoicing_fax" required class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>E-mail</label>
                                <input type="email" name="selves_invoicing_email" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4	Information about ownership: please tick the appropriate box.</h5>
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
                                <label>Owned by a public company/partnership</label>
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
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" name="selves_other_describe" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5	Is certification the main activity of the organization?</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="selves_activity" value="Yes">
                            <label>Yes</label>
                            <input type="radio" name="selves_activity" value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the organization</label>
                            <input type="text" name="selves_cab_activity" class="form-control">

                        </div>
                        <div class="form-group">
                            <h5>1.6	Name of Consultant / Consultancy Firm</h5>
                        </div>


                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="selves_consult_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Organization(if any)</label>
                            <input type="text" name="selves_consult_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="selves_consult_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-3">
                                <label>Postcode</label>
                                <input type="text" name="selves_consult_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Tel</label>
                                <input type="text" name="selves_consult_tel" required class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Fax</label>
                                <input type="text" name="selves_consult_fax" required class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>E-mail</label>
                                <input type="email" name="selves_consult_email" required class="form-control">
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
        <div class="row section-form product-certification-section-form" id="AboutYourStaff-ProductCertification-form">
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
                            <h6>2.1  Please list the names, qualifications and relevant experience of the following staff</h6>
                        </div>
                        <div class="form-group">
                            <h6>A.	Chief Executive </h6>
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
                            <h6>B.	Quality Management Representative</h6>
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
                            <h6>C.	Management (if more than three members please attach extra sheet)</h6>
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
                            <h6>2.2	Please list the names, qualifications, relevant auditing fields and experience of the Auditors/Experts who are permanent employees of the company.</h6>
                        </div>
                        <div class="form-group">
                            <h6>A.	Auditors/Experts (if required please attach extra sheets)</h6>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_auditor_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_auditor_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" name="staff_auditor_field" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit  Experience</label>
                            <input type="text" name="staff_auditor_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>2.2	 Please list the names, qualifications, relevant auditing fields and experience of the Auditors/Experts who are not the permanent employees of the company.
                                B.	Sub-contracted/Freelance/Empanelled Auditors/Experts (if required please attach extra sheets)
                                </h6>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_list_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_list_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" name="staff_list_field" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit  Experience</label>
                            <input type="text" name="staff_list_exp" required class="form-control">
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
        <div class="row section-form product-certification-section-form" id="ScopeApplication-ProductCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope of application</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <h6>List all the sectors/areas for which accreditation is required.</h6>
                        </div>

                        <div class="form-group">
                            <label>Product</label>
                            <input type="text" name="scop_product" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Type of Scheme according to ISO/IEC 17067/ GLOBALGAP certification schemes</label>
                            <input type="text" name="scop_according" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Standards</label>
                            <input type="text" name="scop_standard" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Countries where certificates are to be issued </label>
                            <input type="text" name="scop_countries" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>3.2	List the major items of equipment (For PT providers preparing samples)</h5>
                        </div>
                        <div class="form-group">
                            <h6>(Use of photocopy of this page, if the space given is found insufficient)</h6>
                        </div>
                        <div class="form-group">
                            <label>Equipment, (model, range, etc)</label>
                            <input type="text" name="scop_equipment" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of last calibration</label>
                            <input type="text" name="scop_last_date" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of next calibration</label>
                            <input type="text" name="scop_next_date" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Calibration Organization</label>
                            <input type="text" name="scop_calibration" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Details of in-house Checks performed</label>
                            <input type="text" name="scop_details" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tests for which used and other comments</label>
                            <input type="text" name="scop_comments" required class="form-control">
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
        <div class="row section-form product-certification-section-form" id="AboutQuality-ProductCertification-form">
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
                            <label>1.   Is a copy of the Quality Manual attached with this application? If "No" give reason </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_quality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_quality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="org_quality_comment" required class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>2. Are policy and procedures for the operation of the PCB identified in the Quality Manual?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_policy" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_policy" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_policy_comment_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are there documented procedures for control of changes to Quality System Documentation?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_doc_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Does the Quality Manual contain charts showing
                                •	The organisation structure within the PCB?
                                •	The relationship to any parent organisation?
                                •	Availability of resources to carry out the certification activities?
                                </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_contain" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_contain" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_contain_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Does QMR has the responsibility and authority to identify quality problems and initiate effective solutions?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_qmr" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_qmr" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_qmr_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>6. Does the PCB is legal entity? </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>7.	 Does the PCB has sufficient financial resources to carry out its operational activities effectively and its reference is available in its manual?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="org_sufficient" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="org_sufficient" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="org_sufficient_comment" class="form-control"></textarea>
                            </div>
                        </div>





                        <div class="form-group">
                            <h5>B. Quality audit and review </h5>
                        </div>
                        <div class="form-group">
                            <label>1. Are the documented procedures available for auditing the management system of PCB?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_doc_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. What it frequency of quality audits?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_frequency" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_frequency" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_frequency_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are records of quality audits maintained?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_record_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Is the PCB's quality system reviewed at regular intervals?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. How frequently reviews of the quality system are carried out?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="quality_reviews" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="quality_reviews" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="quality_reviews_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>C. Certification Body staff</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does the Quality System contain the provisions for the supervision of unqualified staff?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="certification_quality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="certification_quality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="certification_quality_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Have appropriate standards of professional ability, qualifications and experience been documented for managerial posts?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="certification_appropriate" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="certification_appropriate" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="certification_appropriate_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are documented training procedures and records available?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="certification_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="certification_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="certification_doc_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>D. 	Procedures</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Are all procedures fully documented?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="procedures_fully" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="procedures_fully" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="procedures_fully_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Are the documents referred to above available to all concerned?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="procedures_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="procedures_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="procedures_doc_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>E. 	Records </h5>
                        </div>
                        <div class="form-group">
                            <label>1. Is there a prescribed system of maintaining records?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="record_system" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="record_system" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="record_system_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Are there arrangements for ensuring the accuracy, completeness and confidentiality of all records?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="record_arrange" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="record_arrange" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="record_arrange_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. For what period does the PCB retain the original recorded observations and derived data?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="record_period" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="record_period" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="record_period_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>F. 	Complaints and anomalies</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does the PCB have a documented procedure for handling complaints/anomalies?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="complaint_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="complaint_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="complaint_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2.Does the PCB keep records of complaints/anomalies and actions taken?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="complaint_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="complaint_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="complaint_record_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>G. 	Sub-contracting </h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does the PCB sub-contract audits?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="sub_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="sub_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="sub_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does the PCB have a documented policy on sub-contracting?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="sub_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="sub_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="sub_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Does the PCB have a register of all sub-contractors used and a record of sub-contracted work?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="sub_register" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="sub_register" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="sub_register_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>H. 	Outside support services</h5>
                        </div>
                        <div class="form-group">
                            <label>1. Does the PCB have a documented policy on the procurement of supplies and support services?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="outside_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="outside_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="outside_pcb_comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does the PCB keep records of such suppliers?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="outside_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="outside_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="outside_record_comment" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <h5>
                                I. 	Compliance with ISO/IEC 17065 and PNAC Accreditation Requirements
                            </h5>
                        </div>
                        <div class="row">
                            <label>
                                1. Does the PCB complies with ISO/IEC 17065 and PNAC accreditation requirements?
                            </label>
                            <div class="form-group col-6">
                                <input type="radio" name="complies_check" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="complies_check" value="No">
                                <label for="">No</label>
                            </div>
                        </div>
                        <div class="row">
                            <label>
                                2. Does the PCB complies with GLOBALGAP accreditation requirements?
                            </label>
                            <div class="form-group col-6">
                                <input type="radio" name="globalgap_check" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="globalgap_check" value="No">
                                <label for="">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                If "No" in which specific areas does it not comply, and when do you expect to close non-compliance?
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Area of non-compliance </label>
                            <input type="text" name="compliance_check" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Rectified by (date)</label>
                            <input type="date" name="rectified_date" class="form-control">
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
        <div class="row section-form product-certification-section-form" id="OtherApprovals-ProductCertification-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 5 - Other approvals (Certifications/ Accreditations)</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please detail current approvals held by your Certification Body</h5>
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
        <div class="row section-form product-certification-section-form" id="Declaration-ProductCertification-form">
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
                            <label>6.1 	The Product Certification Body applies for accreditation by PNAC as (please tick appropriate boxes)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="declaration_new_applicant">
                            <label>New Applicant as Product certification Body as per the requirements of ISO/IEC 17065</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="declaration_product">
                            <label>New Applicant as Product certification Body GLOBALGAP</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="declaration_extension">
                            <label>An extension in scope of existing accreditation</label>
                        </div>
                        <div class="form-group">
                            <label>6.2. 	The PCB/organisation agrees to conform, upon accreditation, PNAC requirements as detailed in the Agreement [F-01/08].</label>
                        </div>
                        <div class="form-group">
                            <label>6.3. 	I enclose a copy of Quality Manual and other documents/information (see Note below)</label>
                        </div>
                        <div class="form-group">
                            <label>6.4. 	I enclose a cheque (payable to PNAC) as Application fee amounting Rs. ________. I understand that this fee is non-refundable. (see Note below).</label>
                        </div>
                        <div class="form-group">
                            <label>6.5. 	I understand manner in which the accreditation system functions</label>
                        </div>
                        <div class="form-group">
                            <label>6.6. 	I declare that the information given in this form is correct to the best of my knowledge and belief  </label>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label>Name of Signed</label>
                                <input type="file" name="declaration_signed" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="declaration_date" class="form-control">
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
