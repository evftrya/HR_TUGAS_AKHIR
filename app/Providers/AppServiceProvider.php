<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure admin middleware is properly registered
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

        // Load migrations from subdirectories
        $this->loadMigrationsFrom(database_path('migrations/default'));
        $this->loadMigrationsFrom(database_path('migrations/dupak'));
    }
}
