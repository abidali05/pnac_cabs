<div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100"
    data-section="ptp_scope"
    data-open="{{ $openSection === 'ptp_scope' ? '1' : '0' }}">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h5 class="mb-1">Step {{ $stepNumber }}: Scope of Proficiency Testing Provider</h5>
            <p class="text-muted mb-0">Items, schemes, and protocols/techniques.</p>
        </div>
        <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
            {{ $saved ? 'Saved' : 'Unsaved' }}
        </span>
    </div>

    @if ($editing)
        <form method="POST" class="js-card-form" novalidate
            action="{{ route('application.savePtpScope', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
            @csrf
            <input type="hidden" name="section" value="ptp_scope">
            
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="ptpScopeTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Items / Materials / Matrix / Products <span class="text-danger">*</span></th>
                            <th>Type of Scheme / Test / Properties <span class="text-danger">*</span></th>
                            <th>Scheme Protocol / Procedure / Technique Used <span class="text-danger">*</span></th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ptpScopeRowsContainer">
                        @php
                            $ptpRows = !empty($ptpScopes) && $ptpScopes->isNotEmpty() 
                                ? $ptpScopes 
                                : collect([new \App\Models\PtpScope()]);
                        @endphp
                        @foreach ($ptpRows as $index => $row)
                            <tr class="ptp-scope-row" id="ptpRow_{{ $index }}">
                                <td>
                                    <textarea name="ptp_scope[{{ $index }}][item_material_matrix_product]" class="form-control" required rows="2">{{ $row->item_material_matrix_product ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="ptp_scope[{{ $index }}][scheme_test_properties]" class="form-control" required rows="2">{{ $row->scheme_test_properties ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="ptp_scope[{{ $index }}][protocol_procedure_technique]" class="form-control" required rows="2">{{ $row->protocol_procedure_technique ?? '' }}</textarea>
                                </td>
                                <td class="text-center">
                                    @if ($loop->first)
                                        <button type="button" class="btn btn-sm btn-success w-100" id="addPtpRowBtn">+ Add More</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger w-100 remove-ptp-row-btn" onclick="removePtpRow('{{ $index }}')">Remove</button>
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
                        <th>Items / Materials / Matrix / Products</th>
                        <th>Type of Scheme / Test / Properties</th>
                        <th>Scheme Protocol / Procedure / Technique Used</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($ptpScopes) && $ptpScopes->isNotEmpty())
                        @foreach ($ptpScopes as $row)
                            <tr>
                                <td>{!! nl2br(e($row->item_material_matrix_product)) !!}</td>
                                <td>{!! nl2br(e($row->scheme_test_properties)) !!}</td>
                                <td>{!! nl2br(e($row->protocol_procedure_technique)) !!}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-muted text-center">No scope saved yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'ptp_scope']) }}"
                class="btn btn-outline-success btn-sm">Edit</a>
        </div>
    @endif
</div>

@once
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let ptpRowCount = {{ !empty($ptpScopes) && $ptpScopes->isNotEmpty() ? $ptpScopes->count() : 1 }};

        document.getElementById('addPtpRowBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            ptpRowCount++;
            let index = ptpRowCount;
            let newRow = `
                <tr class="ptp-scope-row" id="ptpRow_${index}">
                    <td>
                        <textarea name="ptp_scope[${index}][item_material_matrix_product]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td>
                        <textarea name="ptp_scope[${index}][scheme_test_properties]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td>
                        <textarea name="ptp_scope[${index}][protocol_procedure_technique]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger w-100 remove-ptp-row-btn" onclick="removePtpRow('${index}')">Remove</button>
                    </td>
                </tr>
            `;
            document.getElementById('ptpScopeRowsContainer').insertAdjacentHTML('beforeend', newRow);
        });
    });

    function removePtpRow(index) {
        document.getElementById('ptpRow_' + index)?.remove();
    }
</script>
@endonce
