@props(['title' => null, 'hide' => null, 'expanded' => 'false', 'icon' => 'fa-solid fa-folder'])

@php
    $isExpanded = $expanded === 'true';
@endphp

<div x-data="{ open: {{ $isExpanded ? 'true' : 'false' }} }" class="sidebar-group-item mb-1.5">
    <button @click="open = !open"
        title="{{ html_entity_decode(strip_tags($title)) }}"
        class="sm-center w-full flex items-start px-3 py-2.5 rounded-lg transition-all duration-200 group text-left outline-none {{ $isExpanded ? 'bg-blue-50/60' : 'hover:bg-gray-200' }}">

        {{-- Icon dibuat mt-0.5 agar sejajar dengan baris pertama teks jika teksnya panjang --}}
        <i class="{{ $icon }} text-[1.10rem] mr-3 mt-0.5 w-6 text-center text-gray-500 group-hover:text-blue-600 transition-colors shrink-0"></i>

        {{-- Judul dengan text-wrap penuh dan {!! !!} agar tidak render &amp; --}}
        <span class="sm-hide text-sm font-semibold text-gray-700 break-words whitespace-normal leading-tight flex-1 tracking-wide transition-colors group-hover:text-gray-900 pr-2">
            {!! $title !!}
        </span>

        {{-- Icon Panah --}}
        <svg class="sm-hide w-4 h-4 transform transition-transform duration-300 shrink-0 mt-0.5 text-gray-400 group-hover:text-blue-500"
            :class="open ? 'rotate-180' : ''"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-ref="container" class="overflow-hidden transition-all duration-300 ease-in-out"
        :style="open ? 'max-height: 1500px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
        <ul class="space-y-1 py-1 list-none m-0 px-2 mt-1 border-l-2 border-gray-100 ml-5">
            {{ $slot }}
        </ul>
    </div>
</div>
