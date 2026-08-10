# Developer Prompt: Certification Bodies Admin Dashboard Integration

Use this prompt/guide to implement the admin dashboard listing ("All Applications") and the section-by-section dynamic "View Application" mode for the **Certification Bodies** scheme.

---

## 1. Context & Database Overview

The Certification Bodies scheme uses a combination of `CertificationGeneral` (for Step 1 basic info) and its own custom tables (for subsequent steps).

* **Master Table:** `cb_applications` (Model: `CbApplication`)
  * Stores `id`, `application_no`, `scheme_name`, `application_type`, `status` (e.g. `'Submitted'`, `'Draft'`), `submitted_at`, and `created_by`.
* **Step-by-step Data Tables (linked via `application_id` except for Step 1):**
  1. **Step 1:** `certification_generals` (represented by `session('application_id')` or via matching user & category) - stores CAB Name, Address, postcode, tel, email, NTN/FTN, website, city, country.
  2. **Step 2:** `cb_contacts` (authorized contact person details).
  3. **Step 3 (About Yourselves):** `cb_parent_organizations` (parent company details), `cb_invoice_addresses` (billing info), and `cb_consultants` (consultant details).
  4. **Step 4 (Staff Info):** `cb_staff_roles` (CE, QMR, Management, and Auditors/Assessors).
  5. **Step 5 (Scope):** `cb_requested_scopes` (IAF codes, technical sectors, clusters, standards).
  6. **Step 6 (Quality System):** `cb_quality_systems` (compliance details).
  7. **Step 7 (Other Approvals):** `cb_approvals` (other accreditations held).
  8. **Step 8 (Declaration):** `cb_declarations` (fee amount, signatures, agreements).

---

## 2. Step-by-Step Implementation Guide

### Task 2.1: Update the Dashboard Listing Controller

Update `submitedApplication` in `app/Http/Controllers/admin/ApplicationController.php` to fetch legacy `CertificationGeneral` submissions, Halal (`hcb_applications`), Inspection (`inspection_body_applications`), Medical Lab (`mlab_applications`), and now **Certification Bodies** applications (`cb_applications` where status is `'Submitted'`), merging them into a unified list.

**Example Code:**
```php
public function submitedApplication()
{
    // 1. Fetch submitted certification general applications
    $certifications = CertificationGeneral::with('application_statuses')
        ->withWhereHas('declaration', function ($query) {
            $query->where('status', 'submited');
        })
        ->get()
        ->map(function ($item) {
            return (object)[
                'id'           => $item->id,
                'is_special'   => false,
                'special_type' => null,
                'cab_name'     => $item->cab_name,
                'address'      => $item->address,
                'telephone'    => $item->telephone,
                'email'        => $item->email,
                'city'         => $item->city,
                'created_at'   => $item->created_at,
                'category'     => $item->category,
                'application'  => $item->application,
                'status'       => $item->status,
                'message'      => $item->status == 'Not Approved' && $item->application_statuses ? $item->application_statuses->message : '',
            ];
        });

    // 2. Fetch submitted Halal Certification Body applications
    $hcbApplications = DB::table('hcb_applications')
        ->join('hcb_basic_information', 'hcb_applications.id', '=', 'hcb_basic_information.application_id')
        ->where('hcb_applications.status', 'Submitted')
        ->select(
            'hcb_applications.id',
            'hcb_basic_information.organization_name as cab_name',
            'hcb_basic_information.address',
            'hcb_basic_information.telephone',
            'hcb_basic_information.contact_email as email',
            'hcb_applications.created_at',
            'hcb_applications.scheme_name as category',
            'hcb_applications.application_type as application',
            'hcb_applications.status'
        )
        ->get()
        ->map(function ($item) {
            return (object)[
                'id'           => $item->id,
                'is_special'   => true,
                'special_type' => 'hcb',
                'cab_name'     => $item->cab_name,
                'address'      => $item->address,
                'telephone'    => $item->telephone,
                'email'        => $item->email,
                'city'         => '-',
                'created_at'   => $item->created_at,
                'category'     => $item->category,
                'application'  => $item->application,
                'status'       => $item->status,
                'message'      => '',
            ];
        });

    // 3. Fetch submitted Inspection Body applications
    $ibApplications = DB::table('inspection_body_applications')
        ->join('inspection_body_organizations', 'inspection_body_applications.id', '=', 'inspection_body_organizations.application_id')
        ->where('inspection_body_applications.status', 'Submitted')
        ->select(
            'inspection_body_applications.id',
            'inspection_body_organizations.inspection_body_name as cab_name',
            'inspection_body_organizations.address',
            'inspection_body_organizations.telephone',
            'inspection_body_organizations.contact_email as email',
            'inspection_body_applications.created_at',
            'inspection_body_applications.scheme_name as category',
            'inspection_body_applications.application_type as application',
            'inspection_body_applications.status'
        )
        ->get()
        ->map(function ($item) {
            return (object)[
                'id'           => $item->id,
                'is_special'   => true,
                'special_type' => 'ib',
                'cab_name'     => $item->cab_name,
                'address'      => $item->address,
                'telephone'    => $item->telephone,
                'email'        => $item->email,
                'city'         => '-',
                'created_at'   => $item->created_at,
                'category'     => $item->category,
                'application'  => $item->application,
                'status'       => $item->status,
                'message'      => '',
            ];
        });

    // 4. Fetch submitted Medical Laboratory applications
    $mlabApplications = DB::table('mlab_applications')
        ->where('mlab_applications.status', 'submitted')
        ->get()
        ->map(function ($item) {
            return (object)[
                'id'           => $item->id,
                'is_special'   => true,
                'special_type' => 'mlab',
                'cab_name'     => $item->organisation_name ?: 'Medical Lab Application',
                'address'      => $item->lab_address ?: '-',
                'telephone'    => '-',
                'email'        => '-',
                'city'         => '-',
                'created_at'   => $item->created_at,
                'category'     => $item->scheme_name,
                'application'  => $item->application_type,
                'status'       => ucfirst($item->status),
                'message'      => '',
            ];
        });

    // 5. Fetch submitted Certification Bodies applications
    $cbApplications = DB::table('cb_applications')
        ->where('cb_applications.status', 'Submitted')
        ->get()
        ->map(function ($item) {
            // Find linked CertificationGeneral
            $gen = DB::table('certification_generals')
                ->where('user_id', $item->created_by)
                ->where('category', 'Certification Bodies')
                ->where('application', $item->application_type)
                ->latest('id')
                ->first();

            return (object)[
                'id'           => $item->id,
                'is_special'   => true,
                'special_type' => 'cb_bodies',
                'cab_name'     => $gen ? $gen->cab_name : 'Certification Bodies Application',
                'address'      => $gen ? $gen->address : '-',
                'telephone'    => $gen ? $gen->telephone : '-',
                'email'        => $gen ? $gen->email : '-',
                'city'         => $gen ? $gen->city : '-',
                'created_at'   => $item->created_at,
                'category'     => $item->scheme_name,
                'application'  => $item->application_type,
                'status'       => $item->status,
                'message'      => '',
            ];
        });

    // 6. Merge all collections
    $allApplications = $certifications
        ->merge($hcbApplications)
        ->merge($ibApplications)
        ->merge($mlabApplications)
        ->merge($cbApplications)
        ->sortByDesc('created_at');

    return view('admin.application.submited_index', ['certifications' => $allApplications]);
}
```

