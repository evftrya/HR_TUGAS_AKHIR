<?php

if (!function_exists('buildSidebar')) {

    function buildSidebar()
    {
        $rolesRaw = session('account')['role'] ?? [];

        // ===============================
        // NORMALISASI ROLE
        // ===============================
        $userRoles = collect($rolesRaw)
            ->map(function ($value, $key) {

                $key = strtolower($key);

                if (is_bool($value) && $value === true) {
                    return $key;
                }

                if ($key === 'sumber daya manusia') {
                    return 'sdm';
                }

                return null;
            })
            ->filter()
            ->values();

        // ===============================
        // TOP LEVEL
        // ===============================
        $topLevel = isset($rolesRaw['top-level'])
            ? (int) $rolesRaw['top-level']
            : null;

        // ===============================
        // BUILD SIDEBAR
        // ===============================
        return collect(config('sidebar-simdk'))

            ->filter(function ($group) use ($userRoles) {
                return empty($group['meta']['roles']) ||
                    $userRoles->intersect($group['meta']['roles'])->isNotEmpty();
            })

            ->map(function ($group) use ($userRoles, $topLevel) {

                $menus = collect($group['menus'])

                    ->filter(function ($menu) use ($userRoles, $topLevel) {

                        // role
                        if (!empty($menu['roles'])) {
                            if ($userRoles->intersect($menu['roles'])->isEmpty()) {
                                return false;
                            }
                        }

                        // range level
                        if (isset($menu['range_level']) && $topLevel !== null) {
                            [$min, $max] = $menu['range_level'];

                            if (!is_null($min) && $topLevel < $min) return false;
                            if (!is_null($max) && $topLevel > $max) return false;
                        }

                        return true;
                    })

                    ->map(function ($menu) {
                        return [
                            'label' => $menu['label'],
                            'url' => route($menu['route'], $menu['params'] ?? []),
                            'route' => $menu['route'],
                            'icon' => $menu['icon'],
                        ];
                    })
                    ->values();

                if ($menus->isEmpty()) return null;

                return [
                    'title' => $group['meta']['title'],
                    'icon' => $group['meta']['icon'],
                    'menus' => $menus,
                ];
            })

            ->filter()
            ->values()
            ->toArray();
    }
}
