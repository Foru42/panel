<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PanelTekController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');


Route::get('/reset-database', function () {
    // Ejecutar el comando 'migrate:fresh'
    Artisan::call('migrate:fresh');

    // Devolver una respuesta
    return 'Base de datos reiniciada';
});

Route::get('/seed', function () {
    // Ejecutar los seeders
    Artisan::call('db:seed');

    // Devolver una respuesta
    return 'Seeders ejecutados';
});
Route::get('/migrate', function () {
    // Ejecutar las migraciones
    Artisan::call('migrate');

    // Devolver una respuesta
    return 'Migraciones ejecutadas';
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/panel', [PanelTekController::class, 'obtenerInformacionPanelTek'])->name('panel');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\BuscarExtensionesController;

Route::get('/buscar-extensiones', [BuscarExtensionesController::class, 'searchExtensions']);
