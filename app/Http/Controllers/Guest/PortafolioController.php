<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Repositories\Proyecto\ProyectoRepositoryInterface;
use App\Models\Categoria; // <-- Importamos el modelo (o podrías hacer un repositorio para categorías)
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortafolioController extends Controller
{
    public function __construct(
        protected ProyectoRepositoryInterface $proyectoRepository
    ) {}

    public function index(Request $request): View
    {
        // 1. Capturamos el slug de la URL (?category=videojuegos)
        $categoriaSlug = $request->input('category');

        // 2. Obtenemos los proyectos filtrados
        $proyectos = $this->proyectoRepository->obtenerParaGaleria($categoriaSlug);

        // 3. NUEVO: Obtenemos todas las categorías para pintar el menú de filtros dinámicamente
        // (Sugerencia: Podrías cachear esto después si no cambia mucho)
        $categorias = Categoria::has('materias')->get(); // Solo traemos categorías que tengan materias asignadas (opcional)

        return view('guest.portafolio', [
            'proyectos' => $proyectos,
            'categorias' => $categorias, // <-- Pasamos la lista al front
            'categoriaActiva' => $categoriaSlug ?? 'todos'
        ]);
    }

    public function show(string $slug): View
    {
        $proyecto = $this->proyectoRepository->obtenerDetallePorSlug($slug);

        if (! $proyecto) {
            abort(404, 'El proyecto no existe o no está disponible.');
        }

        return view('guest.proyecto.show', [
            'proyecto' => $proyecto
        ]);
    }
}