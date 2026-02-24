@props([
    'name',
    'value' => '',
    'idx' => 0,
])

@php
    $key = $name . '.' . $idx;
    $hasError = $errors->has($key);
    $isEmpty = $value === '' || $value === null;

    $display = $isEmpty ? 'KOSONG' : $value;
@endphp

<x-tb-cl-fill>
    <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300
        {{ $hasError ? 'bg-red-50 ring-1 ring-red-400' : '' }}"
        data-name="{{ $name }}" data-value="{{ $value }}">
        <span class="{{ $isEmpty ? 'text-red-500' : '' }}">
            {{ $display }}
        </span>

        <input type="hidden" name="{{ $name }}[]" value="{{ $value }}">

        {{-- KETERANGAN ERROR (PER CELL) --}}
        @if ($hasError)
            <div class="mt-1 text-xs text-red-600 leading-snug">
                {{ $errors->first($key) }}
            </div>
        @endif
    </div>
</x-tb-cl-fill>
