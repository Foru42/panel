<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PanelTekController;

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

Route::middleware('auth')->group(function () {
    Route::get('/panel', [PanelTekController::class, 'obtenerInformacionPanelTek'])->name('panel');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\BuscarExtensionesController;

Route::get('/buscar-extensiones', [BuscarExtensionesController::class, 'searchExtensions']);

use App\Http\Controllers\PanelakController;


Route::post('/panelak', [PanelakController::class, 'store'])->name('panelak.store');

use App\Http\Controllers\PanelDeleteController;

Route::post('/eliminar-panel', [PanelDeleteController::class, 'eliminar']);

use App\Http\Controllers\PanelUpdateController;

Route::post('/actualizar-panel', [PanelUpdateController::class, 'actualizarPanel']);
