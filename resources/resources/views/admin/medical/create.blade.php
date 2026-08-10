@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
<style>
    /* .btn-success {
    background-color: #28a745;
    color: white;
}
.btn-outline-secondary {
    border: 1px solid #6c757d;
    color: #6c757d;
} */

</style>
@endsection

<div class="main-content">

    <div id="form-error" class="alert alert-danger d-none">
        Please fill all required fields.
    </div>

    <div class="button mb-2">
        <div class="row">
            <div class="col-4">
                <button class="btn btn-outline-primary" id="Application">Application</button>
                <button class="btn btn-outline-primary">Document</button>
            </div>

        </div>
    </div>
    <div class="parts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="GeneralInfo-form" id="GeneralInfo">General Info</button>
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="AboutYourselves-form" id="AboutYourselves">Part 1 - About yourselves</button>
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="AboutYourStaff-form" id="AboutYourStaff">Part 2 - About your staff</button>
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="ScopeApplication-form" id="ScopeApplication">Part 3 - Scope of application</button>
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="CalibrationFacility-form" id="CalibrationFacility">Part 4 - Calibration Facility (for labs performing in-house calibrations)</button>
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="OtherApprovals-form" id="OtherApprovals">Part 5 - Other approvals</button>
                <button class="btn btn-outline-success form-toggle-btn mt-2" data-target="Declaration-form" id="Declaration">Part 6 - Declaration</button>
            </div>

        </div>
    </div>


    <form action="{{ route('application.store') }}" method="POST">
        @csrf
        <section class="section">


            <div class="row form-section section-form" id="GeneralInfo-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.general.store') }}" method="POST">
                    @csrf --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>General Info</h4>
                            {{-- <h4>Application For Laboratory Accreditation ISO/IEC 17025</h4> --}}
                            {{-- <h4>Please type or use BLOCK LETTERS</h4> --}}
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Organisation</label>
                                <input type="text" name="organisation" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Address of laboratory</label>
                                <input type="text" name="address_laboratory" required class="form-control">
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

                            <div class="form-group">
                                <h5>This application is for (tick appropriate boxes)</h5>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_calibration">
                                <label for="">New accreditation as a calibration laboratory</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_laboratory">
                                <label for=""> New accreditation as a testing laboratory</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_extension">
                                <label for=""> Extension of scope</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_permanent">
                                <label for=""> Permanent lab</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_mobile">
                                <label for=""> Mobile lab</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_renewal">
                                <label for=""> Renewal of Accreditation</label>
                            </div>
                            <div class="form-group">
                                <h5>I enclosed (tick boxes)</h5>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_quality">
                                <label for="">A copy of the laboratory's Standard Operating Procedures (Quality & Technical)</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_participation">
                                <label for="">Participation in recognised PT scheme (F-2/31)</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_plan">
                                <label for="">Plan of PT participation (F-2/33)</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_agreement">
                                <label for="">Agreement (F-01/04)</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_filled">
                                <label for="">Filled form (F-2/17-A)</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="chack_staff">
                                <label for="">List of laboratory's staff</label>
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
                    {{-- </form> --}}
                </div>

            </div>

            <div class="row form-section section-form" id="AboutYourselves-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.yourselves.store') }}" method="POST">
                    @csrf --}}
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
                                <h5>1.2 Name and address of parent organisation (if any) of laboratory</h5>
                            </div>
                            <div class="form-group">
                                <label>Parent</label>
                                <input type="text" name="selves_parent" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" name="selves_organization" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Relationship</label>
                                <input type="text" name="selves_relationship" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>With Parent</label>
                                <input type="text" name="selves_with_parent" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" name="selves_parent_organization" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="selves_address" required class="form-control">
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
                                <h5>1.3 Address for invoicing (if different from laboratory address on page 1)</h5>
                            </div>

                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" name="selves_organization_three" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="selves_address_three" required class="form-control">
                            </div>

                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Postcode</label>
                                    <input type="text" name="selves_postcode_three" required class="form-control">
                                </div>
                                <div class="form-group col-4">
                                    <label>Tel</label>
                                    <input type="text" name="selves_tel_three" required class="form-control">
                                </div>
                                <div class="form-group col-4">
                                    <label>Fax</label>
                                    <input type="text" name="selves_fax_three" required class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <h5>1.4 Information about ownership: please tick the appropriate box.</h5>
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
                                    <label>Owned by a private company/partnership</label>
                                </div>


                                <div class="form-group col-6">
                                    <input type="checkbox" name="selves_learned">
                                    <label>Part of learned/tech</label>
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
                                <h5>1.5 Is calibration/testing the main activity of the parent company</h5>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="selves_activities" value="Yes">
                                <label>Yes</label>
                                <input type="radio" name="selves_industry" value="No">
                                <label>No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>describe the main activities of the parent company</label>
                            </div>


                            <div class="form-group">
                                <h5>1.6. For whom does the laboratory undertake calibration/testing</h5>
                            </div>
                            <div class="row">

                                <div class="form-group col-6">
                                    <input type="checkbox" name="selves_own_organisation">
                                    <label>Own organisation</label>
                                </div>
                                <div class="form-group col-6">
                                    <input type="checkbox" name="selves_other_organisation">
                                    <label>Other organisations</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h5>1.7 Name of Consultant / Consultancy Firm (if any)</h5>
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="selves_name_seven" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Organisation(if any)</label>
                                <input type="text" name="selves_organisation_any" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="selves_address_seven" required class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Postcode</label>
                                    <input type="text" name="selves_postcode_seven" required class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label>Tel</label>
                                    <input type="text" name="selves_tel_seven" required class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Fax</label>
                                    <input type="text" name="selves_fax_seven" required class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label>E-mail</label>
                                    <input type="email" name="selves_email_seven" required class="form-control">
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
                    {{-- </form> --}}
                </div>
            </div>

            <div class="row form-section section-form" id="AboutYourStaff-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.yourstaff.store') }}" method="POST">
                    @csrf --}}
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
                                <input type="text" name="staff_name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Qualifications</label>
                                <input type="text" name="staff_qualifications" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Relevant</label>
                                <input type="text" name="staff_relevant" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Experience</label>
                                <input type="text" name="staff_experience" required class="form-control">
                            </div>
                            <div class="form-group">
                                <h5>B. Quality Manger</h5>
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
                                <input type="text" name="staff_quality_experience" required class="form-control">
                            </div>

                            <div class="form-group">
                                <h4>Part 3 - Scope of application: Calibration</h4>
                            </div>
                            <div class="form-group">
                                <h5>List all the measurement parameters for which you seek accreditation. Use a photocopy of this page for each field of measurement.</h5>
                            </div>
                            <div class="form-group">
                                <h6>Field of measurement: </h6>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class="col-2">Measured quantity</label>
                                    <label class="col-2">Range</label>
                                    <label class="col-3">*Expanded Uncertainty
                                        ( +
                                        - )
                                    </label>
                                    <label class="col-4">Technique, Reference Standard, Equipment</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group d-flex">
                                    <input type="text" name="staff_measured" required class="form-control col-3">
                                    <input type="text" name="staff_range" required class="form-control col-3">
                                    <input type="text" name="staff_expanded" required class="form-control col-3">
                                    <input type="text" name="staff_technique" required class="form-control col-3">
                                </div>
                            </div>
                            <div class="form-group">
                                <h6 class="text-underline">* Expanded Uncertainty:</h5>
                                    <p>
                                        Expanded Uncertainty is the measurement uncertainty at a coverage probability of 95 %, which usually requires the use of a coverage factor of k = 2. This measurement uncertainty is a value for which the laboratory has been accredited using the procedure that was the subject of assessment. In certificates issued under its accreditation scope an accredited laboratory is not permitted to quote an uncertainty that is smaller than the published uncertainty for respective ranges as given above.
                                    </p>
                            </div>

                            <div class="footer">
                                <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                    <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-success next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>

            </div>

            <div class="row form-section section-form" id="ScopeApplication-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.scope.store') }}" method="POST">
                    @csrf --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Scope Application</h4>
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
                                <textarea name="scop_materials" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Types of test/Properties measured</label>
                                <textarea name="scop_types" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Range of measurement</label>
                                <textarea name="scop_range" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Minimum detection limit</label>
                                <textarea name="scop_detection" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Uncertainty of Measurement (where applicable)
                                    ( + )
                                </label>
                                <textarea name="scop_uncertainty" required class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Standard specification/Techniques/equipment used</label>
                                <textarea name="scop_standard" required class="form-control"></textarea>
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
                                <textarea name="scop_description" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Working Range/ capacity of equipment and other relevant information</label>
                                <textarea name="scop_working" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Minimum detection limit</label>
                                <textarea name="scop_limit" required class="form-control"></textarea>
                            </div>

                            <div class="footer">
                                <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                    <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-success next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>

            <div class="row form-section section-form" id="CalibrationFacility-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.calibrationFacility.store') }}" method="POST">
                    @csrf --}}
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
                                    <input type="radio" name="calibration_fully" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_fully" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_fully_comment" required class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>2. Is a record maintained for test equipment, including calibration results?</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_record" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_record" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_record_comment" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>3. Are adequate facilities and environments provided for calibration, handling, control, storage and maintenance of all measuring equipment?</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_adequate" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_adequate" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_adequate_comment" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>4. Are there documented procedures for calibrating all equipment and reference standards which cover the method of calibration and maximum, intervals between calibrations?</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_procedures" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_procedures" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_procedures_comment" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>5. Are the internal laboratory reference standards, and the calibration of key testing equipment traceable to national standard through:</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_internal" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_internal" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_internal_comment" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>• PNAC accredited</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_pnac" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_pnac" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_pnac_comment" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>• Other bodies (specify)?</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_other" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_other" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_other_comment" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Does the lab participate in Proficiency Testing for Calibration activities?</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="radio" name="calibration_lab" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_lab" value="No">
                                    <label for="">No</label>
                                </div>
                                <div class="form-group col-6">
                                    <label>Reference/other comment</label>
                                    <textarea name="calibration_lab_comment" class="form-control"></textarea>
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
                                    <input type="radio" name="calibration_consider" value="Yes">
                                    <label for="" class="col-3">Yes</label>
                                    <input type="radio" name="calibration_consider" value="No">
                                    <label for="">No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h5>If "No" in which specific areas does it not comply, and when do you expect non-compliance be rectified?</h5>
                            </div>
                            <div class="form-group">
                                <label for="">Area of non-compliance</label>
                                <textarea name="calibration_compliance" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Rectified by (date)</label>
                                <textarea name="calibration_rectified" class="form-control"></textarea>
                            </div>

                            <div class="footer">
                                <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                    <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-success next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>

            </div>

            <div class="row form-section section-form" id="OtherApprovals-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.otherapprovals.store') }}" method="POST">
                    @csrf --}}
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
                    {{-- </form> --}}
                </div>

            </div>

            <div class="row form-section section-form" id="Declaration-form">
                <div class="col-12 col-md-12 col-lg-12">
                    {{-- <form action="{{ route('application.declaration.store') }}" method="POST">
                    @csrf --}}
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
                                <input type="checkbox" name="declaration_calibration">
                                <label>Calibration</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="declaration_testing">
                                <label>Testing</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="declaration_extension">
                                <label>An extension in scope of existing accreditation for a:</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="declaration_laboratory">
                                <label>Calibration laboratory</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="declaration_test_lab">
                                <label>Testing laboratory</label>
                            </div>
                            <div class="form-group">
                                <h6>7.2. The organisation/laboratory agrees to conform, upon accreditation, with PNAC requirements as detailed in the Agreement [F-01/04].</h6>
                            </div>
                            <div class="form-group">
                                <h6>7.3. I enclose a cheque (payable to PNAC) for the Applicant fee of <span><input type="text" name="applicant_fee" style=" border-left: none;border-right: none;border-top: none;border-bottom:0.5px solid black; outline:none;"></span> I understand that this fee is non-refundable. (see Note below).</h6>
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
                                    <input type="text" name="signed" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                            </div>

                            <div class="footer">
                                <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                                    <button type="button" class="btn btn-light prev-btn">Previous</button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-success next-btn" id="NextBtn">Next</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- </form> --}}
                </div>

            </div>


            <div class="footer main-form-submit-footer d-none">
                <div class="form-navigation d-flex justify-content-center mt-1 mb-5">
                    <a href="{{ route('application.index') }}" type="button" class="btn btn-light">Cancel</a>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success">Save Change</button>
                </div>
            </div>
        </section>
    </form>

