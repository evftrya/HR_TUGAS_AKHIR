<?php

return [
    // 1. MANAJEMEN PEGAWAI
    [
        'meta' => [
            'title' => 'Manajemen Pegawai',
            'icon' => 'fa-solid fa-users-gear',
            'roles' => ['is_admin', 'sdm'],
        ],
        'menus' => [
            [
                'label' => 'Dashboard Pegawai',
                'route' => 'manage.pegawai.dashboard',
                'icon' => 'fa-solid fa-gauge-high',
                'roles' => ['is_admin', 'sdm'],
                // 'range_level' => [1, 2], // Berdasarkan middleware range-level:[1|2]
            ],
            [
                'label' => 'Daftar Pegawai',
                'route' => 'manage.pegawai.list',
                'params' => ['destination' => 'Active'],
                'icon' => 'fa-solid fa-address-book',
                'roles' => ['is_admin', 'sdm'],
                // 'range_level' => [1, 2], // Berdasarkan middleware range-level:[1|2]
            ],
            [
                'label' => 'Riwayat NIP',
                'route' => 'manage.riwayat-nip.list',
                'icon' => 'fa-solid fa-id-badge',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Kontak Darurat',
                'route' => 'manage.emergency-contact.list',
                'params' => ['id_User' => 'all'],
                'icon' => 'fa-solid fa-phone-flip',
                'roles' => ['is_admin', 'sdm'],
            ],
        ],
    ],

    // 2. STRUKTUR ORGANISASI
    [
        'meta' => [
            'title' => 'Struktur Organisasi',
            'icon' => 'fa-solid fa-sitemap',
            'roles' => ['is_admin', 'sdm'],
        ],
        'menus' => [
            [
                'label' => 'Daftar Fakultas',
                'route' => 'manage.fakultas.index',
                'icon' => 'fa-solid fa-building-columns',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Daftar Program Studi',
                'route' => 'manage.prodi.index',
                'icon' => 'fa-solid fa-school',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Bagian / Unit Kerja',
                'route' => 'manage.bagian.list',
                'icon' => 'fa-solid fa-building-user',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Pengawakan (SOTK)',
                'route' => 'manage.pengawakan.list',
                'icon' => 'fa-solid fa-diagram-project',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Level Jabatan',
                'route' => 'manage.level.list',
                'icon' => 'fa-solid fa-layer-group',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Formasi Pegawai',
                'route' => 'manage.formasi.list',
                'icon' => 'fa-solid fa-users-rectangle',
                'roles' => ['is_admin', 'sdm'],
            ],
        ],
    ],

    // 3. KARIR & PENDIDIKAN
    [
        'meta' => [
            'title' => 'Karir & Pendidikan',
            'icon' => 'fa-solid fa-briefcase',
            'roles' => ['is_admin', 'sdm'],
        ],
        'menus' => [
            [
                'label' => 'Jabatan Akademik (JFA)',
                'route' => 'manage.jfa.list',
                'icon' => 'fa-solid fa-user-tie',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Jabatan Keahlian (JFK)',
                'route' => 'manage.jfk.list',
                'icon' => 'fa-solid fa-user-gear',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Pangkat & Golongan',
                'route' => 'manage.pangkat-golongan.list',
                'icon' => 'fa-solid fa-medal',
                'roles' => ['is_admin', 'sdm'],
            ],
            [
                'label' => 'Riwayat Pendidikan',
                'route' => 'manage.jenjang-pendidikan.list',
                'icon' => 'fa-solid fa-graduation-cap',
                'roles' => ['is_admin', 'sdm'],
            ],
        ],
    ],

    // 4. PENGEMBANGAN DOSEN
    [
        'meta' => [
            'title' => 'Pengembangan Dosen',
            'icon' => 'fa-solid fa-chalkboard-user',
            'roles' => ['is_admin', 'sdm', 'is_dosen'],
        ],
        'menus' => [
            [
                'label' => 'Sertifikasi Dosen',
                'route' => 'manage.sertifikasi-dosen.list',
                'icon' => 'fa-solid fa-certificate',
                'roles' => ['is_admin', 'sdm', 'is_dosen'],
            ],
            [
                'label' => 'Kelompok Keahlian',
                'route' => 'manage.kelompok-keahlian.list',
                'icon' => 'fa-solid fa-people-group',
                'roles' => ['is_admin', 'sdm', 'is_dosen'],
            ],
            [
                'label' => 'Center of Excellence',
                'route' => 'manage.coe.index',
                'icon' => 'fa-solid fa-hubspot',
                'roles' => ['is_admin', 'sdm', 'is_dosen'],
            ],
            [
                'label' => 'Studi Lanjut',
                'route' => 'manage.studi-lanjut.list',
                'icon' => 'fa-solid fa-book-reader',
                'roles' => ['is_admin', 'sdm'],
            ],
        ],
    ],

    // 5. KINERJA & ARSIP
    [
        'meta' =>
        [
            'title' => 'Arsip',
            'icon' => 'fa-solid fa-file-invoice',
            'roles' => ['is_admin', 'sdm'],
        ],
        'menus' => [
            [
                'label' => 'Daftar SK',
                'route' => 'manage.sk.list',
                'icon' => 'fa-solid fa-file-pdf',
                'roles' => ['is_admin', 'sdm'],
            ],
        ],
    ],

    // 6. DATA MASTER (KHUSUS ADMIN)
    [
        'meta' => [
            'title' => 'Data Master',
            'icon' => 'fa-solid fa-database',
            'roles' => ['is_admin'],
        ],
        'menus' => [
            [
                'label' => 'Master JFA',
                'route' => 'manage.jfa.ref.list',
                'icon' => 'fa-solid fa-table-list',
                'roles' => ['is_admin'],
            ],
            [
                'label' => 'Master JFK',
                'route' => 'manage.jfk.ref.list',
                'icon' => 'fa-solid fa-table-list',
                'roles' => ['is_admin'],
            ],
            [
                'label' => 'Master Pangkat',
                'route' => 'manage.pangkat-golongan.ref.list',
                'icon' => 'fa-solid fa-table-list',
                'roles' => ['is_admin'],
            ],
            [
                'label' => 'Master Pendidikan',
                'route' => 'manage.jenjang-pendidikan.ref.list',
                'icon' => 'fa-solid fa-table-list',
                'roles' => ['is_admin'],
            ],
            [
                'label' => 'Status Pegawai',
                'route' => 'manage.status-pegawai.list',
                'icon' => 'fa-solid fa-user-check',
                'roles' => ['is_admin'],
            ],
        ],
    ],
];
