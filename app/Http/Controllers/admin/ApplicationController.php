<?php

namespace App\Http\Controllers\admin;

use App\Factories\ScopeFactory;
use App\Factories\ScopeFetcher;
use App\Http\Controllers\CertificationBodies\InspectionBodyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HalalCertification\HalalCertificationBodyController;
use App\Models\ApplicationForLab;
use App\Models\CalibrationScope;
use App\Models\Category22000;
use App\Models\CbApplication;
use App\Models\CertificationBody;
use App\Models\CertificationBodyApproval;
use App\Models\CertificationBodyStaff;
use App\Models\CertificationDeclaration;
use App\Models\CertificationEmployee;
use App\Models\CertificationGeneral;
use App\Models\CertificationIafMd9;
use App\Models\CertificationScope;
use App\Models\Cluster22000;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\FirstIafCode;
use App\Models\HalalCertificationBody;
use App\Models\HalalScope;
use App\Models\InspectionBody;
use App\Models\InspectionScope;
use App\Models\MainTechnical13485;
use App\Models\MedicalLaboratory;
use App\Models\MedicalScope;
use App\Models\MlabApplication;
use App\Models\PersonnelCertification;
use App\Models\PersonnelScope;
use App\Models\ProductScope;
use App\Models\ProductCertificationScope;
use App\Models\ProficiencyScope;
use App\Models\PtpScope;
use App\Models\ProficiencyTesting;
use App\Models\Scheme;
use App\Models\SubCategory22000;
use App\Models\TechnicalArea;
use App\Models\TechnicalCluster;
use App\Models\TestingScope;
use App\Services\CertificationBodiesApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function __construct(private readonly CertificationBodiesApplicationService $certificationBodiesService) {}
    // public function __construct()
    // {
    //     // $this->middleware('permission:view application')->only(['applicationIndex']);
    //     $this->middleware(['permission:view Application'])->only(['applicationIndex']);
    //     $this->middleware('permission:create Application')->only(['applicationCreate']);
    //     $this->middleware('permission:Edit Application')->only(['applicationEdit']);
    //     $this->middleware('permission:delete Application')->only(['applicationDestroy']);
    // }

    // public function applicationIndex()
    // {
    //     $schemes = Scheme::all();
    //     $applications = ApplicationForLab::all();
    //     $certifications = CertificationBody::all();
    //     $medicals = MedicalLaboratory::all();
    //     $inspections = InspectionBody::all();
    //     $halals = HalalCertificationBody::all();
    //     $products = ProductCertification::all();
    //     $proficiencies = ProficiencyTesting::all();
    //     $personnels = PersonnelCertification::all();

    //     return view('admin.application.index', compact('schemes', 'applications'));
    // }

    public function applicationIndex()
    {
        $schemes = Scheme::all();

        $user = Auth::user();

        $mergedApplications = collect();

        $models = [
            ApplicationForLab::class,
            CertificationBody::class,
            MedicalLaboratory::class,
            InspectionBody::class,
            HalalCertificationBody::class,
            ProductCertification::class,
            ProficiencyTesting::class,
            PersonnelCertification::class,
        ];

        foreach ($models as $model) {
            $mergedApplications = $mergedApplications->merge(
                $model::where('user_id', $user->id)->get()->map(function ($item) use ($model, $user) {
                    $general = null;
                    if ($model === ApplicationForLab::class) {
                        $general = CertificationGeneral::where('user_id', $user->id)
                            ->where('category', $item->category)
                            ->latest('id')
                            ->first();
                    }

                    return [
                        'id' => $item->id,
                        'contact_name' => $item->contact_name,
                        'person_email' => $general->email ?? $item->person_email ?? '',
                        'organisation' => $item->organisation ?? '',
                        'address' => $general->address ?? $item->address_laboratory ?? '',
                        'category' => $item->category ?? '',
                    ];
                })
            );
        }
        // $mergedApplications = collect();

        // $mergedApplications = $mergedApplications->merge(
        //     ApplicationForLab::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     CertificationBody::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     MedicalLaboratory::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     InspectionBody::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     HalalCertificationBody::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     ProductCertification::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     ProficiencyTesting::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        // $mergedApplications = $mergedApplications->merge(
        //     PersonnelCertification::all()->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'contact_name' => $item->contact_name,
        //             'person_email' => $item->person_email,
        //             'organisation' => $item->organisation ?? '',
        //             'address' => $item->address_laboratory ?? '',
        //             'category' => $item->category ?? '',
        //         ];
        //     })
        // );

        return view('admin.application.index', compact('mergedApplications', 'schemes'));
    }

    public function applicationCreate(Request $request)
    {
        $employees = [];
        $declaration = [];
        $documentDetails = [];
        $documents = Document::all();
        $technicalClusters = TechnicalCluster::all();
        $mainTechnical13485s = MainTechnical13485::all();

        $clusters22000 = Cluster22000::all();
        $categories = Category22000::all();
        $subCategories = SubCategory22000::all();
        $countries = DB::table('countries')->pluck('en_short_name');

        $scheme_name = $request->scheme_name;
        $form = \App\Models\ApplicationForm::where('application_name', $scheme_name)
            ->orWhere('slug', \Str::slug($scheme_name))
            ->first();
        $application = $request->application;
        $applicationId = session('application_id');
        $general = null;
        if ($scheme_name === 'Certification Bodies' && session('application_id')) {
            $general = CertificationGeneral::where('id', session('application_id'))
                ->where('user_id', auth()->id())
                ->first();
        }
        if (! $general) {
            $general = CertificationGeneral::where('user_id', auth()->user()->id)
                ->where('category', $scheme_name)
                ->where('application', $request->application)
                ->latest('id')
                ->first();
        }

        // Keep Certification Bodies UX aligned with testing flow:
        // initialize a draft general record so all sections are immediately available.
        if ($scheme_name === 'Certification Bodies' && ! $general) {
            $general = CertificationGeneral::create([
                'user_id' => auth()->id(),
                'category' => 'Certification Bodies',
                'application' => $request->application,
                'scheme' => 'Certification Bodies',
                'cab_name' => '',
                'address' => '',
                'telephone' => '',
                'email' => 'draft+'.auth()->id().'@example.com',
                'ntn_ftn' => '',
                'website' => '',
                'city' => '',
                'country' => '',
                'postal_code' => '',
                'reference_no' => 'CAB-'.now()->format('Ymd').rand(1000, 9999),
            ]);
            session(['application_id' => $general->id]);
        } elseif ($scheme_name === 'Certification Bodies' && $general) {
            session(['application_id' => $general->id]);
        }
        $cbApplication = $general?->certificationBodyApplication;
        $cbStaff = $general ? CertificationBodyStaff::where('certification_general_id', $general->id)->orderBy('sort_order')->get()->groupBy('staff_type') : collect();
        $cbApprovals = $general ? CertificationBodyApproval::where('certification_general_id', $general->id)->get() : collect();
        $cbScopes = $general ? CertificationScope::where('certification_general_id', $general->id)->where('category', 'Certification Bodies')->get()->groupBy('scope_type') : collect();
        $cbSavedSections = [
            'basic_info' => ! empty($general?->cab_name) || ! empty($general?->email),
            'about_yourselves' => ! empty($cbApplication?->director_name) || ! empty($cbApplication?->director_position),
            'staff' => $cbStaff->flatten()->isNotEmpty(),
            'scope' => $cbScopes->flatten()->isNotEmpty(),
            'quality_system' => ! empty($cbApplication?->quality_system_complies) || ! empty($cbApplication?->non_compliance_area),
            'approvals' => $cbApprovals->isNotEmpty(),
            'declaration' => ! empty($cbApplication?->signed) || ! empty($cbApplication?->signed_date),
        ];
        $isSubmitted = optional(@$general->declaration)->status === 'submited';
        $applicationId = session('application_id');

        if ($applicationId) {
            $documentDetails = DocumentDetail::where('user_id', auth()->user()->id)->where('certification_general_id', $applicationId)->where('category', $scheme_name)->get();
            $employees = CertificationEmployee::where('category', $scheme_name)->where('certification_general_id', $applicationId)->get();
            $declaration = CertificationDeclaration::where('certification_general_id', $applicationId)->where('category', $scheme_name)->first();
        }

        $scopes = ScopeFactory::getScopes($scheme_name, $applicationId)->where('user_id', Auth::id())->where('certification_general_id', $applicationId);

        $referenceNumber = 'CAB-'.now()->format('Ymd').rand(1000, 9999); // Example: CAB-20250806-4572

        $cbApplication = null;
        $cbData = [];
        if ($scheme_name === 'Certification Bodies') {
            $cbApplication = CbApplication::firstOrCreate(
                [
                    'created_by' => auth()->id(),
                    'scheme_name' => $scheme_name,
                    'application_type' => $application ?: 'New Application',
                    'status' => 'Draft',
                ],
                [
                    'application_no' => $referenceNumber,
                ]
            );

            $cbData = $this->loadCbApplicationData($cbApplication);
        }
        if ($scheme_name === 'Halal Certification Bodies') {
            return app(HalalCertificationBodyController::class)->create($request);
        }

        if ($scheme_name === 'Inspection Bodies') {
            return app(InspectionBodyController::class)->create($request);
        }

        if ($scheme_name === 'Medical Laboratories') {
            // Get or create draft application
            $mlabApplication = MlabApplication::firstOrCreate(
                [
                    'created_by' => auth()->id(),
                    'scheme_name' => $scheme_name,
                    'status' => 'draft',
                ],
                [
                    'application_type' => $application ?: 'New Application',
                    'organisation_name' => '',   // placeholder
                    'lab_address' => '',         // placeholder
                ]
            );

            $general = null;
            if ($mlabApplication->certification_general_id) {
                $general = CertificationGeneral::find($mlabApplication->certification_general_id);
            }
            if (!$general) {
                $general = CertificationGeneral::where('user_id', auth()->id())
                    ->where('category', 'Medical Laboratories')
                    ->where('application', $mlabApplication->application_type ?: 'New Application')
                    ->latest('id')
                    ->first();
                if ($general) {
                    $mlabApplication->update(['certification_general_id' => $general->id]);
                }
            }

            // Load all related data
            $mlabData = $this->loadMedicalLaboratoryData($mlabApplication);

            return view('admin.application.medical_laboratory.index', compact(
                'mlabApplication',
                'mlabData',
                'scheme_name',
                'application',
                'general'
            ));
        }
        $labApplication = ApplicationForLab::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'category' => $scheme_name,
            ],
            [
                'certification_general_id' => $general?->id,
            ]
        );

        $savedSections = [
            'basic_info' => ! empty($general?->cab_name) || ! empty($general?->email),
            'about_yourself' => ! empty($labApplication->selves_name) || ! empty($labApplication->selves_parent_organization),
            'about_staff' => ! empty($labApplication->staff_name) || ! empty($labApplication->staff_quality_name),
            'calibration_scope' => ! empty($labApplication->scop_calib_field) && $labApplication->scop_calib_field !== '[]',
            'testing_scope' => ! empty($labApplication->scop_materials) || ! empty($labApplication->scop_description),
            'calibration_facility' => ! empty($labApplication->calibration_fully) || ! empty($labApplication->calibration_compliance),
            'other_approvals' => ! empty($labApplication->approvals_name) || ! empty($labApplication->approvals_scope),
            'declaration' => ! empty($labApplication->signed) || ! empty($labApplication->date),
            'ptp_scope' => $labApplication->ptpScopes()->exists(),
            'pcb_scope' => $labApplication->pcbScopes()->exists(),
            'personnel_scope' => $labApplication->personnelScopes()->exists(),
        ];

        $ptpScopes = $labApplication->ptpScopes;
        $pcbScopes = $labApplication->pcbScopes;
        $personnelScopes = $labApplication->personnelScopes;

        return view('admin.application.certification.index', compact('cbApplication', 'cbData', 'labApplication', 'savedSections', 'scopes', 'scheme_name', 'application', 'documents', 'general', 'employees', 'documentDetails', 'declaration', 'isSubmitted', 'technicalClusters', 'mainTechnical13485s', 'clusters22000', 'categories', 'subCategories', 'referenceNumber', 'countries', 'form', 'ptpScopes', 'pcbScopes', 'personnelScopes'));
    }

    private function loadCbApplicationData(CbApplication $application): array
    {
        $tables = [
            'contact' => 'cb_contacts',
            'sub_offices' => 'cb_sub_offices',
            'requested_scopes' => 'cb_requested_scopes',
            'documents' => 'cb_documents',
            'authorized_person' => 'cb_authorized_persons',
            'parent_organization' => 'cb_parent_organizations',
            'invoice_address' => 'cb_invoice_addresses',
            'consultant' => 'cb_consultants',
            'staff_roles' => 'cb_staff_roles',
            'management_members' => 'cb_management_members',
            'permanent_auditors' => 'cb_permanent_auditors',
            'freelance_auditors' => 'cb_freelance_auditors',
            'qms_scopes' => 'cb_qms_scopes',
            'ems_scopes' => 'cb_ems_scopes',
            'ohs_scopes' => 'cb_ohs_scopes',
            'fsms_scopes' => 'cb_fsms_scopes',
            'mdqms_scopes' => 'cb_mdqms_scopes',
            'isms_scopes' => 'cb_isms_scopes',
            'non_compliance' => 'cb_non_compliance',
            'other_approvals' => 'cb_other_approvals',
            'declaration' => 'cb_declarations',
        ];

        $data = [];
        foreach ($tables as $key => $table) {
            $rows = DB::table($table)->where('application_id', $application->id)->get();
            $data[$key] = str_contains($key, 'contact') || in_array($key, ['authorized_person', 'parent_organization', 'invoice_address', 'consultant', 'declaration'], true)
                ? $rows->first()
                : $rows;
        }

        $savedSections = [
            'basic_info' => ! empty($application->application_no),
            'body_info' => ! empty(optional($data['contact'])->certification_body_name),
            'accreditation_request' => $data['requested_scopes']->isNotEmpty(),
            'documents' => $data['documents']->isNotEmpty(),
            'about_yourselves' => ! empty(optional($data['authorized_person'])->name),
            'staff_info' => $data['staff_roles']->isNotEmpty() || $data['management_members']->isNotEmpty(),
            'scope_application' => $data['qms_scopes']->isNotEmpty() || $data['fsms_scopes']->isNotEmpty() || $data['isms_scopes']->isNotEmpty(),
            'quality_system' => $data['non_compliance']->isNotEmpty(),
            'other_approvals' => $data['other_approvals']->isNotEmpty(),
            'declaration' => (bool) optional($data['declaration'])->declaration_accepted,
        ];

        $data['saved_sections'] = $savedSections;

        return $data;
    }

    public function saveBasicInfo(Request $request, ApplicationForLab $applicationForLab)
    {
        // dd($request);
        $scheme_name = $request->query('scheme_name');
        $form = \App\Models\ApplicationForm::where('application_name', $scheme_name)
            ->orWhere('slug', \Str::slug($scheme_name))
            ->first();

        $orgFieldName = 'organisation';
        if ($form && isset($form->form_schema['sections'][0]['fields'][0]['name'])) {
            $orgFieldName = $form->form_schema['sections'][0]['fields'][0]['name'];
        }

        $validator = Validator::make($request->all(), [
            $orgFieldName => ['required', 'string', 'max:255'],
            'cab_name' => ['required', 'string', 'max:255'],
            'address_laboratory' => ['required', 'string', 'max:1000'],
            'tel' => ['required', 'string', 'min:7', 'max:30'],
            'person_email' => ['required', 'email', 'max:255'],
            'ntn_ftn' => ['required', 'string', 'max:100'],
            'website' => ['required', 'url', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'basic_info');
        }

        $validated = $validator->validated();

        $general = CertificationGeneral::firstOrNew([
            'user_id' => auth()->id(),
            'category' => urldecode($request->query('scheme_name', $applicationForLab->category)),
            'application' => $request->query('application'),
        ]);

        $general->fill([
            'scheme' => $validated[$orgFieldName],
            'cab_name' => $validated['cab_name'],
            'address' => $validated['address_laboratory'],
            'telephone' => $validated['tel'],
            'email' => $validated['person_email'],
            'ntn_ftn' => $validated['ntn_ftn'],
            'website' => $validated['website'],
            'city' => $validated['city'],
            'country' => $validated['country'],
            'postal_code' => $validated['postcode'],
        ]);

        if (empty($general->reference_no)) {
            $general->reference_no = 'CAB-'.now()->format('Ymd').rand(1000, 9999);
        }

        $general->save();

        $applicationForLab->update([
            'certification_general_id' => $general->id,
        ]);

        return redirect()->route('application.create', [
            'scheme_name' => $request->query('scheme_name'),
            'application' => $request->query('application'),
            'edit_section' => null,
        ])->with('success', 'Basic information saved successfully.')->with('open_section', 'basic_info');
    }

    public function saveAboutYourself(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'selves_title' => 'required|string|max:100',
            'selves_name' => 'required|string|max:255',
            'selves_position' => 'required|string|max:255',
            'selves_parent_organization' => 'required|string|max:255',
            'selves_relationship' => 'required|string|max:255',
            'selves_address' => 'required|string',
            'selves_postcode' => 'required|string|max:100',
            'selves_tel' => ['required', 'string', 'max:100', 'regex:/^[0-9+\-\s]+$/'],
            'selves_fax' => ['required', 'string', 'max:100', 'regex:/^[0-9+\-\s]+$/'],
            'ownership_type' => 'required|string|max:255',
            'selves_other_describe' => 'required|string',
            'parent_main_activity' => 'required|string|max:20',
            'selves_activities' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'about_yourself');
        }

        $data = $validator->validated();
        $data['selves_parent'] = $data['selves_parent_organization'] ?? null;
        $data['selves_with_parent'] = $data['parent_main_activity'] ?? null;
        $data['selves_own_organisation'] = in_array('Own organisation', $request->input('selves_undertakes', []), true) ? '1' : null;
        $data['selves_other_organisation'] = in_array('Other organisations', $request->input('selves_undertakes', []), true) ? '1' : null;
        $data['selves_individual'] = $request->input('ownership_type') === 'Owned by an individual' ? '1' : null;
        $data['selves_public'] = $request->input('ownership_type') === 'Owned by public limited company' ? '1' : null;
        $data['selves_private'] = $request->input('ownership_type') === 'Owned by a private company / partnership' ? '1' : null;
        $data['selves_learned'] = $request->input('ownership_type') === 'Part of learned / technical institution' ? '1' : null;
        $data['selves_industry'] = $request->input('ownership_type') === 'Owned by a public body / nationalised industry' ? '1' : null;
        $data['selves_academic'] = $request->input('ownership_type') === 'Part of an academic institution' ? '1' : null;
        unset($data['ownership_type'], $data['parent_main_activity'], $data['selves_undertakes']);

        $applicationForLab->update($data);

        return redirect()->route('application.create', [
            'scheme_name' => $request->query('scheme_name'),
            'application' => $request->query('application'),
        ])->with('success', 'About yourselves saved successfully.')->with('open_section', 'about_yourself');
    }

    public function saveAboutStaff(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'staff_name' => 'required|string',
            'staff_qualifications' => 'required|string',
            'staff_experience' => 'required|string',
            'staff_quality_name' => 'required|string|max:255',
            'staff_quality_qualifications' => 'required|string|max:255',
            'staff_quality_experience' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'about_staff');
        }
        $applicationForLab->update($validator->validated());

        return redirect()->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])->with('success', 'About staff saved successfully.')->with('open_section', 'about_staff');
    }

    public function saveCalibrationScope(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'calibration' => 'required|array',
            'calibration.*.field' => 'nullable|string',
            'calibration.*.measurement' => 'nullable|string',
            'calibration.*.range' => 'nullable|string',
            'calibration.*.expanded' => 'nullable|string',
            'calibration.*.technique' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_section', 'calibration_scope');
        }

        $data = $validator->validated();

        $applicationForLab->update([
            'scop_calib_field' => json_encode(array_values($data['calibration'])),
        ]);

        return redirect()->route('application.create', [
            'scheme_name' => $request->query('scheme_name'),
            'application' => $request->query('application'),
        ])->with('success', 'Calibration scope saved successfully.')
            ->with('open_section', 'calibration_scope');

    }

    public function saveTestingScope(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'scop_materials' => 'required|string',
            'scop_types' => 'required|string',
            'scop_range' => 'required|string',
            'scop_detection' => 'required|string',
            'scop_uncertainty' => 'required|string',
            'scop_standard' => 'required|string',
            'scop_description' => 'required|string',
            'scop_working' => 'required|string',
            'scop_limit' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'testing_scope');
        }
        $applicationForLab->update($validator->validated());

        return redirect()->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])->with('success', 'Testing scope saved successfully.')->with('open_section', 'testing_scope');
    }

    public function savePtpScope(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'ptp_scope' => 'required|array',
            'ptp_scope.*.item_material_matrix_product' => 'required|string',
            'ptp_scope.*.scheme_test_properties' => 'required|string',
            'ptp_scope.*.protocol_procedure_technique' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'ptp_scope');
        }

        $data = $validator->validated();

        $this->replaceRows('ptp_scope_of_proficiency_testing', $applicationForLab->id, $data['ptp_scope']);

        return redirect()->route('application.create', [
            'scheme_name' => $request->query('scheme_name'),
            'application' => $request->query('application'),
        ])->with('success', 'Proficiency Testing Provider scope saved successfully.')
            ->with('open_section', 'ptp_scope');
    }

    public function savePcbScope(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'pcb_scope' => 'required|array',
            'pcb_scope.*.product' => 'required|string',
            'pcb_scope.*.standard' => 'required|string',
            'pcb_scope.*.countries' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'pcb_scope');
        }

        $data = $validator->validated();

        $this->replaceRows('pcb_scope_of_certification', $applicationForLab->id, $data['pcb_scope']);

        return redirect()->route('application.create', [
            'scheme_name' => $request->query('scheme_name'),
            'application' => $request->query('application'),
        ])->with('success', 'Product Certification Body scope saved successfully.')
            ->with('open_section', 'pcb_scope');
    }

    public function savePersonnelScope(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'personnel_scope' => 'required|array',
            'personnel_scope.*.technical_cluster' => 'required|string',
            'personnel_scope.*.description_iaf' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'personnel_scope');
        }

        $data = $validator->validated();

        $this->replaceRows('personnel_certification_scopes', $applicationForLab->id, $data['personnel_scope']);

        return redirect()->route('application.create', [
            'scheme_name' => $request->query('scheme_name'),
            'application' => $request->query('application'),
        ])->with('success', 'Personnel Certification Bodies scope saved successfully.')
            ->with('open_section', 'personnel_scope');
    }

    public function saveCalibrationFacility(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'calibration_fully' => 'required|in:yes,no',
            'calibration_fully_comment' => 'nullable|string',
            'calibration_record' => 'required|in:yes,no',
            'calibration_record_comment' => 'nullable|string',
            'calibration_adequate' => 'required|in:yes,no',
            'calibration_adequate_comment' => 'nullable|string',
            'calibration_procedures' => 'required|in:yes,no',
            'calibration_procedures_comment' => 'nullable|string',
            'calibration_internal' => 'required|in:yes,no',
            'calibration_internal_comment' => 'nullable|string',
            'calibration_pnac' => 'required|in:yes,no',
            'calibration_pnac_comment' => 'nullable|string',
            'calibration_other_comment' => 'nullable|string',
            'calibration_lab_comment' => 'nullable|string',
            'calibration_compliance' => 'required|in:yes,no',
            'calibration_compliance_comment' => 'nullable|string',
            'calibration_non_compliance' => 'nullable|string',
            'calibration_rectified' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'calibration_facility');
        }

        $applicationForLab->update($validator->validated());

        return redirect()
            ->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])
            ->with('success', 'Calibration facility saved successfully.')
            ->with('open_section', 'calibration_facility');
    }

    public function saveOtherApprovals(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'approvals_name' => 'required|string|max:255',
            'approvals_scope' => 'required|string|max:255',
            'approvals_start_date' => 'required|date',
            'approvals_end_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'other_approvals');
        }
        $applicationForLab->update($validator->validated());

        return redirect()->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])->with('success', 'Other approvals saved successfully.')->with('open_section', 'other_approvals');
    }

    public function saveDeclaration(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'declaration_calibration' => 'nullable|in:yes',
            'declaration_testing' => 'nullable|in:yes',
            'declaration_extension' => 'nullable|in:yes',
            'declaration_laboratory' => 'nullable|in:yes',
            'declaration_test_lab' => 'nullable|in:yes',
            'application_fee' => 'nullable|string|max:255',
            'signed' => 'required|string|max:255',
            'date' => 'required|date',
            // 'upload_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_section', 'declaration');
        }

        $data = $validator->validated();

        // Checkboxes ko explicitly 'no' set karna zaroori hai, warna update() unhe touch hi nahi karega
        foreach (['declaration_calibration', 'declaration_testing', 'declaration_extension', 'declaration_laboratory', 'declaration_test_lab'] as $checkbox) {
            $data[$checkbox] = $request->has($checkbox) ? 'yes' : 'no';
        }

        $applicationForLab->update($data);

        return redirect()
            ->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])
            ->with('success', 'Declaration saved successfully.')
            ->with('open_section', 'declaration');
    }

    public function viewScope(Request $request)
    {
        $scope = $request->get('scope');
        $category = $request->get('category');
        $general = CertificationGeneral::where('user_id', auth()->user()->id)->where('category', $category)->where('application', $request->application)->first();
        $general_id = @$general->id;
        $scopes = ScopeFactory::getScopes($category, $general_id, $scope);

        $categoryViews = [
            'Certification Bodies' => 'admin.application.certification.view_scope',
            'Testing' => 'admin.application.testing.view_scope',
            'Calibration' => 'admin.application.testing.view_scope',
            'Testing Calibration Laboratories' => 'admin.application.testing.view_scope',
            'Medical Laboratories' => 'admin.application.medical.view_scope',
            'Inspection Bodies' => 'admin.application.inspection.view_scope',
            'Halal Certification Bodies' => 'admin.application.halal.view_scope',
            'Proficiency Testing Provider' => 'admin.application.proficiency.view_scope',
            'Product Certification Bodies' => 'admin.application.product.view_scope',
            'Personnel Certification Bodies' => 'admin.application.personnel.view_scope',
        ];

        $view = $categoryViews[$category] ?? 'admin.error.404';
        // dd($view);

        return view($view, compact('scope', 'scopes'));

    }

    public function storeCertification(Request $request)
    {

        //  dd($request->all());

        if ($request->application == 'Renewal Application') {
            $general = CertificationGeneral::where('user_id', auth()->user()->id)
                ->where('category', $request->category)
                ->where('application', $request->application)->first();

        } else {
            $general = CertificationGeneral::where('user_id', auth()->user()->id)->where('category', $request->category)->first();

        }

        if ($request->type == 'general') {
            $generalData = $request->only((new CertificationGeneral)->getFillable());
            $generalData['user_id'] = auth()->user()->id;
            $saved = CertificationGeneral::create($generalData);
            // $generalData = CertificationGeneral::where('id', $request->general_id)->updateOrCreate($generalData);

            session(['application_id' => $saved->id]);

            // dd(session()->all());
            return redirect()->back()->with('show_section', 'Employee');

        } elseif ($request->type == 'employee') {
            if (! empty($general)) {

                $employeeData = $request->only((new CertificationEmployee)->getFillable());
                $employeeData['user_id'] = auth()->user()->id;
                $employeeData['certification_general_id'] = session('application_id');
                // dd($employeeData);
                $employee = CertificationEmployee::create($employeeData);

                // dd($employee);
                // session()->flash('success', 'Employee added successfully');
                return redirect()->back()->with('show_section', 'Employee');
            } else {
                return redirect()->back()->with('error', 'Please fill first general Information');
            }

        } elseif ($request->type == 'scope') {
            // if(!empty($general)){
            if ($request->category == 'Certification Bodies') {
                $scopeData = $request->only((new CertificationScope)->getFillable());
                $scopeData['user_id'] = auth()->user()->id;
                $scopeData['certification_general_id'] = session('application_id');
                $scope = CertificationScope::create($scopeData);

                return redirect()->back()->with('show_section', 'Certification Bodies');

            } elseif ($request->scope_type == 'Testing' || $request->scope_type == 'Testing Calibration Laboratories') {
                $testingData = $request->only((new TestingScope)->getFillable());
                $testingData['user_id'] = auth()->user()->id;
                $testingData['certification_general_id'] = session('application_id');
                $testing = TestingScope::create($testingData);

                session()->flash('success', 'Testing added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->scope_type == 'Calibration' || $request->scope_type == 'Testing Calibration Laboratories') {
                $calibrationData = $request->only((new CalibrationScope)->getFillable());
                $calibrationData['user_id'] = auth()->user()->id;
                $calibrationData['certification_general_id'] = session('application_id');
                $calibration = CalibrationScope::create($calibrationData);

                session()->flash('success', 'Calibration added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->scope_type == 'Medical') {
                $medicalData = $request->only((new MedicalScope)->getFillable());
                $medicalData['user_id'] = auth()->user()->id;
                $medicalData['certification_general_id'] = session('application_id');
                $medical = MedicalScope::create($medicalData);

                session()->flash('success', 'Medical laboratories added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->scope_type == 'Inspection') {
                $inspectionData = $request->only((new InspectionScope)->getFillable());
                $inspectionData['user_id'] = auth()->user()->id;
                $inspectionData['certification_general_id'] = session('application_id');
                $inspection = InspectionScope::create($inspectionData);
                session()->flash('success', 'Inspection Bodies added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->scope_type == 'Halal') {
                $halalData = $request->only((new HalalScope)->getFillable());
                $halalData['user_id'] = auth()->user()->id;
                $halalData['certification_general_id'] = session('application_id');
                $halal = HalalScope::create($halalData);
                session()->flash('success', 'Halal Certification Bodies added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->scope_type == 'Proficiency') {
                $proficiencyData = $request->only((new ProficiencyScope)->getFillable());
                $proficiencyData['user_id'] = auth()->user()->id;
                $proficiencyData['certification_general_id'] = session('application_id');
                $proficiency = ProficiencyScope::create($proficiencyData);
                session()->flash('success', 'Proficiency Testing Provider added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->scope_type == 'Product') {
                $productData = $request->only((new ProductScope)->getFillable());
                $productData['user_id'] = auth()->user()->id;
                $productData['certification_general_id'] = session('application_id');
                $product = ProductScope::create($productData);
                session()->flash('success', 'Product Certification Bodies added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            } elseif ($request->category == 'Personnel Certification Bodies') {
                $personnelData = $request->only((new PersonnelScope)->getFillable());
                $personnelData['user_id'] = auth()->user()->id;
                $personnelData['certification_general_id'] = session('application_id');
                $product = PersonnelScope::create($personnelData);
                session()->flash('success', 'Personnel Certification Bodies added successfully');

                return redirect()->back()->with('show_section', 'Scope');
            }
            // }else{
            //     return redirect()->back()->with('error', 'Please fill first general Information');
            // }
            // session()->flash('success', 'Scope added successfully');

        } elseif ($request->type == 'declaration') {
            // dd('declaration');
            if (! empty($general)) {
                $declarationData = $request->only((new CertificationDeclaration)->getFillable());
                $declarationData['user_id'] = auth()->user()->id;
                $declarationData['certification_general_id'] = session('application_id');
                if ($request->hasFile('upload_file') && $request->file('upload_file')->isValid()) {
                    $image = $request->file('upload_file');
                    $timestamp = now()->format('Ymd_His');
                    $filename = 'application_'.$timestamp.'.'.$image->getClientOriginalExtension();
                    $path = $image->storeAs('applications', $filename, 'public');
                    $declarationData['upload_file'] = $path;
                }
                $declaration = CertificationDeclaration::create($declarationData);
                // dd($declaration);
                session()->flash('success', 'Application Submited Successfully');

                return redirect()->route('application.submited.index');
            } else {
                return redirect()->back()->with('error', 'Please fill first general Information');
            }
        } elseif ($request->type == 'document') {
            if (! empty($general)) {
                $documentData = $request->only((new DocumentDetail)->getFillable());
                $documentData['user_id'] = auth()->user()->id;
                $documentData['certification_general_id'] = session('application_id');

                if ($request->hasFile('upload_doc')) {
                    $image = $request->file('upload_doc');
                    $timestamp = now()->format('Ymd_His');
                    $filename = 'document_'.auth()->id().'_'.$timestamp.'.'.$image->getClientOriginalExtension();
                    $path = $image->storeAs('Documents', $filename, 'public');
                    $documentData['upload_doc'] = $path;
                }
                $Document = DocumentDetail::create($documentData);
                // dd($Document);

                // session()->flash('success', 'Document added successfully');
                return redirect()->back()->with('show_section', 'Document');
            } else {
                return redirect()->back()->with('error', 'Please fill first general Information');
            }
        } else {
            return view('admin.error.404');
        }

        return redirect()->back();

    }

    public function updateCertification(Request $request, $id)
    {
        // dd($request->all());
        // dd($request->all());
        if ($request->type == 'employee') {
            $employeeData = $request->only((new CertificationEmployee)->getFillable());
            $employee = CertificationEmployee::where('id', $id)->update($employeeData);
            session()->flash('success', 'Employee updated successfully');

        } elseif ($request->type == 'scope') {
            // $scopeData = $request->only((new CertificationScope)->getFillable());
            // $scopeData['user_id'] = auth()->user()->id;
            // $scope = CertificationScope::where('id', $id)->update($scopeData);

            if ($request->category == 'certification') {
                $scopeData = $request->only((new CertificationScope)->getFillable());
                $scope = CertificationScope::where('id', $id)->update($scopeData);
                session()->flash('success', 'Certification Bodies Scope updated successfully');
            } elseif ($request->category == 'testing') {
                $testingData = $request->only((new TestingScope)->getFillable());

                $testing = TestingScope::where('id', $id)->update($testingData);

                session()->flash('success', 'Testing Scope updated successfully');
            } elseif ($request->category == 'calibration') {
                $calibrationData = $request->only((new CalibrationScope)->getFillable());
                $calibration = CalibrationScope::where('id', $id)->update($calibrationData);

                session()->flash('success', 'Calibration Scope updated successfully');
            } elseif ($request->category == 'medical') {
                // dd('medical');
                $medicalData = $request->only((new MedicalScope)->getFillable());
                $medical = MedicalScope::where('id', $id)->update($medicalData);

                session()->flash('success', 'Medical laboratories Scope updated successfully');
            } elseif ($request->category == 'inspection') {
                $inspectionData = $request->only((new InspectionScope)->getFillable());
                $inspection = InspectionScope::where('id', $id)->update($inspectionData);
                session()->flash('success', 'Inspection Bodies updated Scope successfully');
            } elseif ($request->category == 'halal') {
                $halalData = $request->only((new HalalScope)->getFillable());
                $halal = HalalScope::where('id', $id)->update($halalData);
                session()->flash('success', 'Halal Certification Bodies Scope updated successfully');
            } elseif ($request->category == 'proficiency') {
                $proficiencyData = $request->only((new ProficiencyScope)->getFillable());
                $proficiency = ProficiencyScope::where('id', $id)->update($proficiencyData);
                session()->flash('success', 'Proficiency Testing Provider Scope updated successfully');
            } elseif ($request->category == 'product') {
                $productData = $request->only((new ProductScope)->getFillable());
                $product = ProductScope::where('id', $id)->update($productData);
                session()->flash('success', 'Product Certification Bodies Scope updated successfully');
            } elseif ($request->category == 'personnel') {
                $personnelData = $request->only((new PersonnelScope)->getFillable());
                $personnel = PersonnelScope::where('id', $id)->update($personnelData);
                session()->flash('success', 'Personnel Certification Bodies Scope updated successfully');
            }

        } elseif ($request->type == 'declaration') {
            $declarationData = $request->only((new CertificationDeclaration)->getFillable());
            // $declarationData['user_id'] = auth()->user()->id;
            // if ($request->hasFile('signed')) {
            //     $image = $request->file('upload_file');
            //     $timestamp = now()->format('Ymd_His');
            //     $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
            //     $path = $image->storeAs('applications', $filename, 'public');
            //     $declarationData['upload_file'] = $path;
            // }
            $scope = CertificationDeclaration::where('id', $id)->update($declarationData);

        } elseif ($request->type == 'document') {
            $document = DocumentDetail::findOrFail($id);
            $documentData = $request->only((new DocumentDetail)->getFillable());

            if ($request->hasFile('upload_doc')) {
                if ($document->upload_doc && Storage::disk('public')->exists($document->upload_doc)) {
                    Storage::disk('public')->delete($document->upload_doc);
                }
                $image = $request->file('upload_doc');
                $timestamp = now()->format('Ymd_His');
                $filename = 'document_'.auth()->id().'_'.$timestamp.'.'.$image->getClientOriginalExtension();
                $path = $image->storeAs('Documents', $filename, 'public');
                $documentData['upload_doc'] = $path;
            }
            $document->update($documentData);
            session()->flash('success', 'Document updated successfully');

            return redirect()->back()->with('show_section', 'Document');

        } else {
            return view('admin.error.404');
        }

        return redirect()->back();

    }

    // //////////////////////////////certification bodies section////////////////////////////////////
    // Store Document
    public function saveCbSection(Request $request, CbApplication $cbApplication, string $section)
    {
        abort_unless($cbApplication->created_by === auth()->id(), 403);
        abort_if($cbApplication->status === 'Submitted', 403, 'Submitted applications cannot be edited.');

        $sectionHandlers = [
            'basic_info' => 'saveCbBasicInfo',
            'body_info' => 'saveCbBodyInfo',
            'accreditation_request' => 'saveCbAccreditationRequest',
            'about_yourselves' => 'saveCbAboutYourselves',
            'staff_info' => 'saveCbStaffInfo',
            'scope_application' => 'saveCbScopeApplication',
            'quality_system' => 'saveCbQualitySystem',
            'other_approvals' => 'saveCbOtherApprovals',
            'declaration' => 'saveCbDeclaration',
        ];

        abort_unless(isset($sectionHandlers[$section]), 404);

        return $this->{$sectionHandlers[$section]}($request, $cbApplication);
    }

    private function saveCbBasicInfo(Request $request, CbApplication $application)
    {
        $data = $request->validate([
            'scheme_name' => 'required|string|max:255',
            'application_type' => 'required|string|max:255',
            'application_no' => 'nullable|string|max:255',
            'cab_name' => 'required|string|max:255',
            'address' => 'required|string',
            'postcode' => 'nullable|string|max:50',
            'telephone' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'ntn_ftn' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $application->update([
            'scheme_name' => $data['scheme_name'],
            'application_type' => $data['application_type'],
            'status' => 'Draft'
        ]);

        if ($application->certification_general_id) {
            $general = \App\Models\CertificationGeneral::find($application->certification_general_id);
            if ($general) {
                $general->update([
                    'cab_name' => $data['cab_name'],
                    'address' => $data['address'],
                    'telephone' => $data['telephone'] ?? '',
                    'email' => $data['email'],
                    'ntn_ftn' => $data['ntn_ftn'] ?? '',
                    'website' => $data['website'] ?? '',
                    'city' => $data['city'] ?? '',
                    'country' => $data['country'] ?? '',
                    'postal_code' => $data['postcode'] ?? '',
                ]);
            }
        }

        return $this->cbSectionResponse($request, 'Basic application information saved.', 'basic_info');
    }

    private function saveCbAboutYourselves(Request $request, CbApplication $application)
    {
        $data = $request->validate([
            'authorized_person.title' => 'nullable|string|max:100',
            'authorized_person.name' => 'required|string|max:255',
            'authorized_person.position' => 'nullable|string|max:255',
            'parent_organization.parent_organization' => 'nullable|string|max:255',
            'parent_organization.relationship' => 'nullable|string|max:255',
            'parent_organization.address' => 'nullable|string',
            'parent_organization.postcode' => 'nullable|string|max:50',
            'parent_organization.telephone' => 'nullable|string|max:100',
            'parent_organization.fax' => 'nullable|string|max:100',
            'parent_organization.ownership_type' => 'nullable|string|max:255',
            'parent_organization.ownership_other_description' => 'nullable|string',
            'parent_organization.main_activity' => 'nullable|in:yes,no',
            'parent_organization.main_activity_description' => 'nullable|string',
            'invoice_address.organization' => 'nullable|string|max:255',
            'invoice_address.address' => 'nullable|string',
            'invoice_address.postcode' => 'nullable|string|max:50',
            'invoice_address.telephone' => 'nullable|string|max:100',
            'invoice_address.fax' => 'nullable|string|max:100',
            'consultant.consultant_name' => 'nullable|string|max:255',
            'consultant.organization' => 'nullable|string|max:255',
            'consultant.address' => 'nullable|string',
            'consultant.postcode' => 'nullable|string|max:50',
            'consultant.telephone' => 'nullable|string|max:100',
            'consultant.fax' => 'nullable|string|max:100',
            'consultant.email' => 'nullable|email|max:255',
        ]);

        foreach ([
            'authorized_person' => 'cb_authorized_persons',
            'parent_organization' => 'cb_parent_organizations',
            'invoice_address' => 'cb_invoice_addresses',
            'consultant' => 'cb_consultants',
        ] as $key => $table) {
            DB::table($table)->updateOrInsert(['application_id' => $application->id], $this->timestamps($data[$key] ?? []));
        }

        return $this->cbSectionResponse($request, 'About yourselves saved.', 'about_yourselves');
    }

    private function saveCbStaffInfo(Request $request, CbApplication $application)
    {
        $data = $request->validate([
            'chief_executive' => 'nullable|array',
            'quality_representative' => 'nullable|array',
            'management_members' => 'nullable|array',
            'permanent_auditors' => 'nullable|array',
            'freelance_auditors' => 'nullable|array',
        ]);

        DB::table('cb_staff_roles')->where('application_id', $application->id)->delete();
        foreach (['chief_executive' => 'Chief Executive', 'quality_representative' => 'Quality Management Representative'] as $key => $role) {
            foreach ($data[$key] ?? [] as $row) {
                if (! array_filter($row)) {
                    continue;
                }
                DB::table('cb_staff_roles')->insert($this->timestamps(array_merge($row, [
                    'application_id' => $application->id,
                    'role' => $role,
                ])));
            }
        }
        $this->replaceRows('cb_management_members', $application->id, $data['management_members'] ?? []);
        $this->replaceRows('cb_permanent_auditors', $application->id, $data['permanent_auditors'] ?? []);
        $this->replaceRows('cb_freelance_auditors', $application->id, $data['freelance_auditors'] ?? []);

        return $this->cbSectionResponse($request, 'Staff information saved.', 'staff_info');
    }

    private function saveCbScopeApplication(Request $request, CbApplication $application)
    {
        $data = $request->validate([
            'qms_scopes' => 'nullable|array',
            'ems_scopes' => 'nullable|array',
            'ohs_scopes' => 'nullable|array',
            'fsms_scopes' => 'nullable|array',
            'mdqms_scopes' => 'nullable|array',
            'isms_scopes' => 'nullable|array',
        ]);

        foreach ([
            'qms_scopes' => 'cb_qms_scopes',
            'ems_scopes' => 'cb_ems_scopes',
            'ohs_scopes' => 'cb_ohs_scopes',
            'fsms_scopes' => 'cb_fsms_scopes',
            'mdqms_scopes' => 'cb_mdqms_scopes',
            'isms_scopes' => 'cb_isms_scopes',
        ] as $key => $table) {
            $this->replaceRows($table, $application->id, $data[$key] ?? []);
        }

        return $this->cbSectionResponse($request, 'Scope of application saved.', 'scope_application');
    }

    private function saveCbQualitySystem(Request $request, CbApplication $application)
    {
        $data = $request->validate([
            'complies' => 'required|in:yes,no',
            'non_compliance' => 'nullable|array',
        ]);
        // dd($request->all());

        $rows = $data['complies'] === 'no' ? ($data['non_compliance'] ?? []) : [['complies' => 'yes']];

        $rows = array_map(fn ($row) => array_merge(['complies' => $data['complies']], $row), $rows);

        $this->replaceRows('cb_non_compliance', $application->id, $rows);

        return $this->cbSectionResponse($request, 'Quality system compliance saved.', 'quality_system');
    }

    private function saveCbOtherApprovals(Request $request, CbApplication $application)
    {
        $data = $request->validate(['other_approvals' => 'nullable|array']);
        $this->replaceRows('cb_other_approvals', $application->id, $data['other_approvals'] ?? []);

        return $this->cbSectionResponse($request, 'Other approvals saved.', 'other_approvals');
    }

    private function saveCbDeclaration(Request $request, CbApplication $application)
    {
        $data = $request->validate([
            'declaration_accepted' => 'required|accepted',
            'applicant_fee_amount' => 'required|string|max:100',
            'digital_signature_name' => 'required|string|max:255',
            'signed_date' => 'required|date',
            'final_submit' => 'nullable|in:1',
        ]);

        DB::table('cb_declarations')->updateOrInsert(
            ['application_id' => $application->id],
            $this->timestamps([
                'declaration_accepted' => true,
                'applicant_fee_amount' => $data['applicant_fee_amount'],
                'digital_signature_name' => $data['digital_signature_name'],
                'signed_date' => $data['signed_date'],
            ])
        );

        if (! empty($data['final_submit'])) {
            $this->validateCbFinalSubmission($application);
            $application->update([
                'status' => 'Submitted',
                'submitted_at' => now(),
                'application_no' => $application->application_no ?: 'CB-'.now()->format('Ymd').'-'.$application->id,
            ]);
        }

        return $this->cbSectionResponse($request, ! empty($data['final_submit']) ? 'Application submitted successfully.' : 'Declaration saved.', 'declaration');
    }

    private function validateCbFinalSubmission(CbApplication $application): void
    {
        // $requiredDocuments = [
        //     'Quality Manual',
        //     'Quality Procedures',
        //     'Staff List',
        //     'Certified Organizations List',
        //     'Applicant Fee Evidence',
        //     'Legal Entity Proof',
        //     'F-02/29 Form',
        // ];

        // $uploaded = DB::table('cb_documents')->where('application_id', $application->id)->pluck('document_type')->all();
        // $missingDocuments = array_diff($requiredDocuments, $uploaded);

        $requiredTables = [
            'cb_contacts' => 'Certification Body Information',
            'cb_requested_scopes' => 'Accreditation Request',
            'cb_authorized_persons' => 'About Yourselves',
            'cb_staff_roles' => 'Staff Information',
            'cb_declarations' => 'Declaration',
        ];

        $missing = [];
        foreach ($requiredTables as $table => $label) {
            if (! DB::table($table)->where('application_id', $application->id)->exists()) {
                $missing[] = $label;
            }
        }

        // if ($missingDocuments || $missing) {
        //     abort(422, 'Complete missing sections/documents before submission: '.implode(', ', array_merge($missing, $missingDocuments)));
        // }
    }

    private function replaceRows(string $table, int $applicationId, array $rows): void
    {
        DB::table($table)->where('application_id', $applicationId)->delete();

        foreach ($rows as $row) {
            $row = array_filter($row, fn ($value) => $value !== null && $value !== '');
            if (! $row) {
                continue;
            }
            DB::table($table)->insert($this->timestamps(array_merge($row, ['application_id' => $applicationId])));

        }
    }

    private function timestamps(array $data): array
    {
        return array_merge($data, ['created_at' => now(), 'updated_at' => now()]);
    }

    private function cbSectionResponse(Request $request, string $message, string $section)
    {
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'open_section' => $section,
            ]);
        }

        return back()->with('success', $message)->with('open_section', $section);
    }
    // /////////////////////////////////////////////////////////////////////////////////////////////////

    // //////////////////////////////Medical Laboratries///////////////////////////////////////////////////
    private function loadMedicalLaboratoryData(MlabApplication $application): array
    {
        // Step 1: Organisation & Contact
        $step1 = DB::table('mlab_step1_organisation')
            ->where('mlab_application_id', $application->id)
            ->first();

        // Step 2: Staff
        $technicalManagement = DB::table('mlab_technical_management')
            ->where('mlab_application_id', $application->id)
            ->get();

        $qualityManager = DB::table('mlab_quality_manager')
            ->where('mlab_application_id', $application->id)
            ->get();

        $labStaff = DB::table('mlab_lab_staff')
            ->where('mlab_application_id', $application->id)
            ->get();

        // Step 3: Scope
        $scopeTests = DB::table('mlab_scope_tests')
            ->where('mlab_application_id', $application->id)
            ->get()
            ->map(function ($row) {
                $row->qc_measures = $row->qc_measures ? json_decode($row->qc_measures, true) : [];

                return $row;
            });

        $equipment = DB::table('mlab_equipment')
            ->where('mlab_application_id', $application->id)
            ->get();

        $referenceMaterials = DB::table('mlab_reference_materials')
            ->where('mlab_application_id', $application->id)
            ->get();

        $proficiencyTesting = DB::table('mlab_proficiency_testing')
            ->where('mlab_application_id', $application->id)
            ->get();

        // Step 4: Quality System
        $calibrationSystem = DB::table('mlab_calibration_system')
            ->where('mlab_application_id', $application->id)
            ->first();

        $isoCompliance = DB::table('mlab_iso_compliance')
            ->where('mlab_application_id', $application->id)
            ->first();

        if ($isoCompliance && $isoCompliance->non_compliance_areas) {
            $isoCompliance->non_compliance_areas = json_decode($isoCompliance->non_compliance_areas, true);
        }

        // Step 5: Other Approvals
        $otherApprovals = DB::table('mlab_other_approvals')
            ->where('mlab_application_id', $application->id)
            ->get();

        // Step 6: Declaration
        $declaration = DB::table('mlab_declarations')
            ->where('mlab_application_id', $application->id)
            ->first();

        // Documents (Step 7)
        // $documents = DB::table('mlab_documents')
        //     ->where('mlab_application_id', $application->id)
        //     ->get();

        // Build saved sections status
        $savedSections = [
            'step1' => (bool) $step1,
            'step2' => $technicalManagement->isNotEmpty() || $qualityManager->isNotEmpty() || $labStaff->isNotEmpty(),
            'step3' => $scopeTests->isNotEmpty() || $equipment->isNotEmpty() || $referenceMaterials->isNotEmpty() || $proficiencyTesting->isNotEmpty(),
            'step4' => (bool) $calibrationSystem || (bool) $isoCompliance,
            'step5' => $otherApprovals->isNotEmpty(),
            'step6' => (bool) $declaration,
            // 'step7' => $documents->isNotEmpty() || $application->status === 'submitted',
        ];

        return [
            'step1_organisation' => $step1,
            'technical_management' => $technicalManagement,
            'quality_manager' => $qualityManager,
            'lab_staff' => $labStaff,
            'scope_tests' => $scopeTests,
            'equipment' => $equipment,
            'reference_materials' => $referenceMaterials,
            'proficiency_testing' => $proficiencyTesting,
            'calibration_system' => $calibrationSystem,
            'iso_compliance' => $isoCompliance,
            'other_approvals' => $otherApprovals,
            'declaration' => $declaration,
            // 'documents' => $documents,
            'saved_sections' => $savedSections,
        ];
    }

    /**
     * Replace rows in a table for Medical Laboratory (uses mlab_application_id)
     */
    private function replaceMlabRows(string $table, int $applicationId, array $rows): void
    {
        DB::table($table)->where('mlab_application_id', $applicationId)->delete();

        foreach ($rows as $row) {
            $hasContent = false;
            foreach ($row as $v) {
                if ($v !== null && $v !== '') {
                    $hasContent = true;
                    break;
                }
            }
            if (!$hasContent) {
                continue;
            }

            $insertData = [];
            foreach ($row as $k => $v) {
                $insertData[$k] = ($v === null) ? '' : $v;
            }

            DB::table($table)->insert($this->timestamps(array_merge($insertData, ['mlab_application_id' => $applicationId])));
        }
    }

    /**
     * Response helper for MLab sections
     */
    private function mlabSectionResponse(Request $request, string $message, string $section)
    {
        session()->put('mlab_saved_sections.'.$section, true);
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'open_section' => $section,
            ]);
        }

        return back()->with('success', $message)->with('open_section', $section);
    }

    public function saveMlabStep1(Request $request, MlabApplication $mlabApplication)
    {
        $data = $request->validate([
            'organisation_name' => 'required|string|max:255',
            'lab_address' => 'required|string',
            'postcode' => 'nullable|string|max:100',
            'tel' => 'nullable|string|max:100',
            'fax' => 'nullable|string|max:100',
            'title' => 'nullable|string|max:100',
            'contact_name' => 'required|string|max:255',
            'contact_designation' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string',
            'contact_tel' => 'nullable|string|max:100',
            'contact_fax' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:255',
            'contact_mobile' => 'nullable|string|max:100',
            'parent_organisation' => 'nullable|string|max:255',
            'parent_relationship' => 'nullable|string|max:255',
            'parent_address' => 'nullable|string',
            'parent_postcode' => 'nullable|string|max:100',
            'parent_tel' => 'nullable|string|max:100',
            'parent_fax' => 'nullable|string|max:100',
            'invoice_organisation' => 'nullable|string|max:255',
            'invoice_address' => 'nullable|string',
            'invoice_postcode' => 'nullable|string|max:100',
            'invoice_tel' => 'nullable|string|max:100',
            'invoice_fax' => 'nullable|string|max:100',
            'ownership_type' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:100',
            'ownership_other_description' => 'nullable|string',
            'testing_main_activity' => 'nullable|in:yes,no',
            'main_activity_description' => 'nullable|string',
            'consultant_name' => 'nullable|string|max:255',
            'consultant_organisation' => 'nullable|string|max:255',
            'consultant_address' => 'nullable|string',
            'consultant_postcode' => 'nullable|string|max:100',
            'consultant_tel' => 'nullable|string|max:100',
            'consultant_fax' => 'nullable|string|max:100',
            'consultant_email' => 'nullable|email|max:255',
            'facility_permanent' => 'nullable|in:yes',
            'facility_sample_collection' => 'nullable|in:yes',
            'facility_temporary' => 'nullable|in:yes',
            'facility_mobile' => 'nullable|in:yes',
            'fields_of_testing' => 'nullable|array',
            'fields_of_testing.*' => 'string|max:100',
            'other_field' => 'nullable|string',
            'sample_collection_list' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'ntn_ftn' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $general = CertificationGeneral::firstOrNew([
            'id' => $mlabApplication->certification_general_id
        ]);
        $general->fill([
            'user_id' => auth()->id(),
            'category' => 'Medical Laboratories',
            'application' => $mlabApplication->application_type ?: 'New Application',
            'scheme' => $data['organisation_name'],
            'cab_name' => $data['organisation_name'],
            'address' => $data['lab_address'],
            'telephone' => $data['tel'] ?? '',
            'email' => $data['contact_email'] ?? '',
            'ntn_ftn' => $data['ntn_ftn'] ?? '',
            'website' => $data['website'] ?? '',
            'city' => $data['city'] ?? '',
            'country' => $data['country'] ?? '',
            'postal_code' => $data['postcode'] ?? '',
        ]);
        if (empty($general->reference_no)) {
            $general->reference_no = 'MLAB-'.now()->format('Ymd').rand(1000, 9999);
        }
        $general->save();

        // Update master application
        $mlabApplication->update([
            'certification_general_id' => $general->id,
            'organisation_name' => $data['organisation_name'],
            'lab_address' => $data['lab_address'],
        ]);

        // Handle file upload for sample collection list
        $filePath = null;
        if ($request->hasFile('sample_collection_list')) {
            $file = $request->file('sample_collection_list');
            $fileName = 'sample_list_'.time().'.'.$file->getClientOriginalExtension();
            $filePath = $file->storeAs("applications/medical-laboratory/{$mlabApplication->id}", $fileName, 'public');
        }

        // Save to step1 table
        DB::table('mlab_step1_organisation')->updateOrInsert(
            ['mlab_application_id' => $mlabApplication->id],
            $this->timestamps([
                'title' => $data['title'] ?? null,
                'contact_name' => $data['contact_name'],
                'contact_designation' => $data['contact_designation'] ?? null,
                'contact_address' => $data['contact_address'] ?? null,
                'contact_tel' => $data['contact_tel'] ?? null,
                'contact_fax' => $data['contact_fax'] ?? null,
                'contact_email' => $data['contact_email'] ?? null,
                'contact_mobile' => $data['contact_mobile'] ?? null,
                'parent_organisation' => $data['parent_organisation'] ?? null,
                'parent_relationship' => $data['parent_relationship'] ?? null,
                'parent_address' => $data['parent_address'] ?? null,
                'parent_postcode' => $data['parent_postcode'] ?? null,
                'parent_tel' => $data['parent_tel'] ?? null,
                'parent_fax' => $data['parent_fax'] ?? null,
                'invoice_organisation' => $data['invoice_organisation'] ?? null,
                'invoice_address' => $data['invoice_address'] ?? null,
                'invoice_postcode' => $data['invoice_postcode'] ?? null,
                'invoice_tel' => $data['invoice_tel'] ?? null,
                'invoice_fax' => $data['invoice_fax'] ?? null,
                'ownership_type' => $data['ownership_type'] ?? null,
                'registration_no' => $data['registration_no'] ?? null,
                'ownership_other_description' => $data['ownership_other_description'] ?? null,
                'testing_main_activity' => $data['testing_main_activity'] ?? null,
                'main_activity_description' => $data['main_activity_description'] ?? null,
                'consultant_name' => $data['consultant_name'] ?? null,
                'consultant_organisation' => $data['consultant_organisation'] ?? null,
                'consultant_address' => $data['consultant_address'] ?? null,
                'consultant_postcode' => $data['consultant_postcode'] ?? null,
                'consultant_tel' => $data['consultant_tel'] ?? null,
                'consultant_fax' => $data['consultant_fax'] ?? null,
                'consultant_email' => $data['consultant_email'] ?? null,
                'facility_permanent' => $request->has('facility_permanent') ? 'yes' : 'no',
                'facility_sample_collection' => $request->has('facility_sample_collection') ? 'yes' : 'no',
                'facility_temporary' => $request->has('facility_temporary') ? 'yes' : 'no',
                'facility_mobile' => $request->has('facility_mobile') ? 'yes' : 'no',
                'sample_collection_list' => $filePath,
                'fields_of_testing' => json_encode($data['fields_of_testing'] ?? []),
                'other_field' => $data['other_field'] ?? null,
            ])
        );

        return $this->mlabSectionResponse($request, 'Step 1 saved successfully.', 'step1');
    }

    public function saveMlabStep2(Request $request, MlabApplication $mlabApplication)
    {
        $data = $request->validate([
            'technical_management' => 'nullable|array',
            'technical_management.*.department' => 'nullable|string|max:255',
            'technical_management.*.name_designation' => 'nullable|string|max:255',
            'technical_management.*.qualification' => 'nullable|string',
            'technical_management.*.experience' => 'nullable|string',
            'technical_management.*.training' => 'nullable|string',
            'technical_management.*.authorized_area' => 'nullable|string',
            'technical_management.*.signature' => 'nullable|string|max:255',
            'quality_manager' => 'nullable|array',
            'quality_manager.*.name' => 'nullable|string|max:255',
            'quality_manager.*.qualification' => 'nullable|string',
            'quality_manager.*.experience' => 'nullable|string',
            'quality_manager.*.training' => 'nullable|string',
            'quality_manager.*.signature' => 'nullable|string|max:255',
            'lab_staff' => 'nullable|array',
            'lab_staff.*.section_name' => 'nullable|string|max:255',
            'lab_staff.*.section_leader' => 'nullable|string|max:255',
            'lab_staff.*.qualification' => 'nullable|string',
            'lab_staff.*.experience' => 'nullable|string',
            'lab_staff.*.training' => 'nullable|string',
            'lab_staff.*.authorized_area' => 'nullable|string',
        ]);

        // Technical Management
        $this->replaceMlabRows('mlab_technical_management', $mlabApplication->id, $data['technical_management'] ?? []);

        // Laboratory Staff
        $this->replaceMlabRows('mlab_lab_staff', $mlabApplication->id, $data['lab_staff'] ?? []);

        // Quality Manager - insert all non-empty rows with empty string fallback
        DB::table('mlab_quality_manager')->where('mlab_application_id', $mlabApplication->id)->delete();

        $qmData = $data['quality_manager'] ?? [];
        foreach ($qmData as $row) {
            $hasContent = false;
            foreach ($row as $v) {
                if ($v !== null && $v !== '') {
                    $hasContent = true;
                    break;
                }
            }
            if (!$hasContent) {
                continue;
            }

            $insertData = [];
            foreach ($row as $k => $v) {
                $insertData[$k] = ($v === null) ? '' : $v;
            }

            DB::table('mlab_quality_manager')->insert(
                $this->timestamps(array_merge($insertData, ['mlab_application_id' => $mlabApplication->id]))
            );
        }

        return $this->mlabSectionResponse($request, 'Step 2 saved successfully.', 'step2');
    }

    public function saveMlabStep3(Request $request, MlabApplication $mlabApplication)
    {
        $data = $request->validate([
            'scope_tests' => 'nullable|array',
            'scope_tests.*.sample_type' => 'nullable|string|max:255',
            'scope_tests.*.test_type' => 'nullable|string|max:255',
            'scope_tests.*.range' => 'nullable|string|max:255',
            'scope_tests.*.detection_limit' => 'nullable|string|max:255',
            'scope_tests.*.uncertainty' => 'nullable|string|max:255',
            'scope_tests.*.standard_method' => 'nullable|string',
            'scope_tests.*.equipment_used' => 'nullable|string',
            'scope_tests.*.qc_measures' => 'nullable|array',
            'equipment' => 'nullable|array',
            'equipment.*.equipment_name' => 'nullable|string|max:255',
            'equipment.*.model' => 'nullable|string|max:255',
            'equipment.*.capacity' => 'nullable|string|max:255',
            'equipment.*.detection_limit' => 'nullable|string|max:255',
            'equipment.*.calibration_date' => 'nullable|date',
            'equipment.*.next_calibration' => 'nullable|date',
            'equipment.*.usage' => 'nullable|string',
            'reference_materials' => 'nullable|array',
            'reference_materials.*.name' => 'nullable|string|max:255',
            'reference_materials.*.supplier' => 'nullable|string|max:255',
            'reference_materials.*.expiry' => 'nullable|date',
            'reference_materials.*.traceability' => 'nullable|string',
            'reference_materials.*.purpose' => 'nullable|string',
            'proficiency_testing' => 'nullable|array',
            'proficiency_testing.*.sample_type' => 'nullable|string|max:255',
            'proficiency_testing.*.test' => 'nullable|string|max:255',
            'proficiency_testing.*.date' => 'nullable|date',
            'proficiency_testing.*.organizing_body' => 'nullable|string|max:255',
            'proficiency_testing.*.z_score' => 'nullable|string|max:255',
            'proficiency_testing.*.corrective_action' => 'nullable|string',
        ]);

        // Scope tests with QC measures as JSON
        $scopeRows = array_map(function ($row) {
            if (! empty($row['qc_measures'])) {
                $row['qc_measures'] = json_encode(array_values($row['qc_measures']));
            }

            return $row;
        }, $data['scope_tests'] ?? []);

        $this->replaceMlabRows('mlab_scope_tests', $mlabApplication->id, $scopeRows);
        $this->replaceMlabRows('mlab_equipment', $mlabApplication->id, $data['equipment'] ?? []);
        $this->replaceMlabRows('mlab_reference_materials', $mlabApplication->id, $data['reference_materials'] ?? []);
        $this->replaceMlabRows('mlab_proficiency_testing', $mlabApplication->id, $data['proficiency_testing'] ?? []);

        return $this->mlabSectionResponse($request, 'Step 3 saved successfully.', 'step3');
    }

    public function saveMlabStep4(Request $request, MlabApplication $mlabApplication)
    {
        $data = $request->validate([
            'calibration_program_exists' => 'nullable|in:yes,no',
            'calibration_program_comment' => 'nullable|string',
            'record_maintained' => 'nullable|in:yes,no',
            'record_maintained_comment' => 'nullable|string',
            'facilities_adequate' => 'nullable|in:yes,no',
            'facilities_adequate_comment' => 'nullable|string',
            'internal_procedure_exists' => 'nullable|in:yes,no',
            'internal_procedure_comment' => 'nullable|string',
            'traceability_pnac' => 'nullable|in:yes,no',
            'traceability_pnac_comment' => 'nullable|string',
            'traceability_other' => 'nullable|string',
            'in_house_calibration' => 'nullable|in:yes,no',
            'in_house_uncertainty_identified' => 'nullable|in:yes,no',
            'in_house_uncertainty_incorporated' => 'nullable|in:yes,no',
            'iso_compliance' => 'nullable|array',
            'iso_compliance.complies' => 'nullable|in:yes,no',
            'iso_compliance.non_compliance_areas' => 'nullable|array',
            'iso_compliance.non_compliance_areas.*.area' => 'nullable|string',
            'iso_compliance.non_compliance_areas.*.rectification_date' => 'nullable|date',
        ]);

        // Calibration System
        $calData = [
            'calibration_program_exists' => $data['calibration_program_exists'] ?? null,
            'calibration_program_comment' => $data['calibration_program_comment'] ?? null,
            'record_maintained' => $data['record_maintained'] ?? null,
            'record_maintained_comment' => $data['record_maintained_comment'] ?? null,
            'facilities_adequate' => $data['facilities_adequate'] ?? null,
            'facilities_adequate_comment' => $data['facilities_adequate_comment'] ?? null,
            'internal_procedure_exists' => $data['internal_procedure_exists'] ?? null,
            'internal_procedure_comment' => $data['internal_procedure_comment'] ?? null,
            'traceability_pnac' => $data['traceability_pnac'] ?? null,
            'traceability_pnac_comment' => $data['traceability_pnac_comment'] ?? null,
            'traceability_other' => $data['traceability_other'] ?? null,
            'in_house_calibration' => $data['in_house_calibration'] ?? null,
            'in_house_uncertainty_identified' => $data['in_house_uncertainty_identified'] ?? null,
            'in_house_uncertainty_incorporated' => $data['in_house_uncertainty_incorporated'] ?? null,
        ];
        $calData = array_filter($calData, fn ($v) => $v !== null);
        DB::table('mlab_calibration_system')
            ->updateOrInsert(
                ['mlab_application_id' => $mlabApplication->id],
                $this->timestamps($calData)
            );

        // ISO Compliance
        $isoData = [];
        if (! empty($data['iso_compliance']['complies'])) {
            $isoData['complies'] = $data['iso_compliance']['complies'];
            if ($data['iso_compliance']['complies'] === 'no') {
                $isoData['non_compliance_areas'] = json_encode($data['iso_compliance']['non_compliance_areas'] ?? []);
            } else {
                $isoData['non_compliance_areas'] = null;
            }
        }
        if (! empty($isoData)) {
            DB::table('mlab_iso_compliance')
                ->updateOrInsert(
                    ['mlab_application_id' => $mlabApplication->id],
                    $this->timestamps($isoData)
                );
        } else {
            DB::table('mlab_iso_compliance')
                ->where('mlab_application_id', $mlabApplication->id)
                ->delete();
        }

        return $this->mlabSectionResponse($request, 'Step 4 saved successfully.', 'step4');
    }

    public function saveMlabStep5(Request $request, MlabApplication $mlabApplication)
    {
        $data = $request->validate([
            'other_approvals' => 'nullable|array',
            'other_approvals.*.body_name' => 'nullable|string|max:255',
            'other_approvals.*.scope' => 'nullable|string',
            'other_approvals.*.certificate_no' => 'nullable|string|max:255',
            'other_approvals.*.start_date' => 'nullable|date',
            'other_approvals.*.expiry_date' => 'nullable|date',
        ]);

        $this->replaceMlabRows('mlab_other_approvals', $mlabApplication->id, $data['other_approvals'] ?? []);

        return $this->mlabSectionResponse($request, 'Step 5 saved successfully.', 'step5');
    }

    public function saveMlabStep6(Request $request, MlabApplication $mlabApplication)
    {
        $data = $request->validate([
            'application_types' => 'nullable|array',
            'application_types.*' => 'string|max:100',
            'other_type' => 'nullable|string',
            'agreement_accepted' => 'nullable|boolean',
            'fee' => 'nullable|string|max:100',
            'signed_by' => 'nullable|string|max:255',
            'signed_date' => 'nullable|date',
            'final_submit' => 'nullable|in:1',
        ]);

        // Save declaration
        DB::table('mlab_declarations')->updateOrInsert(
            ['mlab_application_id' => $mlabApplication->id],
            $this->timestamps([
                'application_types' => json_encode($data['application_types'] ?? []),
                'other_type' => $data['other_type'] ?? null,
                'agreement_accepted' => $request->boolean('agreement_accepted'),
                'fee' => $data['fee'] ?? null,
                'signed_by' => $data['signed_by'] ?? null,
                'signed_date' => $data['signed_date'] ?? null,
            ])
        );

        if (! empty($data['final_submit'])) {
            $this->validateMlabFinalSubmission($mlabApplication);
            $mlabApplication->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'application_no' => $mlabApplication->application_no ?: 'MLAB-'.now()->format('Ymd').'-'.$mlabApplication->id,
            ]);

            return $this->mlabSectionResponse($request, 'Application submitted successfully.', 'step6');
        }

        return $this->mlabSectionResponse($request, 'Step 6 saved successfully.', 'step6');
    }

    private function validateMlabFinalSubmission(MlabApplication $mlabApplication): void
    {
        // $requiredDocuments = [
        //     'Quality Manual',
        //     'Standard Operating Procedures',
        //     'PT Participation Evidence',
        //     'PT Plan',
        //     'Agreement Form',
        //     'Filled Form',
        //     'Applicant Fee Evidence',
        // ];

        $requiredChecks = [
            'Step 1' => DB::table('mlab_step1_organisation')->where('mlab_application_id', $mlabApplication->id)->exists(),
            'Step 2' => DB::table('mlab_quality_manager')->where('mlab_application_id', $mlabApplication->id)->exists()
                || DB::table('mlab_technical_management')->where('mlab_application_id', $mlabApplication->id)->exists(),
            'Step 3' => DB::table('mlab_scope_tests')->where('mlab_application_id', $mlabApplication->id)->exists(),
            'Step 4' => DB::table('mlab_calibration_system')->where('mlab_application_id', $mlabApplication->id)->exists()
                || DB::table('mlab_iso_compliance')->where('mlab_application_id', $mlabApplication->id)->exists(),
            'Step 5' => DB::table('mlab_other_approvals')->where('mlab_application_id', $mlabApplication->id)->exists(),
            'Step 6' => DB::table('mlab_declarations')
                ->where('mlab_application_id', $mlabApplication->id)
                ->where('agreement_accepted', true)
                ->whereNotNull('signed_by')
                ->whereNotNull('signed_date')
                ->exists(),
        ];

        $uploaded = DB::table('mlab_documents')->where('mlab_application_id', $mlabApplication->id)->pluck('document_type')->all();

        $missing = [];
        foreach ($requiredChecks as $label => $exists) {
            if (! $exists) {
                $missing[] = $label;
            }
        }
    }

    public function submitedApplication()
    {
        $certifications = CertificationGeneral::with('application_statuses')->withWhereHas('declaration', function ($query) {
            $query->where('status', 'submited');
        })->where('user_id', auth()->user()->id)->get();

        //  dd($certifications);

        // $redirect 0

        return view('admin.application.submited_index', compact('certifications'));
    }

    public function viewSubmitedApplication($id)
    {
        $general = CertificationGeneral::findOrFail($id);
        $declarations = CertificationDeclaration::where('certification_general_id', $id)->get();
        $category = $general->category;
        $data = ScopeFetcher::getAllByGeneralId($general->id);
        $scopes = ScopeFetcher::getScopesByCategory($category, $general->id);
        // dd($declarations->testing_select);

        $schemes = Scheme::all();
        $user = auth()->user();

        return view('admin.application.view_submited', compact('general', 'data', 'scopes', 'user', 'schemes', 'declarations'));
    }

    // ////////////////////////////////////////////////////////////////////////////////////////////////
    public function getIafCodes(Request $request, $clusterId)
    {
        $iafCodes = FirstIafCode::where('technical_cluster_id', $clusterId)->where('code', $request->cluster_code)->get(['id', 'iaf_code', 'description']);

        return response()->json($iafCodes);
    }

    public function getTechnicalAreas($mainId)
    {
        return TechnicalArea::where('main_technical13485_id', $mainId)->get();
    }

    public function getDescriptions($mainId, $areaId)
    {
        return CertificationIafMd9::where('main_technical13485s_id', $mainId)
            ->where('technical_area_id', $areaId)
            ->select('id', 'description')
            ->get();
    }

    public function getCategories(Request $request)
    {
        $categories = Category22000::where('cluster_id', $request->cluster_id)->get();

        return response()->json($categories);
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = SubCategory22000::where('category_id', $request->category_id)->get();

        return response()->json($subcategories);
    }

    public function applicationShow($id, $category)
    {
        if ($category !== 'Certification Bodies') {
            return view('admin.error.404');
        }

        $application = CertificationGeneral::with([
            'certificationBodyApplication',
            'certificationBodyStaff',
            'certificationBodyApprovals',
            'certificationScopes',
        ])->findOrFail($id);

        return view('admin.application.certification.show.certification_bodies_show', compact('application'));
    }
}
// public function applicationStore(Request $request)
// {
//     // dd($request->category);

//     if($request->category == 'Testing' || $request->category == 'Calibration' || $request->category == 'Testing Calibration Laboratoies'){
//         $applicationData = $request->only((new ApplicationForLab)->getFillable());
//         $applicationData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('signed')) {
//             $image = $request->file('signed');
//             $timestamp = now()->format('Ymd_His');
//             $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
//             $path = $image->storeAs('applications', $filename, 'public');
//             $applicationData['signed'] = $path;
//         }
//         $application = ApplicationForLab::create($applicationData);

//     }elseif($request->category == 'Certification Bodies'){
//         $certificationData = $request->only((new CertificationBody)->getFillable());
//         $certificationData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('signed')) {
//             $image = $request->file('signed');
//             $timestamp = now()->format('Ymd_His');
//             $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
//             $path = $image->storeAs('applications', $filename, 'public');
//             $certificationData['signed'] = $path;
//         }
//         $certification = CertificationBody::create($certificationData);

//     }elseif($request->category == 'Medical Laboratories'){
//         $medicalData = $request->only((new MedicalLaboratory)->getFillable());
//         $medicalData['user_id'] = auth()->user()->id;
//         $medical = MedicalLaboratory::create($medicalData);

//     }elseif($request->category == 'Inspection Bodies'){
//         $inspectionData = $request->only((new InspectionBody)->getFillable());
//         $inspectionData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('declaration_signed')) {
//             $image = $request->file('declaration_signed');
//             $timestamp = now()->format('Ymd_His');
//             $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
//             $path = $image->storeAs('applications', $filename, 'public');
//             $inspectionData['declaration_signed'] = $path;
//         }
//         $inspection = InspectionBody::create($inspectionData);

//     }elseif($request->category == 'Halal Certification Bodies'){
//         $halalData = $request->only((new HalalCertificationBody)->getFillable());
//         $halalData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('declaration_signed')) {
//             $image = $request->file('declaration_signed');
//             $timestamp = now()->format('Ymd_His');
//             $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
//             $path = $image->storeAs('applications', $filename, 'public');
//             $halalData['declaration_signed'] = $path;
//         }
//         $halal = HalalCertificationBody::create($halalData);

//     }elseif($request->category == 'Proficiency Testing Provider'){
//         // dd('ok');
//         $ProficiencyData = $request->only((new ProficiencyTesting)->getFillable());
//         $ProficiencyData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('declaration_signed')) {
//             $image = $request->file('declaration_signed');
//             $timestamp = now()->format('Ymd_His');
//             $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
//             $path = $image->storeAs('applications', $filename, 'public');
//             $ProficiencyData['declaration_signed'] = $path;
//         }
//         $Proficiency = ProficiencyTesting::create($ProficiencyData);

//     }elseif($request->category == 'Product Certification Bodies'){
//         // dd('ok');
//         $ProductData = $request->only((new ProductCertification)->getFillable());
//         $ProductData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('declaration_signed')) {
//             $image = $request->file('declaration_signed');
//             $timestamp = now()->format('Ymd_His');
//             $filename = 'application_' . auth()->id() . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
//             $path = $image->storeAs('applications', $filename, 'public');
//             $ProductData['declaration_signed'] = $path;
//         }
//         $Product = ProductCertification::create($ProductData);

//     }elseif($request->category == 'Personnel Certification Bodies'){
//         // dd('ok');
//         $PersonnelData = $request->only((new PersonnelCertification)->getFillable());
//         $PersonnelData['user_id'] = auth()->user()->id;
//         if ($request->hasFile('declaration_signed')) {
//             $file = $request->file('declaration_signed');
//             $filename = date('dmy') . '_sign_' . time() . '.' . $file->getClientOriginalExtension();
//             $path = $file->storeAs('application_', $filename, 'public');
//             $PersonnelData['declaration_signed'] = $path;
//         }
//         $Personnel = PersonnelCertification::create($PersonnelData);

//     }else{
//         return view('admin.error.404');
//     }

//     return to_route('application.index')->with('success', 'Application Added Successfully');
// }

// public function applicationEdit($id, $category)
// {
//     // dd($category);
//     $scheme_name = $category;
//     $application = [];
//     $certification = [];
//     $medical = [];
//     $inspection = [];
//     $halal = [];
//     $proficiency = [];
//     $product = [];
//     $personnel = [];
//     // dd($category);
//     if($category == 'Testing' || $category == 'Calibration' || $category == 'Testing Calibration Laboratoies'){
//         $application = ApplicationForLab::where('id', $id)->first();

//     }elseif($category == 'Certification Bodies'){
//         $certification = CertificationBody::where('id', $id)->first();

//     }elseif($category == 'Medical Laboratories'){
//         $medical = MedicalLaboratory::where('id', $id)->first();

//     }elseif($category == 'Inspection Bodies'){
//         $inspection = InspectionBody::where('id', $id)->first();

//     }elseif($category == 'Halal Certification Bodies'){
//         $halal = HalalCertificationBody::where('id', $id)->first();

//     }elseif($category == 'Proficiency Testing Provider'){
//         $proficiency = ProficiencyTesting::where('id', $id)->first();

//     }elseif($category == 'Product Certification Bodies'){
//         $product = ProductCertification::where('id', $id)->first();

//     }elseif($category == 'Personnel Certification Bodies'){
//         $personnel = PersonnelCertification::where('id', $id)->first();

//     }else{
//         return view('admin.error.404');
//     }

//     return view('admin.application.edit', compact('application', 'certification', 'medical', 'inspection', 'halal', 'proficiency', 'product', 'personnel', 'scheme_name'));
// }

// public function applicationShow($id, $category)
// {
//     // dd($category);
//     $scheme_name = $category;
//     $application = [];
//     $certification = [];
//     $medical = [];
//     $inspection = [];
//     $halal = [];
//     $proficiency = [];
//     $product = [];
//     $personnel = [];
//     // dd($category);
//     if($category == 'Testing' || $category == 'Calibration' || $category == 'Testing Calibration Laboratoies'){
//         $application = ApplicationForLab::where('id', $id)->first();

//     }elseif($category == 'Certification Bodies'){
//         $certification = CertificationBody::where('id', $id)->first();

//     }elseif($category == 'Medical Laboratories'){
//         $medical = MedicalLaboratory::where('id', $id)->first();

//     }elseif($category == 'Inspection Bodies'){
//         $inspection = InspectionBody::where('id', $id)->first();

//     }elseif($category == 'Halal Certification Bodies'){
//         $halal = HalalCertificationBody::where('id', $id)->first();

//     }elseif($category == 'Proficiency Testing Provider'){
//         $proficiency = ProficiencyTesting::where('id', $id)->first();

//     }elseif($category == 'Product Certification Bodies'){
//         $product = ProductCertification::where('id', $id)->first();

//     }elseif($category == 'Personnel Certification Bodies'){
//         $personnel = PersonnelCertification::where('id', $id)->first();

//     }else{
//         return view('admin.error.404');
//     }

//     return view('admin.application.show', compact('application', 'certification', 'medical', 'inspection', 'halal', 'proficiency', 'product', 'personnel', 'scheme_name'));
// }

// public function applicationUpdate(Request $request, $id)
// {

//     if($request->category == 'Testing' || $request->category == 'Calibration' || $request->category == 'Testing Calibration Laboratoies'){
//         $applicationData = $request->only((new ApplicationForLab)->getFillable());
//         $applicationData['user_id'] = auth()->user()->id;
//         $application = ApplicationForLab::where('id', $id)->update($applicationData);

//     }elseif($request->category == 'Certification Bodies'){

//         $certificationData = $request->only((new CertificationBody)->getFillable());
//         $certificationData['user_id'] = auth()->user()->id;
//         $certification = CertificationBody::where('id', $id)->update($certificationData);

//     }elseif($request->category == 'Medical Laboratories'){

//         $certificationData = $request->only((new MedicalLaboratory)->getFillable());
//         $certificationData['user_id'] = auth()->user()->id;
//         $certification = MedicalLaboratory::where('id', $id)->update($certificationData);

//     }elseif($request->category == 'Inspection Bodies'){

//         $certificationData = $request->only((new InspectionBody)->getFillable());
//         $certificationData['user_id'] = auth()->user()->id;
//         $certification = InspectionBody::where('id', $id)->update($certificationData);

//     }elseif($request->category == 'Halal Certification Bodies'){

//         $halalData = $request->only((new HalalCertificationBody)->getFillable());
//         $halalData['user_id'] = auth()->user()->id;
//         $halal = HalalCertificationBody::where('id', $id)->update($halalData);

//     }elseif($request->category == 'Proficiency Testing Provider'){

//         $ProficiencyData = $request->only((new ProficiencyTesting)->getFillable());
//         $ProficiencyData['user_id'] = auth()->user()->id;
//         $Proficiency = ProficiencyTesting::where('id', $id)->update($ProficiencyData);

//     }elseif($request->category == 'Product Certification Bodies'){

//         $ProductData = $request->only((new ProductCertification)->getFillable());
//         $ProductData['user_id'] = auth()->user()->id;
//         $Product = ProductCertification::where('id', $id)->update($ProductData);

//     }elseif($request->category == 'Personnel Certification Bodies'){

//         $PersonnelData = $request->only((new PersonnelCertification)->getFillable());
//         $Personnel = PersonnelCertification::where('id', $id)->update($PersonnelData);

//     }else{
//         dd('Not Found');
//     }

//     return to_route('application.index')->with('success', 'Application Updated Successfully');
// }

// public function applicationDestroy($id, $category)
// {

//     // dd($id);
//     if($category == 'Testing' || $category == 'Calibration' || $category == 'Testing Calibration Laboratoies'){
//         $application = ApplicationForLab::find($id);
//         $application->delete();

//     }elseif($category == 'Certification Bodies'){

//         $certification = CertificationBody::find($id);
//         $certification->delete();

//     }elseif($category == 'Medical Laboratories'){
//         $medical = MedicalLaboratory::find($id);
//         $medical->delete();

//     }elseif($category == 'Inspection Bodies'){
//         $inspection = InspectionBody::find($id);
//         $inspection->delete();

//     }elseif($category == 'Halal Certification Bodies'){
//         $halal = HalalCertificationBody::find($id);
//         $halal->delete();

//     }elseif($category == 'Proficiency Testing Provider'){
//         $proficiency = ProficiencyTesting::find($id);
//         $proficiency->delete();

//     }elseif($category == 'Product Certification Bodies'){
//         $product = ProductCertification::find($id);
//         $product->delete();

//     }elseif($category == 'Personnel Certification Bodies'){
//         $personnel = PersonnelCertification::find($id);
//         $personnel->delete();
//     }else{
//         dd('Not Found');
//     }

//     return to_route('application.index')->with('success', 'Application Deleted Successfully');
// }
