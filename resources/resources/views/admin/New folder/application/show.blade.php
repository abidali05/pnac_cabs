@extends('admin.layouts.adminlayout')
@section('main-content')

<div class="main-content">

    {{-- <div id="form-error" class="alert alert-danger d-none">
        Please fill all required fields.
    </div> --}}

    <div class="button mb-3">
        <div class="row">
            <div class="header">
                <b class=" font-bold">Application: {{ $scheme_name }}</b>
            </div>
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
            </div>

        </div>
    </div>

    <div class="MedicalParts">
        <div class="row">
            <div class="col-12 mb-3 form-step-nav">
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="GeneralInfo-Medical-form" id="MedicalGeneralInfo">General Info</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="AboutYourselves-Medical-form" id="MedicalAboutYourselves">Part 1 - About yourselves</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="AboutYourStaff-Medical-form" id="MedicalAboutYourStaff">Part 2 - About your staff</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="ScopeApplication-Medical-form" id="MedicalScopeApplication">Part 3 - Scope of application</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="AboutQuality-Medical-form" id="MedicalAboutQuality">Part 4 - About your quality system</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="OtherApprovals-Medical-form" id="MedicalOtherApprovals">Part 5 - Other approvals</button>
                <button class="btn btn-outline-success form-toggle-btn medical-form-toggle-btn mt-2" data-target="Declaration-Medical-form" id="MedicalDeclaration">Part 6 - Declaration</button>
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
            </div>

        </div>
    </div>



    @if ($scheme_name == 'Testing' || $scheme_name == 'Calibration' || $scheme_name == 'Testing Calibration Laboratoies')
    <div class="ApplicationParts">
        @include('admin.application.include.show.application')
    </div>
    @endif

    @if ($scheme_name == 'Medical Laboratories')
    <div class="MedicalParts">
        @include('admin.application.include.show.medical')
    </div>
    @endif

    @if ($scheme_name == 'Certification Bodies')
    <div class="CertificationParts">
        @include('admin.application.include.show.certification')
    </div>
    @endif

    @if ($scheme_name == 'Inspection Bodies')
    <div class="InspectionParts">
        @include('admin.application.include.show.inspection')
    </div>
    @endif

    @if ($scheme_name == 'Halal Certification Bodies')
    <div class="HalalParts">
        @include('admin.application.include.show.halal')
    </div>
    @endif

    @if ($scheme_name == 'Proficiency Testing Provider')
    <div class="ProficiencyTestingParts">
        @include('admin.application.include.show.proficiency_testing')
    </div>
    @endif

    @if ($scheme_name == 'Product Certification Bodies')
    <div class="ProductCertificationParts">
        @include('admin.application.include.show.product_certification')
    </div>
    @endif

    @if ($scheme_name == 'Personnel Certification Bodies')
    <div class="PersonnelCertificationParts">
        @include('admin.application.include.edit.personnel_certification')
    </div>
    @endif
</div>




@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>

    // new validation code
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

</script>
@endsection

