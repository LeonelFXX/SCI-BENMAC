<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImpressionController;
use App\Http\Controllers\QueryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Vista: Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// CRUD: Usuarios
Route::resource('/users', UserController::class)->middleware('can:accederUsuarios');

// Función: Cargar Saldo
Route::post('/users/{id}/cargar-saldo', [SaldoController::class, 'cargarSaldo'])->name('cargarSaldo')->middleware('auth');

// Modal: Cargar Saldo
Route::post('/users/cargar-saldo-modal', [SaldoController::class, 'cargarSaldoModal'])->name('cargarSaldoModal')->middleware('auth');

// Modal: Quitar Saldo
Route::post('/users/quitar-saldo-modal', [SaldoController::class, 'quitarSaldoModal'])->name('quitarSaldoModal')->middleware('auth');

// Vista: Imprimir
Route::get('/imprimir', [ImpressionController::class, 'mostrarVistaImpresion'])->name('imprimir')->middleware('auth');

// Función: Validar Archivo A Imprimir
Route::post('/validar-archivo/{registro_id}', [ImpressionController::class, 'validacionArchivo'])->name('validacionArchivo')->middleware('auth');

// Función: Configurar Datos De Impresión
Route::post('/imprimir', [ImpressionController::class, 'configurarImpresion'])->name('imprimir')->middleware('auth');

// Función: Rollback
Route::post('/rollback/{registro_id}', [ImpressionController::class, 'rollback'])->name('rollback')->middleware('auth');

// Vista: Impresiones
Route::resource('/impressions', ImpressionController::class)->middleware('can:accederImpresiones');


/* - - - Reportes PDF - - - */
// Reporte General Por Mes
Route::get('/reporte-general-mensual', [QueryController::class, 'reporteGeneralMensual'])->name('mensual-general')->middleware('auth');

// Reporte Por Licenciatura
Route::get('/reporte-licenciatura', [QueryController::class, 'reporteLicenciatura'])->name('licenciatura')->middleware('auth');

// Reporte Individual
Route::get('/reporte-individual', [QueryController::class, 'reporteIndividual'])->name('individual')->middleware('auth');
/* - - - Fin - - - */


// Vista: Configurar Precios De Impresiones
Route::get('/precios/{id}', [ImpressionController::class, 'mostrarVistaPrecios'])->name('vistaPrecios')->middleware('auth');

// Función: Aplicar Precios
Route::post('/precios/{id}', [ImpressionController::class, 'aplicarPrecios'])->name('aplicarPrecios')->middleware('auth');

// Vista: Historial De Impresiones
Route::get('/historial', [QueryController::class, 'historialImpresiones'])->name('historial')->middleware('auth');