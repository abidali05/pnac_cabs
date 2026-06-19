<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">{{ $title }}</h6>
        @if(!$isLocked && ($allowAdd ?? true))
            <button type="button" class="btn btn-outline-success btn-sm js-add-row"
                    data-target="{{ $target }}">Add More</button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    @foreach($columns as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                    <th style="width:70px;">Action</th>
                </tr>
            </thead>
            <tbody id="{{ $target }}">
                @foreach($rows as $index => $row)
                    <tr>
                        @foreach($columns as $field => $label)
                            @php
                                $value = is_array($row) ? ($row[$field] ?? '') : ($row->{$field} ?? '');
                                $type  = str_contains($field, 'date') ? 'date' : 'text';
                            @endphp
                            <td>
                                <input type="{{ $type }}" class="form-control"
                                       name="{{ $name }}[{{ $index }}][{{ $field }}]"
                                       value="{{ $value }}" {{ $isLocked ? 'readonly' : '' }}>
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
