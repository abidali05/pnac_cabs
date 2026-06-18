<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">{{ $title }}</h6>
        @if(!$isLocked && ($allowAdd ?? true))
            <button type="button" class="btn btn-outline-success btn-sm js-add-row" data-target="{{ $target }}">Add More</button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    @foreach ($columns as $label)
                        <th style="white-space: nowrap; min-width: 100px;">{{ $label }}</th>
                    @endforeach
                    <th style="width:70px;">Action</th>
                </tr>
            </thead>
            <tbody id="{{ $target }}">
                @foreach ($rows as $index => $row)
                    <tr>
                        @foreach ($columns as $field => $label)
                            @php
                                // Get current value
                                $value = is_array($row) ? $row[$field] ?? '' : $row->{$field} ?? '';

                                // Determine input type
                                $type = 'text';
                                // List of fields that should be date inputs
                                $dateFields = [
                                    'calibration_date',
                                    'next_calibration',
                                    'expiry_date',
                                    'start_date',
                                    'end_date',
                                    'rectification_date',
                                    'signed_date',
                                    'date',
                                ];
                                if (in_array($field, $dateFields)) {
                                    $type = 'date';
                                    // Format the value to Y-m-d if it's a valid date
    if (!empty($value)) {
        try {
            $date = new \DateTime($value);
            $value = $date->format('Y-m-d');
        } catch (\Exception $e) {
            // Keep as is if not a valid date
        }
    }
}

// Determine if textarea (for long text fields)
$isTextarea = in_array($field, [
    'standard_method',
    'equipment_used',
    'scope',
    'corrective_action',
    'address',
    'description',
    'lab_address',
    'contact_address',
                                ]);
                            @endphp
                            <td style="min-width:120px; max-width:250px;">
                                @if ($field === 'qc_measures')
                                    {{-- Multi-select dropdown for QC Measures --}}
                                    @php
                                        $qcOptions = [
                                            'PT',
                                            'Interlab Comparison',
                                            'CRM/SRM',
                                            'Repeatability',
                                            'Control Charts',
                                        ];
                                        $selected = is_array($value) ? $value : json_decode($value, true) ?? [];
                                    @endphp
                                    <select class="form-select form-select-sm"
                                        name="{{ $name }}[{{ $index }}][{{ $field }}][]" multiple
                                        {{ $isLocked ? 'disabled' : '' }} style="height: auto; min-height: 38px;">
                                        @foreach ($qcOptions as $option)
                                            <option value="{{ $option }}"
                                                @if (in_array($option, $selected)) selected @endif>{{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif ($isTextarea)
                                    <textarea class="form-control form-control-sm" name="{{ $name }}[{{ $index }}][{{ $field }}]"
                                        rows="2" {{ $isLocked ? 'readonly' : '' }}>{{ $value }}</textarea>
                                @else
                                    <input type="{{ $type }}" class="form-control form-control-sm"
                                        name="{{ $name }}[{{ $index }}][{{ $field }}]"
                                        value="{{ $value }}" {{ $isLocked ? 'readonly' : '' }}>
                                @endif
                            </td>
                        @endforeach
                        <td>
                            @if(!$isLocked && ($allowAdd ?? true))
                                <button type="button" class="btn btn-sm btn-danger js-remove-row">Remove</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
