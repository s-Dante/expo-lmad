<?php

namespace App\Providers;

use App\Models\Profesor;
use Illuminate\Support\ServiceProvider;

use App\Repositories\Proyecto\ProyectoRepositoryInterface;
use App\Repositories\Proyecto\EloquentProyectoRepository;
use App\Repositories\Teacher\ProfesorRepositoryInterface;
use App\Repositories\Teacher\EloquentProfesorRepository;
use App\Repositories\Student\EstudianteRepositoryInterface;
use App\Repositories\Student\EloquentEstudianteRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Proyecto
        $this->app->bind(
            ProyectoRepositoryInterface::class,
            EloquentProyectoRepository::class
        );

        // Profesor
        $this->app->bind(
            ProfesorRepositoryInterface::class,
            EloquentProfesorRepository::class
        );

        // Estudiante (Este era el que fallaba porque Laravel lo ignoraba arriba)
        $this->app->bind(
            EstudianteRepositoryInterface::class,
            EloquentEstudianteRepository::class
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
