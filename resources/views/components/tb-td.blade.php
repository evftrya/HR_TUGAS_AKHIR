@props(['type' => null, 'nama' => null, 'sorting' => false])

@php
    $url_value_for_this_select = request()->all()[$nama] ?? null;
@endphp

<th data-field="{{ $nama }}" 
    data-filter-control="{{ $type }}"
    @if ($url_value_for_this_select) data-filter-default="{{ $url_value_for_this_select }}" @endif
    @if ($sorting) data-sortable="true" @endif
    class="px-6 py-4 text-[13px] font-bold text-[#1d1d1f] uppercase tracking-tight @if ($sorting) sortable @endif">
    <div class="flex items-center justify-center gap-1">
        <span>{{ $slot }}</span>
        @if ($sorting)
            <i class="bi bi-filter sort-icon transition-colors"></i>
        @endif
    </div>
</th>