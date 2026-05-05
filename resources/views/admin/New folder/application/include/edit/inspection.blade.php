<form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">

        {{-- General Info --}}
        <div class="row section-form inspection-section-form" id="GeneralInfo-Inspection-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-center">
                            <h5>Application For Inspection Body Accreditation</h5>
                            <h6>Please type or use BLOCK LETTERS</h6>
                        </div>
                        <div class="form-group">
                            <label>Inspection Body (IB) </label>
                            <input type="text" value="{{ $inspection->inspection_body }}" name="inspection_body" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $inspection->general_address }}" name="general_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $inspection->postcode }}" name="postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $inspection->tel }}" name="tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $inspection->fax }}" name="fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" value="{{ $inspection->contact_name }}" name="contact_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" value="{{ $inspection->designation }}" name="designation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" value="{{ $inspection->person_address }}" name="person_address" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" value="{{ $inspection->person_postcode }}" name="person_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" value="{{ $inspection->person_tel }}" name="person_tel" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" value="{{ $inspection->person_fax }}" name="person_fax" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" value="{{ $inspection->person_email }}" name="person_email" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Details of sub-offices/marketing</label>
                            <input type="text" name="sub_offices" value="{{ $inspection->sub_offices }}" required class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label>offices in other cities</label>
                            <input type="text" name="offices_cities" value="{{ $inspection->offices_cities }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($inspection->new_accreditation == 'on') checked @endif name="new_accreditation">
                            <label for="">New accreditation as an Inspection body</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($inspection->extension_scope == 'on') checked @endif name="extension_scope">
                            <label for="">Extension of scope</label>
                        </div>
                        <div class="form-group">
                           <h5><b>For new accreditation only:</b> I enclose (tick boxes)  </h5>
                        </div>


                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($inspection->chack_quality_manual == 'on') checked @endif name="chack_quality_manual">
                                <label for="">A copy of the IB’s Quality Manual</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($inspection->chack_applicant == 'on') checked @endif name="chack_applicant">
                                <label for="">Applicant fee-see note below</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" @if($inspection->chack_Completely == 'on') checked @endif name="chack_Completely">
                            <label for="">Completely filled Document-Review-and-Pre-Assessment Report for IBs = F-02/30</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($inspection->chack_calibration == 'on') checked @endif name="chack_calibration">
                            <label for="">Copies of the most recent calibration reports for major inspection equipment; if any.</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($inspection->chack_copies == 'on') checked @endif name="chack_copies">
                            <label for="">Sample copies of the work sheets and reports applicable to inspection activities for 	which accreditation are sought;</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($inspection->chack_internal == 'on') checked @endif name="chack_internal">
                            <label for="">Copy of the most recent internal quality audit & management review report, if any.</label>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($inspection->chack_vitae == 'on') checked @endif name="chack_vitae">
                                <label for="">Curriculum Vitae of all key personnel</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($inspection->chack_performed == 'on') checked @endif name="chack_performed">
                                <label for="">List of performed inspections</label>
                            </div>
                        </div>



                        <div class="form-group">
                            <input type="checkbox" @if($inspection->chack_filled_form == 'on') checked @endif name="chack_filled_form">
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
        <div class="row section-form inspection-section-form" id="AboutOrganization-Inspection-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 1  About Organization/Inspection body</h4>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <h4>Please type or use BLOCK LETTERS</h4>
                        </div>
                        <div class="form-group">
                            <h5>1.1	Name and position (Director level) of person authorising this application</h5>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" value="{{ $inspection->organized_title }}" name="organized_title" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" value="{{ $inspection->organized_name }}" name="organized_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" value="{{ $inspection->organized_position }}" name="organized_position" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2	Name and address of parent organisation (if any) of the IB</h5>
                        </div>
                        <div class="form-group">
                            <label>Parent Organization</label>
                            <input type="text" value="{{ $inspection->organized_parent_organization }}" name="organized_parent_organization" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relationship with Parent Organization</label>
                            <input type="text" value="{{ $inspection->organized_parent_relationship }}" name="organized_parent_relationship" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $inspection->organized_parent_address }}" name="organized_parent_address" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Postcode</label>
                            <input type="text" value="{{ $inspection->organized_parent_postcode }}" name="organized_parent_postcode" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tel</label>
                            <input type="text" value="{{ $inspection->organized_parent_tel }}" name="organized_parent_tel" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fax</label>
                            <input type="text" value="{{ $inspection->organized_parent_fax }}" name="organized_parent_fax" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>1.3 Address for invoicing (if different from IB address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" value="{{ $inspection->organized_invoicing_organization }}" name="organized_invoicing_organization" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="{{ $inspection->organized_invoicing_address }}" name="organized_invoicing_address" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" value="{{ $inspection->organized_invoicing_postcode }}" name="organized_invoicing_postcode" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" value="{{ $inspection->organized_invoicing_tel }}" name="organized_invoicing_tel" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" value="{{ $inspection->organized_invoicing_fax }}" name="organized_invoicing_fax" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4.  Date of Establishment:</h5>
                        </div>
                        <div class="form-group">
                            <label>1.5.  Legal Status (e.g. Limited company, partnership, local authority, etc.)</label>
                            <input type="text" value="{{ $inspection->organized_legal_status }}" name="organized_legal_status">

                        </div>
                        <div class="form-group">
                            <label>1.6 Does your organisation carry out inspection work outside Pakistan?</label>
                            <input type="radio" @if($inspection->organized_inspection == 'Yes') checked @endif name="organized_inspection" value="Yes"> Yes
                            <input type="radio" @if($inspection->organized_inspection == 'No') checked @endif name="organized_inspection" value="No"> No
                        </div>


                        <div class="form-group col-6">
                            <label>(if yes, please specify the types of inspection works and the countries in which they are carried out)</label>
                            <input type="text" value="{{ $inspection->organized_specify }}" name="organized_specify" class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>1.7	Is inspection the main activity of the parent organization?</h5>
                        </div>

                        <div class="form-group">
                            <input type="radio" @if($inspection->organized_activity == 'Yes') checked @endif name="organized_activity" value="Yes"> Yes
                            <input type="radio" @if($inspection->organized_activity == 'No') checked @endif name="organized_activity" value="No"> No
                        </div>
                        <div class="form-group">
                            <label for="">describe the main activities of the company</label>
                            <input type="text" value="{{ $inspection->organized_describe }}" name="organized_describe" class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>1.8	Inspection Body Type (As defined in ISO/IEC 17020, clause 4.1.6/Annex A:</h5>
                        </div>

                        <div class="form-group">
                            <label>Please check one</label>
                        </div>
                        <div class="form-group">
                            <input type="radio" @if($inspection->organized_body_type == 'Type A') checked @endif name="organized_body_type" value="Type A"> Type A:
                            <input type="radio" @if($inspection->organized_body_type == 'Type B') checked @endif name="organized_body_type" value="Type B"> Type B:
                            <input type="radio" @if($inspection->organized_body_type == 'Type C') checked @endif name="organized_body_type" value="Type C"> Type C:
                        </div>
                        <div class="form-group">
                            <h5>1.9	Other Accreditations:</h5>
                        </div>
                        <div class="form-group">
                            <h6>Please provide details of current accreditation (s) held by your Inspection Body</h6>
                        </div>
                        <div class="form-group">
                            <label for="">Name & address of Accreditation body</label>
                            <input type="text" value="{{ $inspection->organized_other_name }}" name="organized_other_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Scope of Accreditation</label>
                            <input type="text" value="{{ $inspection->organized_other_scope }}" name="organized_other_scope" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Period of Accreditation</label>
                            <input type="text" value="{{ $inspection->organized_other_period }}" name="organized_other_period" class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>Name of Consultant / Consultancy Firm (if any)</h6>
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" value="{{ $inspection->organized_consult_name }}" name="organized_consult_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Organisation(if any)</label>
                            <input type="text" value="{{ $inspection->organized_consult_Org }}" name="organized_consult_Org" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" value="{{ $inspection->organized_consult_address }}" name="organized_consult_address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Postcode</label>
                            <input type="text" value="{{ $inspection->organized_consult_postcode }}" name="organized_consult_postcode" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Tel</label>
                            <input type="text" value="{{ $inspection->organized_consult_tel }}" name="organized_consult_tel" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Fax</label>
                            <input type="text" value="{{ $inspection->organized_consult_fax }}" name="organized_consult_fax" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">E-mail</label>
                            <input type="email" value="{{ $inspection->organized_consult_email }}" name="organized_consult_email" class="form-control">
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
        <div class="row section-form inspection-section-form" id="AboutYourStaff-Inspection-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>About your staff</h4>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <h5>Please type or use BLOCK LETTERS</h5>
                        </div>
                        <div class="form-group">
                            <h5>2.1	Please list the names, qualifications and relevant experience of the following staff</h5>
                        </div>
                        <div class="form-group">
                            <h6>A.	Chief Executive</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $inspection->staff_chief_name }}" name="staff_chief_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $inspection->staff_chief_qualifications }}" name="staff_chief_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $inspection->staff_chief_relevant }}" name="staff_chief_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $inspection->staff_chief_exp }}" name="staff_chief_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>B.	Quality Management Representative </h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $inspection->staff_quality_name }}" name="staff_quality_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $inspection->staff_quality_qualifications }}" name="staff_quality_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $inspection->staff_quality_relevant }}" name="staff_quality_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $inspection->staff_quality_exp }}" name="staff_quality_exp" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h6>C.	Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $inspection->staff_manag_name }}" name="staff_manag_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $inspection->staff_manag_qualifications }}" name="staff_manag_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" value="{{ $inspection->staff_manag_relevant }}" name="staff_manag_relevant" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" value="{{ $inspection->staff_manag_exp }}" name="staff_manag_exp" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>2.2	Please list the names, qualifications, relevant inspection fields and experience of the Inspectors (Provide the CV’s of all the Inspectors):</h5>
                        </div>
                        <div class="form-group">
                            <h5><b>A.	Inspectors,  permanent employees of the company;</b>
                                (If required please attach extra sheets)</h5>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $inspection->staff_inspect_name }}" name="staff_inspect_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $inspection->staff_inspect_qualifications }}" name="staff_inspect_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" value="{{ $inspection->staff_inspect_auditing }}" name="staff_inspect_auditing" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit  Experience</label>
                            <input type="text" value="{{ $inspection->staff_inspect_exp }}" name="staff_inspect_exp" required class="form-control">
                        </div>

                        <div class="form-group">
                            <h5>B.	Sub-contracted/Free lance/Empanelled Inspectors, not the permanent employees of the company. (If required please attach extra sheets)</h5>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $inspection->staff_sub_name }}" name="staff_sub_name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" value="{{ $inspection->staff_sub_qualifications }}" name="staff_sub_qualifications" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Auditing Field</label>
                            <input type="text" value="{{ $inspection->staff_sub_auditing }}" name="staff_sub_auditing" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Audit  Experience</label>
                            <input type="text" value="{{ $inspection->staff_sub_exp }}" name="staff_sub_exp" required class="form-control">
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
        <div class="row section-form inspection-section-form" id="ScopeApplication-Inspection-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope of Accreditation</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                3.1. Please complete the following table as precisely as possible and include, wherever possible, standard methods and specifications involved. These may be national, international standards or the inspection body’s normative documents. The title of the method or specification, it’s number and date of issue should be listed. (Use extra sheets if necessary)
                            </p>
                        </div>

                        <div class="form-group">
                            <label>
                                <b>Description of Inspection(s), including the types of items inspected,</b>
                                for example: Product Design, Products (specified as Materials or Equipment), Installations, Plant, Premises, Processes, Services and Surveys, etc
                                </label>
                                <input type="text" value="{{ $inspection->scop_inspect_des }}" name="scop_inspect_des" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>
                                <b>Type and Range of Inspection</b>
                                : In-Service Inspection or Inspection of New Products)
                            </label>
                            <input type="text" value="{{ $inspection->scop_range }}" name="scop_range" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>
                                <b>Methods and Procedures,</b>
                                such as: Regulations, Standards,
                                Specifications, Internal Normative documents.
                            </label>
                            <input type="text" value="{{ $inspection->scop_method }}" name="scop_method" required class="form-control">
                        </div>



                        <div class="form-group">
                            <h5>
                                <b>3.2. Inspection Equipment (If any)</b>
                            </h5>
                        </div>
                        <div class="form-group">
                            <p>
                                Please provide the list of equipment used to perform the inspections for which accreditation is sought and the calibration status of the equipment. (Use extra sheets if necessary)
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Equipment (Name, Made, Capacity etc.)</label>
                            <input type="text" value="{{ $inspection->scop_equipment }}" name="scop_equipment" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status of Calibration</label>
                        </div>
                        <div class="form-group">
                            <label>calibration organization</label>
                            <input type="text" value="{{ $inspection->scop_calibration }}" name="scop_calibration" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Frequency of  Calibration</label>
                            <input type="text" value="{{ $inspection->scop_economic_b }}" name="scop_economic_b" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Date of Last Calibration</label>
                            <input type="date" value="{{ $inspection->scop_last_calib }}" name="scop_last_calib" required class="form-control">
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

        {{-- Part 4 --}}
        <div class="row section-form inspection-section-form" id="Declaration-Inspection-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 4 - Declaration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>This declaration should be made by the person named in Section 1.1</h5>
                        </div>
                        <div class="form-group">
                            <label>7.1 	The Inspection Body applies for accreditation by PNAC as (please tick 	appropriate boxes)</label>
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <input type="checkbox" @if($inspection->declaration_type_a == 'on') checked @endif name="declaration_type_a">
                            </div>
                            <div class="form-group col-4">
                                <input type="checkbox" @if($inspection->declaration_type_b == 'on') checked @endif name="declaration_type_b">
                            </div>
                            <div class="form-group col-4">
                                <input type="checkbox" @if($inspection->declaration_type_c == 'on') checked @endif name="declaration_type_c">
                            </div>
                        </div>

                        <div class="form-group">
                            <h6>
                                7.2	The organisation/Inspection body comply fully with ISO/IEC 17020.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                7.3	I understand with PNAC policies and procedures for Assessment, surveillance 	and Re-assessment.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>7.4 	The IB/organisation agrees to conform, upon accreditation with PNAC 	requirements as detailed in the Agreement [F-01/13]. </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                7.5 	I enclose a copy of Quality Manual (see Note below)
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                7.6	I enclose a copy of filled Document Review Form [F-02/30]
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                7.7 	I enclose a cheque (payable to PNAC) for the Applicant fee of ___________¬¬¬¬¬¬¬¬¬¬¬¬¬_. I 	understand that this fee is non-refundable. (see Note below).
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                7.8 	I understand the manner in which the accreditation system functions.
                            </h6>
                        </div>
                        <div class="form-group">
                            <h6>
                                I declare that the information given in this form is correct to the best of my 	knowledge and belief.
                            </h6>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label>Signed</label>
                                <input type="file" name="declaration_signed" value="{{ $inspection->declaration_signed }}" class="form-control">
                                <img src="{{ asset('storage/'.$inspection->signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" value="{{ $inspection->declaration_date }}" name="declaration_date" class="form-control">
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
