<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelTekController;
use App\Http\Controllers\ModController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\NonAdminMiddleware;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\BuscarExtensionesController;
use App\Http\Controllers\PanelDeleteController;
use App\Http\Controllers\PanelakController;
use App\Http\Controllers\PanelUpdateController;
use App\Http\Controllers\UsuarioController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');


Route::get('/reset-database', function () {

    Artisan::call('migrate:fresh');
    Artisan::call('migrate');
    Artisan::call('db:seed');
    // Devolver una respuesta
    return 'Base de datos reiniciada';
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/panel', [PanelTekController::class, 'showPaneladmin'])->name('panel');
});

Route::middleware(['auth', NonAdminMiddleware::class])->group(function () {
    Route::get('/panelNoadmin', [PanelTekController::class, 'showPanelNoadmin'])->name('panelNoadmin');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/buscar-extensiones', [BuscarExtensionesController::class, 'searchExtensions']);

Route::post('/panelak', [PanelakController::class, 'store'])->name('panelak.store');

Route::post('/eliminar-panel', [PanelDeleteController::class, 'eliminar']);

Route::post('/actualizar-panel', [PanelUpdateController::class, 'actualizarPanel']);

Route::get('/ultimas-modificaciones-panel-tek', [ModController::class, 'ultimasModificacionesPanelTek'])->name('ultimas-modificaciones-panel-tek');

Route::get('/kontua-sortu', [CreateUserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CreateUserController::class, 'register'])->name('register');

Route::get('/usuarios', [UsuarioController::class, 'index']);

Route::post('/eliminar-usuario', [UsuarioController::class, 'eliminar'])->name('eliminar');

Route::post('/cambiar-usuario', [UsuarioController::class, 'cambiar']);
use App\Http\Controllers\CambioContrasenaController;

Route::post('/cambiar-contrasena', [CambioContrasenaController::class, 'cambiarContraseña']);