<?php

namespace App\Http\Controllers\CertificationBodies;

use App\Http\Controllers\Controller;
use App\Models\InspectionBodyApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InspectionBodyController extends Controller
{
    public function create(Request $request)
    {
        $application = InspectionBodyApplication::firstOrCreate(
            [
                'created_by' => auth()->id(),
                'scheme_name' => 'Inspection Bodies',
                'application_type' => $request->application ?: 'New Application',
                'status' => 'Draft',
            ],
            ['application_no' => null]
        );

        $data = $this->loadData($application);

        return view('application.certification_bodies.inspection_body.index', compact('application', 'data'));
    }

    public function saveStep1(Request $request, InspectionBodyApplication $application)
    {
        $this->guardApplication($application);

        $data = $request->validate([
            'inspection_body_name' => 'required|string|max:255',
            'address' => 'required|string',
            // 'postcode'                 => 'nullable|string|max:50',
            // 'telephone'                => 'nullable|string|max:100',
            // 'fax'                      => 'nullable|string|max:100',
            // 'contact_name'             => 'required|string|max:255',
            // 'designation'              => 'nullable|string|max:255',
            // 'contact_address'          => 'nullable|string',
            // 'contact_postcode'         => 'nullable|string|max:50',
            // 'contact_tel'              => 'nullable|string|max:100',
            // 'contact_fax'              => 'nullable|string|max:100',
            // 'contact_email'            => 'nullable|email|max:255',
            // 'office_details'           => 'nullable|string',
            // 'new_accreditation'        => 'nullable|in:1',
            // 'extension_scope'          => 'nullable|in:1',
            'parent_organization' => 'nullable|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'parent_address' => 'nullable|string',
            'parent_postcode' => 'nullable|string|max:50',
            'parent_tel' => 'nullable|string|max:100',
            'parent_fax' => 'nullable|string|max:100',
            'invoice_organization' => 'nullable|string|max:255',
            'invoice_address' => 'nullable|string',
            'invoice_postcode' => 'nullable|string|max:50',
            'invoice_tel' => 'nullable|string|max:100',
            'invoice_fax' => 'nullable|string|max:100',
            'date_of_establishment' => 'nullable|date',
            'legal_status' => 'nullable|string|max:255',
            'outside_pakistan' => 'nullable|in:yes,no',
            'countries_description' => 'nullable|string',
            'inspection_main_activity' => 'nullable|in:yes,no',
            'activity_description' => 'nullable|string',
            'body_type' => 'nullable|in:Type A,Type B,Type C',
            'consultant_name' => 'nullable|string|max:255',
            'consultant_organization' => 'nullable|string|max:255',
            'consultant_address' => 'nullable|string',
            'consultant_postcode' => 'nullable|string|max:50',
            'consultant_tel' => 'nullable|string|max:100',
            'consultant_fax' => 'nullable|string|max:100',
            'consultant_email' => 'nullable|email|max:255',
        ]);

        DB::table('inspection_body_organizations')->updateOrInsert(
            ['application_id' => $application->id],
            $this->timestamps(array_merge($data, [
                'new_accreditation' => $request->has('new_accreditation') ? 1 : 0,
                'extension_scope' => $request->has('extension_scope') ? 1 : 0,
            ]))
        );

        return $this->sectionResponse($request, 'Step 1 saved.', 'step1', $application);
    }

    public function saveStep2(Request $request, InspectionBodyApplication $application)
    {
        $this->guardApplication($application);

        $data = $request->validate([
            'chief_executive' => 'nullable|array',
            'quality_representative' => 'nullable|array',
            'management_members' => 'nullable|array',
            'permanent_inspectors' => 'nullable|array',
            'freelance_inspectors' => 'nullable|array',
        ]);

        DB::table('inspection_body_staff')->where('application_id', $application->id)->delete();
        foreach ([
            'chief_executive' => 'Chief Executive',
            'quality_representative' => 'Quality Management Representative',
        ] as $key => $role) {
            foreach ($data[$key] ?? [] as $row) {
                if (! array_filter($row)) {
                    continue;
                }
                DB::table('inspection_body_staff')->insert(
                    $this->timestamps(array_merge($row, ['application_id' => $application->id, 'role' => $role]))
                );
            }
        }
        foreach ($data['management_members'] ?? [] as $row) {
            $row = array_filter($row, fn ($v) => $v !== null && $v !== '');
            if ($row) {
                DB::table('inspection_body_staff')->insert(
                    $this->timestamps(array_merge($row, ['application_id' => $application->id, 'role' => 'Management Member']))
                );
            }
        }

        $this->replaceRows('inspection_body_inspectors', $application->id, $data['permanent_inspectors'] ?? []);
        $this->replaceRows('inspection_body_freelance_inspectors', $application->id, $data['freelance_inspectors'] ?? []);

        return $this->sectionResponse($request, 'Step 2 saved.', 'step2', $application);
    }

    public function saveStep3(Request $request, InspectionBodyApplication $application)
    {
        $this->guardApplication($application);

        $data = $request->validate([
            'scopes' => 'nullable|array',
            'equipment' => 'nullable|array',
        ]);

        $this->replaceRows('inspection_body_scopes', $application->id, $data['scopes'] ?? []);
        $this->replaceRows('inspection_body_equipment', $application->id, $data['equipment'] ?? []);

        return $this->sectionResponse($request, 'Step 3 saved.', 'step3', $application);
    }

    public function saveStep4(Request $request, InspectionBodyApplication $application)
    {
        $this->guardApplication($application);

        $data = $request->validate([
            'type_a' => 'nullable|in:1',
            'type_b' => 'nullable|in:1',
            'type_c' => 'nullable|in:1',
            'iso17020_compliance' => 'nullable|in:1',
            'assessment_understanding' => 'nullable|in:1',
            'agreement_acceptance' => 'nullable|in:1',
            'quality_manual_attached' => 'nullable|in:1',
            'document_review_attached' => 'nullable|in:1',
            'applicant_fee' => 'nullable|string|max:100',
            'declaration_name' => 'nullable|string|max:255',
            'declaration_date' => 'nullable|date',
            'final_submit' => 'nullable|in:1',
        ]);

        DB::table('inspection_body_declarations')->updateOrInsert(
            ['application_id' => $application->id],
            $this->timestamps([
                'type_a' => $request->boolean('type_a'),
                'type_b' => $request->boolean('type_b'),
                'type_c' => $request->boolean('type_c'),
                'iso17020_compliance' => $request->boolean('iso17020_compliance'),
                'assessment_understanding' => $request->boolean('assessment_understanding'),
                'agreement_acceptance' => $request->boolean('agreement_acceptance'),
                'quality_manual_attached' => $request->boolean('quality_manual_attached'),
                'document_review_attached' => $request->boolean('document_review_attached'),
                'applicant_fee' => $data['applicant_fee'] ?? null,
                'declaration_name' => $data['declaration_name'] ?? null,
                'declaration_date' => $data['declaration_date'] ?? null,
            ])
        );

        if (! empty($data['final_submit'])) {
            $this->validateFinalSubmission($application);
            $application->update([
                'status' => 'Submitted',
                'submitted_at' => now(),
                'application_no' => $application->application_no ?: 'IB-'.now()->format('Ymd').'-'.$application->id,
            ]);

            return $this->sectionResponse($request, 'Application submitted successfully.', 'step4', $application);
        }

        return $this->sectionResponse($request, 'Step 4 saved.', 'step4', $application);
    }

    // public function uploadDocument(Request $request, InspectionBodyApplication $application)
    // {
    //     $this->guardApplication($application);

    //     $data = $request->validate([
    //         'document_type' => 'required|string|max:100',
    //         'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
    //     ]);

    //     $existing = DB::table('inspection_body_documents')
    //         ->where('application_id', $application->id)
    //         ->where('document_type', $data['document_type'])
    //         ->first();

    //     if ($existing && Storage::disk('public')->exists($existing->file_path)) {
    //         Storage::disk('public')->delete($existing->file_path);
    //     }

    //     $file = $request->file('document_file');
    //     $safeType = Str::slug($data['document_type']);
    //     $fileName = $safeType.'_'.now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
    //     $path = $file->storeAs("applications/inspection-body/{$application->id}/{$safeType}", $fileName, 'public');

    //     DB::table('inspection_body_documents')->updateOrInsert(
    //         ['application_id' => $application->id, 'document_type' => $data['document_type']],
    //         [
    //             'file_name' => $fileName,
    //             'original_name' => $file->getClientOriginalName(),
    //             'file_path' => $path,
    //             'mime_type' => $file->getMimeType(),
    //             'uploaded_by' => auth()->id(),
    //             'updated_at' => now(),
    //             'created_at' => $existing->created_at ?? now(),
    //         ]
    //     );

    //     return back()->with('success', 'Document uploaded.')->with('open_section', 'documents');
    // }

    // public function deleteDocument(InspectionBodyApplication $application, int $document)
    // {
    //     $this->guardApplication($application);

    //     $row = DB::table('inspection_body_documents')
    //         ->where('application_id', $application->id)
    //         ->where('id', $document)
    //         ->first();

    //     if ($row && Storage::disk('public')->exists($row->file_path)) {
    //         Storage::disk('public')->delete($row->file_path);
    //     }

    //     DB::table('inspection_body_documents')->where('id', $document)->delete();

    //     return back()->with('success', 'Document deleted.')->with('open_section', 'documents');
    // }

    // ─── Private helpers ────────────────────────────────────────────────────────

    private function guardApplication(InspectionBodyApplication $application): void
    {
        abort_unless($application->created_by === auth()->id(), 403);
        abort_if($application->status === 'Submitted', 403, 'Submitted applications cannot be edited.');
    }

    public function loadData(InspectionBodyApplication $application): array
    {
        $org = DB::table('inspection_body_organizations')->where('application_id', $application->id)->first();
        $staffRoles = DB::table('inspection_body_staff')->where('application_id', $application->id)->get()->groupBy('role');
        $mgmtMembers = DB::table('inspection_body_staff')->where('application_id', $application->id)->where('role', 'Management Member')->get();
        $inspectors = DB::table('inspection_body_inspectors')->where('application_id', $application->id)->get();
        $freelance = DB::table('inspection_body_freelance_inspectors')->where('application_id', $application->id)->get();
        $scopes = DB::table('inspection_body_scopes')->where('application_id', $application->id)->get();
        $equipment = DB::table('inspection_body_equipment')->where('application_id', $application->id)->get();
        $declaration = DB::table('inspection_body_declarations')->where('application_id', $application->id)->first();
        // $documents = DB::table('inspection_body_documents')->where('application_id', $application->id)->get();

        return [
            'organization' => $org,
            'staff_roles' => $staffRoles,
            'mgmt_members' => $mgmtMembers,
            'inspectors' => $inspectors,
            'freelance' => $freelance,
            'scopes' => $scopes,
            'equipment' => $equipment,
            'declaration' => $declaration,
            // 'documents' => $documents,
            'saved_sections' => [
                'step1' => (bool) $org,
                'step2' => $staffRoles->isNotEmpty() || $inspectors->isNotEmpty(),
                'step3' => $scopes->isNotEmpty() || $equipment->isNotEmpty(),
                'step4' => (bool) $declaration,
                // 'documents' => $documents->isNotEmpty(),
            ],
        ];
    }

    private function validateFinalSubmission(InspectionBodyApplication $application): void
    {
        // $requiredDocs = [
        //     'Quality Manual',
        //     'F-02/30 Document Review',
        //     'Fee Evidence',
        // ];

        // $uploaded = DB::table('inspection_body_documents')->where('application_id', $application->id)->pluck('document_type')->all();
        // $missingDocs = array_diff($requiredDocs, $uploaded);

        $hasOrg = DB::table('inspection_body_organizations')->where('application_id', $application->id)->exists();
        $hasDecl = DB::table('inspection_body_declarations')
            ->where('application_id', $application->id)
            ->where('agreement_acceptance', true)
            ->exists();

        $missing = [];
        if (! $hasOrg) {
            $missing[] = 'Step 1 (Organization Details)';
        }
        if (! $hasDecl) {
            $missing[] = 'Step 4 (Declaration with agreement acceptance)';
        }

        // if ($missing || $missingDocs) {
        //     abort(422, 'Complete missing sections/documents: '.implode(', ', array_merge($missing, $missingDocs)));
        // }
    }

    private function replaceRows(string $table, int $applicationId, array $rows): void
    {
        DB::table($table)->where('application_id', $applicationId)->delete();
        foreach ($rows as $row) {
            $row = array_filter($row, fn ($v) => $v !== null && $v !== '');
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

    private function sectionResponse(Request $request, string $message, string $section, InspectionBodyApplication $application)
    {
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'open_section' => $section]);
        }

        return redirect()->route('inspection-body.create', [
            'scheme_name' => 'Inspection Bodies',
            'application' => $application->application_type,
        ])->with('success', 'Inspection Body Application submitted successfully.')->with('open_section', $section);
    }
}