### Task 2.2: Update the Index Blade View (`submited_index.blade.php`)

In `resources/views/admin/application/submited_index.blade.php`, handle the "View" action button link based on the `special_type` flag:

```html
@if($certification->is_special)
    @if($certification->special_type == 'hcb')
        <a href="{{ route('application.submited.view-hcb', $certification->id) }}"
           type="button" class="btn btn-success btn-sm">
            View
        </a>
    @elseif($certification->special_type == 'ib')
        <a href="{{ route('application.submited.view-ib', $certification->id) }}"
           type="button" class="btn btn-success btn-sm">
            View
        </a>
    @elseif($certification->special_type == 'mlab')
        <a href="{{ route('application.submited.view-mlab', $certification->id) }}"
           type="button" class="btn btn-success btn-sm">
            View
        </a>
    @elseif($certification->special_type == 'cb_bodies')
        <a href="{{ route('application.submited.view-cb-bodies', $certification->id) }}"
           type="button" class="btn btn-success btn-sm">
            View
        </a>
    @endif
@else
    <a href="{{ route('application.submited.view', [$certification->id, 'category' => $certification->category]) }}"
       type="button" class="btn btn-success btn-sm">
        View
    </a>
@endif
```

### Task 2.3: Implement the Certification Bodies View Action in the Controller

1. Add a new route in `routes/web.php`:
   ```php
   Route::get('view/submited-application/cb-bodies/{id}', [ApplicationController::class, 'viewSubmitedCbBodiesApplication'])->name('submited.view-cb-bodies');
   ```
