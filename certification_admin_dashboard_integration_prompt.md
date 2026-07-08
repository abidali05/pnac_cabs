# Developer Prompt: Certification Bodies Admin Dashboard Integration

Use this prompt/guide to implement the admin dashboard listing ("All Applications") and the section-by-section dynamic "View Application" mode for the **Certification Bodies** scheme.

---

## 1. Database Schema & Data Mapping (Where Data is Stored)

For any application under the **Certification Bodies** scheme, data is stored across the following tables:

*   **`cb_applications`**: The primary record representing the application.
    *   *Fields:* `id`, `application_no`, `scheme_name`, `application_type`, `status`, `submitted_at`, `created_by`, `certification_general_id`.
*   **`certification_generals`**: Holds the basic application details (e.g. CAB Name, Address, NTN/FTN, etc.).
    *   *Linkage:* Linked to `cb_applications.certification_general_id`.
    *   *Fields:* `cab_name`, `address`, `postal_code`, `telephone`, `email`, `ntn_ftn`, `website`, `city`, `country`.
*   **`cb_contacts`**: Information about key contact persons.
*   **`cb_sub_offices`**: Details of any sub-offices.
*   **`cb_requested_scopes`**: Scopes requested for accreditation.
*   **`cb_documents`**: Files uploaded for the application.
*   **`cb_authorized_persons`**: Information of authorized representatives.
*   **`cb_parent_organizations`**: Relationship details with parent/related bodies.
*   **`cb_invoice_addresses`**: Billing and invoicing address information.
*   **`cb_consultants`**: Details of any consultants involved.
*   **`cb_staff_roles`**: List of personnel roles.
*   **`cb_management_members`**: Management and committee members.
*   **`cb_permanent_auditors`**: Permanent auditing staff list.
*   **`cb_freelance_auditors`**: Contractual/freelance auditors list.
*   **`cb_qms_scopes`**, **`cb_ems_scopes`**, **`cb_ohs_scopes`**, **`cb_fsms_scopes`**, **`cb_mdqms_scopes`**, **`cb_isms_scopes`**: Dynamic scopes of different standard systems.
*   **`cb_non_compliance`**: Non-compliance declarations.
*   **`cb_declarations`**: Final declarations, signatures, and agreement dates.

---

## 2. Part A: Integrating into the "All Applications" Listing
In the admin listing controller action (which lists all submitted applications across different schemes), pull submitted applications from `cb_applications` and merge them.

### Controller Logic:
Add `CbApplication` to your collection retrieval logic:
```php
$cbApplications = CbApplication::where('status', 'submitted')
    ->with('certificationGeneral')
    ->get()
    ->map(function ($item) {
        $general = $item->certificationGeneral;
        return [
            'id' => $item->id,
            'cab_name' => $general->cab_name ?? $item->organization_name ?? 'N/A',
            'address' => $general->address ?? 'N/A',
            'telephone' => $general->telephone ?? 'N/A',
            'email' => $general->email ?? 'N/A',
            'city' => $general->city ?? 'N/A',
            'created_at' => $item->created_at->format('Y-m-d H:i'),
            'category' => 'Certification Bodies',
            'application' => $item->application_type,
            'status' => $item->status,
        ];
    });
```

Merge `$cbApplications` with other schemes (e.g. testing, medical, inspection) in the view-rendering controller method.

---

## 3. Part B: Action Button Target
In the view page `submited_index.blade.php`, ensure the view button uses the correct route to dynamically render Certification Bodies:
```html
<a href="{{ route('admin.application.cb.view', $application->id) }}" class="btn btn-success btn-sm">
    View
</a>
```

---

## 4. Part C: View Action Controller Method
Define a controller method `viewSubmitedCbApplication` to load all schema sections dynamically:

```php
public function viewSubmitedCbApplication($id)
{
    $cbApplication = CbApplication::findOrFail($id);
    $general = $cbApplication->certificationGeneral;
    
    // Fetch schema configuration from application_forms table
    $form = DB::table('application_forms')
        ->where('slug', 'certification-bodies')
        ->first();
        
    $formScheme = json_decode($form->form_scheme, true);

    // Fetch related tables data
    $cbData = [
        'contact' => DB::table('cb_contacts')->where('application_id', $id)->first(),
        'sub_offices' => DB::table('cb_sub_offices')->where('application_id', $id)->get(),
        'requested_scopes' => DB::table('cb_requested_scopes')->where('application_id', $id)->get(),
        'documents' => DB::table('cb_documents')->where('application_id', $id)->get(),
        'authorized_person' => DB::table('cb_authorized_persons')->where('application_id', $id)->first(),
        'parent_organization' => DB::table('cb_parent_organizations')->where('application_id', $id)->first(),
        'invoice_address' => DB::table('cb_invoice_addresses')->where('application_id', $id)->first(),
        'consultant' => DB::table('cb_consultants')->where('application_id', $id)->first(),
        'staff_roles' => DB::table('cb_staff_roles')->where('application_id', $id)->get(),
        'management_members' => DB::table('cb_management_members')->where('application_id', $id)->get(),
        'permanent_auditors' => DB::table('cb_permanent_auditors')->where('application_id', $id)->get(),
        'freelance_auditors' => DB::table('cb_freelance_auditors')->where('application_id', $id)->get(),
        'qms_scopes' => DB::table('cb_qms_scopes')->where('application_id', $id)->get(),
        'ems_scopes' => DB::table('cb_ems_scopes')->where('application_id', $id)->get(),
        'ohs_scopes' => DB::table('cb_ohs_scopes')->where('application_id', $id)->get(),
        'fsms_scopes' => DB::table('cb_fsms_scopes')->where('application_id', $id)->get(),
        'mdqms_scopes' => DB::table('cb_mdqms_scopes')->where('application_id', $id)->get(),
        'isms_scopes' => DB::table('cb_isms_scopes')->where('application_id', $id)->get(),
        'non_compliance' => DB::table('cb_non_compliance')->where('application_id', $id)->first(),
        'declaration' => DB::table('cb_declarations')->where('application_id', $id)->first(),
    ];

    return view('admin.application.certification_bodies.view_submited', compact('cbApplication', 'general', 'formScheme', 'cbData'));
}
```

