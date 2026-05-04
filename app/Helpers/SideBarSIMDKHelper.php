<?php

if (!function_exists('BuildSidebar')) {

    function BuildSidebar()
    {
        $rolesRaw = session('account')['role'] ?? [];

        // ===============================
        // NORMALISASI ROLE
        // ===============================
        $userRoles = collect($rolesRaw)
            ->map(function ($value, $key) {
                $key = strtolower($key);
                if (is_bool($value) && $value === true) return $key;
                if ($key === 'sumber daya manusia') return 'sdm';
                return null;
            })
            ->filter()
            ->values();

        // ===============================
        // AMBIL TOP LEVEL (Dari struktur session yang baru)
        // ===============================
        $topLevel = isset($rolesRaw['direktorat']['level'])
            ? (int) $rolesRaw['direktorat']['level']
            : (isset($rolesRaw['top-level']) ? (int) $rolesRaw['top-level'] : null);

        // ===============================
        // FUNGSI CEK AKSES (LOGIKA ATAU/OR)
        // ===============================
        $checkAccess = function ($rolesConfig) use ($userRoles, $topLevel) {
            // Jika tidak ada pembatasan sama sekali, langsung lolos
            if (empty($rolesConfig)) return true;

            $isAllowed = false;

            // 1. Ambil nama-nama role saja (buang key 'range_level' dari array)
            $stringRoles = collect($rolesConfig)->filter(function ($val, $key) {
                return is_numeric($key); // Hanya ambil yang indexnya angka (teks role)
            })->toArray();

            // Cek apakah user punya salah satu role tersebut
            if ($userRoles->intersect($stringRoles)->isNotEmpty()) {
                $isAllowed = true;
            }

            // 2. ATAU, jika belum lolos role, cek range_level
            if (!$isAllowed && isset($rolesConfig['range_level'])) {
                if ($topLevel !== null) {
                    [$min, $max] = $rolesConfig['range_level'];
                    if ($topLevel >= $min && $topLevel <= $max) {
                        $isAllowed = true;
                    }
                }
            }

            return $isAllowed;
        };

        // ===============================
        // BUILD SIDEBAR
        // ===============================
        return collect(config('sidebar-simdk'))

            // FILTER LEVEL GRUP (META)
            ->filter(function ($group) use ($checkAccess) {
                return $checkAccess($group['meta']['roles'] ?? []);
            })

            // FILTER LEVEL MENU
            ->map(function ($group) use ($checkAccess) {
                $menus = collect($group['menus'])
                    ->filter(function ($menu) use ($checkAccess) {
                        return $checkAccess($menu['roles'] ?? []);
                    })
                    ->map(function ($menu) {
                        return [
                            'label' => $menu['label'],
                            'url'   => route($menu['route'], $menu['params'] ?? []),
                            'route' => $menu['route'],
                            'icon'  => $menu['icon'],
                        ];
                    })
                    ->values();

                if ($menus->isEmpty()) return null;

                return [
                    'title' => $group['meta']['title'],
                    'icon'  => $group['meta']['icon'],
                    'menus' => $menus,
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }
}
