# Developer Prompt: Halal Certification Bodies Admin Dashboard Integration

Use this prompt/guide to implement the admin dashboard listing ("All Applications") and the section-by-section dynamic "View Application" mode for the **Halal Certification Bodies** scheme.

---

## 1. Context & Database Overview

The Halal Certification Bodies scheme uses its own set of database tables instead of the shared `CertificationGeneral` model. 

* **Master Table:** `hcb_applications` (Model: `HcbApplication`)
  * Stores `id`, `application_no`, `status` (e.g. `'Submitted'`, `'Draft'`), `submitted_at`, and `created_by`.
* **Step-by-step Data Tables (linked via `application_id`):**
  1. **Step 1:** `hcb_basic_information` (basic contact info, new/extension check) and `hcb_sub_offices` (sub-offices list).
  2. **Step 2:** `hcb_about_hcb` (parent org, invoicing, ownership, activities, consultant details).
  3. **Step 3 (Staff):** `hcb_chief_executives`, `hcb_shariah_experts`, `hcb_quality_management_representatives`, `hcb_management_members`, `hcb_permanent_auditors`, `hcb_external_auditors`.
  4. **Step 4 (Scope):** `hcb_scopes` (category_code, category, subcategory, included_activities).
  5. **Step 5 (Quality System):** `hcb_quality_system` (questions/answers) and `hcb_non_compliances`.
  6. **Step 6:** `hcb_other_approvals`.
  7. **Step 7:** `hcb_declarations` (declarations, fee amount, signed_by, signed_date).

---

## 2. Step-by-Step Implementation Guide

### Task 2.1: Update the Dashboard Listing Controller

Update `submitedApplication` in `app/Http/Controllers/admin/ApplicationController.php` to fetch both legacy `CertificationGeneral` submissions AND submitted `HcbApplication` applications, merging them into a unified list.

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
                'is_hcb'       => false,
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
                'is_hcb'       => true,
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

    // 3. Merge the collections
    $allApplications = $certifications->merge($hcbApplications)->sortByDesc('created_at');

    return view('admin.application.submited_index', ['certifications' => $allApplications]);
}
```

### Task 2.2: Update the Index Blade View (`submited_index.blade.php`)

In `resources/views/admin/application/submited_index.blade.php`, handle the "View" action button link depending on whether the application is a Halal Certification Body (`is_hcb` flag):

```html
@if($certification->is_hcb)
    <a href="{{ route('application.submited.view-hcb', $certification->id) }}"
       type="button" class="btn btn-success btn-sm">
        View
    </a>
@else
    <a href="{{ route('application.submited.view', [$certification->id, 'category' => $certification->category]) }}"
       type="button" class="btn btn-success btn-sm">
        View
    </a>
