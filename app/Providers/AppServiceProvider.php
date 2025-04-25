<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\UsuarioRepository::class,
            \App\Repositories\UsuarioRepository::class
        );

        $this->app->bind(
            \App\Repositories\PkUsuarioRepository::class,
            \App\Repositories\PkUsuarioRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
