{{-- Application For lab --}}
<form action="{{ route('application.update', $application->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <input type="hidden" name="category" value="{{ $scheme_name }}">


        <div class="row form-section section-form" id="GeneralInfo-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>General Info</h4>

                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Organisation</label>
                            <input type="text" name="organisation" value="{{ $application->organisation }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address of laboratory</label>
                            <input type="text" name="address_laboratory" value="{{ $application->address_laboratory }}" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" name="postcode" value="{{ $application->postcode }}" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" name="tel" value="{{ $application->tel }}" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" name="fax" value="{{ $application->fax }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            Person to whom enquiries about this application should be directed
                        </div>
                        <div class="form-group">
                            <label>Name of Contact:</label>
                            <input type="text" name="contact_name" value="{{ $application->contact_name }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Designation:</label>
                            <input type="text" name="designation" value="{{ $application->designation }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" name="person_address" value="{{ $application->person_address }}" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" name="person_postcode" value="{{ $application->person_postcode }}" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" name="person_tel" value="{{ $application->person_tel }}" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" name="person_fax" value="{{ $application->person_fax }}" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" name="person_email" value="{{ $application->person_email }}" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>This application is for (tick appropriate boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_calibration == 'on') checked @endif name="chack_calibration">
                            <label for="">New accreditation as a calibration laboratory</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_laboratory == 'on') checked @endif name="chack_laboratory">
                            <label for=""> New accreditation as a testing laboratory</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_extension == 'on') checked @endif name="chack_extension">
                            <label for=""> Extension of scope</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_permanent == 'on') checked @endif name="chack_permanent">
                            <label for=""> Permanent lab</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_mobile == 'on') checked @endif name="chack_mobile">
                            <label for=""> Mobile lab</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_renewal == 'on') checked @endif name="chack_renewal">
                            <label for=""> Renewal of Accreditation</label>
                        </div>
                        <div class="form-group">
                            <h5>I enclosed (tick boxes)</h5>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_quality == 'on') checked @endif name="chack_quality">
                            <label for="">A copy of the laboratory's Standard Operating Procedures (Quality & Technical)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_participation == 'on') checked @endif name="chack_participation">
                            <label for="">Participation in recognised PT scheme (F-2/31)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_plan == 'on') checked @endif name="chack_plan">
                            <label for="">Plan of PT participation (F-2/33)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_agreement == 'on') checked @endif name="chack_agreement">
                            <label for="">Agreement (F-01/04)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_filled == 'on') checked @endif name="chack_filled">
                            <label for="">Filled form (F-2/17-A)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_staff == 'on') checked @endif name="chack_staff">
                            <label for="">List of laboratory's staff</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->chack_applicant == 'on') checked @endif name="chack_applicant">
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

        <div class="row form-section section-form" id="AboutYourselves-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>About yourselves</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>1.1 Name and position (Director level) of person authorising this application</h5>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="selves_title" value="{{ $application->selves_title }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" name="selves_name" value="{{ $application->selves_name }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" name="selves_position" value="{{ $application->selves_position }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.2 Name and address of parent organisation (if any) of laboratory</h5>
                        </div>
                        <div class="form-group">
                            <label>Parent</label>
                            <input type="text" name="selves_parent" value="{{ $application->selves_parent }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" name="selves_organization" value="{{ $application->selves_organization }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relationship</label>
                            <input type="text" name="selves_relationship" value="{{ $application->selves_relationship }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>With Parent</label>
                            <input type="text" name="selves_with_parent" value="{{ $application->selves_with_parent }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" name="selves_parent_organization" value="{{ $application->selves_with_parent }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="selves_address" value="{{ $application->selves_address }}" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" name="selves_postcode" value="{{ $application->selves_postcode }}" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" name="selves_tel" value="{{ $application->selves_tel }}" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" name="selves_fax" value="{{ $application->selves_fax }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.3 Address for invoicing (if different from laboratory address on page 1)</h5>
                        </div>

                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" name="selves_organization_three" value="{{ $application->selves_organization_three }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="selves_address_three" value="{{ $application->selves_address_three }}" required class="form-control">
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                <label>Postcode</label>
                                <input type="text" name="selves_postcode_three" value="{{ $application->selves_postcode_three }}" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Tel</label>
                                <input type="text" name="selves_tel_three" value="{{ $application->selves_tel_three }}" required class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Fax</label>
                                <input type="text" name="selves_fax_three" value="{{ $application->selves_fax_three }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.4 Information about ownership: please tick the appropriate box.</h5>
                        </div>

                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_individual == 'on') checked @endif name="selves_individual">
                                <label>Owned by an individual</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_public == 'on') checked @endif name="selves_public">
                                <label>Owned by public limited Company</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_private == 'on') checked @endif name="selves_private">
                                <label>Owned by a private company/partnership</label>
                            </div>


                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_learned == 'on') checked @endif name="selves_learned">
                                <label>Part of learned/tech</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_industry == 'on') checked @endif name="selves_industry">
                                <label>Owned by a public body/nationalised industry</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_academic == 'on') checked @endif name="selves_academic">
                                <label>Part of an academic institution</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Other: Please describe</label>
                            <input type="text" name="selves_other_describe" value="{{ $application->selves_other_describe }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>1.5 Is calibration/testing the main activity of the parent company</h5>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="selves_activities" @if($application->selves_activities == 'Yes') checked @endif value="Yes">
                            <label>Yes</label>
                            <input type="radio" name="selves_industry" @if($application->selves_activities == 'No') checked @endif value="No">
                            <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>describe the main activities of the parent company</label>
                        </div>


                        <div class="form-group">
                            <h5>1.6. For whom does the laboratory undertake calibration/testing</h5>
                        </div>
                        <div class="row">

                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_own_organisation == 'on') checked @endif name="selves_own_organisation">
                                <label>Own organisation</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="checkbox" @if($application->selves_other_organisation == 'on') checked @endif name="selves_other_organisation">
                                <label>Other organisations</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>1.7 Name of Consultant / Consultancy Firm (if any)</h5>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="selves_name_seven" value="{{ $application->selves_name_seven }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Organisation(if any)</label>
                            <input type="text" name="selves_organisation_any" value="{{ $application->selves_organisation_any }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="selves_address_seven" value="{{ $application->selves_address_seven }}" required class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Postcode</label>
                                <input type="text" name="selves_postcode_seven" value="{{ $application->selves_postcode_seven }}" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Tel</label>
                                <input type="text" name="selves_tel_seven" value="{{ $application->selves_tel_seven }}" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Fax</label>
                                <input type="text" name="selves_fax_seven" value="{{ $application->selves_fax_seven }}" required class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>E-mail</label>
                                <input type="email" name="selves_email_seven" value="{{ $application->selves_email_seven }}" required class="form-control">
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

        <div class="row form-section section-form" id="AboutYourStaff-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>About Your Staff</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please list the names, technical qualifications and relevant experience of the following staff</h5>
                        </div>
                        <div class="form-group">
                            <h6>A. Technical Management (if more than three members please attach extra sheet)</h6>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_name" value="{{ $application->staff_name }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_qualifications" value="{{ $application->staff_qualifications }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" name="staff_relevant" value="{{ $application->staff_relevant }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" name="staff_experience" value="{{ $application->staff_experience }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <h5>B. Quality Manger</h5>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_quality_name" value="{{ $application->staff_quality_name }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qualifications</label>
                            <input type="text" name="staff_quality_qualifications" value="{{ $application->staff_quality_qualifications }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Relevant</label>
                            <input type="text" name="staff_quality_relevant" value="{{ $application->staff_quality_relevant }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" name="staff_quality_experience" value="{{ $application->staff_quality_experience }}" required class="form-control">
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

        @if($scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratoies')

        {{-- Scope of application: Calibration --}}
        <div class="row section-form application-section-form" id="ScopeApplicationCalibration-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 3 - Scope of application: Calibration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                List all the measurement parameters for which you seek accreditation. Use a photocopy of this page for each field of measurement.
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Field of measurement:</label>
                        </div>
                        <div class="form-group">
                            <label>Measured quantity</label>
                            <textarea name="scop_calib_measurement" required class="form-control">{{ $application->scop_calib_measurement }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Range</label>
                            <textarea name="scop_calib_range" required class="form-control">{{ $application->scop_calib_range }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>*Expanded Uncertainty( +  )</label>
                            <textarea name="scop_calib_expanded" required class="form-control">{{ $application->scop_calib_expanded }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Technique, Reference Standard, Equipment</label>
                            <textarea name="scop_calib_technique" required class="form-control">{{ $application->scop_calib_technique }}</textarea>
                        </div>

                        <div class="form-group">
                            <h6>
                                <b class="underline">Expanded Uncertainty:</b>
                                	Expanded Uncertainty is the measurement uncertainty at a coverage probability of 95 %, which usually requires the use of a coverage factor of k = 2. This measurement uncertainty is a value for which the laboratory has been accredited using the procedure that was the subject of assessment. In certificates issued under its accreditation scope an accredited laboratory is not permitted to quote an uncertainty that is smaller than the published uncertainty for respective ranges as given above.

                            </h6>
                        </div>
                        {{-- <div class="form-group">
                            <h5>
                                4C List the major items of equipment currently used for the types of test listed in part 3 and/or 4
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (Use of photocopy of this page, if the space given is found insufficient)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Description (include make and model)</label>
                            <textarea name="scop_description" required class="form-control">{{ $application->scop_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Working Range/ capacity of equipment and other relevant information</label>
                            <textarea name="scop_working" required class="form-control">{{ $application->scop_working }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Minimum detection limit</label>
                            <textarea name="scop_limit" required class="form-control">{{ $application->scop_limit }}</textarea>
                        </div> --}}

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
        @endif


        @if($scheme_name == 'Testing' || $scheme_name == 'Testing Calibration Laboratoies')
        {{-- Scope of application: Testing --}}
        <div class="row section-form application-section-form" id="ScopeApplication-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 4 - Scope Application: Testing</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                <b>4A.</b> As far as is possible, quote standard specifications in the third column. These may include specifications issued by companies and other organisations, both Pakistan and foreign, as well as national and international standards. Give reference numbers and dates of specifications quoted.

                                In the absence of standard specifications, documented in-house procedures may be quoted: cross-refer to your laboratory Management System/Procedures Manual.
                                (Use of photocopy of this page, if the space given is found insufficient)

                            </p>
                        </div>
                         <div class="form-group">
                            <label>Materials/Products tested*</label>
                            <textarea name="scop_materials" required class="form-control">{{ $application->scop_materials }}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label>Types of test/Properties measured</label>
                            <textarea name="scop_types" required class="form-control">{{ $application->scop_types }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Range of measurement</label>
                            <textarea name="scop_range" required class="form-control">{{ $application->scop_range }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Minimum detection limit</label>
                            <textarea name="scop_detection" required class="form-control">{{ $application->scop_detection }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Uncertainty of Measurement (where applicable)
                                ( + )
                            </label>
                            <textarea name="scop_uncertainty" required class="form-control">{{ $application->scop_uncertainty }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Standard specification/Techniques/equipment used</label>
                            <textarea name="scop_standard" required class="form-control">{{ $application->scop_standard }}</textarea>
                        </div>
                        <div class="form-group">
                            <h6>
                                *Please also mention Active Pharmaceutical Ingredient (API) in case of Pharmaceutical Testing
                            </h6>
                        </div>
                        <div class="form-group">
                            <h5>
                                4C List the major items of equipment currently used for the types of test listed in part 3 and/or 4
                            </h5>
                        </div>
                        <div class="form-group">
                            <h6>
                                (Use of photocopy of this page, if the space given is found insufficient)
                            </h6>
                        </div>
                        <div class="form-group">
                            <label>Description (include make and model)</label>
                            <textarea name="scop_description" required class="form-control">{{ $application->scop_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Working Range/ capacity of equipment and other relevant information</label>
                            <textarea name="scop_working" required class="form-control">{{ $application->scop_working }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Minimum detection limit</label>
                            <textarea name="scop_limit" required class="form-control">{{ $application->scop_limit }}</textarea>
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
        @endif

        <div class="row form-section section-form" id="CalibrationFacility-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Calibration Facility (for testing laboratories performing in-house calibrations)</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>
                                Please answer every question, adding comments as necessary
                            </p>
                        </div>
                        <div class="form-group">
                            <label>1. Does a fully documented calibration program exist to ensure that the accuracy of equipment is adequate for the service operated by the laboratory?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_fully" @if($application->calibration_fully == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_fully" @if($application->calibration_fully == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_fully_comment" required class="form-control">{{ $application->calibration_fully_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>2. Is a record maintained for test equipment, including calibration results?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_record" @if($application->calibration_record == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_record" @if($application->calibration_record == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_record_comment" class="form-control">{{ $application->calibration_record_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>3. Are adequate facilities and environments provided for calibration, handling, control, storage and maintenance of all measuring equipment?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_adequate" @if($application->calibration_adequate == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_adequate" @if($application->calibration_adequate == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_adequate_comment" class="form-control">{{ $application->calibration_adequate_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>4. Are there documented procedures for calibrating all equipment and reference standards which cover the method of calibration and maximum, intervals between calibrations?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_procedures" @if($application->calibration_procedures == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_procedures" @if($application->calibration_procedures == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_procedures_comment" class="form-control">{{ $application->calibration_procedures_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>5. Are the internal laboratory reference standards, and the calibration of key testing equipment traceable to national standard through:</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_internal" @if($application->calibration_internal == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_internal" @if($application->calibration_internal == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_internal_comment" class="form-control">{{ $application->calibration_internal_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>• PNAC accredited</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_pnac" @if($application->calibration_pnac == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_pnac" @if($application->calibration_pnac == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_pnac_comment" class="form-control">{{ $application->calibration_pnac }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>• Other bodies (specify)?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_other" @if($application->calibration_other == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_other" @if($application->calibration_other == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_other_comment" class="form-control">{{ $application->calibration_other_comment }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Does the lab participate in Proficiency Testing for Calibration activities?</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_lab" @if($application->calibration_lab == 'Yes') checked @endif value="Yes">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_lab" @if($application->calibration_lab == 'No') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                            <div class="form-group col-6">
                                <label>Reference/other comment</label>
                                <textarea name="calibration_lab_comment" class="form-control">{{ $application->calibration_lab }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Compliance with ISO/IEC 17025 and PNAC Accreditation Requirements</h5>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label>1. Do you consider that your laboratory complies with ISO/IEC 17025 and PNAC accreditation requirements? (Pl see PNAC’s website for policies).</label>
                            </div>
                            <div class="form-group col-6">
                                <input type="radio" name="calibration_consider" @if($application->calibration_consider == 'Yes') checked @endif value="No">
                                <label for="" class="col-3">Yes</label>
                                <input type="radio" name="calibration_consider" @if($application->calibration_consider == 'Yes') checked @endif value="No">
                                <label for="">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>If "No" in which specific areas does it not comply, and when do you expect non-compliance be rectified?</h5>
                        </div>
                        <div class="form-group">
                            <label for="">Area of non-compliance</label>
                            <textarea name="calibration_compliance" class="form-control">{{ $application->calibration_compliance }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Rectified by (date)</label>
                            <textarea name="calibration_rectified" class="form-control">{{ $application->calibration_rectified }}</textarea>
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

        <div class="row form-section section-form" id="OtherApprovals-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 6 - Other approvals (certifications/ accreditations)</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>Please detail current accreditation/approval held by your laboratory's calibration/ testing facility</h5>
                        </div>
                        <div class="form-group">
                            <label>Name & address of approval body</label>
                            <textarea name="approvals_name" class="form-control">{{ $application->approvals_name }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>calibrationFacility of accreditation/approval and number of certificate (if any)</label>
                            <textarea name="approvals_scope" class="form-control">{{ $application->approvals_scope }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Period of accreditation/approval</label>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Start</label>
                                <input type="date" name="approvals_start_date" value="{{ $application->approvals_start_date }}" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Expiry Date</label>
                                <input type="date" name="approvals_end_date" value="{{ $application->approvals_end_date }}" class="form-control">
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

        <div class="row form-section section-form" id="Declaration-form">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Part 7 - Declaration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <h5>This declaration should be made by the person named in Section 1.1</h5>
                        </div>
                        <div class="form-group">
                            <label>7.1 The laboratory applies for accreditation by PNAC for (please tick appropriate boxes)</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->declaration_calibration == 'on') checked @endif name="declaration_calibration">
                            <label>Calibration</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->declaration_testing == 'on') checked @endif name="declaration_testing">
                            <label>Testing</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->declaration_extension == 'on') checked @endif name="declaration_extension">
                            <label>An extension in scope of existing accreditation for a:</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->declaration_laboratory == 'on') checked @endif name="declaration_laboratory">
                            <label>Calibration laboratory</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" @if($application->declaration_test_lab == 'on') checked @endif name="declaration_test_lab">
                            <label>Testing laboratory</label>
                        </div>
                        <div class="form-group">
                            <h6>7.2. The organisation/laboratory agrees to conform, upon accreditation, with PNAC requirements as detailed in the Agreement [F-01/04].</h6>
                        </div>
                        <div class="form-group">
                            <h6>7.3. I enclose a cheque (payable to PNAC) for the Applicant fee of <span><input type="text" name="applicant_fee" value="{{ $application->declaration_applicant_fee }}" style=" border-left: none;border-right: none;border-top: none;border-bottom:0.5px solid black; outline:none;"></span> I understand that this fee is non-refundable. (see Note below).</h6>
                        </div>
                        <div class="form-group">
                            <h6>7.4. I understand the manner in which the accreditation system functions. </h6>
                        </div>
                        <div class="form-group">
                            <h6>7.5. I declare that the information given in this form is correct to the best of my knowledge and belief</h6>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Signed</label>
                                <input type="file" name="signed" value="{{ $application->signed }}" class="form-control">
                                <img src="{{ asset('storage/'.$application->signed) }}" width="60px" alt="">
                            </div>
                            <div class="form-group col-6">
                                <label>Date</label>
                                <input type="date" name="date" value="{{ $application->date }}" class="form-control">
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
