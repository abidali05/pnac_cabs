@extends('admin.layouts.adminlayout')
@section('main-content')
@section('style')
<style>
    .btn-success {
        background-color: #187a4c;
        color: white;
    }

    .btn-success:hover {
        background-color: #187a4c !important;
        color: white;
    }

    .btn-success:active {
        background-color: #187a4c !important;
        color: white;
    }

    .bg-success {
        background-color: #187a4c !important;
        color: white;
    }

    .card {
        display: none;
    }

    .iso-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 1rem;
        overflow: hidden;
    }

    .iso-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }

    .iso-card img {
        transition: transform 0.3s ease;
    }

    .iso-card:hover img {
        transform: scale(1.1);
    }

    .iso-card .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .iso-card .btn:hover {
        background-color: #ff9800;
        color: white;
    }

</style>
@endsection
<!-- Start app main Content -->
<div class="main-content">
    <section class="section">
        <div class="row">

            <div class="mb-3 bg-success rounded-1 p-2">
                <button class="btn btn-success p-2 section-btn" id="General">Part 1 (General Info)</button>
                <button class="btn btn-success p-2 section-btn" id="Employee">Part 2 (Employees)</button>
                <button class="btn btn-success p-2 section-btn" id="Document">Part 3 (Documents)</button>
                <button class="btn btn-success p-2 section-btn" id="Scope">Part 4 (Scope)</button>
                <button class="btn btn-success p-2 section-btn" id="Declaration">Part 5 (Declaration)</button>
            </div>



            <div class="col-12">

                <div class="card" id="GeneralTable">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">General</h4>
                        {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#schemeModal">New General</button> --}}
                    </div>
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Accreditation Scheme</label>
                                <input type="text" name="scheme" value="{{ urldecode(request()->query('scheme_name')) }}" readonly class="form-control">
                                <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                                <input type="hidden" name="type" value="general">
                                <input type="hidden" name="general_id" value="{{ $general->id ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>CAB Name</label>
                                <input type="text" name="cab_name" value="{{ $general->cab_name ?? '' }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" value="{{ $general->address ?? '' }}" required class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Telephone</label>
                                    <input type="text" name="telephone" value="{{ $general->telephone ?? '' }}" required class="form-control">
                                </div>
                                <div class="form-group col-4">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $general->email ?? '' }}" required class="form-control">
                                </div>
                                <div class="form-group col-4">
                                    <label>NTN/FTN</label>
                                    <input type="text" name="ntn_ftn" value="{{ $general->ntn_ftn ?? '' }}" required class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" name="website" value="{{ $general->website ?? '' }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" name="city" value="{{ $general->city ?? '' }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Country:</label>
                                <input type="text" name="country" value="{{ $general->country ?? '' }}" required class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Postal Code</label>
                                    <input type="text" name="postal_code" value="{{ $general->postal_code ?? '' }}" required class="form-control">
                                </div>
                            </div>
                            <div class="footer">
                                {{-- <button class="btn btn-success" type="submit">Submit</button> --}}
                                {{-- <button class="btn btn-secondary prev-btn" type="button">Previous</button> --}}
                                <button class="btn btn-primary next-btn" type="submit">Next</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Employees --}}
                <div class="card" id="EmployeeTable">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Employees</h4>
                        <button class="btn btn-success" onclick="openEmployeeModal()">New Employees</button>

                        {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#employeeModal">New Employees</button> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Employees Name</th>
                                        <th>Designation</th>
                                        <th>Address</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $key => $employee)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $employee->employee_name }}</td>
                                        <td>{{ $employee->designation }}</td>
                                        <td>{{ $employee->address }}</td>
                                        <td>{{ $employee->telephone }}</td>
                                        <td>{{ $employee->email }}</td>
                                        @php
                                        $isSubmitted = optional($employee->general->declaration)->status === 'submited';
                                        @endphp

                                        <td>
                                            @if (!$isSubmitted)
                                            <button class="btn btn-sm btn-primary" onclick='openEmployeeModal(@json($employee))'>Edit</button>
                                            {{-- <button class="btn btn-sm btn-primary" onclick='openEmployeeModal(@json($employee))'>Edit</button> --}}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex mt-3">
                            <button class="btn btn-secondary prev-btn m-1" type="button">Previous</button>
                            <button class="btn btn-primary next-btn m-1" type="button">Next</button>
                        </div>
                    </div>
                </div>

                {{-- Documents --}}
                <div class="card" id="DocumentTable">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Documents</h4>
                        <button class="btn btn-success" onclick="openDocumentModal()">New Documents</button>
                        {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#documentModal">New Documents</button> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="documentsTable" class="table table-striped v_center">
                                <thead>
                                    <tr>
                                        <th class="text-center">S#</th>
                                        <th>Name of Document</th>
                                        <th>File</th>
                                        <th>Date Upload</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($documentDetails as $key => $document)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $document->name }}</td>
                                        <td>
                                            <a href="{{ asset('storage/'.$document->upload_doc) }}" target="_blank">File</a>
                                        </td>
                                        <td>{{ $document->created_at }}</td>
                                        @php
                                        $isSubmitted = optional($employee->general->declaration)->status === 'submited';
                                        @endphp

                                        <td>
                                            @if (!$isSubmitted)
                                            <button class="btn btn-sm btn-primary" onclick='openDocumentModal(@json($document))'>Edit</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex mt-3">
                            <button class="btn btn-secondary prev-btn m-1" type="button">Previous</button>
                            <button class="btn btn-primary next-btn m-1" type="button">Next</button>
                        </div>
                    </div>
                </div>

                {{-- Scope --}}
                <div class="card" id="ScopeTable">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Scope</h4>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#scopeModal">New Scope</button>
                    </div>
                    <div class="card-body row mb-3">

                        <div class="col-lg-4 col-md-4">
                            <div class="bg-white border text-center iso-card shadow-sm mt-4" style="width: 20rem;">
                                <div class="card-body p-3">
                                    <h5 class="card-title font-weight-bold">ISO 9001:2025</h5>
                                    <h6 class="card-subtitle mb-3 text-muted">Quality Management System</h6>
                                    <p class="card-text">
                                        <img src="{{ asset('images/iso.png') }}" width="100px" class="rounded-circle" alt="ISO 9001">
                                    </p>
                                    <a href="{{ route('application.view.scope', ['category' => 'Medical Laboratories', 'scope' => 'ISO9001']) }}" class="card-link btn btn-warning ">View ISO 9001:2025</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="bg-white border text-center iso-card shadow-sm mt-4" style="width: 20rem;">
                                <div class="card-body p-3">
                                    <h5 class="card-title font-weight-bold">ISO 14001:2025</h5>
                                    <h6 class="card-subtitle mb-3 text-muted">Environmental Management System</h6>
                                    <p class="card-text">
                                        <img src="{{ asset('images/iso.png') }}" width="100px" class="rounded-circle" alt="ISO 14001">
                                    </p>
                                    <a href="{{ route('application.view.scope', ['category' => 'Medical Laboratories', 'scope' => 'ISO14001']) }}" class="card-link btn btn-warning px-4">View ISO 14001</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="bg-white border text-center iso-card shadow-sm mt-4" style="width: 20rem;">
                                <div class="card-body p-3">
                                    <h5 class="card-title font-weight-bold">ISO 45001:2025</h5>
                                    <h6 class="card-subtitle mb-3 text-muted">Occupational Health & Safety</h6>
                                    <p class="card-text">
                                        <img src="{{ asset('images/iso.png') }}" width="100px" class="rounded-circle" alt="ISO 45001">
                                    </p>
                                    <a href="{{ route('application.view.scope', ['category' => 'Medical Laboratories', 'scope' => 'ISO45001']) }}" class="card-link btn btn-warning px-4">View ISO 45001</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="bg-white border text-center iso-card shadow-sm mt-4" style="width: 20rem;">
                                <div class="card-body p-3">
                                    <h5 class="card-title font-weight-bold">ISO 13485:2025</h5>
                                    <h6 class="card-subtitle mb-3 text-muted">Medical Devices QMS</h6>
                                    <p class="card-text">
                                        <img src="{{ asset('images/iso.png') }}" width="100px" class="rounded-circle" alt="ISO 13485">
                                    </p>
                                    <a href="{{ route('application.view.scope', ['category' => 'Medical Laboratories', 'scope' => 'ISO13485']) }}" class="card-link btn btn-warning px-4">View ISO 13485</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="bg-white border text-center iso-card shadow-sm mt-4" style="width: 20rem;">
                                <div class="card-body p-3">
                                    <h5 class="card-title font-weight-bold">ISO 22000:2025</h5>
                                    <h6 class="card-subtitle mb-3 text-muted">Food Safety Management System</h6>
                                    <p class="card-text">
                                        <img src="{{ asset('images/iso.png') }}" width="100px" class="rounded-circle" alt="ISO 22000">
                                    </p>
                                    <a href="{{ route('application.view.scope', ['category' => 'Medical Laboratories', 'scope' => 'ISO22000']) }}" class="card-link btn btn-warning px-4">View ISO 22000</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-5">
                            <button class="btn btn-secondary prev-btn m-1" type="button">Previous</button>
                            <button class="btn btn-primary next-btn m-1" type="button">Next</button>
                        </div>
                    </div>
                </div>

                {{-- Declaration --}}
                <div class="card" id="DeclarationTable">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Declarations</h4>
                    </div>
                    <form action="{{ route('application.store.certification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ urldecode(request()->query('scheme_name')) }}">
                        <input type="hidden" name="type" value="declaration">
                        <div class="card-body">
                            <div class="form-group">
                                <p>
                                    6.2. The CB/organisation agrees to conform, upon accreditation, with PNAC requirements as detailed in the Agreement [F-01/08].
                                </p>
                            </div>
                            <div class="form-group">
                                <p>
                                    6.3. I enclose a copy of Quality Manual and other documents/information (see Note below)
                                </p>
                            </div>
                            <div class="form-group">
                                <p>6.4. I enclose a cheque (payable to PNAC) for the Applicant fee of <input type="text" name="application_fee" value="{{ $declaration->application_fee ?? '' }}" style="outline: none;"> I understand that this fee is non-refundable. (see Note below).</p>
                            </div>
                            <div class="form-group">
                                <p>6.5. I understand the manner in which the accreditation system functions.
                                </p>
                            </div>
                            <div class="form-group">
                                <p>
                                    I declare that the information given in this form is correct to the best of my knowledge and belief
                                </p>
                            </div>
                            <div class="form-group">
                                <p>
                                    <b>Note:</b> PNAC will not process your application until it has received your Quality Manual, procedures, other documents/information and application fee.
                                </p>
                            </div>

                            <div class="footer mb-5 pb-3">
                                <button class="btn btn-secondary prev-btn" type="button">Previous</button>
                                <button type="submit" class="btn btn-success">Final Submition</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </section>
