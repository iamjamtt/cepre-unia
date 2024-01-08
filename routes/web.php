<?php

use App\Helpers\HelpersUnia;
use App\Http\Controllers\ReporteController;
use App\Livewire\Administrador\Configuracion\Roles as RolesAdministrador;
use App\Livewire\Administrador\Configuracion\Semestres as SemestresAdministrador;
use App\Livewire\Administrador\Configuracion\Vacantes as VacantesAdministrador;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Perfil\Index as PerfilIndex;
use App\Livewire\Trabajador\Home as HomeTrabajador;
use App\Livewire\Trabajador\Inscripciones as InscripcionesTrabajador;
use App\Livewire\Trabajador\Ingresantes as IngresantesTrabajador;
use App\Livewire\Trabajador\Postulantes as PostulantesTrabajador;
use App\Livewire\Postulante\Home as HomePostulante;
use App\Livewire\Postulante\Matricula as MatriculaPostulante;
use App\Livewire\Postulante\Documento as DocumentoPostulante;
use App\Livewire\Administrador\User as UserAdministrador;
use Illuminate\Support\Facades\Route;

// ruta de la pagina principal
Route::redirect('/', '/perfil');
// ruta de la pagina de inicio de sesion
Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');
// ruta de la pagina de registro
Route::get('/registro', Register::class)
    ->middleware('verificar_fecha_ciclo')
    ->name('registro.postulantes');
// ruta para ver el perfil del usuario logueado
Route::middleware('auth')
    ->group(function () {
    Route::get('/perfil', PerfilIndex::class)
        ->name('perfil');
});

// rutas de los trabajadores
Route::prefix('trabajador/')
    ->name('trabajador.')
    ->middleware('is_trabajador')
    ->group(function () {
    Route::get('home', HomeTrabajador::class)
        ->name('home');
    Route::get('inscripciones', InscripcionesTrabajador::class)
        ->name('inscripciones');
    Route::get('ingresantes', IngresantesTrabajador::class)
        ->name('ingresantes');
    Route::get('buscar-postulantes', PostulantesTrabajador::class)
        ->name('buscar-postulantes');
});

// rutas de los postulantes
Route::prefix('postulante/')
    ->name('postulante.')
    ->middleware('is_postulante')
    ->group(function () {
    Route::get('home', HomePostulante::class)
        ->middleware('verificar_si_no_finalizo_matricula')
        ->name('home');
    Route::get('matricula', MatriculaPostulante::class)
        ->middleware('verificar_si_finalizo_matricula')
        ->name('matricula');
    Route::get('documentos', DocumentoPostulante::class)
        ->middleware('verificar_si_no_finalizo_matricula')
        ->name('documentos');
});

// rutas del administrador
Route::prefix('administrador/')
    ->name('administrador.')
    ->middleware('is_admin')->group(function () {
    Route::get('home', HomeTrabajador::class)
        ->name('home');
    Route::get('usuarios', UserAdministrador::class)
        ->name('usuarios');
    Route::get('inscripciones', InscripcionesTrabajador::class)
        ->name('inscripciones');
    Route::get('ingresantes', IngresantesTrabajador::class)
        ->name('ingresantes');
    Route::get('ciclos', SemestresAdministrador::class)
        ->name('ciclos');
    Route::get('roles', RolesAdministrador::class)
        ->name('roles');
    Route::get('vacantes', VacantesAdministrador::class)
        ->name('vacantes');
    Route::get('buscar-postulantes', PostulantesTrabajador::class)
        ->name('buscar-postulantes');
});

// rutas de los reportes
Route::prefix('reporte/')
    ->name('reporte.')
    ->middleware('auth')
    ->group(function () {
    Route::get('ficha-matricula/{inscripcion_id}', [ReporteController::class, 'ficha_matricula'])
        ->name('ficha-matricula');
    Route::get('carta-compromiso/{inscripcion_id}', [ReporteController::class, 'carta_compromiso'])
        ->name('carta-compromiso');
    Route::get('declaracion-jurada/{inscripcion_id}', [ReporteController::class, 'declaracion_jurada'])
        ->name('declaracion-jurada');
});
