<?php

use App\Http\Controllers\BuscarExtensionesController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\IruzkinController;
use App\Http\Controllers\KoloreakController;
use App\Http\Controllers\LdapLoginController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModController;
use App\Http\Controllers\PanelakController;
use App\Http\Controllers\PanelFavStarContoller;
use App\Http\Controllers\PanelTekController;
use App\Http\Controllers\PanelUpdateController;
use App\Http\Controllers\ProfilaController;
use App\Http\Controllers\UsuarioController;
use App\Models\SisOperativo;
use App\Models\Teknologiak;
use Illuminate\Support\Facades\Route;

//Datubasea
Route::get('/reset-database', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('migrate');
    Artisan::call('db:seed');
    // Devolver una respuesta
    return 'Datu basea Sortuta :)';

});
//Datuak
Route::get('/data', [PanelTekController::class, 'showPaneladmin']);
Route::get('/roles', [UsuarioController::class, 'asignarRol']);

//Login partea eta Erabiltzaileak
Route::view('/', 'logeatu');
Route::view('/login', 'logeatu');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/registrar', [CreateUserController::class, 'register'])->name('register');
Route::get('/check-admin-status', [LoginController::class, 'checkAdminStatus']);

Route::post('/ldap/login', [LdapLoginController::class, 'login'])->name('ldap.login');
Route::post('/ProfilaGorde', [ProfilaController::class, 'GordeDatuak']);

//Erabiltzaile Gestioa aplikazioan
Route::post('/cambiar-usuario', [UsuarioController::class, 'cambiar']);
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuario', [UsuarioController::class, 'mostrarPorNombre']);
Route::post('/eliminar-usuario', [UsuarioController::class, 'eliminar'])->name('eliminar');
Route::post('/cambiar-contrasena', [UsuarioController::class, 'cambiarContraseña']);

//Panel DatuakIkusi editatu
Route::view('/panel', 'panelMain')->middleware('auth');
Route::post('/actualizar-panel', [PanelUpdateController::class, 'actualizarPanel']);
Route::post('/eliminar-panel', [PanelakController::class, 'eliminar']);
Route::post('/anadir-panel', [PanelTekController::class, 'anadir']);

//TekIkusi, Panel gehitu, Aldaketak Ikusi
Route::get('/ultimas-modificaciones-panel-tek', [ModController::class, 'obtenerInformacionPanelTekActualizado']);
Route::get('/buscar-extensiones', [BuscarExtensionesController::class, 'searchExtensions']);
Route::get('/obtener-sistemas-operativos', function () {
    $sisOperativos = SisOperativo::all();
    return response()->json($sisOperativos);
})->name('obtener.sistemas.operativos');
Route::post('/panelakGehi', [PanelakController::class, 'store']);

//Gustuko panelak
Route::post('/anadir-fav', [PanelFavStarContoller::class, 'anadirFavorito']);
Route::get('/gustukoa-ikusi', [PanelTekController::class, 'obtenerInformacionPanelTek']);

//Iruzkin Kudeaketa
Route::post('/add-iruzkin', [IruzkinController::class, 'addComment']);
Route::get('/show-iruzkin', [IruzkinController::class, 'infoIruzkinak']);
Route::post('/eliminar-iruzkin', [IruzkinController::class, 'deleteIruzkin']);
Route::post('/update-comment', [IruzkinController::class, 'editarIruzkin']);

Route::get('/technologies', function () {
    $Teknologiak = Teknologiak::all();
    return response()->json($Teknologiak);
});

//Erabiltzailearen Koloreak
Route::post('/koloreak', [KoloreakController::class, 'sartuKoloreak']);
Route::post('/koloreakKargatu', [KoloreakController::class, 'KargatuKoloreak']);
