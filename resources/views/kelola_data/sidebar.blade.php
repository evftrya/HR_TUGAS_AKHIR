<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@foreach ($sidebars as $sidebar)
    @php
        $isGroupActive = collect($sidebar['menus'])->contains(function ($menu) {
            return request()->routeIs($menu['route']);
        });
    @endphp

    <x-sidebar-group
        :expanded="$isGroupActive"
        title="{!! $sidebar['title'] !!}"
        icon="{{ $sidebar['icon'] }}"
    >
        @foreach ($sidebar['menus'] as $menu)
            <x-sidebar-button
                :isactive="request()->routeIs($menu['route']) ? 'active' : ''"
                href="{{ $menu['url'] }}"
                icon="{{ $menu['icon'] }}"
                label="{{ $menu['label'] }}"
            />
        @endforeach
    </x-sidebar-group>
@endforeach
