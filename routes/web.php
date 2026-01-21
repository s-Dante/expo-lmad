<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('/guest/landing-page');
});

Route::get('/login', function () {
    return view('/guest/login');
});

Route::get('/NuestrasEstrellas', function () {
    return view('guest.patrocinadores');
});

Route::get('/Cronograma', function () {
    return view('guest.cronograma');
});

// Rutas de Autenticacion
Route::post('/auth/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])
->name('auth.login');

// Rutas de Super_Admin
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})->name('superadmin.dashboard');

//Rutas de admin
Route::get('/admin/dashboard', function () {
    return view(view: 'admin.dashboard');
})->name('admin.dashboard');

//Rutas de profesor
Route::get('/profesor/dashboard', function () {
    return view(view: 'teacher.dashboard');
})->name('profesor.dashboard');

//Rutas de estudiante 
Route::get('/estudiante/dashboard', function () {
    return view('student.dashboard');
})->name('estudiante.dashboard');

//Rutas de staff
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->name('staff.dashboard');
