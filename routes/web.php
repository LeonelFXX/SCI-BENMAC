<?php


use App\Http\Controllers\BindingController;
use App\Http\Controllers\PrinterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImpressionController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ExternalDataController;

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

// CRUD: Impresoras
Route::resource('/printers', PrinterController::class)->middleware('can:accederUsuarios');

// Vista: Matrícula
Route::get('/matricula', [ExternalDataController::class, 'mostrarVistaMatricula'])->name('matricula');

// Funcion: Validar Matrícula
Route::post('/matricula', [ExternalDataController::class, 'validarMatricula'])->name('validarMatricula');

// Vista: Clave Administrativa
Route::get('/clave', [ExternalDataController::class, 'mostrarVistaClave'])->name('clave');

// Función: Validar Clave Administrativa
Route::post('/clave', [ExternalDataController::class, 'validarClave'])->name('validarClave');

// Función: Cargar Saldo
Route::post('/users/{id}/cargar-saldo', [SaldoController::class, 'cargarSaldo'])->name('cargarSaldo')->middleware('can:accederUsuarios');

// Modal: Cargar Saldo
Route::post('/users/cargar-saldo-modal', [SaldoController::class, 'cargarSaldoModal'])->name('cargarSaldoModal')->middleware('can:accederUsuarios');

// Modal: Quitar Saldo
Route::post('/users/quitar-saldo-modal', [SaldoController::class, 'quitarSaldoModal'])->name('quitarSaldoModal')->middleware('can:accederUsuarios');

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

// Vista: Solicitudes De Engargolado
Route::get('/solicitudes', [BindingController::class, 'mostrarVistaSolicitudes'])->name('solicitudes')->middleware('can:accederEngargolados');

// Vista: Engargolados Realizados
Route::get('/engargolados', [BindingController::class, 'mostrarVistaEngargolados'])->name('engargolados')->middleware('can:accederEngargolados');

// Vista: Panel De Solicitudes
Route::get('/panel-solicitudes', [ImpressionController::class, 'mostrarPanelSolicitudes'])->name('panel');

// Vista: Impresión De Solicitud
Route::get('/imprimir-solicitud/{id}', [ImpressionController::class, 'imprimirSolicitud'])->name('imprimirSolicitud')->middleware('can:accederPersonalAdministrativo');

// Vista: Solicitudes De Impresiones
Route::get('/solicitudes-impresiones', [ImpressionController::class, 'mostrarVistaSolicitudesImpresiones'])->name('solicitudesImpresiones')->middleware('can:accederSolicitudesImpresiones');

// Función: Solicitar Impresión
Route::post('/solicitar-impresion', [ImpressionController::class, 'solicitarImpresion'])->name('solicitarImpresion');

// Vista: Solicitud De Impresión
Route::get('/solicitud/{id}', [ImpressionController::class, 'mostrarSolicitud'])->name('mostrarSolicitud')->middleware('can:accederSolicitudesImpresiones');

// Función: Autoriza Las Impresiones
Route::put('autorizar-impresion/{id}', [ImpressionController::class, 'autorizarImpresion'])->name('autorizar')->middleware('can:accederSolicitudesImpresiones');

// Función: Denega Las Impresiones
Route::put('denegar-impresion/{id}', [ImpressionController::class, 'denegarImpresion'])->name('denegar')->middleware('can:accederSolicitudesImpresiones');

// Función: Imprimir Solicitud De Impresión
Route::post('/imprimir-solicitud/{id}', [ImpressionController::class, 'validarArchivoImpresion'])->name('validarArchivoImpresion')->middleware('can:accederPersonalAdministrativo');

// Vista: Impresiones Realizadas
Route::get('/realizadas', [ImpressionController::class, 'mostrarVistaRealizadas'])->name('realizadas')->middleware('can:accederSolicitudesImpresiones');

// Vista: Impresiones Denegadas
Route::get('/denegadas', [ImpressionController::class, 'mostrarVistaDenegadas'])->name('denegadas')->middleware('can:accederSolicitudesImpresiones');

// Función: Dar Por Realizada El Engargolado
Route::put('/engargolado-realizado/{id}', [BindingController::class, 'controlarSolicitudes'])->name('engargoladoCompletado')->middleware('can:accederEngargolados');

// Función: Enviar Solicitud De Engargolado
Route::post('/enviar-solicitud', [BindingController::class, 'crearSolicitud'])->name('enviarSolicitud');

// Vista: Historial De Solicitudes Del Usuario
Route::get('/usuario-solicitudes', [BindingController::class, 'mostrarSolicitudesPendientes'])->name('vistaUsuarioSolicitudes')->middleware('can:accederEstudiante');

// Función: Rollback De Solicitud
Route::post('/rollback-solicitud/{solicitud_id}', [BindingController::class, 'rollbackSolicitud'])->name('rollbackSolicitud');

// Función: Rollback De Impresión
Route::post('/rollback-impresion/{impresion_id}', [ImpressionController::class, 'rollbackImpresion'])->name('rollbackImpresion');

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
Route::get('/historial', [QueryController::class, 'historial'])->name('historial')->middleware('can:accederEstudiante');