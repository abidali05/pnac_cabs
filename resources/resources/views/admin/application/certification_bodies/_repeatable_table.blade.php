@php
    $allowMultiple = $allowMultiple ?? false;
@endphp
<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">{{ $title }}</h6>
        @if ($allowMultiple && !$isLocked)
            <button type="button" class="btn btn-outline-success btn-sm js-add-row" data-target="{{ $target }}">Add
                More</button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    @foreach ($columns as $label)
                        <th>{{ $label }} <span class="text-danger">*</span></th>
                    @endforeach
                    @if ($allowMultiple)
                        <th style="width:70px;">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody id="{{ $target }}">
                @foreach ($rows as $index => $row)
                    <tr>
                        @foreach ($columns as $field => $label)
                            @php
                                $value = is_array($row) ? $row[$field] ?? '' : $row->{$field} ?? '';
                                $type = str_contains($field, 'date') ? 'date' : 'text';
                            @endphp
                            <td>
                                <input type="{{ $type }}" class="form-control"
                                    name="{{ $name }}[{{ $index }}][{{ $field }}]"
                                    value="{{ $value }}" {{ $isLocked ? 'readonly' : '' }}
                                    {{ isset($disableRequired) && $disableRequired ? '' : 'required' }}>
                            </td>
                        @endforeach
                        @if ($allowMultiple)
                            <td>
                                @unless ($isLocked)
                                    <button type="button" class="btn btn-sm btn-danger js-remove-row">Remove</button>
                                @endunless
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