</div>

@include('admin.application.certification.modal')



@endsection
@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
@include('admin.application.certification.modal_script');
<script>
    $(document).ready( function () {
        $('#documentsTable').DataTable();

    } );
    // $(document).ready(function() {
    //     // Hide all form sections initially
    //     $(".card").hide();
    //     $("#GeneralTable").show();

    //     // Show corresponding section when button is clicked
    //     $("#General").click(function() {
    //         $(".card").hide();
    //         $("#GeneralTable").show();
    //     });
    //     $("#Employees").click(function() {
    //         $(".card").hide();
    //         $("#EmployeesTable").show();
    //     });
    //     $("#Document").click(function() {
    //         $(".card").hide();
    //         $("#DocumentTable").show();
    //     });
    //     $("#Scope").click(function() {
    //         $(".card").hide();
    //         $("#ScopeTable").show();
    //     });
    //     $("#Declaration").click(function() {
    //         $(".card").hide();
    //         $("#DeclarationTable").show();
    //     });
    // });

    // show and hide card
    // $(document).ready(function() {
    //     // Hide all sections initially
    //     $(".card").hide();

    //     // Get last selected section from localStorage
    //     let lastSection = localStorage.getItem("lastSection") || "General";
    //     $("#" + lastSection + "Table").show();

    //     // Button click handler
    //     $(".section-btn").click(function() {
    //         let sectionId = $(this).attr("id");

    //         // Save to localStorage
    //         localStorage.setItem("lastSection", sectionId);

    //         // Show related table
    //         $(".card").hide();
    //         $("#" + sectionId + "Table").show();
    //     });
    // });

    $(document).ready(function() {
        const sections = ["General", "Employee", "Document", "Scope", "Declaration"]; // Add all your section names in order
        let currentIndex = 0;

        // Hide all cards initially
        $(".card").hide();

        // Show last opened or first card
        const lastSection = localStorage.getItem("lastSection");
        if (lastSection && sections.includes(lastSection)) {
            currentIndex = sections.indexOf(lastSection);
        }
        $("#" + sections[currentIndex] + "Table").show();

        // Save current section to localStorage
        function showSection(index) {
            $(".card").hide();
            $("#" + sections[index] + "Table").show();
            localStorage.setItem("lastSection", sections[index]);
        }

        // Section button clicks (your existing code)
        $(".section-btn").click(function() {
            const sectionId = $(this).attr("id");
            // alert(sectionId);
            if (sections.includes(sectionId)) {
                currentIndex = sections.indexOf(sectionId);
                showSection(currentIndex);
            }
        });

        // Handle Next/Previous
        $(".next-btn").click(function() {
            if (currentIndex < sections.length - 1) {
                currentIndex++;
                showSection(currentIndex);
            }
        });

        $(".prev-btn").click(function() {
            if (currentIndex > 0) {
                currentIndex--;
                showSection(currentIndex);
            }
        });
    });




    // Store Document Detail

    // $(document).ready(function() {
    //     $('#documentForm').on('submit', function(e) {
    //         e.preventDefault();

    //         var formData = new FormData(this);

    //         $.ajax({
    //             url: $(this).attr('action')
    //             , type: 'POST'
    //             , data: formData
    //             , cache: false
    //             , contentType: false
    //             , processData: false
    //             , success: function(response) {
    //                 Swal.fire({
    //                     title: 'Success!'
    //                     , text: 'Document saved successfully.'
    //                     , icon: 'success'
    //                     , confirmButtonText: 'OK'
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         $('#DocumentModal').modal('hide');
    //                         // You can refresh part of page or table if needed
    //                     }
    //                 });
    //             }
    //             , error: function(xhr) {
    //                 Swal.fire({
    //                     title: 'Error!'
    //                     , text: 'Something went wrong while saving.'
    //                     , icon: 'error'
    //                     , confirmButtonText: 'OK'
    //                 });
    //                 console.log(xhr.responseText);
    //             }
    //         });
    //     });
    // });



    // Scope Modal
    $(document).ready(function() {
        $(".scope-btn").click(function() {
            // Remove active class from all buttons
            $(".scope-btn").removeClass("active");

            // Add active class to clicked button
            $(this).addClass("active");

            // Hide all sections with fadeOut
            $(".scope-section").fadeOut(200);

            // Show target section with fadeIn
            let target = $(this).data("target");
            setTimeout(() => {
                $(target).fadeIn(300);
            }, 200);
        });
    });

</script>

@endsection
