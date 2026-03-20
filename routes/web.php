<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Guest\PortafolioController;
use App\Http\Controllers\Student\EstudianteController;
use App\Http\Controllers\Teacher\ProfesorController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Admin\AdminController;
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
 * Vista de Registro de AFI
 */
Route::get('/Registro', function () {
    return view('guest.registro');
})->name('registro');

/**
 * Vista de Asistencia de AFI
 */
Route::get('/Asistencia', function () {
    return view('guest.asistencia');
})->name('asistencia');

/**
 * Vista de Cronograma
 */
Route::get('/Cronograma', function () {
    return view('guest.cronograma');
})->name('cronograma');

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
Route::post('/auth/login', [AuthController::class, 'login'])
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

    Route::get('/superadmin/revision-proyecto/{id}', [SuperAdminController::class, 'paginaRevisionProyecto'])->name('superadmin.revision-proyecto');

    Route::get('/superadmin/proyectos', [SuperAdminController::class, 'paginaProyectos'])
        ->name('superadmin.proyectos');

    Route::post("/superadmin/actualizarRevisionProyecto", [SuperAdminController::class, 'actualizarRevisionProyecto']);Route::get('/superadmin/getDashboardInfo', [SuperAdminController::class, 'getDashboardInfo']);

    Route::post("/superadmin/actualizarRevisionProyecto", [SuperAdminController::class, 'actualizarRevisionProyecto']);

    Route::get('/superadmin/mandarRevisionProyecto/{id}', [SuperAdminController::class, 'mandarRevisionProyecto']);
});

//Rutas de Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/dashboard/exportar', [App\Http\Controllers\Admin\AdminDashboardController::class, 'exportar'])
        ->name('admin.dashboard.export');

    // Eventos
    Route::get('/admin/events', [App\Http\Controllers\Admin\AdminEventoController::class, 'index'])
        ->name('admin.events');
    Route::post('/admin/eventos', [App\Http\Controllers\Admin\AdminEventoController::class, 'store'])
        ->name('admin.eventos.store');
    Route::put('/admin/eventos/{evento}', [App\Http\Controllers\Admin\AdminEventoController::class, 'update'])
        ->name('admin.eventos.update');
    Route::delete('/admin/eventos/{evento}', [App\Http\Controllers\Admin\AdminEventoController::class, 'destroy'])
        ->name('admin.eventos.destroy');

    // Conferencistas (Guests)
    Route::get('/admin/guest', [App\Http\Controllers\Admin\AdminConferencistaController::class, 'index'])
        ->name('admin.guest');
    Route::post('/admin/conferencistas', [App\Http\Controllers\Admin\AdminConferencistaController::class, 'store'])
        ->name('admin.conferencistas.store');
    Route::put('/admin/conferencistas/{conferencista}', [App\Http\Controllers\Admin\AdminConferencistaController::class, 'update'])
        ->name('admin.conferencistas.update');
    Route::delete('/admin/conferencistas/{conferencista}', [App\Http\Controllers\Admin\AdminConferencistaController::class, 'destroy'])
        ->name('admin.conferencistas.destroy');

    // Empresas / Patrocinadores
    Route::get('/admin/companies', [App\Http\Controllers\Admin\AdminPatrocinadorController::class, 'index'])
        ->name('admin.companies');
    Route::post('/admin/patrocinadores', [App\Http\Controllers\Admin\AdminPatrocinadorController::class, 'store'])
        ->name('admin.patrocinadores.store');
    Route::put('/admin/patrocinadores/{patrocinador}', [App\Http\Controllers\Admin\AdminPatrocinadorController::class, 'update'])
        ->name('admin.patrocinadores.update');
    Route::delete('/admin/patrocinadores/{patrocinador}', [App\Http\Controllers\Admin\AdminPatrocinadorController::class, 'destroy'])
        ->name('admin.patrocinadores.destroy');

    // Maestros (Teachers)
    Route::get('/admin/teachers', [App\Http\Controllers\Admin\AdminTeacherController::class, 'index'])
        ->name('admin.teachers');
    Route::post('/admin/teachers', [App\Http\Controllers\Admin\AdminTeacherController::class, 'store'])
        ->name('admin.teachers.store');
    Route::put('/admin/teachers/{profesor}', [App\Http\Controllers\Admin\AdminTeacherController::class, 'update'])
        ->name('admin.teachers.update');
    Route::delete('/admin/teachers/{profesor}', [App\Http\Controllers\Admin\AdminTeacherController::class, 'destroy'])
        ->name('admin.teachers.destroy');

    // Staff
    Route::get('/admin/staff', [App\Http\Controllers\Admin\AdminStaffController::class, 'index'])
        ->name('admin.staff');
    Route::post('/admin/staff', [App\Http\Controllers\Admin\AdminStaffController::class, 'store'])
        ->name('admin.staff.store');
    Route::put('/admin/staff/{staff}', [App\Http\Controllers\Admin\AdminStaffController::class, 'update'])
        ->name('admin.staff.update');
    Route::delete('/admin/staff/{staff}', [App\Http\Controllers\Admin\AdminStaffController::class, 'destroy'])
        ->name('admin.staff.destroy');
});

