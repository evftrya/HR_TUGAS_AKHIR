<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ middleware tetap
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

        // ✅ migrations tetap
        $this->loadMigrationsFrom(database_path('migrations/default'));
        $this->loadMigrationsFrom(database_path('migrations/dupak'));

        // ===============================
        // ✅ SIDEBAR LOGIC
        // ===============================
        View::composer('kelola_data.sidebar', function ($view) {
            // dd(session('sidebar-simdk', []));
            $view->with('sidebars', session('sidebar-simdk', []));
        });
    }
}
