<div class="border rounded p-3 p-md-4 mb-3 bg-white pnac-step-card w-100"
    data-section="pcb_scope"
    data-open="{{ $openSection === 'pcb_scope' ? '1' : '0' }}">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h5 class="mb-1">Step {{ $stepNumber }}: Scope of Product Certification Body (PCB)</h5>
            <p class="text-muted mb-0">Products, standards, and countries where certificates are to be issued.</p>
        </div>
        <span class="badge {{ $saved ? 'bg-success' : 'bg-warning text-dark' }}">
            {{ $saved ? 'Saved' : 'Unsaved' }}
        </span>
    </div>

    @if ($editing)
        <form method="POST" class="js-card-form" novalidate
            action="{{ route('application.savePcbScope', ['applicationForLab' => $labApplication->id, 'scheme_name' => request('scheme_name'), 'application' => request('application')]) }}">
            @csrf
            <input type="hidden" name="section" value="pcb_scope">
            
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="pcbScopeTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Product <span class="text-danger">*</span></th>
                            <th>Standards <span class="text-danger">*</span></th>
                            <th>Countries Where Certificates Are To Be Issued <span class="text-danger">*</span></th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="pcbScopeRowsContainer">
                        @php
                            $pcbRows = !empty($pcbScopes) && $pcbScopes->isNotEmpty() 
                                ? $pcbScopes 
                                : collect([new \App\Models\ProductCertificationScope()]);
                        @endphp
                        @foreach ($pcbRows as $index => $row)
                            <tr class="pcb-scope-row" id="pcbRow_{{ $index }}">
                                <td>
                                    <textarea name="pcb_scope[{{ $index }}][product]" class="form-control" required rows="2">{{ $row->product ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="pcb_scope[{{ $index }}][standard]" class="form-control" required rows="2">{{ $row->standard ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="pcb_scope[{{ $index }}][countries]" class="form-control" required rows="2">{{ $row->countries ?? '' }}</textarea>
                                </td>
                                <td class="text-center">
                                    @if ($loop->first)
                                        <button type="button" class="btn btn-sm btn-success w-100" id="addPcbRowBtn">+ Add More</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger w-100 remove-pcb-row-btn" onclick="removePcbRow('{{ $index }}')">Remove</button>
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
                        <th>Product</th>
                        <th>Standards</th>
                        <th>Countries Where Certificates Are To Be Issued</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($pcbScopes) && $pcbScopes->isNotEmpty())
                        @foreach ($pcbScopes as $row)
                            <tr>
                                <td>{!! nl2br(e($row->product)) !!}</td>
                                <td>{!! nl2br(e($row->standard)) !!}</td>
                                <td>{!! nl2br(e($row->countries)) !!}</td>
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
            <a href="{{ route('application.create', ['scheme_name' => request('scheme_name'), 'application' => request('application'), 'edit_section' => 'pcb_scope']) }}"
                class="btn btn-outline-success btn-sm">Edit</a>
        </div>
    @endif
</div>

@once
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let pcbRowCount = {{ !empty($pcbScopes) && $pcbScopes->isNotEmpty() ? $pcbScopes->count() : 1 }};

        document.getElementById('addPcbRowBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            pcbRowCount++;
            let index = pcbRowCount;
            let newRow = `
                <tr class="pcb-scope-row" id="pcbRow_${index}">
                    <td>
                        <textarea name="pcb_scope[${index}][product]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td>
                        <textarea name="pcb_scope[${index}][standard]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td>
                        <textarea name="pcb_scope[${index}][countries]" class="form-control" required rows="2"></textarea>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger w-100 remove-pcb-row-btn" onclick="removePcbRow('${index}')">Remove</button>
                    </td>
                </tr>
            `;
            document.getElementById('pcbScopeRowsContainer').insertAdjacentHTML('beforeend', newRow);
        });
    });

    function removePcbRow(index) {
        document.getElementById('pcbRow_' + index)?.remove();
    }
</script>
@endonce
