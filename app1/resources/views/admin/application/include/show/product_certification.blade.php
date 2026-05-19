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
                            <input type="text" value="{{ $product->product }}" name="product" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Certification Body (PCB),</label>
                            <input type="text" value="{{ $product->certification_body }}" name="certification_body" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Name and Address</label>
                            <input type="text" value="{{ $product->name_address }}" name="name_address" readonly class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $product->postcode }}" name="postcode" readonly class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $product->tel }}" name="tel" readonly class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $product->fax }}" name="fax" readonly class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" value="{{ $product->email }}" name="email" readonly class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Website</label>
                                <input type="text" value="{{ $product->website }}" name="website" readonly class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" value="{{ $product->contact_name }}" name="contact_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="{{ $product->designation }}" name="designation" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" value="{{ $product->person_address }}" name="person_address" readonly class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{ $product->person_postcode }}" name="person_postcode" readonly class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{ $product->person_tel }}" name="person_tel" readonly class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{ $product->person_fax }}" name="person_fax" readonly class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" value="{{ $product->person_email }}" name="person_email" readonly class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Details of sub-offices/marketing offices in other cities</label>
                            <input type="text" value="{{ $product->person_detail }}" name="person_detail" readonly class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_accreditation == 'on') checked @endif name="chack_accreditation">
                            <label for="">New accreditation as a product certification body</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_product == 'on') checked @endif name="chack_product">
                            <label for="">New accreditation as a product certification body with GLOBALGAP scheme</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_extension == 'on') checked @endif name="chack_extension">
                            <label for="">Extension of scope</label>
                        </div>

                        <div class="form-group">
                            <h5><b>For new accreditation only:</b> I enclosed (tick boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_manual == 'on') checked @endif name="chack_manual">
                            <label for="">A copy of the PCB’s Quality Manual</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_procedures == 'on') checked @endif name="chack_procedures">
                            <label for="">A copy of Quality & Technical Procedures</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_certified == 'on') checked @endif name="chack_certified">
                            <label for="">List of certified organizations with brief detail of relevant scheme and scope</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_scheme == 'on') checked @endif name="chack_scheme">
                            <label for="">GLOBAL GAP scheme requirements</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->chack_applicant == 'on') checked @endif name="chack_applicant">
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
                            <input type="text" value="{{ $product->selves_title }}" name="selves_title" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" value="{{ $product->selves_name }}" name="selves_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" value="{{ $product->selves_position }}" name="selves_position" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2	Name and address of parent organisation (if different from Proficiency Testing Provider address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Parent Organization</label>
                            <input type="text" value="{{ $product->selves_parent_organization }}" name="selves_parent_organization" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relationship with parent organization</label>
                            <input type="text" value="{{ $product->selves_parent_relationship }}" name="selves_parent_relationship" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $product->selves_parent_address }}" name="selves_parent_address" readonly class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $product->selves_postcode }}" name="selves_postcode" readonly class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $product->selves_tel }}" name="selves_tel" readonly class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $product->selves_fax }}" name="selves_fax" readonly class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.3	Address for invoicing (if different from PCB address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $product->selves_invoicing_organization }}" name="selves_invoicing_organization" readonly class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $product->selves_invoicing_address }}" name="selves_invoicing_address" readonly class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-3">
                                <label>Postcode</label>
                                <input type="text" value="{{ $product->selves_invoicing_postcode }}" name="selves_invoicing_postcode" readonly class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Tel</label>
                                <input type="text" value="{{ $product->selves_invoicing_tel }}" name="selves_invoicing_tel" readonly class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Fax</label>
                                <input type="text" value="{{ $product->selves_invoicing_fax }}" name="selves_invoicing_fax" readonly class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>E-mail</label>
                                <input type="email" value="{{ $product->selves_invoicing_email }}" name="selves_invoicing_email" readonly class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4	Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($product->selves_individual == 'on') checked @endif name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($product->selves_public == 'on') checked @endif name="selves_public">
                                <label>Owned by public limited Company</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($product->selves_private == 'on') checked @endif name="selves_private">
                                <label>Owned by a public company/partnership</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($product->selves_learned == 'on') checked @endif name="selves_learned">
                                <label>Part of learned/tech institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($product->selves_industry == 'on') checked @endif name="selves_industry">
                                <label>Owned by a public body/nationalised industry</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($product->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" value="{{ $product->selves_other_describe }}" name="selves_other_describe" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5	Is certification the main activity of the organization?</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" @if($product->selves_activity == 'Yes') checked @endif name="selves_activity" value="Yes">
                            <label>Yes</label>
                            <input type="radio" @if($product->selves_activity == 'No') checked @endif name="selves_activity" value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the organization</label>
                            <input type="text" value="{{ $product->selves_cab_activity }}" name="selves_cab_activity" class="form-control">

                        </div>
                        <div class="form-group">
                            <h5>1.6	Name of Consultant / Consultancy Firm</h5>
                        </div>


                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $product->selves_consult_name }}" name="selves_consult_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Organization(if any)</label>
                            <input type="text" value="{{ $product->selves_consult_organization }}" name="selves_consult_organization" readonly class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $product->selves_consult_address }}" name="selves_consult_address" readonly class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-3">
                                <label>Postcode</label>
                                <input type="text" value="{{ $product->selves_consult_postcode }}" name="selves_consult_postcode" readonly class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Tel</label>
                                <input type="text" value="{{ $product->selves_consult_tel }}" name="selves_consult_tel" readonly class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>Fax</label>
                                <input type="text" value="{{ $product->selves_consult_fax }}" name="selves_consult_fax" readonly class="form-control">
                            </div>
                            <div class="form-group col-3">
                                <label>E-mail</label>
                                <input type="email" value="{{ $product->selves_consult_email }}" name="selves_consult_email" readonly class="form-control">
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
                            <input type="text" value="{{ $product->staff_chief_name }}" name="staff_chief_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $product->staff_chief_qualifications }}" name="staff_chief_qualifications" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $product->staff_chief_relevant }}" name="staff_chief_relevant" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $product->staff_chief_exp }}" name="staff_chief_exp" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>B.	Quality Management Representative</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $product->staff_quality_name }}" name="staff_quality_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $product->staff_quality_qualifications }}" name="staff_quality_qualifications" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $product->staff_quality_relevant }}" name="staff_quality_relevant" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $product->staff_quality_exp }}" name="staff_quality_exp" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>C.	Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $product->staff_manage_name }}" name="staff_manage_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $product->staff_manage_qualifications }}" name="staff_manage_qualifications" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $product->staff_manage_relevant }}" name="staff_manage_relevant" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $product->staff_manage_exp }}" name="staff_manage_exp" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>2.2	Please list the names, qualifications, relevant auditing fields and experience of the Auditors/Experts who are permanent employees of the company.</h6>
                        </div>
                        <div class="form-group">
                            <h6>A.	Auditors/Experts (if readonly please attach extra sheets)</h6>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $product->staff_auditor_name }}" name="staff_auditor_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $product->staff_auditor_qualifications }}" name="staff_auditor_qualifications" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" value="{{ $product->staff_auditor_field }}" name="staff_auditor_field" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit  Experience</label>
                            <input type="text" value="{{ $product->staff_auditor_exp }}" name="staff_auditor_exp" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>2.2	 Please list the names, qualifications, relevant auditing fields and experience of the Auditors/Experts who are not the permanent employees of the company.
                                B.	Sub-contracted/Freelance/Empanelled Auditors/Experts (if readonly please attach extra sheets)
                                </h6>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $product->staff_list_name }}" name="staff_list_name" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $product->staff_list_qualifications }}" name="staff_list_qualifications" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" value="{{ $product->staff_list_field }}" name="staff_list_field" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit  Experience</label>
                            <input type="text" value="{{ $product->staff_list_exp }}" name="staff_list_exp" readonly class="form-control">
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
                            <h6>List all the sectors/areas for which accreditation is readonly.</h6>
                        </div>

                        <div class="form-group">
                            <label>Product</label>
                            <input type="text" value="{{ $product->scop_product }}" name="scop_product" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Type of Scheme according to ISO/IEC 17067/ GLOBALGAP certification schemes</label>
                            <input type="text" value="{{ $product->scop_according }}" name="scop_according" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Standards</label>
                            <input type="text" value="{{ $product->scop_standard }}" name="scop_standard" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Countries where certificates are to be issued </label>
                            <input type="text" value="{{ $product->scop_countries }}" name="scop_countries" readonly class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>3.2	List the major items of equipment (For PT providers preparing samples)</h5>
                        </div>
                        <div class="form-group">
                            <h6>(Use of photocopy of this page, if the space given is found insufficient)</h6>
                        </div>
                        <div class="form-group">
                            <label>Equipment, (model, range, etc)</label>
                            <input type="text" value="{{ $product->scop_equipment }}" name="scop_equipment" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of last calibration</label>
                            <input type="text" value="{{ $product->scop_last_date }}" name="scop_last_date" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of next calibration</label>
                            <input type="text" value="{{ $product->scop_next_date }}" name="scop_next_date" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Calibration Organization</label>
                            <input type="text" value="{{ $product->scop_calibration }}" name="scop_calibration" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Details of in-house Checks performed</label>
                            <input type="text" value="{{ $product->scop_details }}" name="scop_details" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tests for which used and other comments</label>
                            <input type="text" value="{{ $product->scop_comments }}" name="scop_comments" readonly class="form-control">
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
                                <input type="radio" @if($product->org_quality == 'Yes') checked @endif name="org_quality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_quality == 'No') checked @endif name="org_quality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="org_quality_comment" readonly class="form-control">{{ $product->org_quality_comment }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>2. Are policy and procedures for the operation of the PCB identified in the Quality Manual?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->org_policy == 'Yes') checked @endif name="org_policy" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_policy == 'No') checked @endif name="org_policy" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="org_policy_comment_comment" class="form-control">{{ $product->org_policy_comment_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are there documented procedures for control of changes to Quality System Documentation?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->org_doc == 'Yes') checked @endif name="org_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_doc == 'No') checked @endif name="org_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="org_doc_comment" class="form-control">{{ $product->org_doc_comment }}</textarea>
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
                                <input type="radio" @if($product->org_contain == 'Yes') checked @endif name="org_contain" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_contain == 'No') checked @endif name="org_contain" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="org_contain_comment" class="form-control">{{ $product->org_contain_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Does QMR has the responsibility and authority to identify quality problems and initiate effective solutions?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->org_qmr == 'Yes') checked @endif name="org_qmr" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_qmr == 'No') checked @endif name="org_qmr" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="org_qmr_comment" class="form-control">{{ $product->org_qmr_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>6. Does the PCB is legal entity? </label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->org_pcb == 'Yes') checked @endif name="org_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_pcb == 'No') checked @endif name="org_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="org_pcb_comment" class="form-control">{{ $product->org_pcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>7.	 Does the PCB has sufficient financial resources to carry out its operational activities effectively and its reference is available in its manual?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->org_sufficient == 'Yes') checked @endif name="org_sufficient" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->org_sufficient == 'No') checked @endif name="org_sufficient" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="org_sufficient_comment" class="form-control">{{ $product->org_sufficient_comment }}</textarea>
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
                                <input type="radio" @if($product->quality_doc == 'Yes') checked @endif name="quality_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->quality_doc == 'No') checked @endif name="quality_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="quality_doc_comment" class="form-control">{{ $product->quality_doc_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. What it frequency of quality audits?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->quality_frequency == 'Yes') checked @endif name="quality_frequency" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->quality_frequency == 'No') checked @endif name="quality_frequency" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="quality_frequency_comment" class="form-control">{{ $product->quality_frequency_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are records of quality audits maintained?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->quality_record == 'Yes') checked @endif name="quality_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->quality_record == 'No') checked @endif name="quality_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="quality_record_comment" class="form-control">{{ $product->quality_record_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Is the PCB's quality system reviewed at regular intervals?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->quality_pcb == 'Yes') checked @endif name="quality_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->quality_pcb == 'No') checked @endif name="quality_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="quality_pcb_comment" class="form-control">{{ $product->quality_pcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. How frequently reviews of the quality system are carried out?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->quality_reviews == 'Yes') checked @endif name="quality_reviews" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->quality_reviews == 'No') checked @endif name="quality_reviews" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="quality_reviews_comment" class="form-control">{{ $product->quality_reviews_comment }}</textarea>
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
                                <input type="radio" @if($product->certification_quality == 'Yes') checked @endif name="certification_quality" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->certification_quality == 'No') checked @endif name="certification_quality" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="certification_quality_comment" class="form-control">{{ $product->certification_quality_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Have appropriate standards of professional ability, qualifications and experience been documented for managerial posts?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->certification_appropriate == 'Yes') checked @endif name="certification_appropriate" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->certification_appropriate == 'No') checked @endif name="certification_appropriate" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="certification_appropriate_comment" class="form-control">{{ $product->certification_appropriate_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are documented training procedures and records available?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->certification_doc == 'Yes') checked @endif name="certification_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->certification_doc == 'No') checked @endif name="certification_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="certification_doc_comment" class="form-control">{{ $product->certification_doc_comment }}</textarea>
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
                                <input type="radio" @if($product->procedures_fully == 'Yes') checked @endif name="procedures_fully" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->procedures_fully== 'No') checked @endif name="procedures_fully" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="procedures_fully_comment" class="form-control">{{ $product->procedures_fully_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Are the documents referred to above available to all concerned?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->procedures_doc == 'Yes') checked @endif name="procedures_doc" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->procedures_doc == 'No') checked @endif name="procedures_doc" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="procedures_doc_comment" class="form-control">{{ $product->procedures_doc_comment }}</textarea>
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
                                <input type="radio" @if($product->record_system == 'Yes') checked @endif name="record_system" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->record_system == 'No') checked @endif name="record_system" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="record_system_comment" class="form-control">{{ $product->record_system_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Are there arrangements for ensuring the accuracy, completeness and confidentiality of all records?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->record_arrange == 'Yes') checked @endif name="record_arrange" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->record_arrange == 'No') checked @endif name="record_arrange" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="record_arrange_comment" class="form-control">{{ $product->record_arrange_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. For what period does the PCB retain the original recorded observations and derived data?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->record_period == 'Yes') checked @endif name="record_period" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->record_period == 'No') checked @endif name="record_period" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="record_period_comment" class="form-control">{{ $product->record_period_comment }}</textarea>
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
                                <input type="radio" @if($product->complaint_pcb == 'Yes') checked @endif name="complaint_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->complaint_pcb == 'No') checked @endif name="complaint_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="complaint_pcb_comment" class="form-control">{{ $product->complaint_pcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2.Does the PCB keep records of complaints/anomalies and actions taken?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->complaint_record == 'Yes') checked @endif name="complaint_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->complaint_record== 'no') checked @endif name="complaint_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="complaint_record_comment" class="form-control">{{ $product->complaint_record_comment }}</textarea>
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
                                <input type="radio" @if($product->sub_pcb == 'Yes') checked @endif name="sub_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->sub_pcb == 'No') checked @endif name="sub_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="sub_pcb_comment" class="form-control">{{ $product->sub_pcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does the PCB have a documented policy on sub-contracting?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->sub_pcb == 'Yes') checked @endif name="sub_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->sub_pcb == 'No') checked @endif name="sub_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="sub_pcb_comment" class="form-control">{{ $product->sub_pcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Does the PCB have a register of all sub-contractors used and a record of sub-contracted work?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->sub_register == 'Yes') checked @endif name="sub_register" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->sub_register == 'No') checked @endif name="sub_register" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="sub_register_comment" class="form-control">{{ $product->sub_register_comment }}</textarea>
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
                                <input type="radio" @if($product->outside_pcb == 'Yes') checked @endif name="outside_pcb" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->outside_pcb == 'No') checked @endif name="outside_pcb" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="outside_pcb_comment" class="form-control">{{ $product->outside_pcb_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Does the PCB keep records of such suppliers?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($product->outside_record == 'Yes') checked @endif name="outside_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->outside_record == 'No') checked @endif name="outside_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea readonly name="outside_record_comment" class="form-control">{{ $product->outside_record_comment }}</textarea>
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
                                <input type="radio" @if($product->complies_check == 'Yes') checked @endif name="complies_check" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->complies_check == 'No') checked @endif name="complies_check" value="No">
                                <label for="">No</label>
                            </div>
                        </div>
                        <div class="row">
                            <label>
                                2. Does the PCB complies with GLOBALGAP accreditation requirements?
                            </label>
                            <div class="form-group col-6">
                                <input type="radio" @if($product->globalgap_check == 'Yes') checked @endif name="globalgap_check" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($product->globalgap_check == 'no') checked @endif name="globalgap_check" value="No">
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
                            <input type="text" value="{{ $product->compliance_check }}" name="compliance_check" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-3">Rectified by (date)</label>
                            <input type="date" value="{{ $product->rectified_date }}" readonly name="rectified_date" class="form-control">
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
                            <textarea readonly name="approvals_name" class="form-control">{{ $product->approvals_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Scope of accreditation/approval and number of certificate (if any)</label>
                            <textarea readonly name="approvals_scope" class="form-control">{{ $product->approvals_scope }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Period of accreditation/approval</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Start</label>
                                <input type="date" name="approvals_start_date" value="{{ $product->approvals_start_date }}" readonly class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Expiry Date</label>
                                <input type="date" name="approvals_end_date" value="{{ $product->approvals_end_date }}" readonly class="form-control">
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
                            <input type="checkbox" @if($product->declaration_new_applicant == 'on') checked @endif name="declaration_new_applicant">
                            <label>New Applicant as Product certification Body as per the requirements of ISO/IEC 17065</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->declaration_product == 'on') checked @endif name="declaration_product">
                            <label>New Applicant as Product certification Body GLOBALGAP</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($product->declaration_extension == 'on') checked @endif name="declaration_extension">
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
                                {{-- <input type="file" name="declaration_signed" value="{{ $product->declaration_signed }}" class="form-control"> --}}
                                <img src="{{ asset('storage/'.$product->declaration_signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="declaration_date" value="{{ $product->declaration_date }}" readonly class="form-control">
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success next-btn" id="NextBtn">Next</button>
                                {{-- <div class="submit-btn-wrapper d-none">
                                    <button type="submit" class="btn btn-success">Save Change</button>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>
</form>
