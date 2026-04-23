<!-- Menu Kelola Data -->


@php
    $sidebars = [
        [
            ['Manajemen Data Pegawai', 'Pegawai', 'fa-solid fa-users-viewfinder'],
            [
                ['Dashboard Pegawai', route('manage.pegawai.dashboard'), 'fa-solid fa-gauge'],
                ['Daftar Pegawai', route('manage.pegawai.list', ['destination' => 'Active']), 'fa-solid fa-users'],
                [
                    'Daftar Dosen',
                    route('manage.pegawai.list', ['destination' => 'Active', 'tipe' => 'Dosen']),
                    'fa-solid fa-chalkboard-user',
                ],
                [
                    'Daftar TPA',
                    route('manage.pegawai.list', ['destination' => 'Active', 'tipe' => 'TPA']),
                    'fa-solid fa-user-tie',
                ],
                ['Tambah Pegawai Baru', route('manage.pegawai.new'), 'fa-solid fa-user-plus'],
                ['Tambah Dosen Baru', route('manage.pegawai.new', ['type' => 'Dosen']), 'fa-solid fa-plus'],
                ['Tambah TPA Baru', route('manage.pegawai.new', ['type' => 'Tpa']), 'fa-solid fa-plus'],
                ['Import Pegawai', route('manage.pegawai.import.add-file'), 'fa-solid fa-file-import'],
            ],
        ],
        [
            ['Manajemen Fakultas', 'Fakultas', 'fa-solid fa-university'],
            [
                ['Daftar Fakultas', route('manage.fakultas.index'), 'fa-solid fa-building-columns'],
                ['Tambah Fakultas', route('manage.fakultas.create'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Manajemen Prodi', 'Prodi', 'fa-solid fa-book'],
            [
                ['Daftar Prodi', route('manage.prodi.index'), 'fa-solid fa-book-open'],
                ['Tambah Prodi', route('manage.prodi.create'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Dashboard Prodi', 'DashboardProdi', 'fa-solid fa-chart-pie'],
            [
                ['Dashboard Pendidikan', route('manage.dashboard-prodi.pendidikan'), 'fa-solid fa-graduation-cap'],
                ['Dashboard Jabatan Fungsional', route('manage.dashboard-prodi.fungsional'), 'fa-solid fa-award'],
                ['Dashboard Kepegawaian', route('manage.dashboard-prodi.kepegawaian'), 'fa-solid fa-id-card'],
            ],
        ],
        [
            ['Sertifikasi Dosen', 'Sertifikasi', 'fa-solid fa-stamp'],
            [
                ['Daftar Sertifikasi', route('manage.sertifikasi-dosen.list'), 'fa-solid fa-certificate'],
                ['Tambah Sertifikasi', route('manage.sertifikasi-dosen.input'), 'fa-solid fa-plus-circle'],
                ['Upload Sertifikasi', route('manage.sertifikasi-dosen.upload'), 'fa-solid fa-file-upload'],
            ],
        ],
        [
            ['Kelompok Keahlian', 'KelompokKeahlian', 'fa-solid fa-layer-group'],
            [
                ['Daftar Kelompok Keahlian', route('manage.kelompok-keahlian.list'), 'fa-solid fa-users-gear'],
                ['Daftar Sub Kelompok Keahlian', route('manage.kelompok-keahlian.list'), 'fa-solid fa-users-gear'],
                [
                    'Daftar Dosen dengan Kelompok Keahlian',
                    route('manage.kelompok-keahlian.sub.list'),
                    'fa-solid fa-users',
                ],
                ['Struktur KK', route('manage.kelompok-keahlian.dosen-with-kk.struktur'), 'fa-solid fa-plus-circle'],
                ['Petakan Dosen', route('manage.kelompok-keahlian.input'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Center Of Excellence', 'COE', 'fa-solid fa-award'],
            [
                ['Daftar COE', route('manage.coe.index'), 'fa-solid fa-star'],
                ['Tambah COE', route('manage.coe.create'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Studi Lanjut', 'StudiLanjut', 'fa-solid fa-user-graduate'],
            [
                ['Daftar Studi Lanjut', route('manage.studi-lanjut.list'), 'fa-solid fa-user-graduate'],
                ['Tambah Studi Lanjut', route('manage.studi-lanjut.input'), 'fa-solid fa-plus-circle'],
            ],
        ],

        [
            ['Manajemen Level', 'Level', 'fa-solid fa-gears'],
            [
                ['Daftar Level', route('manage.level.list'), 'fa-solid fa-layer-group'],
                ['Tambah Level', route('manage.level.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Manajemen Formasi', 'Formasi', 'fa-solid fa-clipboard-list'],
            [
                ['Daftar Formasi', route('manage.formasi.list'), 'fa-solid fa-list-check'],
                ['Tambah Formasi', route('manage.formasi.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Pemetaan', 'Pemetaan', 'fa-solid fa-sitemap'],
            [
                ['Daftar Pemetaan', route('manage.pengawakan.list'), 'fa-solid fa-users-gear'],
                ['Tambah Pemetaan', route('manage.pengawakan.new'), 'fa-solid fa-user-plus'],
                ['Struktur Jabatan', route('manage.pengawakan.struktur'), 'fa-solid fa-sitemap'],
                // ['Struktur Jabatan', route('manage.pengawakan.list'), 'fa-solid fa-sitemap'],
            ],
        ],
        [
            ['Jabatan Fungsional Akademik', 'JFA', 'fa-solid fa-briefcase'],
            [
                ['Daftar JFA', route('manage.jfa.list'), 'fa-solid fa-list-check'],
                ['Tambah JFA', route('manage.formasi.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Jabatan Fungsional Keahlian', 'JFK', 'fa-solid fa-id-badge'],
            [
                ['Daftar JFK', route('manage.jfk.list'), 'fa-solid fa-list-check'],
                ['Tambah JFK', route('manage.jfk.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Jabatan Golongan', 'JG', 'fa-solid fa-medal'],
            [
                ['Daftar Pangkat Golongan', route('manage.pangkat-golongan.list'), 'fa-solid fa-list-check'],
                ['Tambah Pangkat Golongan', route('manage.pangkat-golongan.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Jenjang Pendidikan', 'JP', 'fa-solid fa-stairs'],
            [
                ['Daftar Jenjang Pendidikan', route('manage.jenjang-pendidikan.list'), 'fa-solid fa-list-check'],
                ['Tambah Jenjang Pendidikan', route('manage.jenjang-pendidikan.new'), 'fa-solid fa-plus-circle'],
            ],
        ],

        [
            ['Master Data Bagian Kerja', 'Bagian', 'fa-solid fa-fingerprint'],
            [
                ['Daftar Bagian Kerja', route('manage.bagian.list'), 'fa-solid fa-list-check'],
                ['Tambah Bagian kerja', route('manage.bagian.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Master Data Status Pegawai', 'Status Pegawai', 'fa-solid fa-fingerprint'],
            [
                ['Daftar Status Pegawai', route('manage.status-pegawai.list'), 'fa-solid fa-list-check'],
            ],
        ],

        [
            ['Master Data Pangkat Golongan', 'PG', 'fa-solid fa-medal'],
            [
                ['Daftar Referensi Pangkat Golongan', route('manage.pangkat-golongan.ref.list'), 'fa-solid fa-list-check'],
                ['Tambah Referensi Pangkat Golongan', route('manage.pangkat-golongan.ref.new'), 'fa-solid fa-plus-circle'],
            ],
        ],

        [
            ['Master Data Jenjang Pendidikan', 'PG', 'fa-solid fa-medal'],
            [
                ['Daftar Referensi Jenjang Pendidikan', route('manage.jenjang-pendidikan.ref.list'), 'fa-solid fa-list-check'],
                ['Tambah Referensi Jenjang Pendidikan', route('manage.jenjang-pendidikan.ref.new'), 'fa-solid fa-plus-circle'],
            ],
        ],


        [
            ['Master Data JFA', 'PG', 'fa-solid fa-medal'],
            [
                ['Daftar Referensi JFA', route('manage.jfa.ref.list'), 'fa-solid fa-list-check'],
                ['Tambah Referensi JFA', route('manage.jfa.ref.new'), 'fa-solid fa-plus-circle'],
            ],
        ],


        [
            ['Master Data JFK', 'PG', 'fa-solid fa-medal'],
            [
                ['Daftar Referensi JFK', route('manage.jfk.ref.list'), 'fa-solid fa-list-check'],
            ],
        ],

        [
            ['Riwayat Nip Pegawai', 'NIP', 'fa-solid fa-fingerprint'],
            [
                ['Daftar History NIP', route('manage.riwayat-nip.list'), 'fa-solid fa-list-check'],
                ['Tambah NIP', route('manage.riwayat-nip.new'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Manage Surat Keputusan', 'SK', 'fa-solid fa-file-signature'],
            [
                ['Daftar SK', route('manage.sk.list'), 'fa-solid fa-list-check'],
                ['Tambah SK', route('manage.sk.input'), 'fa-solid fa-plus-circle'],
            ],
        ],
        [
            ['Laporan', 'Laporan', 'fa-solid fa-file-invoice'],
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

    {{-- Perhatikan bagian icon: kita ambil dari $sidebar[0][2] --}}
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
