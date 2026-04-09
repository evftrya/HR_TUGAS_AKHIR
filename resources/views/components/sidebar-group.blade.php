@props(['title' => null, 'hide' => null, 'expanded' => 'false', 'icon' => 'fa-solid fa-folder'])

@php
    $isExpanded = $expanded === 'true';
@endphp

<div x-data="{ open: {{ $isExpanded ? 'true' : 'false' }} }" class="border mb-2 border-gray-200 overflow-hidden rounded-md">
    {{-- Tambahkan atribut title="{{ $title }}" di bawah ini --}}
    <button @click="open = !open"
        title="{{ $title }}"
        class="sm-center w-full bg-white flex items-start p-4 hover:bg-gray-50 transition-colors text-left group">
        
        {{-- Icon Group (Muncul saat Collapsed) --}}
        <div class="sm-show hidden text-gray-500 group-hover:text-blue-600 transition-colors">
            <i class="{{ $icon }} fa-lg"></i>
        </div>

        {{-- Icon Group Kecil (Muncul saat Normal) --}}
        <div class="sm-hide flex mr-3 mt-0.5 text-gray-500 group-hover:text-blue-600 transition-colors">
            <i class="{{ $icon }} fa-fw"></i>
        </div>

        {{-- Judul --}}
        <span class="sm-hide font-semibold text-gray-700 break-words leading-tight flex-1 pr-2">
            {{ $title }}
        </span>

        {{-- Panah --}}
        <svg class="sm-hide w-4 h-4 transform transition-transform duration-300 shrink-0 mt-1 text-gray-400" 
            :class="open ? 'rotate-180' : ''"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-ref="container" class="overflow-hidden transition-all duration-300 bg-gray-50"
        :style="open ? 'max-height: ' + $refs.container.scrollHeight + 'px' : 'max-height: 0px'">
        <ul class="space-y-1 py-2 list-none p-0 border-t border-gray-100">
            {{ $slot }}
        </ul>
    </div>
</div>