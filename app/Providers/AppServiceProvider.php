<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Proyecto\ProyectoRepositoryInterface;
use App\Repositories\Proyecto\EloquentProyectoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        ProyectoRepositoryInterface::class,
        EloquentProyectoRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
