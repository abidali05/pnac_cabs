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

    <div class="button mb-3">
        <div class="row">
            <div class="header">
                <b class=" font-bold">Application: {{ $scheme_name }}</b>
            </div>
            {{-- <div class="col-12">
                @if ($scheme_name == 'Testing' || $scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratoies')
                <button class="btn btn-outline-primary" id="Application">Application</button>
                @endif
                @if ($scheme_name == 'Medical Laboratories')
                <button class="btn btn-outline-primary" id="Medical">Medical</button>
                @endif
                @if ($scheme_name == 'Certification Bodies')
                <button class="btn btn-outline-primary" id="Certification">Certification</button>
                @endif
                @if ($scheme_name == 'Inspection Bodies')
                <button class="btn btn-outline-primary" id="Inspection">Incpection Body</button>
                @endif
                @if ($scheme_name == 'Halal Certification Bodies')
                <button class="btn btn-outline-primary" id="Halal">Halal</button>
                @endif
                @if ($scheme_name == 'Proficiency Testing Provider')
                <button class="btn btn-outline-primary" id="ProficiencyTesting">Proficiency Testing</button>
                @endif
                @if ($scheme_name == 'Product Certification Bodies')
                <button class="btn btn-outline-primary" id="ProductCertification">Product Certification</button>
                @endif
                @if ($scheme_name == 'Personnel Certification Bodies')
                <button class="btn btn-outline-primary" id="PersonnelCertification">Personnel Certification</button>
                @endif
            </div> --}}

        </div>
    </div>

    <div class="ApplicationParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav text-white">
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="GeneralInfo-form" id="GeneralInfo">General Info</button>
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="AboutYourselves-form" id="AboutYourselves">Part 1 - About yourselves</button>
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="AboutYourStaff-form" id="AboutYourStaff">Part 2 - About your staff</button>
                @if($scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratoies')
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="ScopeApplicationCalibration-form" id="ScopeApplicationCalibration">Part 3 - Scope of application: Calibration</button>
                @endif
                @if($scheme_name == 'Testing' || $scheme_name == 'Testing Calibration Laboratoies')
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="ScopeApplication-form" id="ScopeApplication">Part 4 - Scope of application: Testing</button>
                @endif
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="CalibrationFacility-form" id="CalibrationFacility">Part 5 - Calibration Facility (for labs performing in-house calibrations)</button>
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="OtherApprovals-form" id="OtherApprovals">Part 6 - Other approvals</button>
                <button class="btn btn-outline-success form-toggle-btn application-form-toggle-btn mt-2" data-target="Declaration-form" id="Declaration">Part 7 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>

    <div class="modal fade" id="DocumentModal" tabindex="-1" aria-labelledby="DocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="documentForm" action="{{ route('document-detail.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $scheme_name }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="schemeModalLabel">Doncuments</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Document Name</label>
                            <select name="document_id" class="form-control">
                                <option selected disabled>Select Document Name</option>
                                @foreach ($documents as $document)
                                <option value="{{ $document->id }}">{{ $document->document_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Upload Doc</label>
                            <input type="file" name="upload_doc" required class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="MedicalParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav text-white">
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="GeneralInfo-Medical-form" id="MedicalGeneralInfo">General Info</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="AboutYourselves-Medical-form" id="MedicalAboutYourselves">Part 1 - About
                    yourselves</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="AboutYourStaff-Medical-form" id="MedicalAboutYourStaff">Part 2 - About your
                    staff</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="ScopeApplication-Medical-form" id="MedicalScopeApplication">Part 3 - Scope of
                    application</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="AboutQuality-Medical-form" id="MedicalAboutQuality">Part 4 - About your quality
                    system</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="OtherApprovals-Medical-form" id="MedicalOtherApprovals">Part 5 - Other
                    approvals</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="Declaration-Medical-form" id="MedicalDeclaration">Part 6 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>

    <div class="CertificationParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="GeneralInfo-Certification-form" id="CertificationGeneralInfo">General Info</button>
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="AboutYourselves-Certification-form" id="CertificationAboutYourselves">Part 1 - About yourselves</button>
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="AboutYourStaff-Certification-form" id="CertificationAboutYourStaff">Part 2 - About your staff</button>
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="ScopeApplication-Certification-form" id="CertificationScopeApplication">Part 3 - Scope of application</button>
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="AboutQuality-Certification-form" id="CertificationAboutQuality">Part 4 - About your quality system</button>
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="OtherApprovals-Certification-form" id="CertificationOtherApprovals">Part 5 - Other approvals</button>
                <button class="btn btn-outline-success certification-form-toggle-btn mt-2" data-target="Declaration-Certification-form" id="CertificationDeclaration">Part 6 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>

    <div class="InspectionParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success inspection-form-toggle-btn mt-2" data-target="GeneralInfo-Inspection-form" id="InspectionGeneralInfo">General Info</button>
                <button class="btn btn-outline-success inspection-form-toggle-btn mt-2" data-target="AboutOrganization-Inspection-form" id="InspectionAboutOrganization">Part 1 - About
                    Organization/Inspection body</button>
                <button class="btn btn-outline-success inspection-form-toggle-btn mt-2" data-target="AboutYourStaff-Inspection-form" id="InspectionAboutYourStaff">Part 2 - About your
                    staff</button>
                <button class="btn btn-outline-success inspection-form-toggle-btn mt-2" data-target="ScopeApplication-Inspection-form" id="InspectionScopeApplication">Part 3 - Scope of
                    application</button>
                <button class="btn btn-outline-success inspection-form-toggle-btn mt-2" data-target="Declaration-Inspection-form" id="InspectionDeclaration">Part 4 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>

    {{-- Halal --}}
    <div class="HalalParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="GeneralInfo-Halal-form" id="HalalGeneralInfo">General Info</button>
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="AboutYourselves-Halal-form" id="HalalAboutOrganization">Part 1 - About
                    yourselves</button>
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="AboutYourStaff-Halal-form" id="HalalAboutYourStaff">Part 2 - About your
                    staff</button>
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="ScopeApplication-Halal-form" id="HalalScopeApplication">Part 3 - Scope of
                    application</button>
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="AboutQuality-Halal-form" id="HalalAboutQuality">Part 4 - About your quality
                    system</button>
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="OtherApprovals-Halal-form" id="HalalOtherApprovals">Part 4 - Other approvals</button>
                <button class="btn btn-outline-success halal-form-toggle-btn mt-2" data-target="Declaration-Halal-form" id="HalalDeclaration">Part 4 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>

    {{-- Proficiency Testing --}}
    <div class="ProficiencyTestingParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success proficiency-testing-form-toggle-btn mt-2" data-target="GeneralInfo-ProficiencyTesting-form" id="ProficiencyTestingGeneralInfo">General
                    Info</button>
                <button class="btn btn-outline-success proficiency-testing-form-toggle-btn mt-2" data-target="AboutYourselves-ProficiencyTesting-form" id="ProficiencyTestingAboutYourselves">Part
                    1
                    - About yourselves</button>
                <button class="btn btn-outline-success proficiency-testing-form-toggle-btn mt-2" data-target="AboutYourStaff-ProficiencyTesting-form" id="ProficiencyTestingAboutYourStaff">Part 2
                    -
                    About your staff</button>
                <button class="btn btn-outline-success proficiency-testing-form-toggle-btn mt-2" data-target="ScopeApplication-ProficiencyTesting-form" id="ProficiencyTestingScopeApplication">Part
                    3 - Scope of application</button>
                <button class="btn btn-outline-success proficiency-testing-form-toggle-btn mt-2" data-target="OtherApprovals-ProficiencyTesting-form" id="ProficiencyTestingOtherApprovals">Part 4
                    -
                    Other approvals</button>
                <button class="btn btn-outline-success proficiency-testing-form-toggle-btn mt-2" data-target="Declaration-ProficiencyTesting-form" id="ProficiencyTestingDeclaration">Part 5 -
                    Declaration</button>
                    <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>


    {{-- Product Certification --}}
    <div class="ProductCertificationParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="GeneralInfo-ProductCertification-form" id="ProductCertificationGeneralInfo">General Info</button>
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="AboutYourselves-ProductCertification-form" id="ProductCertificationAboutYourselves">Part 1 - About yourselves</button>
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="AboutYourStaff-ProductCertification-form" id="ProductCertificationAboutYourStaff">Part 2 - About your staff</button>
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="ScopeApplication-ProductCertification-form" id="ProductCertificationScopeApplication">Part 3 - Scope of application</button>
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="AboutQuality-ProductCertification-form" id="ProductCertificationAboutQuality">Part 4 - About your quality system</button>
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="OtherApprovals-ProductCertification-form" id="ProductCertificationOtherApprovals">Part 5 - Other approvals</button>
                <button class="btn btn-outline-success product-certification-form-toggle-btn mt-2" data-target="Declaration-ProductCertification-form" id="ProductCertificationDeclaration">Part 6 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>


    {{-- Personnel Certification --}}
    <div class="PersonnelCertificationParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="GeneralInfo-PersonnelCertification-form" id="PersonnelCertificationGeneralInfo">General Info</button>
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="AboutYourselves-PersonnelCertification-form" id="PersonnelCertificationAboutYourselves">Part 1 - About yourselves</button>
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="AboutYourStaff-PersonnelCertification-form" id="PersonnelCertificationAboutYourStaff">Part 2 - About your staff</button>
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="ScopeApplication-PersonnelCertification-form" id="PersonnelCertificationScopeApplication">Part 3 - Scope of application</button>
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="AboutQuality-PersonnelCertification-form" id="PersonnelCertificationAboutQuality">Part 4 - About your quality system</button>
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="OtherApprovals-PersonnelCertification-form" id="PersonnelCertificationOtherApprovals">Part 5 - Other approvals</button>
                <button class="btn btn-outline-success personnel-certification-form-toggle-btn mt-2" data-target="Declaration-PersonnelCertification-form" id="PersonnelCertificationDeclaration">Part 6 - Declaration</button>
                <button class="btn btn-outline-success mt-2" data-bs-toggle="modal" data-bs-target="#DocumentModal" data-target="Document-form" id="Document">Upload Documents</button>
            </div>

        </div>
    </div>



    @if ($scheme_name == 'Testing' || $scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratoies')
    <div class="ApplicationParts">
        @include('admin.application.include.application')
    </div>
    @endif

    @if ($scheme_name == 'Medical Laboratories')
    <div class="MedicalParts">
        @include('admin.application.include.medical')
    </div>
    @endif

    @if ($scheme_name == 'Certification Bodies')
    <div class="CertificationParts">
        @include('admin.application.include.certification')
    </div>
    @endif

    @if ($scheme_name == 'Inspection Bodies')
    <div class="InspectionParts">
        @include('admin.application.include.inspection')
    </div>
    @endif

    @if ($scheme_name == 'Halal Certification Bodies')
    <div class="HalalParts">
        @include('admin.application.include.halal')
    </div>
    @endif

    @if ($scheme_name == 'Proficiency Testing Provider')
    <div class="ProficiencyTestingParts">
        @include('admin.application.include.proficiency_testing')
    </div>
    @endif

    @if ($scheme_name == 'Product Certification Bodies')
    <div class="ProductCertificationParts">
        @include('admin.application.include.product_certification')
    </div>
    @endif

    @if ($scheme_name == 'Personnel Certification Bodies')
    <div class="PersonnelCertificationParts">
        @include('admin.application.include.personnel_certification')
    </div>
    @endif

    {{-- @include('admin.application.include.application')
    @include('admin.application.include.medical')
    @include('admin.application.include.certification')
    @include('admin.application.include.inspection')
    @include('admin.application.include.halal')
    @include('admin.application.include.proficiency_testing')
    @include('admin.application.include.product_certification')
    @include('admin.application.include.personnel_certification') --}}



</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    // $(".ApplicationParts").show();
    // $(".MedicalParts").hide();
    // $(".CertificationParts").hide();
    // $(".InspectionParts").hide();
    // $(".HalalParts").hide();
    // $(".ProficiencyTestingParts").hide();
    // $(".PersonnelCertificationParts").hide();
    // $(".ProductCertificationParts").hide();

    // Application For Lab
    // $("#GeneralInfo-form").hide();
    // $("#AboutYourselves-form").hide();
    // $("#AboutYourStaff-form").hide();
    // $("#ScopeApplication-form").hide();
    // $("#CalibrationFacility-form").hide();
    // $("#OtherApprovals-form").hide();
    // $("#Declaration-form").hide();


    // $("#Application").click(function() {
    //     // alert('ok')
    //     $(".MedicalParts").hide();
    //     $(".CertificationParts").hide();
    //     $(".InspectionParts").hide();
    //     $(".HalalParts").hide();
    //     $(".ProficiencyTestingParts").hide();
    //     $(".PersonnelCertificationParts").hide();
    //     $(".ProductCertificationParts").hide();
    //     $(".ApplicationParts").toggle();
    // });
    // function Application() {
    //     var element = document.getElementByClass("ApplicationParts");
    //     element.IdList.toggle("Application");
    // }
    // function Medical() {
    //     // alert('ok')
    //     var element = document.getElementByClass("MedicalParts");
    //     element.IdList.toggle("Medical");
    // }





    // perpact code
    // $(document).ready(function() {

    //     // Start validation
    //     let sections = $('.section-form');
    //     const buttons = $('.form-toggle-btn');
    //     let currentIndex = 0;

    //     function validateCurrentSection() {
    //         alert('ok')
    //         let currentForm = sections.eq(currentIndex).find(':input');
    //         let isValid = true;

    //         currentForm.each(function() {
    //             if (!this.checkValidity()) {
    //                 isValid = false;
    //                 this.reportValidity();
    //                 return false;
    //             }
    //         });

    //         if (!isValid) {
    //             $('#form-error').removeClass('d-none');
    //             return false;
    //         }

    //         $('#form-error').addClass('d-none');
    //         return true;
    //     }
    //     // End Validation



    //     // Hide all sections initially
    //     $('.section-form').hide();
    //     $('#GeneralInfo-form').show();
    //     $(".ApplicationParts, .MedicalParts, .CertificationParts, .InspectionParts, .HalalParts, .ProficiencyTestingParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();

    //     // Main Button Click (Application, Medical, etc.)
    //     $("#Application").click(function() {
    //         $(".MedicalParts, .CertificationParts, .InspectionParts, .HalalParts, .ProficiencyTestingParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();
    //         $(".ApplicationParts").toggle();
    //     });

    //     $("#Medical").click(function() {
    //         $(".ApplicationParts, .CertificationParts, .InspectionParts, .HalalParts, .ProficiencyTestingParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();
    //         $(".MedicalParts").toggle();
    //     });
    //     $("#Certification").click(function() {
    //         $(".ApplicationParts, .MedicalParts, .InspectionParts, .HalalParts, .ProficiencyTestingParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();
    //         $(".CertificationParts").toggle();
    //     });
    //     $("#Inspection").click(function() {
    //         $(".ApplicationParts, .CertificationParts, .MedicalParts, .HalalParts, .ProficiencyTestingParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();
    //         $(".InspectionParts").toggle();
    //     });
    //     $("#Halal").click(function() {
    //         $(".ApplicationParts, .CertificationParts, .MedicalParts, .InspectionParts, .ProficiencyTestingParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();
    //         $(".HalalParts").toggle();
    //     });
    //     $("#ProficiencyTesting").click(function() {
    //         $(".ApplicationParts, .CertificationParts, .MedicalParts, .InspectionParts, .HalalParts, .PersonnelCertificationParts, .ProductCertificationParts").hide();
    //         $(".ProficiencyTestingParts").toggle();
    //     });
    //     $("#ProductCertification").click(function() {
    //         $(".ApplicationParts, .CertificationParts, .MedicalParts, .InspectionParts, .HalalParts, .PersonnelCertificationParts, .ProficiencyTestingParts").hide();
    //         $(".ProductCertificationParts").toggle();
    //     });
    //     $("#PersonnelCertification").click(function() {
    //         $(".ApplicationParts, .CertificationParts, .MedicalParts, .InspectionParts, .HalalParts, .ProductCertificationParts, .ProficiencyTestingParts").hide();
    //         $(".PersonnelCertificationParts").toggle();
    //     });

    //     // Repeat similarly for other main buttons...

    //     // ✅ Application Inner Parts toggle
    //     $(".application-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });

    //     // medical
    //     $(".medical-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });

    //     // certification
    //     $(".certification-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });
    //     // inspection
    //     $(".inspection-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });
    //     // Halal
    //     $(".halal-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });
    //     // ProficiencyTesting
    //     $(".proficiency-testing-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });
    //     // ProductCertification
    //     $(".product-certification-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });
    //     // ProductCertification
    //     $(".personnel-certification-form-toggle-btn").click(function() {
    //         let targetForm = $(this).data("target");
    //         console.log(targetForm);

    //         // Hide all form sections first
    //         $(".application-section-form").hide();
    //         $(".medical-section-form").hide();
    //         $(".certification-section-form").hide();
    //         $(".inspection-section-form").hide();
    //         $(".halal-section-form").hide();
    //         $(".proficiency-testing-section-form").hide();
    //         $(".product-certification-section-form").hide();
    //         $(".personnel-certification-section-form").hide();
    //         // Then show the targeted one
    //         $("#" + targetForm).show();
    //     });


    //     // Initialize both Application and Medical forms
    //     initializeFormSections('application');
    //     // initializeFormSections('medical');
    // });




    // new validation code step form
    $(document).ready(function() {

        // const allParts = [
        //     ".ApplicationParts",
        //     ".MedicalParts",
        //     ".CertificationParts",
        //     ".InspectionParts",
        //     ".HalalParts",
        //     ".ProficiencyTestingParts",
        //     ".ProductCertificationParts",
        //     ".PersonnelCertificationParts"
        // ];

        const schemeName = @json($scheme_name);

        const schemeMap = {
            "Testing": ".ApplicationParts",
            "Calibration": ".ApplicationParts",
            "Testing Calibration Laboratoies": ".ApplicationParts",
            "Medical Laboratories": ".MedicalParts",
            "Certification Bodies": ".CertificationParts",
            "Inspection Bodies": ".InspectionParts",
            "Halal Certification Bodies": ".HalalParts",
            "Proficiency Testing Provider": ".ProficiencyTestingParts",
            "Product Certification Bodies": ".ProductCertificationParts",
            "Personnel Certification Bodies": ".PersonnelCertificationParts",
        };

        Object.values(schemeMap).forEach(selector => $(selector).hide());
        // alert(schemeMap)

        // Show only the matching part from schemeName
        if (schemeMap[schemeName]) {
            $(schemeMap[schemeName]).show();
        }

        // Hide all parts
        // allParts.forEach(part => $(part).hide());

        // Show only Application section
        // $(".ApplicationParts").show();

        // Sections and Navigation
        let sections = $('.section-form');
        const buttons = $('.form-toggle-btn');
        let currentIndex = 0;

        // Hide all and show first section
        sections.hide();
        sections.eq(0).show();
        $('.prev-btn').hide(); // Hide prev initially
        $('.submit-btn-wrapper').addClass('d-none');

        // Step validation function
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

            $('#form-error').toggleClass('d-none', isValid);
            return isValid;
        }

        // Show the current step
        function showSection(index) {
            sections.hide().eq(index).show();
            currentIndex = index;

            // Button appearance
            buttons.each(function(i) {
                $(this).removeClass('btn-success btn-primary').addClass('btn-outline-primary');
                if (i < index) $(this).removeClass('btn-outline-primary').addClass('btn-success');
                if (i === index) $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            });

            // Footer controls
            $('.prev-btn').toggle(index > 0);
            $('.next-btn').toggle(index < sections.length - 1);
            $('.submit-btn-wrapper').toggleClass('d-none', index < sections.length - 1);
        }

        // Form toggle button click
        $('.form-toggle-btn').on('click', function(e) {
            e.preventDefault();
            const targetId = $(this).data('target');
            const index = sections.index($('#' + targetId));
            if (index <= currentIndex || validateCurrentSection()) showSection(index);
        });

        // Next button click
        $('.next-btn').on('click', function() {
            $(window).scrollTop(0);
            if (validateCurrentSection() && currentIndex < sections.length - 1) {
                showSection(currentIndex + 1);
            }
        });

        // Previous button click
        $('.prev-btn').on('click', function() {
            if (currentIndex > 0) showSection(currentIndex - 1);
        });

        // --- Main Section Toggles (Application, Medical, etc.) ---
        const sectionsMap = {
            Application: ".ApplicationParts",
            Medical: ".MedicalParts",
            Certification: ".CertificationParts",
            Inspection: ".InspectionParts",
            Halal: ".HalalParts",
            ProficiencyTesting: ".ProficiencyTestingParts",
            ProductCertification: ".ProductCertificationParts",
            PersonnelCertification: ".PersonnelCertificationParts"
        };

        $.each(sectionsMap, function(key, selector) {
            $("#" + key).click(function() {
                $.each(sectionsMap, function(_, part) {
                    $(part).hide();
                });
                $(selector).toggle();
            });
        });

        // --- Inner Form Toggles ---
        const formClasses = [
            "application", "medical", "certification", "inspection", "halal", "proficiency-testing"
            , "product-certification", "personnel-certification"
        ];

        formClasses.forEach(cls => {
            $(`.${cls}-form-toggle-btn`).click(function() {
                const targetForm = $(this).data("target");
                formClasses.forEach(c => $(`.${c}-section-form`).hide());
                $("#" + targetForm).show();
            });
        });

    });




// Store Document Detail

$(document).ready(function() {
    $('#documentForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Document saved successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#DocumentModal').modal('hide');
                        // You can refresh part of page or table if needed
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong while saving.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.log(xhr.responseText);
            }
        });
    });
});



// preview button
$('#view-summary-btn').on('click', function() {
    let summaryHtml = '';

    $('.section-form:visible').parent().find('.section-form').each(function() {
        const sectionTitle = $(this).find('.card-header h4').text();
        summaryHtml += `<div class="card mb-3"><div class="card-header"><h5>${sectionTitle}</h5></div><div class="card-body">`;

        $(this).find('input, select, textarea').each(function() {
            const label = $(this).closest('.form-group').find('label').text() || $(this).parent('label').text();

            const type = $(this).attr('type');
            let value = '';

            if (type === 'checkbox' || type === 'radio') {
                if ($(this).is(':checked')) {
                    value = 'Yes';
                } else {
                    value = 'No';
                }
            } else if (type === 'file') {
                value = $(this).val().split('\\').pop() || 'No file selected';
            } else {
                value = $(this).val() || '---';
            }

            if (label) {
                summaryHtml += `<p><strong>${label}:</strong> ${value}</p>`;
            }
        });

        summaryHtml += '</div></div>';
    });

    $('#form-summary-content').html(summaryHtml);
    $('#formSummaryModal').modal('show');
});



</script>
@endsection
