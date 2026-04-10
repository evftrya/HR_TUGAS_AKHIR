@props(['type' => null, 'nama' => null, 'sorting' => false])

@php
        $url_value_for_this_select =request()->all()[$nama]??null;
@endphp



<th data-field="{{ $nama }}" data-filter-control="{{ $type }}"
    @if ($url_value_for_this_select) data-filter-default="{{ $url_value_for_this_select??null }}" @endif
    @if ($sorting) data-sortable="true" @endif
    class="px-4 py-3 text-xs font-semibold bg-gray-500 text-blue-600 uppercase tracking-wider @if ($sorting) sortable @endif">
    {{ $slot }}

    @if ($sorting)
        <i class="bi bi-filter sort-icon"></i>
    @endif
</th>
