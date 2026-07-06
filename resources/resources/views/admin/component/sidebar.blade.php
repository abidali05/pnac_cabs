<div class="main-sidebar sidebar-style-3">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            {{-- <a href="{{ route('dashboard') }}">Pnac</a> --}}
            <img alt="image" src="{{ asset('images/pnac.png') }}" class="rounded-circle mr-1 my-4" width="100">
            <ul class="sidebar-menu">
                <li class="menu-header"></li>
            </ul>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index-2.html">PA</a>
        </div>
        @php
            $schemes = App\Models\Scheme::all();
            // $user = Auth::user();

            // $mergedApplications = collect();

            // $models = [
            //     App\Models\ApplicationForLab::class,
            //     App\Models\CertificationBody::class,
            //     App\Models\MedicalLaboratory::class,
            //     App\Models\InspectionBody::class,
            //     App\Models\HalalCertificationBody::class,
            //     App\Models\ProductCertification::class,
            //     App\Models\ProficiencyTesting::class,
            //     App\Models\PersonnelCertification::class,
            // ];

            // foreach ($models as $model) {
            //     $mergedApplications = $mergedApplications->merge(
            //         $model::where('user_id', $user->id)->get()->map(function ($item) {
            //             return [
            //                 'id' => $item->id,
            //                 'category' => $item->category ?? '',
            //             ];
            //         })
            //     );
            // }
        @endphp
        <ul class="sidebar-menu mt-4">
            <li><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            {{-- <li class="menu-header">Dashboard</li> --}}

            {{-- <li class="menu-header"></li> --}}
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Accreditation</span></a>
                <ul class="dropdown-menu">
                    {{-- Dropdown --}}
                    {{-- <li><a class="nav-link" href="{{ route('index') }}">Scope & Certification</a></li> --}}
                    {{-- Under Dropdown --}}
                    {{-- <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Assessment</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="#">Documentation Review</a></li>
                            <li><a class="nav-link" href="#">Compliance</a></li>
                            <li><a class="nav-link" href="#">EP Meeting</a></li>

                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Application</span></a>
                        <ul class="dropdown-menu text-nowrap">
                            <li><a class="nav-link" href="{{ route('application.index') }}">New Application</a></li> --}}
                            {{-- <li><a class="nav-link" href="#">EOS/EOB/ Site Application</a></li>
                            <li><a class="nav-link" href="#">ILAC MRA/IAF MLA MARK Application</a></li> --}}

                        {{-- </ul>
                    </li> --}}
                    {{-- <li><a class="nav-link" href="{{ route('application.index') }}">Application</a></li> --}}
                    <li><a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#schemeModal">New Application</a></li>
                    <li><a href="{{ route('application.submited.index') }}" class="nav-link">Submited Application</a></li>
                    {{-- @foreach ($mergedApplications as $key => $application)
                    <li><a href="{{ route('application.show', [$application['id'], $application['category']]) }}">{{ $application['category'] }}</a></li>
                    @endforeach --}}
                    {{-- <li><a class="nav-link" href="{{ route('scheme.index') }}">New Scheme</a></li> --}}
                    {{-- <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Scheme</span></a>
                        <ul class="dropdown-menu text-nowrap">
                            <li><a class="nav-link" href="{{ route('scheme.index') }}">New Scheme</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Post Assessment</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="#">Withdrawal</a></li>
                            <li><a class="nav-link" href="#">Inoprative</a></li>
                            <li><a class="nav-link" href="#">Suspension</a></li>
                            <li><a class="nav-link" href="#">Apeal</a></li>
                            <li><a class="nav-link" href="#">Scope & Certificate</a></li>

                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown text-nowrap" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Scope & Certification</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="#">Change Application</a></li>

                        </ul>
                    </li> --}}
                </ul>
            </li>

            <li><a href="{{ route('assessment.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Assessments</span></a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-columns"></i> <span>Feedback</span></a></li>
            <li><a href="{{ route('client-satisfication.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Client Satisfication</span></a></li>
            <li><a href="{{ route('message.notification.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Message/Notification</span></a></li>

            <div class="modal fade" id="schemeModal" tabindex="-1" aria-labelledby="schemeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('application.create') }}" method="GET">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="schemeModalLabel">Scheme</h5>
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> --}}
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">X</button>
                            </div>
                            <div class="modal-body model">
                                <label for="">Scheme</label>
                                <select name="scheme_name" class="form-control" >
                                    <option selected disabled>Select Scheme</option>
                                    @foreach ($schemes as $scheme)
                                    <option value="{{ $scheme->scheme_name }}">{{ $scheme->scheme_name }}</option>
                                    @endforeach
                                </select>
                            {{-- </div> --}}
                            <div class="mt-3">
                                <label for="application">Application</label>
                                <select name="application" class="form-control" >
                                    <option value="" selected disabled>Select Application</option>
                                    <option value="New Application">New Application</option>
                                    <option value="Renewal Application">Renewal Application</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- New Dropdown --}}
            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Specific</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Personnel</span></a>
                        <ul class="dropdown-menu text-nowrap">
                            <li><a class="nav-link" href="#">Assessor Application</a></li>
                            <li><a class="nav-link" href="#">Assessor Competency Update</a></li>
                            <li><a class="nav-link" href="#">Assessor Upgrade</a></li>
                            <li><a class="nav-link" href="#">Assessor Evaluation</a></li>
                            <li><a class="nav-link" href="#">Appointment of Evaluation Panel(EP)/(AP)</a></li>
                            <li><a class="nav-link" href="#">EP Evaluation</a></li>
                            <li><a class="nav-link" href="#">AB Personnel Evaluation</a></li>
                            <li><a class="nav-link" href="#">Auditor/Members (NAC/MASDAM/TWG/STC)</a></li>
                            <li><a class="nav-link" href="#">Appointment of Evaluation of Internet</a></li>
                            <li><a class="nav-link" href="#">Conformity Assessment Bodies(CAB)</a></li>

                        </ul>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Terimaan</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Applicaton Fee</a><li>
                </ul>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Knowledge Managment</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Domain Control</a><li>
                </ul>
            </li> --}}
        </ul>

        {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getcodiepie.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split"><i class="fas fa-rocket"></i> Documentation</a>
        </div> --}}
    </aside>
</div>
{{-- i coded --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#schemeModal form");

    form.addEventListener("submit", function (e) {
        let valid = true;
        let scheme = form.querySelector("select[name='scheme_name']");
        let application = form.querySelector("select[name='application']");

        // reset previous error styles
        scheme.classList.remove("is-invalid");
        application.classList.remove("is-invalid");

        // validate scheme
        if (!scheme.value || scheme.value === "Select Scheme") {
            valid = false;
            scheme.classList.add("is-invalid");
        }

        // validate application
        if (!application.value) {
            valid = false;
            application.classList.add("is-invalid");
        }

        if (!valid) {
            e.preventDefault(); // stop form submission
        }
    });
});
</script>
{{-- i coded --}}