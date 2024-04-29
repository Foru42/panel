<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelTekController;
use App\Http\Controllers\ModController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\BuscarExtensionesController;
use App\Http\Controllers\PanelDeleteController;
use App\Http\Controllers\PanelakController;
use App\Http\Controllers\PanelUpdateController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CambioContrasenaController;
use App\Http\Controllers\PanelFavStarContoller;
use App\Models\SisOperativo;


Route::get('/reset-database', function () {

    Artisan::call('migrate:fresh');
    Artisan::call('migrate');
    Artisan::call('db:seed');
    // Devolver una respuesta
    return 'Base de datos reiniciada';
});

Route::get('/data', [PanelTekController::class, 'showPaneladmin']);

Route::view('/', 'logeatu');
Route::view('/login', 'logeatu');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::view('/kontua-sortu', 'register');
Route::post('/registrar', [CreateUserController::class, 'register'])->name('register');


Route::view('/panel', 'panelMain');
Route::get('/check-admin-status', [LoginController::class, 'checkAdminStatus']);


Route::get('/ultimas-modificaciones-panel-tek', [ModController::class, 'obtenerInformacionPanelTekActualizado']);

Route::get('/buscar-extensiones', [BuscarExtensionesController::class, 'searchExtensions']);
Route::get('/obtener-sistemas-operativos', function () {
    $sisOperativos = SisOperativo::all();
    return response()->json($sisOperativos);
})->name('obtener.sistemas.operativos');
Route::post('/panelakGehi', [PanelakController::class, 'store']);



Route::post('/cambiar-usuario', [UsuarioController::class, 'cambiar']);
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/eliminar-usuario', [UsuarioController::class, 'eliminar'])->name('eliminar');
Route::post('/cambiar-contrasena', [CambioContrasenaController::class, 'cambiarContraseña']);




Route::post('/actualizar-panel', [PanelUpdateController::class, 'actualizarPanel']);
Route::post('/eliminar-panel', [PanelDeleteController::class, 'eliminar']);
Route::post('/anadir-panel', [PanelTekController::class, 'anadir']);

Route::post('/anadir-fav', [PanelFavStarContoller::class, 'anadirFavorito']);
Route::get('/gustukoa-ikusi', [PanelFavStarContoller::class, 'showFav']);

