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

// Rutas de Autenticacion
Route::post('/auth/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])
->name('auth.login');

Route::get('/auth/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])
->name('auth.logout');

// Rutas de Super_Admin
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})->name('superadmin.dashboard');

//Rutas de admin
Route::get('/admin/dashboard', function () {
    return view(view: 'admin.dashboard');
})->name('admin.dashboard');

//Rutas de estudiante 
Route::get('/estudiante/dashboard', function () {
    return view('student.dashboard');
})->name('estudiante.dashboard');

//Rutas de profesor
Route::get('/profesor/dashboard', function () {
    return view(view: 'teacher.dashboard');
})->name('profesor.dashboard');

Route::get('/profesor/registro-expositores', [App\Http\Controllers\Teacher\ProfesorController::class, 'cargarRegistroExpositores'])
->name('teacher.registro-expositores');

Route::post('/profesor/cargar-proyecto', [App\Http\Controllers\Teacher\ProfesorController::class, 'cargarProyecto'])
->name('teacher.cargar-proyecto');

Route::get('/profesor/lista-proyectos', [App\Http\Controllers\Teacher\ProfesorController::class, 'listadoProyectos'])
->name('teacher.lista-proyectos');

Route::get('/buscar-estudiante/{matricula}', [App\Http\Controllers\Teacher\ProfesorController::class, 'buscarEstudiante']);

//Rutas de staff
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->name('staff.dashboard');