2. Implement the controller method in `ApplicationController.php`:
   ```php
   public function viewSubmitedCbBodiesApplication($id)
   {
       // Fetch Master Application
       $application = DB::table('cb_applications')->where('id', $id)->first();
       if (!$application) {
           abort(404);
       }

       // Fetch linked CertificationGeneral
       $general = DB::table('certification_generals')
           ->where('user_id', $application->created_by)
           ->where('category', 'Certification Bodies')
           ->where('application', $application->application_type)
           ->latest('id')
           ->first();

       // Fetch Step Data
       $contact = DB::table('cb_contacts')->where('application_id', $id)->first();
       $parent = DB::table('cb_parent_organizations')->where('application_id', $id)->first();
       $invoice = DB::table('cb_invoice_addresses')->where('application_id', $id)->first();
       $consultant = DB::table('cb_consultants')->where('application_id', $id)->first();
       $staff = DB::table('cb_staff_roles')->where('application_id', $id)->get();
       $scopes = DB::table('cb_requested_scopes')->where('application_id', $id)->get();
       $quality = DB::table('cb_quality_systems')->where('application_id', $id)->first();
       $approvals = DB::table('cb_approvals')->where('application_id', $id)->get();
       $declaration = DB::table('cb_declarations')->where('application_id', $id)->first();

       // Load Form Schema to match labels dynamically
       $form = DB::table('application_forms')->where('slug', 'certification-bodies')->first();
       $formSchema = $form ? json_decode($form->form_schema, true) : null;

       return view('admin.application.cb_bodies_view_submited', compact(
           'application', 'general', 'contact', 'parent', 'invoice', 'consultant',
           'staff', 'scopes', 'quality', 'approvals', 'declaration', 'formSchema'
       ));
   }
   ```

### Task 2.4: Create the Dynamic View Mode Blade Template (`cb_bodies_view_submited.blade.php`)

Create `resources/views/admin/application/cb_bodies_view_submited.blade.php` to render the data section-wise dynamically by reading labels from `$formSchema` and values from the Certification Bodies database tables:

```html
@extends('admin.layouts.adminlayout')
@section('main-content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="mb-3 mt-2 d-flex justify-content-between">
                <h6>Show Submitted Certification Body Application ({{ $application->application_no }})</h6>
                <a href="{{ route('application.submited.index') }}" class="btn btn-danger">Back</a>
            </div>

            @php
                // Helper to get Section title from Schema
                $getSectionTitle = function($index, $default) use ($formSchema) {
                    return $formSchema['sections'][$index]['title'] ?? $default;
                };

                // Helper to get Field label from Schema
                $getFieldLabel = function($secIndex, $fieldIndex, $default) use ($formSchema) {
                    return $formSchema['sections'][$secIndex]['fields'][$fieldIndex]['label'] ?? $default;
                };
            @endphp

            <div class="col-12">
                <!-- Section 1: Basic Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">{{ $getSectionTitle(0, 'Basic Application Information') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>CAB Name:</strong>
                                <span>{{ $general->cab_name ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Address:</strong>
                                <span>{{ $general->address ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>Postcode:</strong>
                                <span>{{ $general->postal_code ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>Telephone:</strong>
                                <span>{{ $general->telephone ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>Email:</strong>
                                <span>{{ $general->email ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>NTN/FTN:</strong>
                                <span>{{ $general->ntn_ftn ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>Website:</strong>
                                <span>{{ $general->website ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>City/Country:</strong>
                                <span>{{ $general->city ?? '-' }} / {{ $general->country ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Contact Person -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Authorized Representative / Contact Person</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <strong>Contact Name:</strong>
                                <span>{{ $contact->contact_name ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>Position:</strong>
                                <span>{{ $contact->contact_position ?? '-' }}</span>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>Direct Email:</strong>
                                <span>{{ $contact->contact_email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Parent Org, Invoicing & Consultants -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Parent Organization & Invoicing</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Parent Company Name:</strong>
                                <span>{{ $parent->parent_organization ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Relationship:</strong>
                                <span>{{ $parent->relationship ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Invoice Recipient Organization:</strong>
                                <span>{{ $invoice->organization ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Invoice Address:</strong>
                                <span>{{ $invoice->address ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Staff Roles -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Staff & Auditors/Assessors Details</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Role</th><th>Name</th><th>Designation</th><th>Qualifications</th></tr>
                            </thead>
                            <tbody>
                                @forelse($staff as $row)
                                    <tr>
                                        <td><strong>{{ $row->role }}</strong></td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->designation }}</td>
                                        <td>{{ $row->qualifications }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No staff listings found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 5: Scopes -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Scope of Application</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>IAF Code</th>
                                    <th>Technical Sector</th>
                                    <th>Cluster Name</th>
                                    <th>Standard / Scheme Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($scopes as $scope)
                                    <tr>
                                        <td>{{ $scope->iaf_code }}</td>
                                        <td>{{ $scope->technical_sector }}</td>
                                        <td>{{ $scope->cluster_name }}</td>
                                        <td>{{ $scope->standard_scheme }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No scopes applied.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 6: Quality Systems -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quality System Compliance</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>System complies with ISO/IEC 17021?:</strong>
                                <span>{{ $quality->quality_system_complies ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Non-compliance Area Description:</strong>
                                <span>{{ $quality->non_compliance_area ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 8: Declarations -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Declarations & Signed Agreements</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Applicant Fee Enclosed:</strong>
                                <span>{{ $declaration->applicant_fee_amount ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Authorized Signatory Name:</strong>
                                <span>{{ $declaration->digital_signature_name ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Date of Signing:</strong>
                                <span>{{ $declaration->signed_date ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
```