@endif
```

### Task 2.3: Implement the HCB View Action in the Controller

1. Add a new route in `routes/web.php`:
   ```php
   Route::get('view/submited-application/hcb/{id}', [ApplicationController::class, 'viewSubmitedHcbApplication'])->name('submited.view-hcb');
   ```
2. Implement the controller method in `ApplicationController.php`:
   ```php
   public function viewSubmitedHcbApplication($id)
   {
       // Fetch Master Application
       $application = DB::table('hcb_applications')->where('id', $id)->first();
       if (!$application) {
           abort(404);
       }

       // Fetch Step Data
       $basicInfo = DB::table('hcb_basic_information')->where('application_id', $id)->first();
       $subOffices = DB::table('hcb_sub_offices')->where('application_id', $id)->get();
       $aboutHcb = DB::table('hcb_about_hcb')->where('application_id', $id)->first();
       $chiefExecs = DB::table('hcb_chief_executives')->where('application_id', $id)->get();
       $shariahExperts = DB::table('hcb_shariah_experts')->where('application_id', $id)->get();
       $qualityReps = DB::table('hcb_quality_management_representatives')->where('application_id', $id)->get();
       $mgmtMembers = DB::table('hcb_management_members')->where('application_id', $id)->get();
       $permAuditors = DB::table('hcb_permanent_auditors')->where('application_id', $id)->get();
       $extAuditors = DB::table('hcb_external_auditors')->where('application_id', $id)->get();
       $scopes = DB::table('hcb_scopes')->where('application_id', $id)->get();
       $qsAnswers = DB::table('hcb_quality_system')->where('application_id', $id)->get()->keyBy('question_code');
       $nonCompliances = DB::table('hcb_non_compliances')->where('application_id', $id)->get();
       $otherApprovals = DB::table('hcb_other_approvals')->where('application_id', $id)->get();
       $declaration = DB::table('hcb_declarations')->where('application_id', $id)->first();

       // Load Form Schema to match labels dynamically
       $form = DB::table('application_forms')->where('slug', 'halal-certification-bodies')->first();
       $formSchema = $form ? json_decode($form->form_schema, true) : null;

       return view('admin.application.halal_view_submited', compact(
           'application', 'basicInfo', 'subOffices', 'aboutHcb',
           'chiefExecs', 'shariahExperts', 'qualityReps', 'mgmtMembers', 'permAuditors', 'extAuditors',
           'scopes', 'qsAnswers', 'nonCompliances', 'otherApprovals', 'declaration', 'formSchema'
       ));
   }
   ```

### Task 2.4: Create the Dynamic View Mode Blade Template (`halal_view_submited.blade.php`)

Create `resources/views/admin/application/halal_view_submited.blade.php` to render the data section-wise dynamically by reading labels from `$formSchema` and values from the HCB database tables:

```html
@extends('admin.layouts.adminlayout')
@section('main-content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="mb-3 mt-2 d-flex justify-content-between">
                <h6>Show Submitted Halal Certification Application ({{ $application->application_no }})</h6>
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
                <!-- Section 0/1: Basic Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">{{ $getSectionTitle(0, 'Basic Information') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 1, 'Organization Name') }}:</strong>
                                <span>{{ $basicInfo->organization_name ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 2, 'Address') }}:</strong>
                                <span>{{ $basicInfo->address ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 3, 'Postcode') }}:</strong>
                                <span>{{ $basicInfo->postcode ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 4, 'Telephone') }}:</strong>
                                <span>{{ $basicInfo->telephone ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 5, 'Fax') }}:</strong>
                                <span>{{ $basicInfo->fax ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 6, 'Contact Name') }}:</strong>
                                <span>{{ $basicInfo->contact_name ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 7, 'Designation') }}:</strong>
                                <span>{{ $basicInfo->designation ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>{{ $getFieldLabel(0, 11, 'Contact Email') }}:</strong>
                                <span>{{ $basicInfo->contact_email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: About HCB -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">{{ $getSectionTitle(3, 'About HCB') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Director Title/Name:</strong>
                                <span>{{ $aboutHcb->title ?? '' }} {{ $aboutHcb->name ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Director Position:</strong>
                                <span>{{ $aboutHcb->position ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Parent Organization:</strong>
                                <span>{{ $aboutHcb->parent_organization ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Relationship:</strong>
                                <span>{{ $aboutHcb->relationship ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Ownership Type:</strong>
                                <span>{{ $aboutHcb->ownership_type ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Is Halal Main Activity?:</strong>
                                <span>{{ ucfirst($aboutHcb->is_halal_main_activity ?? '-') }}</span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Activity Description:</strong>
                                <p class="text-muted">{{ $aboutHcb->activity_description ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Staff details -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Staff & Auditors</h6>
                    </div>
                    <div class="card-body">
                        <h6>Chief Executives:</h6>
                        <table class="table table-striped mb-4">
                            <thead>
                                <tr><th>Name</th><th>Religion</th><th>Qualification</th><th>Experience</th></tr>
                            </thead>
                            <tbody>
                                @forelse($chiefExecs as $staff)
                                    <tr><td>{{ $staff->name }}</td><td>{{ $staff->religion }}</td><td>{{ $staff->qualification }}</td><td>{{ $staff->experience }}</td></tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h6>Permanent Auditors:</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Name</th><th>Religion</th><th>Qualification</th><th>Auditing Field</th><th>Experience</th></tr>
                            </thead>
                            <tbody>
                                @forelse($permAuditors as $staff)
                                    <tr><td>{{ $staff->name }}</td><td>{{ $staff->religion }}</td><td>{{ $staff->qualification }}</td><td>{{ $staff->auditing_field }}</td><td>{{ $staff->audit_experience }}</td></tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted">No records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 4: Scope of Application -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Scopes of Certification</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Category Code</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Included Activities / Products</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($scopes as $scope)
                                    <tr>
                                        <td>{{ $scope->category_code }}</td>
                                        <td>{{ $scope->category }}</td>
                                        <td>{{ $scope->subcategory }}</td>
                                        <td>{{ $scope->included_activities }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No scopes applied.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 5: Quality System Answers -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quality System compliance</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Question Code</th><th>Answer</th><th>Comments / Remarks</th></tr>
                            </thead>
                            <tbody>
                                @forelse($qsAnswers as $code => $ans)
                                    <tr>
                                        <td><strong>{{ strtoupper(str_replace('_', ' ', $code)) }}</strong></td>
                                        <td><span class="badge {{ $ans->answer == 'yes' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($ans->answer) }}</span></td>
                                        <td>{{ $ans->comments ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No questions answered.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 6: Other Approvals -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Other Approvals / Accreditations</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Body Name</th><th>Address</th><th>Scope</th><th>Certificate No.</th><th>Valid From</th><th>Expiry</th></tr>
                            </thead>
                            <tbody>
                                @forelse($otherApprovals as $approval)
                                    <tr>
                                        <td>{{ $approval->approval_body_name }}</td>
                                        <td>{{ $approval->approval_body_address }}</td>
                                        <td>{{ $approval->scope }}</td>
                                        <td>{{ $approval->certificate_number }}</td>
                                        <td>{{ $approval->start_date }}</td>
                                        <td>{{ $approval->expiry_date }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">No approvals listed.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 7: Declarations & Signatures -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Declaration Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Fee Enclosed / Cheque:</strong>
                                <span>{{ $declaration->applicant_fee_amount ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Authorized Signatory:</strong>
                                <span>{{ $declaration->signed_by ?? '-' }}</span>
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
