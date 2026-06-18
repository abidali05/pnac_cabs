<?php

namespace App\Services;

use App\Models\CertificationBodyApplication;
use App\Models\CertificationBodyApproval;
use App\Models\CertificationBodyStaff;
use App\Models\CertificationGeneral;
use App\Models\CertificationScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CertificationBodiesApplicationService
{
    public function saveBasicInfo(Request $request): CertificationGeneral
    {
        $data = Validator::make($request->all(), [
            'scheme' => 'required|string|max:255',
            'cab_name' => 'required|string|max:255',
            'address' => 'required|string',
            'telephone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'ntn_ftn' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'contact_name' => 'nullable|string|max:255',
            'contact_designation' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string',
            'contact_postcode' => 'nullable|string|max:100',
            'contact_tel' => 'nullable|string|max:100',
            'contact_fax' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:255',
            'sub_offices_details' => 'nullable|string',
        ])->validate();

        return DB::transaction(function () use ($request, $data) {
            $payload = [
                'scheme' => $data['scheme'],
                'cab_name' => $data['cab_name'],
                'address' => $data['address'],
                'telephone' => $data['telephone'],
                'email' => $data['email'],
                'ntn_ftn' => $data['ntn_ftn'] ?? '',
                'website' => $data['website'] ?? '',
                'city' => $data['city'],
                'country' => $data['country'],
                'postal_code' => $data['postal_code'] ?? '',
            ];

            $generalId = $request->input('general_id');
            if (!empty($generalId)) {
                $general = CertificationGeneral::where('id', $generalId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
                $general->fill($payload);
                $general->save();
            } else {
                $general = CertificationGeneral::create(array_merge($payload, [
                    'user_id' => Auth::id(),
                    'category' => 'Certification Bodies',
                    'application' => $request->input('application'),
                    'reference_no' => 'CAB-' . now()->format('Ymd') . rand(1000, 9999),
                ]));
            }

            CertificationBodyApplication::updateOrCreate(
                ['certification_general_id' => $general->id],
                [
                    'user_id' => Auth::id(),
                    'contact_name' => $data['contact_name'] ?? null,
                    'contact_designation' => $data['contact_designation'] ?? null,
                    'contact_address' => $data['contact_address'] ?? null,
                    'contact_postcode' => $data['contact_postcode'] ?? null,
                    'contact_tel' => $data['contact_tel'] ?? null,
                    'contact_fax' => $data['contact_fax'] ?? null,
                    'contact_email' => $data['contact_email'] ?? null,
                    'sub_offices_details' => $data['sub_offices_details'] ?? null,
                    'is_new_accreditation' => $request->boolean('is_new_accreditation'),
                    'is_extension_scope' => $request->boolean('is_extension_scope'),
                    'qms' => $request->boolean('qms'),
                    'ems' => $request->boolean('ems'),
                    'fsms' => $request->boolean('fsms'),
                    'iso_45001' => $request->boolean('iso_45001'),
                    'iso_13485' => $request->boolean('iso_13485'),
                    'other_management_system' => $request->boolean('other_management_system'),
                    'other_management_system_detail' => $request->input('other_management_system_detail'),
                    'enclosed_quality_manual' => $request->boolean('enclosed_quality_manual'),
                    'enclosed_quality_procedures' => $request->boolean('enclosed_quality_procedures'),
                    'enclosed_staff_list' => $request->boolean('enclosed_staff_list'),
                    'enclosed_certified_organizations' => $request->boolean('enclosed_certified_organizations'),
                    'enclosed_applicant_fee' => $request->boolean('enclosed_applicant_fee'),
                    'enclosed_legal_entity' => $request->boolean('enclosed_legal_entity'),
                    'enclosed_f0229_document_review' => $request->boolean('enclosed_f0229_document_review'),
                ]
            );

            return $general;
        });
    }

    public function saveAboutYourselves(Request $request, CertificationGeneral $general): void
    {
        $data = Validator::make($request->all(), [
            'director_name' => 'required|string|max:255',
            'director_position' => 'required|string|max:255',
            'consultant_email' => 'nullable|email|max:255',
        ])->validate();

        DB::transaction(function () use ($request, $general, $data) {
            CertificationBodyApplication::updateOrCreate(
                ['certification_general_id' => $general->id],
                array_merge($data, $request->only([
                    'director_title', 'parent_organization', 'parent_relationship', 'parent_address', 'parent_postcode', 'parent_tel',
                    'parent_fax', 'invoice_organisation', 'invoice_address', 'invoice_postcode', 'invoice_tel', 'invoice_fax',
                    'ownership_type', 'ownership_other', 'certification_main_activity', 'main_activity_description',
                    'consultant_name', 'consultant_organisation', 'consultant_address', 'consultant_postcode', 'consultant_tel', 'consultant_fax',
                ]), ['user_id' => Auth::id()])
            );
        });
    }

    public function saveStaff(Request $request, CertificationGeneral $general): void
    {
        Validator::make($request->all(), [
            'staff.*.*.name' => 'nullable|string|max:255',
            'staff.*.*.qualifications' => 'nullable|string|max:1000',
            'staff.*.*.relevant_experience' => 'nullable|string|max:1000',
            'staff.*.*.auditing_field' => 'nullable|string|max:255',
            'staff.*.*.audit_experience' => 'nullable|string|max:1000',
        ])->validate();

        DB::transaction(function () use ($request, $general) {
            CertificationBodyStaff::where('certification_general_id', $general->id)->delete();
            $staffData = $request->input('staff', []);

            foreach ($staffData as $staffType => $rows) {
                foreach ((array) $rows as $index => $row) {
                    if (empty($row['name']) && empty($row['qualifications'])) {
                        continue;
                    }
                    CertificationBodyStaff::create([
                        'certification_general_id' => $general->id,
                        'user_id' => Auth::id(),
                        'staff_type' => $staffType,
                        'name' => $row['name'] ?? null,
                        'qualifications' => $row['qualifications'] ?? null,
                        'relevant_experience' => $row['relevant_experience'] ?? null,
                        'auditing_field' => $row['auditing_field'] ?? null,
                        'audit_experience' => $row['audit_experience'] ?? null,
                        'sort_order' => (int) $index,
                    ]);
                }
            }
        });
    }

    public function saveScope(Request $request, CertificationGeneral $general): void
    {
        Validator::make($request->all(), [
            'scopes.*.*.description' => 'nullable|string',
            'scopes.*.*.iaf_code' => 'nullable|string|max:100',
            'scopes.*.*.technical_cluster_id' => 'nullable|integer',
            'scopes.*.*.cluster_id' => 'nullable|integer',
            'scopes.*.*.cluster_cat' => 'nullable|integer',
            'scopes.*.*.cluster_sub_cat' => 'nullable|integer',
            'scopes.*.*.main_technical_id' => 'nullable|integer',
            'scopes.*.*.technical_area' => 'nullable|integer',
        ])->validate();

        DB::transaction(function () use ($request, $general) {
            CertificationScope::where('certification_general_id', $general->id)
                ->where('category', 'Certification Bodies')
                ->delete();

            foreach ((array) $request->input('scopes', []) as $scopeType => $rows) {
                foreach ((array) $rows as $row) {
                    if (empty($row['description']) && empty($row['technical_cluster_id']) && empty($row['cluster_id']) && empty($row['main_technical_id'])) {
                        continue;
                    }

                    CertificationScope::create([
                        'certification_general_id' => $general->id,
                        'user_id' => Auth::id(),
                        'category' => 'Certification Bodies',
                        'scope_type' => $scopeType,
                        'technical_cluster_id' => $row['technical_cluster_id'] ?? null,
                        'iaf_code' => $row['iaf_code'] ?? null,
                        'description' => $row['description'] ?? null,
                        'cluster_id' => $row['cluster_id'] ?? null,
                        'cluster_cat' => $row['cluster_cat'] ?? null,
                        'cluster_sub_cat' => $row['cluster_sub_cat'] ?? null,
                        'main_technical_id' => $row['main_technical_id'] ?? null,
                        'technical_area' => $row['technical_area'] ?? null,
                    ]);
                }
            }
        });
    }

    public function saveQualitySystem(Request $request, CertificationGeneral $general): void
    {
        $data = Validator::make($request->all(), [
            'quality_system_complies' => 'nullable|in:yes,no',
            'non_compliance_area' => 'nullable|string',
            'rectified_by_date' => 'nullable|date',
        ])->validate();

        DB::transaction(function () use ($general, $data) {
            CertificationBodyApplication::updateOrCreate(
                ['certification_general_id' => $general->id],
                array_merge($data, ['user_id' => Auth::id()])
            );
        });
    }

    public function saveOtherApprovals(Request $request, CertificationGeneral $general): void
    {
        Validator::make($request->all(), [
            'approvals.*.start_date' => 'nullable|date',
            'approvals.*.expiry_date' => 'nullable|date',
            'approvals.*.approval_body_name_address' => 'nullable|string',
            'approvals.*.scope_certificate_no' => 'nullable|string|max:255',
        ])->after(function ($validator) use ($request) {
            foreach ((array) $request->input('approvals', []) as $i => $approval) {
                if (!empty($approval['start_date']) && !empty($approval['expiry_date']) && $approval['expiry_date'] < $approval['start_date']) {
                    $validator->errors()->add("approvals.$i.expiry_date", 'Expiry date must be after or equal to start date.');
                }
            }
        })->validate();

        DB::transaction(function () use ($request, $general) {
            CertificationBodyApproval::where('certification_general_id', $general->id)->delete();
            foreach ((array) $request->input('approvals', []) as $approval) {
                if (empty($approval['approval_body_name_address']) && empty($approval['scope_certificate_no'])) {
                    continue;
                }
                CertificationBodyApproval::create([
                    'certification_general_id' => $general->id,
                    'user_id' => Auth::id(),
                    'approval_body_name_address' => $approval['approval_body_name_address'] ?? null,
                    'scope_certificate_no' => $approval['scope_certificate_no'] ?? null,
                    'start_date' => $approval['start_date'] ?? null,
                    'expiry_date' => $approval['expiry_date'] ?? null,
                ]);
            }
        });
    }

    public function saveDeclaration(Request $request, CertificationGeneral $general): void
    {
        $data = Validator::make($request->all(), [
            'signed' => 'required|string|max:255',
            'signed_date' => 'required|date',
        ])->validate();

        DB::transaction(function () use ($request, $general, $data) {
            CertificationBodyApplication::updateOrCreate(
                ['certification_general_id' => $general->id],
                array_merge($data, $request->only([
                    'declaration_scope_applied',
                    'declaration_agreement',
                    'declaration_documents_enclosed',
                    'declaration_fee_enclosed',
                    'declaration_understands_system',
                    'declaration_information_correct',
                    'application_fee',
                ]), ['user_id' => Auth::id()])
            );
        });
    }
}
