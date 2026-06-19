<?php

namespace App\Http\Controllers\HalalCertification;

use App\Http\Controllers\Controller;
use App\Models\HcbApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HalalCertificationBodyController extends Controller
{
    // ── Entry point ──────────────────────────────────────────────────────────

    public function create(Request $request)
    {
        $application = HcbApplication::firstOrCreate(
            [
                'created_by'       => auth()->id(),
                'scheme_name'      => 'Halal Certification Bodies',
                'application_type' => $request->application ?: 'New Application',
                'status'           => 'Draft',
            ],
            ['application_no' => null]
        );

        $data = $this->loadData($application);

        return view('admin.application.halal_certification_bodies.index', compact('application', 'data'));
    }

    // ── Step 1: Basic Information ─────────────────────────────────────────────

    public function saveStep1(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $data = $request->validate([
            'organization_name' => 'required|string|max:255',
            'address'           => 'required|string',
            'postcode'          => 'nullable|string|max:50',
            'telephone'         => 'nullable|string|max:100',
            'fax'               => 'nullable|string|max:100',
            'contact_name'      => 'required|string|max:255',
            'designation'       => 'nullable|string|max:255',
            'contact_address'   => 'nullable|string',
            'contact_postcode'  => 'nullable|string|max:50',
            'contact_tel'       => 'nullable|string|max:100',
            'contact_fax'       => 'nullable|string|max:100',
            'contact_email'     => 'nullable|email|max:255',
            'halal_scope'       => 'nullable|string',
            'sub_offices'       => 'nullable|array',
        ]);

        $application->update(['organization_name' => $data['organization_name']]);

        DB::table('hcb_basic_information')->updateOrInsert(
            ['application_id' => $application->id],
            $this->ts([
                'organization_name'  => $data['organization_name'],
                'address'            => $data['address'],
                'postcode'           => $data['postcode'] ?? null,
                'telephone'          => $data['telephone'] ?? null,
                'fax'                => $data['fax'] ?? null,
                'contact_name'       => $data['contact_name'],
                'designation'        => $data['designation'] ?? null,
                'contact_address'    => $data['contact_address'] ?? null,
                'contact_postcode'   => $data['contact_postcode'] ?? null,
                'contact_tel'        => $data['contact_tel'] ?? null,
                'contact_fax'        => $data['contact_fax'] ?? null,
                'contact_email'      => $data['contact_email'] ?? null,
                'new_accreditation'  => $request->boolean('new_accreditation'),
                'extension_scope'    => $request->boolean('extension_scope'),
                'halal_scope'        => $data['halal_scope'] ?? null,
            ])
        );

        $this->replaceRows('hcb_sub_offices', $application->id, $data['sub_offices'] ?? []);

        return $this->response($request, 'Step 1 saved.', 'step1', $application);
    }

    // ── Step 2: About HCB ────────────────────────────────────────────────────

    public function saveStep2(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        DB::table('hcb_about_hcb')->updateOrInsert(
            ['application_id' => $application->id],
            $this->ts([
                'title'                 => $request->input('title'),
                'name'                  => $request->input('name'),
                'position'              => $request->input('position'),
                'parent_organization'   => $request->input('parent_organization'),
                'relationship'          => $request->input('relationship'),
                'parent_address'        => $request->input('parent_address'),
                'parent_postcode'       => $request->input('parent_postcode'),
                'parent_telephone'      => $request->input('parent_telephone'),
                'parent_fax'            => $request->input('parent_fax'),
                'invoice_organization'  => $request->input('invoice_organization'),
                'invoice_address'       => $request->input('invoice_address'),
                'invoice_postcode'      => $request->input('invoice_postcode'),
                'invoice_telephone'     => $request->input('invoice_telephone'),
                'invoice_fax'           => $request->input('invoice_fax'),
                'ownership_type'        => $request->input('ownership_type'),
                'other_description'     => $request->input('other_description'),
                'is_halal_main_activity'=> $request->input('is_halal_main_activity'),
                'activity_description'  => $request->input('activity_description'),
                'consultant_name'       => $request->input('consultant_name'),
                'consultant_organization'=> $request->input('consultant_organization'),
                'consultant_address'    => $request->input('consultant_address'),
                'consultant_postcode'   => $request->input('consultant_postcode'),
                'consultant_tel'        => $request->input('consultant_tel'),
                'consultant_fax'        => $request->input('consultant_fax'),
                'consultant_email'      => $request->input('consultant_email'),
            ])
        );

        return $this->response($request, 'Step 2 saved.', 'step2', $application);
    }

    // ── Step 3: Staff Information ─────────────────────────────────────────────

    public function saveStep3(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $staffCols = ['name', 'religion', 'qualification', 'experience'];
        $auditorCols = ['name', 'religion', 'qualification', 'auditing_field', 'audit_experience'];

        $this->replaceRows('hcb_chief_executives', $application->id, $request->input('chief_executives', []), $staffCols);
        $this->replaceRows('hcb_shariah_experts', $application->id, $request->input('shariah_experts', []), $staffCols);
        $this->replaceRows('hcb_quality_management_representatives', $application->id, $request->input('quality_reps', []), $staffCols);
        $this->replaceRows('hcb_management_members', $application->id, $request->input('management_members', []), $staffCols);
        $this->replaceRows('hcb_permanent_auditors', $application->id, $request->input('permanent_auditors', []), $auditorCols);
        $this->replaceRows('hcb_external_auditors', $application->id, $request->input('external_auditors', []), $auditorCols);

        return $this->response($request, 'Step 3 saved.', 'step3', $application);
    }

    // ── Step 4: Scope of Application ─────────────────────────────────────────

    public function saveStep4(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $this->replaceRows('hcb_scopes', $application->id, $request->input('scopes', []),
            ['category_code', 'category', 'subcategory', 'included_activities']);

        return $this->response($request, 'Step 4 saved.', 'step4', $application);
    }

    // ── Step 5: Quality System ────────────────────────────────────────────────

    public function saveStep5(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        // Replace all quality system answers
        DB::table('hcb_quality_system')->where('application_id', $application->id)->delete();

        $answers = $request->input('qs', []);
        foreach ($answers as $code => $item) {
            DB::table('hcb_quality_system')->insert($this->ts([
                'application_id' => $application->id,
                'question_code'  => $code,
                'answer'         => $item['answer'] ?? null,
                'comments'       => $item['comments'] ?? null,
            ]));
        }

        // Non-compliance rows
        $complies = $request->input('complies', 'yes');
        if ($complies === 'no') {
            $this->replaceRows('hcb_non_compliances', $application->id, $request->input('non_compliances', []),
                ['area_of_non_compliance', 'rectified_by_date']);
        } else {
            DB::table('hcb_non_compliances')->where('application_id', $application->id)->delete();
        }

        return $this->response($request, 'Step 5 saved.', 'step5', $application);
    }

    // ── Step 6: Other Approvals ───────────────────────────────────────────────

    public function saveStep6(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $this->replaceRows('hcb_other_approvals', $application->id, $request->input('other_approvals', []),
            ['approval_body_name', 'approval_body_address', 'scope', 'certificate_number', 'start_date', 'expiry_date']);

        return $this->response($request, 'Step 6 saved.', 'step6', $application);
    }

    // ── Step 7: Declaration & Submit ─────────────────────────────────────────

    public function saveStep7(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $data = $request->validate([
            'halal_scope'             => 'nullable|in:1',
            'extension_scope'         => 'nullable|in:1',
            'quality_manual_confirmed'=> 'nullable|in:1',
            'applicant_fee_amount'    => 'nullable|string|max:100',
            'declaration_accepted'    => 'nullable|accepted',
            'signed_by'               => 'nullable|string|max:255',
            'signed_date'             => 'nullable|date',
            'final_submit'            => 'nullable|in:1',
        ]);

        DB::table('hcb_declarations')->updateOrInsert(
            ['application_id' => $application->id],
            $this->ts([
                'halal_scope'              => $request->boolean('halal_scope'),
                'extension_scope'          => $request->boolean('extension_scope'),
                'quality_manual_confirmed' => $request->boolean('quality_manual_confirmed'),
                'applicant_fee_amount'     => $data['applicant_fee_amount'] ?? null,
                'declaration_accepted'     => $request->boolean('declaration_accepted'),
                'signed_by'                => $data['signed_by'] ?? null,
                'signed_date'              => $data['signed_date'] ?? null,
            ])
        );

        if (! empty($data['final_submit'])) {
            $this->validateSubmission($application);
            $application->update([
                'status'         => 'Submitted',
                'submitted_at'   => now(),
                'application_no' => $application->application_no
                    ?: 'HCB-' . now()->format('Ymd') . '-' . $application->id,
            ]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success'      => true,
                    'message'      => 'Application submitted successfully.',
                    'redirect_url' => route('application.index'),
                ]);
            }

            return redirect()->route('application.index')
                ->with('success', 'HCB Application submitted successfully.');
        }

        return $this->response($request, 'Step 7 saved.', 'step7', $application);
    }

    // ── Documents ─────────────────────────────────────────────────────────────

    public function uploadDocument(Request $request, HcbApplication $application)
    {
        $this->guard($application);

        $data = $request->validate([
            'document_type' => 'required|string|max:100',
            'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $existing = DB::table('hcb_documents')
            ->where('application_id', $application->id)
            ->where('document_type', $data['document_type'])
            ->first();

        if ($existing && Storage::disk('public')->exists($existing->file_path)) {
            Storage::disk('public')->delete($existing->file_path);
        }

        $file     = $request->file('document_file');
        $safeType = Str::slug($data['document_type']);
        $fileName = $safeType . '_' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs(
            "applications/halal-certification-bodies/{$application->id}/{$safeType}",
            $fileName,
            'public'
        );

        DB::table('hcb_documents')->updateOrInsert(
            ['application_id' => $application->id, 'document_type' => $data['document_type']],
            [
                'file_name'     => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_path'     => $path,
                'mime_type'     => $file->getMimeType(),
                'uploaded_by'   => auth()->id(),
                'updated_at'    => now(),
                'created_at'    => $existing->created_at ?? now(),
            ]
        );

        return back()->with('success', 'Document uploaded.')->with('open_section', 'documents');
    }

    public function deleteDocument(HcbApplication $application, int $document)
    {
        $this->guard($application);

        $row = DB::table('hcb_documents')
            ->where('application_id', $application->id)
            ->where('id', $document)
            ->first();

        if ($row && Storage::disk('public')->exists($row->file_path)) {
            Storage::disk('public')->delete($row->file_path);
        }

        DB::table('hcb_documents')->where('id', $document)->delete();

        return back()->with('success', 'Document deleted.')->with('open_section', 'documents');
    }

    // ── Load all data for view ────────────────────────────────────────────────

    public function loadData(HcbApplication $application): array
    {
        $basicInfo    = DB::table('hcb_basic_information')->where('application_id', $application->id)->first();
        $subOffices   = DB::table('hcb_sub_offices')->where('application_id', $application->id)->get();
        $aboutHcb     = DB::table('hcb_about_hcb')->where('application_id', $application->id)->first();
        $chiefExecs   = DB::table('hcb_chief_executives')->where('application_id', $application->id)->get();
        $shariahExp   = DB::table('hcb_shariah_experts')->where('application_id', $application->id)->get();
        $qualityReps  = DB::table('hcb_quality_management_representatives')->where('application_id', $application->id)->get();
        $mgmtMembers  = DB::table('hcb_management_members')->where('application_id', $application->id)->get();
        $permAuditors = DB::table('hcb_permanent_auditors')->where('application_id', $application->id)->get();
        $extAuditors  = DB::table('hcb_external_auditors')->where('application_id', $application->id)->get();
        $scopes       = DB::table('hcb_scopes')->where('application_id', $application->id)->get();
        $qs           = DB::table('hcb_quality_system')->where('application_id', $application->id)->get()->keyBy('question_code');
        $nonComply    = DB::table('hcb_non_compliances')->where('application_id', $application->id)->get();
        $approvals    = DB::table('hcb_other_approvals')->where('application_id', $application->id)->get();
        $declaration  = DB::table('hcb_declarations')->where('application_id', $application->id)->first();
        $documents    = DB::table('hcb_documents')->where('application_id', $application->id)->get();

        return [
            'basic_info'     => $basicInfo,
            'sub_offices'    => $subOffices,
            'about_hcb'      => $aboutHcb,
            'chief_execs'    => $chiefExecs,
            'shariah_experts'=> $shariahExp,
            'quality_reps'   => $qualityReps,
            'mgmt_members'   => $mgmtMembers,
            'perm_auditors'  => $permAuditors,
            'ext_auditors'   => $extAuditors,
            'scopes'         => $scopes,
            'quality_system' => $qs,
            'non_compliances'=> $nonComply,
            'other_approvals'=> $approvals,
            'declaration'    => $declaration,
            'documents'      => $documents,
            'saved_sections' => [
                'step1' => (bool) $basicInfo,
                'step2' => (bool) $aboutHcb,
                'step3' => $chiefExecs->isNotEmpty() || $shariahExp->isNotEmpty() || $qualityReps->isNotEmpty(),
                'step4' => $scopes->isNotEmpty(),
                'step5' => $qs->isNotEmpty(),
                'step6' => $approvals->isNotEmpty(),
                'step7' => (bool) $declaration,
                'documents' => $documents->isNotEmpty(),
            ],
        ];
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function guard(HcbApplication $application): void
    {
        abort_unless($application->created_by === auth()->id(), 403);
        abort_if($application->status === 'Submitted', 403, 'Submitted applications cannot be edited.');
    }

    private function replaceRows(string $table, int $appId, array $rows, array $allowed = []): void
    {
        DB::table($table)->where('application_id', $appId)->delete();
        foreach ($rows as $row) {
            if ($allowed) {
                $row = array_intersect_key($row, array_flip($allowed));
            }
            $row = array_filter($row, fn ($v) => $v !== null && $v !== '');
            if (! $row) {
                continue;
            }
            DB::table($table)->insert($this->ts(array_merge($row, ['application_id' => $appId])));
        }
    }

    private function ts(array $data): array
    {
        return array_merge($data, ['created_at' => now(), 'updated_at' => now()]);
    }

    private function response(Request $request, string $message, string $section, HcbApplication $application)
    {
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'open_section' => $section]);
        }

        return redirect()->route('hcb.create', [
            'scheme_name' => 'Halal Certification Bodies',
            'application' => $application->application_type,
        ])->with('success', $message)->with('open_section', $section);
    }

    private function validateSubmission(HcbApplication $application): void
    {
        $hasBasic = DB::table('hcb_basic_information')->where('application_id', $application->id)->exists();
        $hasDecl  = DB::table('hcb_declarations')
            ->where('application_id', $application->id)
            ->where('declaration_accepted', true)
            ->exists();

        $missing = [];
        if (! $hasBasic) $missing[] = 'Step 1 (Basic Information)';
        if (! $hasDecl)  $missing[] = 'Step 7 (Declaration - must be accepted)';

        if ($missing) {
            abort(422, 'Complete before submission: ' . implode(', ', $missing));
        }
    }
}