//Rutas de Estudiante 
Route::middleware(['auth', 'role:estudiante'])->group(function () {
    Route::get('/estudiante/dashboard', function () {
        return view('student.dashboard');
    })->name('estudiante.dashboard');

    Route::get('/estudiante/registro-proyecto', function () {
        return view('student.registro-proyecto');
    })->name('estudiante.registro-proyecto');

    Route::get('/estudiante/lista-exposiciones', function () {
        return view('student.lista-exposiciones');
    })->name('estudiante.lista-exposiciones');

    Route::get('/estudiante/dashboard', [EstudianteController::class, 'dashboard'])->name('estudiante.dashboard');

    Route::get('/estudiante/asistencia-qr', [EstudianteController::class, 'asistenciaQr'])->name('estudiante.qr');

    Route::get('/estudiante/proyectos', [EstudianteController::class, 'index'])->name('estudiante.proyectos.index');
    Route::get('/estudiante/proyectos/{id}/editar', [EstudianteController::class, 'edit'])->name('estudiante.proyectos.edit');
    Route::get('/estudiante/proyectos/{id}/registro', [EstudianteController::class, 'firts_Show'])->name('estudiante.proyectos.create');
    Route::put('/estudiante/proyectos/{id}', [EstudianteController::class, 'update'])->name('estudiante.proyectos.update');
    Route::put('/estudiante/proyectos/{id}', [EstudianteController::class, 'updateEdit'])->name('estudiante.proyectos.updateEdit');
    Route::put('/estudiante/proyectos/{id}/send', [EstudianteController::class, 'send'])->name('estudiante.proyectos.send');
    Route::get('/estudiante/proyectos/{id}', [EstudianteController::class, 'show'])->name('estudiante.proyectos.show');
});

//Rutas de Profesor
Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::get('/profesor/dashboard', function () {
        return view('teacher.dashboard');
    })->name('profesor.dashboard');

    Route::get('/profesor/registro-expositores', [ProfesorController::class, 'cargarRegistroExpositores'])
        ->name('teacher.registro-expositores');

    Route::post('/profesor/cargar-proyecto', [ProfesorController::class, 'cargarProyecto'])
        ->name('teacher.cargar-proyecto');

    Route::get('/profesor/lista-proyectos', [App\Http\Controllers\Teacher\ProfesorController::class, 'listadoProyectos'])
        ->name('teacher.lista-proyectos');

    Route::post('/profesor/actualizar-proyecto', [App\Http\Controllers\Teacher\ProfesorController::class, 'actualizarProyecto'])
        ->name('teacher.actualizar-proyecto');
});

//Rutas de staff
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    Route::get('/staff/expositor', function () {
        return view('staff.expositor');
    })->name('staff.expositor');

    Route::get('/staff/registro-asistencia-expositor/{matricula}', [App\Http\Controllers\Staff\StaffController::class, 'registrarAsistenciaExpositor']);

     Route::get('/staff/visitantes', function () {
        return view('staff.visitantes');
    })->name('staff.visitantes');

     Route::get('/staff/empresas', function () {
        return view('staff.empresas');
    })->name('staff.empresas');

        Route::get('/staff/empresas/asistencia', function () {
        return view('staff.empresas-asist');
    })->name('staff.empresa-asistencia');

});


/* 
APIS 

La verdad creo que dentro de lo planeado no teniamos pensado algo asi, pero es consecuencia de que hacer una funcionalidad en el registro de proyectos. Medio sobrepensador de mi parte separar esta parte, pero creo que es util si se desea implementar esta funcionalidad en otras vistas de distintos roles, e incluso hacer algo de APIs para terceros si es que se llega a necesitar. Se pueden hacer modificaciones para su middleware propio pero eso eventualmente sera analizado por el super genial, fantastico, asombroso, poderoso, inconmensurable, apoteosico, biblico, potente y mamastroso equipo de programacion del departamento multimedia.

*/

Route::get('/api/buscar-estudiante/{matricula}', [App\Http\Controllers\api\ApiController::class, 'buscarEstudiantePorMatricula']);
Route::get('/api/obtener-proyecto-token/{token}', [App\Http\Controllers\api\ApiController::class, 'obtenerProyectoPorToken']);
Route::get('/api/obtener-proyecto-id/{id}', [App\Http\Controllers\api\ApiController::class, 'obtenerProyectoPorId']);
