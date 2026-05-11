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

        // ── Admin Repositories ──────────────────────────────────────────

        $this->app->bind(
            \App\Repositories\Admin\EventoRepositoryInterface::class,
            \App\Repositories\Admin\EloquentEventoRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\ConferencistaRepositoryInterface::class,
            \App\Repositories\Admin\EloquentConferencistaRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\PatrocinadorRepositoryInterface::class,
            \App\Repositories\Admin\EloquentPatrocinadorRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\ProfesorAdminRepositoryInterface::class,
            \App\Repositories\Admin\EloquentProfesorAdminRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\StaffRepositoryInterface::class,
            \App\Repositories\Admin\EloquentStaffRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\DashboardRepositoryInterface::class,
            \App\Repositories\Admin\EloquentDashboardRepository::class
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