</div>

@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $("#GeneralInfo-form").hide();
    $(".parts").show();
    $("#AboutYourselves-form").hide();
    $("#AboutYourStaff-form").hide();
    $("#ScopeApplication-form").hide();
    $("#CalibrationFacility-form").hide();
    $("#OtherApprovals-form").hide();
    $("#Declaration-form").hide();

    $("#Application").click(function() {
        $(".parts").toggle();
    });



    $(document).ready(function() {
        let sections = $('.section-form');
        const buttons = $('.form-toggle-btn');
        let currentIndex = 0;

        function validateCurrentSection() {
            let currentForm = sections.eq(currentIndex).find(':input');
            let isValid = true;

            currentForm.each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    this.reportValidity();
                    return false;
                }
            });

            if (!isValid) {
                $('#form-error').removeClass('d-none');
                return false;
            }

            $('#form-error').addClass('d-none');
            return true;
        }

        function showSection(index) {
            sections.hide().eq(index).show();
            currentIndex = index;

            buttons.each(function(i) {
                $(this).removeClass('btn-primary btn-success').addClass('btn-outline-primary');

                if (i < index) {
                    $(this).removeClass('btn-outline-primary').addClass('btn-success'); // completed
                } else if (i === index) {
                    $(this).removeClass('btn-outline-primary').addClass('btn-success'); // current
                }
                // future steps stay btn-outline-primary
            });

            if (index === sections.length - 1) {
                $('.main-form-submit-footer').removeClass('d-none');
            } else {
                $('.main-form-submit-footer').addClass('d-none');
            }

            // Show/hide prev button
            if (index === 0) {
                $('.prev-btn').hide();
            } else {
                $('.prev-btn').show();
            }

        }


        // Toggle buttons at top
        // $('.form-toggle-btn').on('click', function(e) {
        //     e.preventDefault();
        //     let targetId = $(this).data('target');
        //     let index = sections.index($('#' + targetId));

        //     if (index <= currentIndex && validateCurrentSection()) {
        //         showSection(index);
        //     }
        // });

        $('.form-toggle-btn').on('click', function(e) {
    e.preventDefault();
    let targetId = $(this).data('target');
    let index = sections.index($('#' + targetId));

    // Allow going backward freely
    if (index <= currentIndex) {
        showSection(index);
    }
    // Only validate if jumping forward
    else if (validateCurrentSection()) {
        showSection(index);
    }
});


        $('.next-btn').on('click', function() {
            if (!validateCurrentSection()) return;

            if (currentIndex < sections.length - 1) {
                showSection(currentIndex + 1);

                // Scroll to top after showing the new section
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');
            }

            // Disable Next button on last step
            if (currentIndex === sections.length - 1) {
                $('.next-btn').prop('disabled', true);
            }
        });


        $('.prev-btn').on('click', function() {
            if (currentIndex > 0) {
                showSection(currentIndex - 1);
                $('.next-btn').prop('disabled', false); // Re-enable
            }
        });

        // Initial state
        showSection(0);
    });



    // $(document).ready(function() {
    //     const sections = $('.section-form');
    //     let currentIndex = 0;

    //     // Show the first section by default
    //     sections.hide().eq(currentIndex).show();

    //     // Toggle via top buttons
    //     $('.form-toggle-btn').on('click', function() {
    //         const targetId = $(this).attr('id') + '-form';
    //         sections.hide();
    //         $('#' + targetId).show();
    //         currentIndex = sections.index($('#' + targetId));
    //     });

    //     // Next button logic
    //     $('.next-btn').on('click', function () {
    //         let currentSection = sections.eq(currentIndex);
    //         let form = currentSection.find('form')[0]; // Get native form element

    //         if (form.checkValidity()) {
    //             form.reportValidity(); // Shows built-in browser validation feedback

    //             // Go to next section
    //             if (currentIndex < sections.length - 1) {
    //                 currentSection.hide();
    //                 currentIndex++;
    //                 sections.eq(currentIndex).show();
    //             }
    //         } else {
    //             form.reportValidity(); // Show validation message
    //         }
    //     });

    //     // Previous button logic
    //     $('.prev-btn').on('click', function() {
    //         if (currentIndex > 0) {
    //             sections.eq(currentIndex).hide();
    //             currentIndex--;
    //             sections.eq(currentIndex).show();
    //         }
    //     });
    // });

    // $(document).ready(function() {
    //     $('.form-toggle-btn').on('click', function() {
    //         var targetId = $(this).attr('id') + '-form';
    //         $('.form-section').hide(); // Hide all forms
    //         $('#' + targetId).show(); // Show only the clicked one
    //     });
    // });

</script>
@endsection