---

## 5. Part D: Dynamic Section-by-Section View Blade (`view_submited.blade.php`)

Create `resources/views/admin/application/certification_bodies/view_submited.blade.php` to dynamically iterate through schema sections and show database values side-by-side:

```html
@extends('admin.layouts.adminlayout')
@section('main-content')
<div class="main-content">
    <section class="section">
        <div class="section-header d-flex justify-content-between">
            <h1>View Certification Body Application - {{ $cbApplication->application_no }}</h1>
            <a href="{{ route('application.submited.index') }}" class="btn btn-primary">Back to Listing</a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Sections</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column" id="sectionTabs" role="tablist">
                            @foreach ($formScheme as $index => $section)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                       id="tab-{{ $index }}" 
                                       data-toggle="tab" 
                                       href="#sec-{{ $index }}" 
                                       role="tab">
                                        {{ $section['section_name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                <div class="tab-content" id="sectionTabContent">
                    @foreach ($formScheme as $index => $section)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}" 
                             id="sec-{{ $index }}" 
                             role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ $section['section_name'] }}</h4>
                                </div>
                                <div class="card-body">
                                    @php
                                        // Retrieve variables based on the section structure
                                        // 1. Basic Application Information mapping
                                        if ($section['section_name'] === 'Basic Application Information') {
                                            $dataMapping = [
                                                'Scheme Name' => $cbApplication->scheme_name,
                                                'Application Type' => $cbApplication->application_type,
                                                'Application Number' => $cbApplication->application_no,
                                                'Status' => $cbApplication->status,
                                                'CAB Name' => $general->cab_name ?? '-',
                                                'Address' => $general->address ?? '-',
                                                'Postcode' => $general->postal_code ?? '-',
                                                'Telephone' => $general->telephone ?? '-',
                                                'Email' => $general->email ?? '-',
                                                'NTN/FTN' => $general->ntn_ftn ?? '-',
                                                'Website' => $general->website ?? '-',
                                                'City' => $general->city ?? '-',
                                                'Country' => $general->country ?? '-',
                                            ];
                                        }
                                        // 2. About Yourselves mapping
                                        elseif ($section['section_name'] === 'About Yourselves') {
                                            $auth = $cbData['authorized_person'];
                                            $parent = $cbData['parent_organization'];
                                            $invoice = $cbData['invoice_address'];
                                            $consultant = $cbData['consultant'];
                                            
                                            $dataMapping = [
                                                'Authorized Person Name' => $auth->name ?? '-',
                                                'Authorized Person Designation' => $auth->designation ?? '-',
                                                'Authorized Person Address' => $auth->address ?? '-',
                                                'Parent Organization Name' => $parent->parent_organization_name ?? '-',
                                                'Invoicing Org Name' => $invoice->invoice_organization_name ?? '-',
                                                'Invoicing Address' => $invoice->address ?? '-',
                                                'Consultant Name' => $consultant->consultant_name ?? '-',
                                                'Consultant Organization' => $consultant->organization ?? '-',
                                            ];
                                        }
                                        // 3. Staff Information
                                        elseif ($section['section_name'] === 'About Staff') {
                                            $dataMapping = null; // Shown in sub-tables below
                                        }
                                        // Default fallback or general mappings
                                        else {
                                            $dataMapping = null;
                                        }
                                    @endphp

                                    @if ($dataMapping)
                                        <div class="row">
                                            @foreach ($dataMapping as $label => $val)
                                                <div class="col-md-6 mb-3">
                                                    <strong class="text-muted">{{ $label }}:</strong>
                                                    <div class="mt-1 text-dark font-weight-bold">{{ $val }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Render Sub tables/Repeatable items dynamically based on section name -->
                                    @if ($section['section_name'] === 'About Staff')
                                        <h5>Staff Roles</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr><th>Name</th><th>Designation</th><th>Role/Responsibility</th></tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($cbData['staff_roles'] as $staff)
                                                        <tr>
                                                            <td>{{ $staff->name }}</td>
                                                            <td>{{ $staff->designation }}</td>
                                                            <td>{{ $staff->role_description }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="3" class="text-center">No record found</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($section['section_name'] === 'Requested Scope of Accreditation')
                                        <h5>Accreditation Scopes</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr><th>Standard Scheme</th><th>Scope Category</th><th>Auditors Count</th></tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($cbData['requested_scopes'] as $scope)
                                                        <tr>
                                                            <td>{{ $scope->standard_scheme }}</td>
                                                            <td>{{ $scope->category_name }}</td>
                                                            <td>{{ $scope->auditors_count }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="3" class="text-center">No scope registered</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
```
