<div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100" data-section="personnel_scope"
    data-open="{{ $openSection === 'personnel_scope' ? '1' : '0' }}">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h5 class="mb-1">Step {{ $stepNumber }}: {{ $personnelScopeSection['title'] }}</h5>
            <p class="text-muted mb-0">Personnel certification categories and normative references.</p>
        </div>
        <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
            {{ $saved ? 'Saved' : 'Unsaved' }}
        </span>
    </div>

    @if ($editing)
        <form method="POST" class="js-card-form" novalidate
            action="{{ route('application.savePersonnelScope', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
            @csrf
            <input type="hidden" name="section" value="personnel_scope">

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="personnelScopeTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Personnel Certification Categories <span class="text-danger">*</span></th>
                            <th>Standards / Normative References <span class="text-danger">*</span></th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="personnelScopeRowsContainer">
                        @php
                            $personnelRows =
                                !empty($personnelScopes) && $personnelScopes->isNotEmpty()
                                    ? $personnelScopes
                                    : collect([new \App\Models\PersonnelCertificationScope()]);
                        @endphp
                        @foreach ($personnelRows as $index => $row)
                            <tr class="personnel-scope-row" id="personnelRow_{{ $index }}">
                                <td>
                                    <textarea name="personnel_scope[{{ $index }}][technical_cluster]" class="form-control" required rows="2">{{ $row->technical_cluster ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="personnel_scope[{{ $index }}][description_iaf]" class="form-control" required rows="2">{{ $row->description_iaf ?? '' }}</textarea>
                                </td>
                                <td class="text-center">
                                    @if ($loop->first)
                                        <button type="button" class="btn btn-sm btn-success w-100"
                                            id="addPersonnelRowBtn">+ Add More</button>
                                    @else
                                        <button type="button"
                                            class="btn btn-sm btn-danger w-100 remove-personnel-row-btn"
                                            onclick="removePersonnelRow('{{ $index }}')">Remove</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-success btn-sm">Save Scope</button>
            </div>
        </form>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Personnel Certification Categories</th>
                        <th>Standards / Normative References</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($personnelScopes) && $personnelScopes->isNotEmpty())
                        @foreach ($personnelScopes as $row)
                            <tr>
                                <td>{!! nl2br(e($row->technical_cluster)) !!}</td>
                                <td>{!! nl2br(e($row->description_iaf)) !!}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-muted text-center">No scope saved yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'personnel_scope']) }}"
                class="btn btn-outline-success btn-sm">Edit</a>
        </div>
    @endif
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let personnelRowCount =
                {{ !empty($personnelScopes) && $personnelScopes->isNotEmpty() ? $personnelScopes->count() : 1 }};

            document.getElementById('addPersonnelRowBtn')?.addEventListener('click', function(e) {
                e.preventDefault();
                personnelRowCount++;
                let index = personnelRowCount;
                let newRow = `
                <tr class="personnel-scope-row" id="personnelRow_${index}">
                    <td>
                        <textarea name="personnel_scope[${index}][technical_cluster]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td>
                        <textarea name="personnel_scope[${index}][description_iaf]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger w-100 remove-personnel-row-btn" onclick="removePersonnelRow('${index}')">Remove</button>
                    </td>
                </tr>
            `;
                document.getElementById('personnelScopeRowsContainer').insertAdjacentHTML('beforeend',
                    newRow);
            });
        });

        function removePersonnelRow(index) {
            document.getElementById('personnelRow_' + index)?.remove();
        }
    </script>
@endonce
