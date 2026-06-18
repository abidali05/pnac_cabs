@extends('admin.layouts.adminlayout')

@section('main-content')
<div class="main-content">
    <section class="section">
        <div class="card p-3 mb-3">
            <h4>Application Summary</h4>
            <p><strong>Reference:</strong> {{ $application->reference_no ?? '-' }}</p>
            <p><strong>Category:</strong> {{ $application->category ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $application->status ?? 'Pending' }}</p>
        </div>

        <div class="card p-3 mb-3">
            <h5>Basic Certification Body Information</h5>
            <p><strong>Certification Body Name:</strong> {{ $application->cab_name ?? '-' }}</p>
            <p><strong>Address:</strong> {{ $application->address ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $application->email ?? '-' }}</p>
            <p><strong>Telephone:</strong> {{ $application->telephone ?? '-' }}</p>
        </div>

        <div class="card p-3 mb-3">
            <h5>Part 1: About Yourselves</h5>
            <p><strong>Director Name:</strong> {{ $application->certificationBodyApplication->director_name ?? '-' }}</p>
            <p><strong>Director Position:</strong> {{ $application->certificationBodyApplication->director_position ?? '-' }}</p>
            <p><strong>Parent Organization:</strong> {{ $application->certificationBodyApplication->parent_organization ?? '-' }}</p>
        </div>

        <div class="card p-3 mb-3">
            <h5>Part 2: About Your Staff</h5>
            <table class="table table-bordered">
                <thead><tr><th>Type</th><th>Name</th><th>Qualifications</th><th>Experience</th></tr></thead>
                <tbody>
                    @forelse($application->certificationBodyStaff as $staff)
                        <tr>
                            <td>{{ $staff->staff_type }}</td>
                            <td>{{ $staff->name ?: '-' }}</td>
                            <td>{{ $staff->qualifications ?: '-' }}</td>
                            <td>{{ $staff->relevant_experience ?: ($staff->audit_experience ?: '-') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No staff data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card p-3 mb-3">
            <h5>Part 3: Scope of Application</h5>
            <table class="table table-bordered">
                <thead><tr><th>Scope Type</th><th>Description</th><th>IAF</th></tr></thead>
                <tbody>
                    @forelse($application->certificationScopes as $scope)
                        <tr>
                            <td>{{ $scope->scope_type ?: '-' }}</td>
                            <td>{{ $scope->description ?: '-' }}</td>
                            <td>{{ $scope->iaf_code ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">No scope data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card p-3 mb-3">
            <h5>Part 4: About Your Quality System</h5>
            <p><strong>Complies:</strong> {{ $application->certificationBodyApplication->quality_system_complies ?? '-' }}</p>
            <p><strong>Non Compliance Area:</strong> {{ $application->certificationBodyApplication->non_compliance_area ?? '-' }}</p>
            <p><strong>Rectified By:</strong> {{ $application->certificationBodyApplication->rectified_by_date ?? '-' }}</p>
        </div>

        <div class="card p-3 mb-3">
            <h5>Part 5: Other Approvals</h5>
            <table class="table table-bordered">
                <thead><tr><th>Approval Body</th><th>Scope/Certificate No</th><th>Start</th><th>Expiry</th></tr></thead>
                <tbody>
                    @forelse($application->certificationBodyApprovals as $approval)
                        <tr>
                            <td>{{ $approval->approval_body_name_address ?: '-' }}</td>
                            <td>{{ $approval->scope_certificate_no ?: '-' }}</td>
                            <td>{{ $approval->start_date ?: '-' }}</td>
                            <td>{{ $approval->expiry_date ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No approvals data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card p-3 mb-3">
            <h5>Part 6: Declaration</h5>
            <p><strong>Signed:</strong> {{ $application->certificationBodyApplication->signed ?? '-' }}</p>
            <p><strong>Signed Date:</strong> {{ $application->certificationBodyApplication->signed_date ?? '-' }}</p>
            <p><strong>Application Fee:</strong> {{ $application->certificationBodyApplication->application_fee ?? '-' }}</p>
        </div>
    </section>
</div>
@endsection

