<?php

namespace App\Http\Controllers\admin;

use App\Factories\ScopeFactory;
use App\Factories\ScopeFetcher;
use App\Http\Controllers\Controller;
use App\Models\ApplicationForLab;
use App\Models\CalibrationScope;
use App\Models\Category22000;
use App\Models\CertificationBody;
use App\Models\CertificationBodyApplication;
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
use App\Models\PersonnelCertification;
use App\Models\PersonnelScope;
use App\Models\ProductCertification;
use App\Models\ProductScope;
use App\Models\ProficiencyScope;
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

class ApplicationController extends Controller
{
    public function __construct(private readonly CertificationBodiesApplicationService $certificationBodiesService)
    {
    }
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
        $application = $request->application;
        $applicationId = session('application_id');
        $general = null;
        if ($scheme_name === 'Certification Bodies' && session('application_id')) {
            $general = CertificationGeneral::where('id', session('application_id'))
                ->where('user_id', auth()->id())
                ->first();
        }
        if (!$general) {
            $general = CertificationGeneral::where('user_id', auth()->user()->id)
                ->where('category', $scheme_name)
                ->where('application', $request->application)
                ->latest('id')
                ->first();
        }

        // Keep Certification Bodies UX aligned with testing flow:
        // initialize a draft general record so all sections are immediately available.
        if ($scheme_name === 'Certification Bodies' && !$general) {
            $general = CertificationGeneral::create([
                'user_id' => auth()->id(),
                'category' => 'Certification Bodies',
                'application' => $request->application,
                'scheme' => 'Certification Bodies',
                'cab_name' => '',
                'address' => '',
                'telephone' => '',
                'email' => 'draft+' . auth()->id() . '@example.com',
                'ntn_ftn' => '',
                'website' => '',
                'city' => '',
                'country' => '',
                'postal_code' => '',
                'reference_no' => 'CAB-' . now()->format('Ymd') . rand(1000, 9999),
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
            'basic_info' => !empty($general?->cab_name) || !empty($general?->email),
            'about_yourselves' => !empty($cbApplication?->director_name) || !empty($cbApplication?->director_position),
            'staff' => $cbStaff->flatten()->isNotEmpty(),
            'scope' => $cbScopes->flatten()->isNotEmpty(),
            'quality_system' => !empty($cbApplication?->quality_system_complies) || !empty($cbApplication?->non_compliance_area),
            'approvals' => $cbApprovals->isNotEmpty(),
            'declaration' => !empty($cbApplication?->signed) || !empty($cbApplication?->signed_date),
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
            'basic_info' => !empty($general?->cab_name) || !empty($general?->email),
            'about_yourself' => !empty($labApplication->selves_name) || !empty($labApplication->selves_parent_organization),
            'about_staff' => !empty($labApplication->staff_name) || !empty($labApplication->staff_quality_name),
            'calibration_scope' => !empty($labApplication->scop_calib_field) && $labApplication->scop_calib_field !== '[]',
            'testing_scope' => !empty($labApplication->scop_materials) || !empty($labApplication->scop_description),
            'calibration_facility' => !empty($labApplication->calibration_fully) || !empty($labApplication->calibration_compliance),
            'other_approvals' => !empty($labApplication->approvals_name) || !empty($labApplication->approvals_scope),
            'declaration' => !empty($labApplication->signed) || !empty($labApplication->date),
        ];

        return view('admin.application.certification.index', compact('labApplication', 'savedSections', 'scopes', 'scheme_name', 'application', 'documents', 'general', 'employees', 'documentDetails', 'declaration', 'isSubmitted', 'technicalClusters', 'mainTechnical13485s', 'clusters22000', 'categories', 'subCategories', 'referenceNumber', 'countries', 'cbApplication', 'cbStaff', 'cbApprovals', 'cbScopes', 'cbSavedSections'));
    }

    public function saveCertificationBodiesBasicInfo(Request $request)
    {
        $general = $this->certificationBodiesService->saveBasicInfo($request);
        session(['application_id' => $general->id]);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => $request->input('application')])
            ->with('success', 'Basic Certification Body information saved successfully.')
            ->with('open_section', 'basic_info');
    }

    public function saveCertificationBodiesAboutYourselves(Request $request, CertificationGeneral $general)
    {
        $this->certificationBodiesService->saveAboutYourselves($request, $general);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => request('application')])
            ->with('success', 'Part 1 saved successfully.')
            ->with('open_section', 'about_yourselves');
    }

    public function saveCertificationBodiesStaff(Request $request, CertificationGeneral $general)
    {
        $this->certificationBodiesService->saveStaff($request, $general);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => request('application')])
            ->with('success', 'Part 2 saved successfully.')
            ->with('open_section', 'staff');
    }

    public function saveCertificationBodiesScope(Request $request, CertificationGeneral $general)
    {
        $this->certificationBodiesService->saveScope($request, $general);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => request('application')])
            ->with('success', 'Part 3 saved successfully.')
            ->with('open_section', 'scope');
    }

    public function saveCertificationBodiesQualitySystem(Request $request, CertificationGeneral $general)
    {
        $this->certificationBodiesService->saveQualitySystem($request, $general);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => request('application')])
            ->with('success', 'Part 4 saved successfully.')
            ->with('open_section', 'quality_system');
    }

    public function saveCertificationBodiesApprovals(Request $request, CertificationGeneral $general)
    {
        $this->certificationBodiesService->saveOtherApprovals($request, $general);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => request('application')])
            ->with('success', 'Part 5 saved successfully.')
            ->with('open_section', 'approvals');
    }

    public function saveCertificationBodiesDeclaration(Request $request, CertificationGeneral $general)
    {
        $this->certificationBodiesService->saveDeclaration($request, $general);
        return redirect()->route('application.create', ['scheme_name' => 'Certification Bodies', 'application' => request('application')])
            ->with('success', 'Part 6 saved successfully.')
            ->with('open_section', 'declaration');
    }

    public function saveBasicInfo(Request $request, ApplicationForLab $applicationForLab)
    {
        $validator = Validator::make($request->all(), [
            'scheme' => 'required|string|max:255',
            'cab_name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'telephone' => ['required', 'string', 'min:7', 'max:30', 'regex:/^[0-9+\-\s]+$/'],
            'email' => 'required|email|max:255',
            'ntn_ftn' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z0-9\-\/]+$/'],
            'website' => 'required|url|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\s\-]+$/'],
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
            'scheme' => $validated['scheme'],
            'cab_name' => $validated['cab_name'],
            'address' => $validated['address'],
            'telephone' => $validated['telephone'],
            'email' => $validated['email'],
            'ntn_ftn' => $validated['ntn_ftn'],
            'website' => $validated['website'],
            'city' => $validated['city'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
        ]);

        if (empty($general->reference_no)) {
            $general->reference_no = 'CAB-' . now()->format('Ymd') . rand(1000, 9999);
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

    // public function saveCalibrationFacility(Request $request, ApplicationForLab $applicationForLab)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'calibration_fully' => 'required|string',
    //         'calibration_fully_comment' => 'required|string',
    //         'calibration_record' => 'required|string',
    //         'calibration_record_comment' => 'required|string',
    //         'calibration_adequate' => 'required|string',
    //         'calibration_adequate_comment' => 'required|string',
    //         'calibration_procedures' => 'required|string',
    //         'calibration_procedures_comment' => 'required|string',
    //         'calibration_internal' => 'required|string',
    //         'calibration_internal_comment' => 'required|string',
    //         'calibration_pnac' => 'required|string',
    //         'calibration_pnac_comment' => 'required|string',
    //         'calibration_other_comment' => 'required|string',
    //         'calibration_lab_comment' => 'required|string',
    //         'calibration_compliance' => 'required|string',
    //         'calibration_rectified' => 'required|date',
    //     ]);
    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput()->with('open_section', 'calibration_facility');
    //     }
    //     $applicationForLab->update($validator->validated());

    //     return redirect()->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])->with('success', 'Calibration facility saved successfully.')->with('open_section', 'calibration_facility');
    // }

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

    // public function saveDeclaration(Request $request, ApplicationForLab $applicationForLab)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'declaration_calibration' => 'required|string|max:100',
    //         'declaration_testing' => 'required|string|max:100',
    //         'declaration_extension' => 'required|string|max:255',
    //         'declaration_laboratory' => 'required|string|max:255',
    //         'declaration_test_lab' => 'required|string|max:255',
    //         'signed' => 'required|string|max:255',
    //         'date' => 'required|date',
    //     ]);
    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput()->with('open_section', 'declaration');
    //     }
    //     $applicationForLab->update($validator->validated());

    //     return redirect()->route('application.create', ['scheme_name' => $request->query('scheme_name'), 'application' => $request->query('application')])->with('success', 'Declaration saved successfully.')->with('open_section', 'declaration');
    // }
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

    // Store Document
    public function documentStore(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'document_id' => 'required|integer',
        //     // 'category' => 'required|string',
        //     'name' => 'required|string',
        //     'number' => 'required|string',
        //     'upload_doc' => 'required|file|mimes:pdf,jpg,png,docx|max:2048',
        // ]);

        if ($request->hasFile('upload_doc')) {
            $file = $request->file('upload_doc');
            $filename = date('dmy').'_sign_'.time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('Documents_', $filename, 'public');
        }
        $usr_id = auth()->user()->id;

        DocumentDetail::create([
            'document_id' => $request->document_id,
            'category' => $request->category,
            'name' => $request->name,
            'number' => $request->number,
            'upload_doc' => $path,
            'user_id' => $usr_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Document created successfully']);
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
