{{-- Sidebar Kinerja Pegawai --}}

@php
    $sidebars = [
        [
            ['Dashboard Kinerja', 'Dashboard', 'fa-solid fa-gauge'],
            [
                ['Beranda Kinerja', route('manage.target-kinerja.index'), 'fa-solid fa-house'],
                ['Presensi & Jam Kerja', route('manage.presensi.index'), 'fa-solid fa-clock-rotate-left'],
            ],
        ],
        [
            ['Target Kinerja', 'TargetKinerja', 'fa-solid fa-bullseye'],
            [
                ['Daftar Target Kinerja', route('manage.target-kinerja.list'), 'fa-solid fa-list-check'],
                ['Tambah Target Kinerja', route('manage.target-kinerja.input'), 'fa-solid fa-plus-circle'],
                ['Laporan Target Kinerja', route('manage.target-kinerja.laporan'), 'fa-solid fa-chart-bar'],
            ],
        ],
        [
            ['Target Kinerja Harian', 'TargetKinerjaHarian', 'fa-solid fa-calendar-day'],
            [
                ['Daftar Target Harian', route('manage.target-kinerja.harian.list'), 'fa-solid fa-list-check'],
                ['Tambah Target Harian', route('manage.target-kinerja.harian.input'), 'fa-solid fa-plus-circle'],
                ['Approval Laporan', route('manage.target-kinerja.harian.reports'), 'fa-solid fa-check-double'],
            ],
        ],
    ];
@endphp

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@foreach ($sidebars as $i => $sidebar)
    @php
        $isGroupActive = false;
        foreach ($sidebar[1] as $button) {
            if (request()->url() == $button[1]) {
                $isGroupActive = true;
                break;
            }
        }
    @endphp

    <x-sidebar-group :expanded="$isGroupActive ? 'true' : 'false'" title="{{ $sidebar[0][0] }}" hide="{{ $sidebar[0][1] }}"
        icon="{{ $sidebar[0][2] }}">
        @foreach ($sidebar[1] as $button)
            @php
                $isActive = request()->url() == $button[1] ? 'active' : '';
            @endphp
            <x-sidebar-button :isactive="$isActive" href="{{ $button[1] }}" icon="{{ $button[2] }}"
                label="{{ $button[0] }}" />
        @endforeach
    </x-sidebar-group>
@endforeach
