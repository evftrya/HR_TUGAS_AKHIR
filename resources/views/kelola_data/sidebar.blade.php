<!-- Menu Kelola Data -->


@php
    $sidebars = [
        [
            ['Manajemen Data Pegawai', 'Pegawai'],
            [
                ['Dashboard Pegawai', route('manage.pegawai.list', ['destination' => 'Active']), 'fa-solid fa-gauge'],
                ['Daftar Pegawai', route('manage.pegawai.list', ['destination' => 'Active']), 'fa-solid fa-users'],
                ['Tambah Pegawai Baru', route('manage.pegawai.new'), 'fa-solid fa-user-plus'],
                ['Tambah Dosen Baru', route('manage.pegawai.new', ['type' => 'Dosen']), 'fa-solid fa-chalkboard-user'],
                ['Tambah TPA Baru', route('manage.pegawai.new', ['type' => 'Tpa']), 'fa-solid fa-user-tie'],
                ['Import Pegawai', route('manage.pegawai.new'), 'fa-solid fa-file-import'],
            ],
        ],
        [
            ['Manajemen Fakultas', 'Fakultas'],
            [
                ['Daftar Fakultas', route('manage.fakultas.index'), 'fa-solid fa-building-columns'],
                ['Tambah Fakultas', route('manage.fakultas.create'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Manajemen Prodi', 'Prodi'],
            [
                ['Daftar Prodi', route('manage.prodi.index'), 'fa-solid fa-book-open'],
                ['Tambah Prodi', route('manage.prodi.create'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Dashboard Prodi', 'DashboardProdi'],
            [
                ['Dashboard Pendidikan', route('manage.dashboard-prodi.pendidikan'), 'fa-solid fa-graduation-cap'],
                ['Dashboard Jabatan Fungsional', route('manage.dashboard-prodi.fungsional'), 'fa-solid fa-award'],
                ['Dashboard Kepegawaian', route('manage.dashboard-prodi.kepegawaian'), 'fa-solid fa-id-card'],
            ],
        ],
        [
            ['Sertifikasi Dosen', 'Sertifikasi'],
            [
                ['Daftar Sertifikasi', route('manage.sertifikasi-dosen.list'), 'fa-solid fa-certificate'],
                ['Tambah Sertifikasi', route('manage.sertifikasi-dosen.input'), 'fa-solid fa-plus-circle'],
                ['Upload Sertifikasi', route('manage.sertifikasi-dosen.upload'), 'fa-solid fa-file-upload'],
            ],
        ],
        [
            ['Manajemen Level', 'Level'],
            [
                ['Daftar Level', route('manage.level.list'), 'fa-solid fa-layer-group'],
                ['Tambah Level', route('manage.level.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Manajemen Formasi', 'Formasi'],
            [
                ['Daftar Formasi', route('manage.formasi.list'), 'fa-solid fa-list-check'],
                ['Tambah Formasi', route('manage.formasi.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Pemetaan', 'Pemetaan'],
            [
                ['Daftar Pemetaan', route('manage.pengawakan.list'), 'fa-solid fa-users-gear'],
                ['Tambah Pemetaan', route('manage.pengawakan.new'), 'fa-solid fa-user-plus'],
                ['Struktur Jabatan', route('manage.pengawakan.list'), 'fa-solid fa-sitemap'],
            ],
        ],
        [
            ['Laporan', 'Laporan'],
            [
                [
                    'Laporan Pegawai Lengkap',
                    route('manage.pegawai.list', ['destination' => 'All']),
                    'fa-solid fa-file-lines',
                ],
            ],
        ],
    ];
@endphp



@foreach ($sidebars as $sidebar)
    <x-sidebar-group title="{{ $sidebar[0][0] }}" hide="{{ $sidebar[0][1] }}" icon="fa-users">
        @foreach ($sidebar[1] as $i => $button)
            <x-sidebar-button :isactive="isset($active_sidebar) && $active_sidebar === $button[0] ? 'active-sidebar' : null" href="{{ $button[1] }}" icon="{{ $button[2] }}"
                label="{{ $button[0] }}" />
        @endforeach
    </x-sidebar-group>
@endforeach
