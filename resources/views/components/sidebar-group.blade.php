@props(['title' => null, 'hide' => null, 'expanded' => 'false'])

@php
    $formatTitle = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $title)));
    $isExpanded = $expanded === 'true';
@endphp

<div x-data="{ open: {{ $isExpanded ? 'true' : 'false' }} }" class="border mb-2 border-gray-200 overflow-hidden">
    <button @click="open = !open"
        class="w-full bg-white flex justify-between items-start p-4 hover:bg-gray-50 transition-colors text-left">

        {{-- Container teks agar bisa multi-baris --}}
        <span class="font-semibold text-gray-700 break-words leading-tight flex-1 pr-4">
            {{ $title }}
        </span>

        {{-- Icon tetap di posisinya (kanan atas atau tengah) --}}
        <svg class="w-5 h-5 transform transition-transform duration-300 shrink-0 mt-1" :class="open ? 'rotate-180' : ''"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-ref="container" class="overflow-hidden transition-all duration-300"
        :style="open
            ?
            'max-height: ' + $refs.container.scrollHeight + 'px' :
            'max-height: 0px'">
        <ul class="space-y-1 mb-2 list-none p-0">
            {{ $slot }}
        </ul>
    </div>
</div>
