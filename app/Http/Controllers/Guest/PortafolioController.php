<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Repositories\Proyecto\ProyectoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortafolioController extends Controller
{
    public function __construct(
        protected ProyectoRepositoryInterface $proyectoRepository
    ) {}

    public function index(Request $request): View
    {
        // Obtenemos la categoría del Query Param (?category=videojuegos)
        $categoria = $request->input('category');

        $proyectos = $this->proyectoRepository->obtenerParaGaleria($categoria);

        return view('guest.portafolio', [
            'proyectos' => $proyectos,
            'categoriaActiva' => $categoria ?? 'todos'
        ]);
    }

    public function show(string $slug): View
    {
        $proyecto = $this->proyectoRepository->obtenerDetallePorSlug($slug);

        if (! $proyecto) {
            abort(404, 'El proyecto no existe o no está disponible.');
        }

        // Retornamos la vista (que crearemos vacía en el siguiente paso)
        return view('guest.proyecto.show', [
            'proyecto' => $proyecto
        ]);
    }
}