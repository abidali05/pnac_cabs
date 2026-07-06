<form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">

        <div class="row section-form medical-section-form" id="GeneralInfo-Medical-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5>Application For Medical Laboratory Accreditation (ISO 15189)</h5>
                            <h6>Please type or use BLOCK LETTERS</h6>
                        </div>
                        <div class="form-group">
                            <label>Organisation</label>
                            <input type="text" value="{{ $medical->organisation }}" name="organisation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address of Medical laboratory</label>
                            <input type="text" value="{{ $medical->address_medical }}" name="address_medical" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $medical->postcode }}" name="postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $medical->tel }}" name="tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $medical->fax }}" name="fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" value="{{ $medical->contact_name }}" name="contact_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="{{ $medical->designation }}" name="designation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" value="{{ $medical->person_address }}" name="person_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{ $medical->person_postcode }}" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{ $medical->person_tel }}" name="person_tel" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{ $medical->person_fax }}" name="person_fax" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Mobile</label>
                                <input type="text" value="{{ $medical->person_mobile }}" name="person_mobile" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Fields of Medical Testing*: This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->clinical_chemistry == 'on') checked @endif name="clinical_chemistry">
                            <label for="">Clinical Chemistry</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->haematology == 'on') checked @endif name="haematology">
                            <label for="">Haematology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->histopathology == 'on') checked @endif name="histopathology">
                            <label for="">Histopathology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->immunology == 'on') checked @endif name="immunology">
                            <label for="">Immunology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->microbiology == 'on') checked @endif name="microbiology">
                            <label for="">Microbiology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->molecular_biology == 'on') checked @endif name="molecular_biology">
                            <label for="">Molecular Biology</label>
                        </div>
                        <div class="form-group">
                            <label for="">Other (Please describe)</label>
                            <input type="text" value="{{ $medical->other_describe }}" name="other_describe" class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>* ISO 15189:2012 is the standard for Medical Laboratories (examination of material derived from the human body)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_quality == 'on') checked @endif name="chack_quality">
                            <label for="">A copy of the laboratory's Quality Manual</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_procedures == 'on') checked @endif name="chack_procedures">
                            <label for="">A copy of the laboratory's Standard Operating Procedures (Management & Technical)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_recognised == 'on') checked @endif name="chack_recognised">
                            <label for="">Participation in recognised PT scheme (F-2/31) </label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_plan == 'on') checked @endif name="chack_plan">
                            <label for="">Plan of PT participation (F-2/33)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_agreement == 'on') checked @endif name="chack_agreement">
                            <label for="">Agreement (F-01/04)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_filled == 'on') checked @endif name="chack_filled">
                            <label for="">Filled form (F-2/18) </label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->chack_applicant == 'on') checked @endif name="chack_applicant">
                            <label for="">Applicant fee-see note below</label>
                        </div>

                        <div class="text-center mb-3">
                            <h5>Before completing the rest of this form, please read the following notes</h5>
                            <h6>Notes on completing this form</h6>
                        </div>
                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light medical-prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success medical-next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row section-form medical-section-form" id="AboutYourselves-Medical-form">
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
                            <input type="text" value="{{ $medical->selves_title }}" name="selves_title" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" value="{{ $medical->selves_name }}" name="selves_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" value="{{ $medical->selves_position }}" name="selves_position" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2 Name and address of the parent organisation (if different from the laboratory address given at page1)</h5>
                        </div>
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $medical->selves_parent_organization }}" name="selves_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $medical->selves_parent_address }}" name="selves_parent_address" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Postcode</label>
                            <input type="text" value="{{ $medical->selves_parent_postcode }}" name="selves_parent_postcode" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tel</label>
                            <input type="text" value="{{ $medical->selves_parent_tel }}" name="selves_parent_tel" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fax</label>
                            <input type="text" value="{{ $medical->selves_parent_fax }}" name="selves_parent_fax" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>1.3 Address for invoicing (if different from the laboratory’s address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $medical->selves_invoicing_organization }}" name="selves_invoicing_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $medical->selves_invoicing_address }}" name="selves_invoicing_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $medical->selves_invoicing_postcode }}" name="selves_invoicing_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $medical->selves_invoicing_tel }}" name="selves_invoicing_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $medical->selves_invoicing_fax }}" name="selves_invoicing_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4 Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($medical->selves_individual == 'on') checked @endif name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($medical->selves_public == 'on') checked @endif name="selves_public">
                                <label>Owned by public hospital</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($medical->selves_private == 'on') checked @endif name="selves_private">
                                <label>Owned by a private company/partnership</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($medical->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($medical->selves_hospital == 'on') checked @endif name="selves_hospital">
                                <label>Owned by a private hospital</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($medical->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" value="{{ $medical->selves_other_describe }}" name="selves_other_describe" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5 Is calibration/testing the main activity of the parent company</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" @if($medical->selves_activities == 'Yes') checked @endif name="selves_activities" value="Yes">
                            <label>Yes</label>
                            <input type="radio" @if($medical->selves_activities == 'No') checked @endif name="selves_activities" value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the parent company</label>
                        </div>


                        <div class="form-group">
                            <h5>1.7 Do you conduct Testing in the following category (if yes, please clearly mention the scope of accreditation, Part of this application)</h5>
                        </div>
                        <div class="row">

                            <div class="form-group col-6">
                                <label>A. Permanent facility</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->selves_permanent_facility == 'Yes') checked @endif name="selves_permanent_facility" value="Yes"> Yes
                                <input type="radio" @if($medical->selves_permanent_facility == 'No') checked @endif name="selves_permanent_facility" value="No"> No
                            </div>
                            <div class="form-group col-6">
                                <label>B. Sample Collection Centre If yes attach list of sample collection centres</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->selves_sample_collection == 'Yes') checked @endif name="selves_sample_collection" value="Yes"> Yes
                                <input type="radio" @if($medical->selves_sample_collection == 'Yes') checked @endif name="selves_sample_collection" value="No"> No
                            </div>
                            <div class="form-group col-6">
                                <label>C. Temporary Facility (when a facility is created temporarily).</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->selves_temporary_facility == 'Yes') checked @endif name="selves_temporary_facility" value="Yes"> Yes
                                <input type="radio" @if($medical->selves_temporary_facility == 'Yes') checked @endif name="selves_temporary_facility" value="No"> No
                            </div>
                            <div class="form-group col-6">
                                <label>D. Mobile Laboratory.</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->selves_mobile_laboratory == 'Yes') checked @endif name="selves_mobile_laboratory" value="Yes"> Yes
                                <input type="radio" @if($medical->selves_mobile_laboratory == 'Yes') checked @endif name="selves_mobile_laboratory" value="No"> No
                            </div>

                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light medical-prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success medical-next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row section-form medical-section-form" id="AboutYourStaff-Medical-form">
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
                            <h5>2.1 Please list the names, technical qualifications and relevant experience of the following staff</h5>
                        </div>
                        <div class="form-group">
                            <h6>A. A. Technical Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Laboratory/Department/Section</label>
                            <input type="text" value="{{ $medical->staff_laboratory }}" name="staff_laboratory" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Name & Designation of Signatory</label>
                            <input type="text" value="{{ $medical->staff_name }}" name="staff_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualification with Specialisation</label>
                            <input type="text" value="{{ $medical->staff_qualification }}" name="staff_qualification" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience in years related to present work</label>
                            <input type="text" value="{{ $medical->staff_experience }}" name="staff_experience" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant Training</label>
                            <input type="text" value="{{ $medical->staff_relevant }}" name="staff_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Authorised for which specific area of testing</label>
                            <input type="text" value="{{ $medical->staff_authorised }}" name="staff_authorised" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Specimen Signature</label>
                            <input type="text" value="{{ $medical->staff_specimen }}" name="staff_specimen" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>B. Quality Manger</h5>
                        </div>
                        <div class="form-group">
                            <label>Name & Designation</label>
                            <input type="text" value="{{ $medical->staff_quality_name }}" name="staff_quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Qualification with Specialisation</label>
                            <input type="text" value="{{ $medical->staff_quality_qualifications }}" name="staff_quality_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Experience in years related to present work</label>
                            <input type="text" value="{{ $medical->staff_quality_experience }}" name="staff_quality_experience" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Relevant Training</label>
                            <input type="text" value="{{ $medical->staff_quality_training }}" name="staff_quality_training" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Specimen Signature</label>
                            <input type="text" value="{{ $medical->staff_quality_specimen }}" name="staff_quality_specimen" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h4>C. Laboratory Staff.</h4>
                        </div>
                        <div class="form-group">
                            <h5>Laboratory Staff are the personnel who make critical evaluation of test results and whom is responsible for the adequacy of results. Please provide the list of Laboratory Staff and also provide their CV’s/Job Description’s. (Use extra sheets if necessary).</h5>
                        </div>
                        <div class="form-group">
                            <label>Name of Section: </label>
                            <input type="text" value="{{ $medical->staff_name_section }}" name="staff_name_section" required class="form-control">

                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="col-2">Name of section leader/Designation</label>
                                <label class="col-2">Qualification with Specialisation</label>
                                <label class="col-2">Experience in years related to present work</label>
                                <label class="col-2">Relevant Training</label>
                                <label class="col-2">Authorised for which specific area of testing</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group d-flex">
                                <input type="text" value="{{ $medical->staff_section_name }}" name="staff_section_name" required class="form-control col-2">
                                <input type="text" value="{{ $medical->staff_section_qualification }}" name="staff_section_qualification" required class="form-control col-2">
                                <input type="text" value="{{ $medical->staff_section_experience }}" name="staff_section_experience" required class="form-control col-2">
                                <input type="text" value="{{ $medical->staff_section_relevant }}" name="staff_section_relevant" required class="form-control col-2">
                                <input type="text" value="{{ $medical->staff_section_authorised }}" name="staff_section_authorised" required class="form-control col-2">
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light medical-prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success medical-next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row section-form medical-section-form" id="ScopeApplication-Medical-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope Application</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                3A. As far as possible, quote standard specifications in the third column. These may include specifications issued by companies and other organisations, both Pakistan and foreign, as well as national and international standards. Give reference numbers and dates of specifications quoted.
                                In the absence of standard specifications, documented in-house procedures may be quoted: cross-refer to your laboratory's Quality Manual/Procedures Manual.
                                (Use of photocopy of this page, if the space given is found insufficient)
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Sample Type/ Matrix</label>
                            <textarea name="scop_sample_type" required class="form-control">{{ $medical->scop_sample_type }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Types of test/Properties measured</label>
                            <textarea name="scop_types" required class="form-control">{{ $medical->scop_types }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Range of measurement</label>
                            <textarea name="scop_range" required class="form-control">{{ $medical->scop_range }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Minimum detection limit</label>
                            <textarea name="scop_detection" required class="form-control">{{ $medical->scop_detection }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Uncertainty of Measurement (where applicable)
                                ( + )
                            </label>
                            <textarea name="scop_uncertainty" required class="form-control">{{ $medical->scop_uncertainty }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Standard specification/Techniques/equipment used</label>
                            <textarea name="scop_standard" required class="form-control">{{ $medical->scop_standard }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>*Quality Control Measures</label>
                            <textarea name="scop_quality" required class="form-control">{{ $medical->scop_quality }}</textarea>
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
                            <textarea name="scop_major_name" required class="form-control">{{ $medical->scop_major_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Model/Type/year of make</label>
                            <textarea name="scop_major_model" required class="form-control">{{ $medical->scop_major_model }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Working Range/capacity of equipment</label>
                            <textarea name="scop_major_working" required class="form-control">{{ $medical->scop_major_working }}</textarea>
                            <div class="form-group">
                                <label>Minimum detection limit</label>
                                <textarea name="scop_major_minimum" required class="form-control">{{ $medical->scop_major_minimum }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Last date of calibration</label>
                                <textarea name="scop_major_lastdate" required class="form-control">{{ $medical->scop_major_lastdate }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Calibration due date</label>
                                <textarea name="scop_major_duedate" required class="form-control">{{ $medical->scop_major_duedate }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Test for which used and other relevant information</label>
                                <textarea name="scop_major_test" required class="form-control">{{ $medical->scop_major_test }}</textarea>
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
                                <textarea name="scop_reference_name" required class="form-control">{{ $medical->scop_reference_name }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Source/Supplier’s name</label>
                                <textarea name="scop_reference_source" required class="form-control">{{ $medical->scop_reference_source }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Date of expiry/validity</label>
                                <textarea name="scop_reference_date_ex" required class="form-control">{{ $medical->scop_reference_date_ex }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Traceability</label>
                                <textarea name="scop_reference_traceability" required class="form-control">{{ $medical->scop_reference_traceability }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Purpose of use</label>
                                <textarea name="scop_reference_purpose" required class="form-control">{{ $medical->scop_reference_purpose }}</textarea>
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
                                <textarea name="scop_proficiency_product" required class="form-control">{{ $medical->scop_proficiency_product }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Details of Test(s)/examination</label>
                                <textarea name="scop_proficiency_details" required class="form-control">{{ $medical->scop_proficiency_details }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Date of testing/examination</label>
                                <textarea name="scop_proficiency_date" required class="form-control">{{ $medical->scop_proficiency_date }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Organizing body</label>
                                <textarea name="scop_proficiency_organizing" required class="form-control">{{ $medical->scop_proficiency_organizing }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Performance in term of Z -score or any other criteria</label>
                                <textarea name="scop_proficiency_performance" required class="form-control">{{ $medical->scop_proficiency_performance }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Corrective actions taken (if required)</label>
                                <textarea name="scop_proficiency_corrective" required class="form-control">{{ $medical->scop_proficiency_corrective }}</textarea>
                            </div>

                            <div class="footer">
                                <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                    <button type="button" class="btn btn-light medical-prev-btn">Previous</button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-success medical-next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row section-form medical-section-form" id="AboutQuality-Medical-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 4 - About your quality system</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                Please fill the PNAC form F-02/18 and answer the following question, adding comments as necessary
                            </p>
                        </div>
                        <div class="form-group">
                            <b>
                                A. Equipment and calibration
                            </b>
                        </div>
                        <div class="form-group">
                            <label>1. Does a fully documented calibration program exist to ensure that the accuracy of equipment is adequate for the service operated by the laboratory?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_fully == 'Yes') checked @endif name="quality_fully" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_fully == 'No') checked @endif name="quality_fully" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_fully_comment" required class="form-control">{{ $medical->quality_fully_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">2. Is a record maintained for test equipment, including calibration results?</label> </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_record == 'Yes') checked @endif name="quality_record" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_record == 'No') checked @endif name="quality_record" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_record_comment" class="form-control">{{ $medical->quality_record_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">3. Are adequate facilities and environments provided for calibration, handling, control, storage and maintenance of all testing & measuring equipment?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_adequate == 'Yes') checked @endif name="quality_adequate" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_adequate == 'No') checked @endif name="quality_adequate" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_adequate_comment" class="form-control">{{ $medical->quality_adequate_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Are there documented procedures for internal calibration (if any) of all equipments and reference standards which cover the method of calibration and maximum, intervals between calibrations?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_procedures == 'Yes') checked @endif name="quality_procedures" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_procedures == 'No') checked @endif name="quality_procedures" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_procedures_comment" class="form-control">{{ $medical->quality_procedures_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Are the internal laboratory reference standards, and the calibration of key testing equipment traceable to national standard through:</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_internal == 'Yes') checked @endif name="quality_internal" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_internal == 'No') checked @endif name="quality_internal" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_internal_comment" class="form-control">{{ $medical->quality_internal_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>• PNAC accredited</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_pnac == 'Yes') checked @endif name="quality_pnac" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_pnac == 'No') checked @endif name="quality_pnac" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_pnac_comment" class="form-control">{{ $medical->quality_pnac_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>• Other bodies (specify)?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_other == 'Yes') checked @endif name="quality_other" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_other == 'No') checked @endif name="quality_other" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_other_comment" class="form-control">{{ $medical->quality_other_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>6. Do you perform in-house calibration of your instruments? (if yes)</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_perform == 'Yes') checked @endif name="quality_perform" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_perform == 'No') checked @endif name="quality_perform" value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_perform_comment" class="form-control">{{ $medical->quality_perform_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>a. Have you identified source of uncertainty measurement?</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">

                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_identified_comment" class="form-control">{{ $medical->quality_identified_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>b. Do you incorporate uncertainty of measurement in your calibration?</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">

                            </div>
                            <div class="form-group col-6">
                                <label>Quality Manual reference/other comment</label>
                                <textarea name="quality_incorporate_comment" class="form-control">{{ $medical->quality_incorporate_comment }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>B. Compliance with ISO 15189:2012 and PNAC Accreditation Requirements</h5>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label>1. Do you consider that your laboratory complies with ISO 15189:2012 and PNAC accreditation requirements? (Pls. see PNAC’s website for policies).</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="radio" @if($medical->quality_compliance_consider == 'Yes') checked @endif name="quality_compliance_consider" value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" @if($medical->quality_compliance_consider == 'No') checked @endif name="quality_compliance_consider" value="No">
                                <label for="">No</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">If "No" in which specific areas it does not comply, and when do you expect non-compliance is rectified?</label>
                            <textarea name="quality_compliance_specific" class="form-control">{{ $medical->quality_compliance_specific }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Area of non-compliance </label>
                            <textarea name="quality_compliance_area" class="form-control">{{ $medical->quality_compliance_area }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Rectified by (date)</label>
                            <input type="date" name="quality_rectified" value="{{ $medical->quality_rectified }}" class="form-control">
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light medical-prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success medical-next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row section-form medical-section-form" id="OtherApprovals-Medical-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 5 - Other approvals (certifications/ accreditations)</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please detail current accreditation/approval held by your laboratory's testing facility</h5>
                        </div>
                        <div class="form-group">
                            <label>Name & address of approval body</label>
                            <textarea name="approvals_name" class="form-control">{{ $medical->approvals_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Scope of accreditation/approval and number of certificate (if any)</label>
                            <textarea name="approvals_scope" class="form-control">{{ $medical->approvals_scope }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Period of accreditation/approval</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Start</label>
                                <input type="date" name="approvals_start_date" value="{{ $medical->approvals_start_date }}" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Expiry Date</label>
                                <input type="date" name="approvals_end_date" value="{{ $medical->approvals_end_date }}" class="form-control">
                            </div>
                        </div>

                        <div class="footer">
                            <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                <button type="button" class="btn btn-light medical-prev-btn">Previous</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-success medical-next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row section-form medical-section-form" id="Declaration-Medical-form">
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
                            <label>6.1 The laboratory applies to PNAC for accreditation for (please tick appropriate boxes)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_clinical == 'on') checked @endif name="declaration_clinical">
                            <label>Clinical Chemistry</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_haematology == 'on') checked @endif name="declaration_haematology">
                            <label>Haematology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_histopathology == 'on') checked @endif name="declaration_histopathology">
                            <label>Histopathology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_immunology == 'on') checked @endif name="declaration_immunology">
                            <label>Immunology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_microbiology == 'on') checked @endif name="declaration_microbiology">
                            <label>Microbiology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_moleculary == 'on') checked @endif name="declaration_moleculary">
                            <label>Molecular Biology</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($medical->declaration_other == 'on') checked @endif name="declaration_other">
                            <label>Other (Please describe)</label>
                            <input type="text" value="{{ $medical->declaration_moleculary }}" name="declaration_moleculary" class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>6.2. The organisation/laboratory agrees to conform, upon accreditation, with PNAC
                                requirements as detailed in the Agreement [F-01/04].
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>6.3 The organisation/lab comply fully with ISO 15189: 2012 for accreditation of
                                Medical testing laboratories.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>6.4. I enclose a copy of Quality Manual and Quality Procedures (see Note below)</h6>
                        </div>
                        <div class="form-group">
                            <h6>6.5 I understand PNAC policies and procedures for Assessment, surveillance and
                                Re-assessment.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>6.6. I enclose a cheque (payable to PNAC) for the Applicant fee of ________. I
                                understand that this fee is non-refundable. (see Note below).
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>6.7. I understand the manner in which the accreditation system functions.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>6.8. I declare that the information given in this form is correct to the best of my knowledge and belief
                            </h6>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Signed</label>
                                <input type="file" name="signed" value="{{ $medical->signed }}" class="form-control">
                                <img src="{{ asset('storage/'.$medical->signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="date" value="{{ $medical->date }}" class="form-control">
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
