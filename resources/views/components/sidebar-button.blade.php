@props([
    'href' => null,
    'icon' => null,
    'label' => null,
    'isactive' => '',
])

<li class="active:scale-95">
    <a href="{{ $href }}" title="{{ $label }}"
        class="flex route_pop_up items-center gap-2 px-4 py-2 transition-colors
        {{ $isactive === 'active' ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-700 hover:text-white' }}">

        <i class="{{ $icon }} w-6 text-center text-xl mr-3"></i>
        <span class="text-md">{{ $label }}</span>
    </a>
</li>
