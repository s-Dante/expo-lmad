<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Guest\PortafolioController;
use App\Http\Controllers\Guest\ProyectoController;

// Rutas de paginas publicas

/**
 * Vista de la Landig Page
 */
Route::get('/', function () {
    return view('guest.landing-page');
});

//Ruta de autentificacion
/**
 * Vista de Login
 */
Route::get('/login', function () {
    return view('guest.login');
})->name('login');

/**
 * Vista de Nuestras Estrellas / Patrocinadores
 */
Route::get('/NuestrasEstrellas', function () {
    return view('guest.patrocinadores');
});

/**
 * Vista de Cronograma
 */
Route::get('/Cronograma', function () {
    return view('guest.cronograma');
});

/**
 * Vista de Portafolio
 */
Route::get('/Portafolio', [PortafolioController::class, 'index'])->name('portafolio.index');
Route::get('/Portafolio/{slug}', [PortafolioController::class, 'show'])->name('proyecto.show');

Route::get('/Proyecto', function () {
    return view('guest.portafolio-proyecto');
});



/*
RUTAS PARA INICIAR Y CERRAR SESION

Pos aqui se hace todo para iniciar o cerrar una sesion con el controlador Auth, asi nomas sin tanto rollo que no es sushi.
*/
Route::post('/auth/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])
    ->name('auth.login');

Route::get('/auth/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])
    ->name('auth.logout');


/* 
PAGINAS CON MIDDLEWARE - AUTENTICACION Y ACCESO UNICAMENTE POR ROL

El funcionamiento es practicamente igual, solo que si ahora quieres hacer una rutilla para cada rol lo debes de meter dentro del
Route::middleware que le corresponda uwu. Se valida que haya tanto una sesion iniciada como que el rol se cumpla para cada vista, asi un alumno curioso no va a poder andar chismoseando vistas ajenas a su posicion inferior muajaja. Pero bueno ya asi eso fue todo creo que todo claro, por si hay alguna duda del funcionamiento me mandan wsp o a mi insta que tengo insta, en teams tambien pero en facebook no porque no tengo. tqm papoi <3 

*/

// Rutas de Super_Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');
    
    Route::get('/superadmin/revision-proyecto', function () {
        return view('superadmin.revision-proyecto');
    })->name('superadmin.revision-proyecto');
});

//Rutas de Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

//Rutas de Estudiante 
Route::middleware(['auth', 'role:estudiante'])->group(function () {
    Route::get('/estudiante/dashboard', function () {
        return view('student.dashboard');
    })->name('estudiante.dashboard');

    Route::get('/estudiante/registro-proyecto', function () {
        return view('student.registro-proyecto');
    })->name('estudiante.registro-proyecto');

    Route::get('/estudiante/lista-exposiones', function () {
        return view('student.lista-exposiones');
    })->name('estudiante.lista-exposiones');
});

//Rutas de Profesor
Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::get('/profesor/dashboard', function () {
        return view('teacher.dashboard');
    })->name('profesor.dashboard');

    Route::get('/profesor/registro-expositores', [App\Http\Controllers\Teacher\ProfesorController::class, 'cargarRegistroExpositores'])
        ->name('teacher.registro-expositores');

    Route::post('/profesor/cargar-proyecto', [App\Http\Controllers\Teacher\ProfesorController::class, 'cargarProyecto'])
        ->name('teacher.cargar-proyecto');

    Route::get('/profesor/lista-proyectos', [App\Http\Controllers\Teacher\ProfesorController::class, 'listadoProyectos'])
        ->name('teacher.lista-proyectos');
});

//Rutas de staff
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');
});


/* 
APIS 

La verdad creo que dentro de lo planeado no teniamos pensado algo asi, pero es consecuencia de que hacer una funcionalidad en el registro de proyectos. Medio sobrepensador de mi parte separar esta parte, pero creo que es util si se desea implementar esta funcionalidad en otras vistas de distintos roles, e incluso hacer algo de APIs para terceros si es que se llega a necesitar. Se pueden hacer modificaciones para su middleware propio pero eso eventualmente sera analizado por el super genial, fantastico, asombroso, poderoso, inconmensurable, apoteosico, biblico, potente y mamastroso equipo de programacion del departamento multimedia.

*/

Route::get('/api/buscar-estudiante/{matricula}', [App\Http\Controllers\api\ApiController::class, 'buscarEstudiante']);
