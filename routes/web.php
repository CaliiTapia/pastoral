<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Ficha;
use App\Helpers\Helpers;
use App\Acceso;

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

Auth::routes();

// Json para verificar sesion activa por JS
Route::get('/validaSesion', function () {
    if (!empty(Auth::user())) {
        $datos = ["estado" => 'activa'];
        return response()->json($datos);
    } else {
        $datos = ["estado" => 'inactiva'];
        return response()->json($datos);
    }
});

// * Middleware de Autenticacion
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/inicio/ur/seleccionada/', 'HomeController@seleccionarUR')->name('urSeleccionada');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/inicio/instituciones/seleccionar', 'HomeController@listar_ur_asignadas')->name('urSeleccionar');


    Route::get('/', function () {
        $urAsignadas = Acceso::where('U_IdUsuario', Auth::user()->IdUsuario)->get();
        if (count($urAsignadas) == 1) {
            return redirect()->route('home');
        } else {
            foreach ($urAsignadas as $ur) {
                if ($ur->EnUso == 'true') {
                    return redirect()->route('home');
                }
            }
            return redirect()->route('urSeleccionar');
        }
    });

    // Menu de ingreso a modulos
    Route::prefix('unoporciento')->group(function () {
        Route::get('/preboleta', 'PreboletaController@Preboleta')->name('Preboleta');
        Route::post('/preboleta/pdf', 'PreboletaController@PDF')->name('PdfPreboleta');
    });


    Route::prefix('ajax/')->group(function () {
        Route::get('region', 'AjaxController@getComunas');
        Route::get('comprobarRut', 'AjaxController@existenciaAP');

        Route::get('regionesAux', 'AjaxController@getRegiones'); //Auxiliar
        Route::get('comunaCiudad', 'AjaxController@getComunasCiudad'); //Ciudad-Comuna
        Route::get('validaExisteRut', 'AjaxController@getRutExiste'); //crear, valida rut si existe

        Route::get('desactivarAN/{id}', 'AjaxController@getDesactivarAN'); //desactivar area negocio
        Route::get('activarAN/{id}', 'AjaxController@getActivarAN'); //activar area negocio

        Route::get('desactivarAU/{id}', 'AjaxController@getDesactivarAU'); //desactivar auxiliar
        Route::get('activarAU/{id}', 'AjaxController@getActivarAU'); //activar auxiliar

        Route::get('desactivarCC/{id}', 'AjaxController@getDesactivarCC'); //desactivar centro costo
        Route::get('activarCC/{id}', 'AjaxController@getActivarCC'); //activar centro costo

        Route::get('desactivarPE/{id}', 'AjaxController@getDesactivarPE'); //desactivar periodo
        Route::get('activarPE/{id}', 'AjaxController@getActivarPE'); //activar periodo

        Route::get('desactivarTD/{id}', 'AjaxController@getDesactivarTD'); //desactivar tipo documento
        Route::get('activarTD/{id}', 'AjaxController@getActivarTD'); //activar tipo documento

        Route::get('validaExistePlanCuentas', 'AjaxController@getPlanCuentasExiste'); // valida plan de cuentas


        // Rutas ajax para completar select
        Route::prefix('listar')->group(function () {
            Route::get('zonas', 'AjaxController@ListarZonas');
            Route::get('areas', 'AjaxController@ListarAreas');
            Route::get('urs', 'AjaxController@ListarUR');
            Route::get('todo/ficha/{IdFicha}', 'AjaxController@ListarTodo');
            Route::get('participaciones/ficha/{IdFicha}', 'AjaxController@ListarParticipacionesFicha')->middleware('permission:ap_ver_participacion');
            Route::get('referencias/ficha/{IdFicha}', 'AjaxController@ListarReferenciasFicha')->middleware('permission:ap_ver_referencia');
        });
    });

    // Middleware permisos Agentes Pastorales
    Route::group(['middleware' => ['permission:ap_ver_modulo_agentes_pastorales']], function () {
        Route::prefix('pastoral/')->group(function () {
            Route::resource('listado', 'AgentePastoralController');
            Route::get('ficha', 'AgentePastoralController@create');
            Route::get('descarga/ficha', 'AgentePastoralController@descargarFicha');
        });
        Route::prefix('historial/')->group(function () {
            Route::group(['middleware' => ['permission:ap_crear_participacion']], function () {
                Route::resource('participacion/parroquial', 'HistorialParticipacionParroquial');
            });
            Route::group(['middleware' => ['permission:ap_modificar_participacion']], function () {
                Route::get('participacion/parroquial/deshabilitar/{IdParticipacion}', 'HistorialParticipacionParroquial@deshabilitar');
            });
            Route::post('referencia/parroquial/store', 'ReferenciasController@store')->middleware('permission:ap_crear_referencia');
            Route::get('referencia/deshabilitar/{IdReferencia}', 'ReferenciasController@deshabilitar');
        });
    });
    // Middleware permisos develacion
    Route::group(['middleware' => ['permission:ap_descargar_documentos']], function () {
        Route::prefix('develacion/')->group(function () {
            // Route::resource('listado', 'AgentePastoralController');
            Route::get('/', 'HomeController@indexDevelacion');
            Route::get('descarga/ficha', 'AgentePastoralController@descargarFicha');
            Route::prefix('descargar/')->group(function () {
                Route::get('recepcionrelato', 'HomeController@descargarActaReceocionRelato')->name('recepcionrelato');
                Route::get('comunicacionafectado', 'HomeController@descargarComunicacionAfectado')->name('comunicacionafectado');
                Route::get('comunicacioninvolucrado', 'HomeController@descargarComunicacionInvolucrado')->name('comunicacioninvolucrado');
            });
        });
    });
    // Menu de ingreso al mantenedores
    Route::prefix('mantenedores')->group(function () {
        //* Cambio de contraseña
        Route::get('/cambiar-contraseña', 'UsuarioController@actual_pass');
        Route::post('/cambiar-contraseña', 'UsuarioController@cambio_pass')->name('Cambiando');

        // * Menu ingreso a modulo usuarios
        Route::get('/', function () {
            return view('modulos.mantenedores.index');
        });
        // * Accesos directos
        Route::resource('usuario', 'UsuarioController', ['names' => ['index' => 'usuario']]);
        Route::get('/nuevo/contacto', 'ParroquiaController@form_contacto');

        //MANTENEDOR DE CAPILLAS
        //Route::get('/', function () {return view('modulos.mantenedores.index');});
        Route::resource('capilla', 'CapillaController');
        Route::get('capilla/update/{id}', 'CapillaController@edit');
        Route::post('capilla/update/{id}', array('as' => 'updateCapilla', 'uses' => 'CapillaController@update'));

        //MANTENEDOR DE PARROQUIAS
        Route::resource('parroquia', 'ParroquiaController');
        //Route::get('/parroquia/{id}/update','ParroquiaController@edit')->name('update_parroquia');
        Route::get('/parroquia/editar/{id}', 'ParroquiaController@edit');

        //MANTENEDOR DE VISITADORES
        Route::resource('visitadores', 'VisitadorController');

        //Mantenedor contacto
        Route::resource('contacto', 'ContactoController');
        Route::get('/contacto', 'ContactoController@index');
        Route::get('/nuevo/contacto', 'ContactoController@create');
        Route::get('/contacto/editar/{id}', 'ContactoController@edit');
        Route::get('/contacto/eliminar/{id}', 'ContactoController@destroy');
    });

    //PESTAÑA INFOPARROQUIAL
    Route::get('informacion/update/{id}/edit', 'InfoParroquial@edit');
    Route::put('informacion/update/{id}/edit', ['as' => 'parroquia.update', 'uses' => 'InfoParroquial@update']);
    Route::put('AjaxP/update/{id}', 'InfoParroquial@AjaxCoordenadasPA');
    // Horarios Parroquia
    Route::post('/hora', 'InfoParroquial@store');
    Route::get('/horaeliminar/{id}', 'InfoParroquial@AjaxEliminarH');
    Route::get('/get/horario/{id}', 'InfoParroquial@AjaxGetHorario');
    Route::put('/horaactualizar/{id}', 'InfoParroquial@AjaxActualizar');

    // Capilla
    Route::get('capilla/update/{id}/edit', 'InfoCapillaController@edit');
    Route::put('capilla/update/{id}/edit', ['as' => 'capilla.update', 'uses' => 'InfoCapillaController@update']);
    Route::put('Ajax/update/{id}', 'InfoCapillaController@AjaxCoordenadas');
    // hORARIOS cAPILLA
    Route::post('/horaC', 'InfoCapillaController@store');
    Route::get('/horaeliminarC/{id}', 'InfoCapillaController@AjaxEliminar');
    Route::get('/get/horarioC/{id}', 'InfoCapillaController@AjaxGetHorario');
    Route::put('/horaactualizarC/{id}', 'InfoCapillaController@AjaxActualizarc');
    // develaciones
    Route::group(['middleware' => ['permission:dev_proceso_develacion']], function () {
        Route::get('/develaciones', 'DevelacionController@index');
        Route::post('/estado', 'DevelacionController@store');
        Route::get('/ver/historial/{id}', 'DevelacionController@AjaxGetDev');
        Route::get('/ver_nuevohistorial/{id}/{idproceso}', 'DevelacionController@AjaxHistorial'); // el id es el rut
    });
    // buscar Agente
    Route::group(['middleware' => ['permission:dev_buscarAp']], function () {
        Route::get('/buscar', 'BuscarAgenteController@index')->name('agentes');
        Route::get('/buscar/{id}', 'BuscarAgenteController@getParro');
        Route::post('Ajax/iniciar/{id}', 'BuscarAgenteController@AjaxInicioDev');
    });
    Route::get('/pastoral/listado/{id}/editD', 'AgentePastoralController@editDel');
    //documentos develaciones
    Route::group(['middleware' => ['permission:dev_carga_develacion']], function () {
        Route::get('/documentosdevelaciones', 'ArchivosDevelacionesController@indexsubida');
        Route::post('/guardararchivodenuncia', 'ArchivosDevelacionesController@store');
    });
    Route::group(['middleware' => ['permission:dev_descarga_develacion']], function () {
        Route::get('/descargararchivos', 'ArchivosDevelacionesController@descargararchivos');
        Route::get('/eliminar_logico/{id}', 'ArchivosDevelacionesController@eliminar_archivo');
    });
    //Bloquear Agente
    Route::post('/bloqueoAgente', 'AgentePastoralController@bloquearBuscar');
    Route::post('/bloqueoAgenteL', 'AgentePastoralController@bloquearAPlista');
    Route::get('/participacion_actual/{idficha}/{incodigo}', 'AgentePastoralController@bloqparticipacion_actual');
    Route::get('/participacion_actuallistado/{idficha}', 'AgentePastoralController@bloqparticipacion_actuallistado');
    //Activar Agente
    Route::post('/activarAgente', 'AgentePastoralController@activarAp');
    // Modulo Formacion
    Route::prefix('/formacion')->group(function () {
        Route::get('/ingresar', 'FormacionController@index');
    });
    // Calendario Home
    Route::post('/', 'HomeController@store');
    Route::get('ajax/informacion/{id}', 'HomeController@AjaxDatos');
    Route::get('/informacion/eliminar/{id}', 'HomeController@AjaxEliminar');

    //MODULO DE INFORMES
    Route::prefix('informes')->group(function () {
        Route::get('/', function () {
            return view('modulos.informes.index');
        });
        // *Rutas submódulo de CANCELACIONES DE CONTRIBUYENTES
        Route::resource('cancelaciones_contribuyentes', 'CancelacionesContribuyentesController', ['names' => ['index' => 'cancelaciones_contribuyentes']]);
        Route::post('/', 'CancelacionesContribuyentesController@generarInforme')->name('detallePagoContribuyente');
        //Route::post ('/generarInforme', 'CancelacionesContribuyentesController@generarInforme')->name('postGenerarInforme');
    });

    // Modulo ContaParroquial
    Route::prefix('/contaparroquial')->group(function () {
        // CONTABILIDAD
        Route::get('/contabilidad/comprobantes', 'ComprobanteController@index')->name("contaparroquial.contabilidad.comprobantes");
        Route::get('/contabilidad/comprobantes/crear', 'ComprobanteController@create')->name("contaparroquial.contabilidad.comprobantes.crear");
        Route::post('/contabilidad/comprobantes/store', 'ComprobanteController@store')->name("contaparroquial.contabilidad.comprobantes.crear.store");
        Route::post('/contabilidad/comprobantes/filter', 'ComprobanteController@filter')->name("contaparroquial.contabilidad.comprobantes.filter");
        Route::get('/contabilidad/comprobantes/editar/{id?}', 'ComprobanteController@edit')->name("contaparroquial.contabilidad.comprobantes.edit");
        Route::post('/contabilidad/comprobantes/editar', 'ComprobanteController@update')->name("contaparroquial.contabilidad.comprobantes.edit.store");
        Route::get('/contabilidad/comprobantes/imprimir/{id?}', 'ComprobanteController@print')->name("contaparroquial.contabilidad.comprobantes.print");
        Route::get('/contabilidad/ingreso-masivo', 'IngresoMasivoController@index')->name("contaparroquial.contabilidad.ingreso-masivo");
        Route::post('/contabilidad/ingreso-masivo/check', 'IngresoMasivoController@check')->name("contaparroquial.contabilidad.ingreso-masivo.check");
        Route::post('/contabilidad/ingreso-masivo/process', 'IngresoMasivoController@process')->name("contaparroquial.contabilidad.ingreso-masivo.process");
        Route::get('/contabilidad/comprobante-tipo', 'ComprobanteTipoController@index')->name("contaparroquial.contabilidad.comprobante-tipo");
        Route::post('/contabilidad/comprobante-tipo/store', 'ComprobanteTipoController@store')->name("contaparroquial.contabilidad.comprobante-tipo.store");
        Route::get('/contabilidad/comprobante-tipo/{id?}', 'ComprobanteTipoController@findById')->name("contaparroquial.contabilidad.comprobante-tipo.get");
        Route::get('/contabilidad/libro-diario', 'LibroDiarioController@index')->name("contaparroquial.contabilidad.libro-diario");
        Route::post('/contabilidad/libro-diario', 'LibroDiarioController@generatePreview')->name("contaparroquial.contabilidad.libro-diario.preview");
        Route::get('/contabilidad/libro-diario/download', 'LibroDiarioController@download')->name("contaparroquial.contabilidad.libro-diario.download");
        Route::get('/contabilidad/libro-mayor', 'LibroMayorController@index')->name("contaparroquial.contabilidad.libro-mayor");
        Route::post('/contabilidad/libro-mayor', 'LibroMayorController@generatePreview')->name("contaparroquial.contabilidad.libro-mayor.preview");
        Route::post('/contabilidad/comprobantes/editMov', 'ComprobanteController@updateMovimiento')->name("contaparroquial.contabilidad.comprobantes.editMov");

        //CENTRO COSTO
        Route::get('/mantenedores/centroCosto', 'CentroCostoController@index')->name("contaparroquial.mantenedores.centroCosto");
        Route::get('/mantenedores/centroCosto/crear', 'CentroCostoController@crear')->name("contaparroquial.mantenedores.centroCosto.crear");
        Route::post('/mantenedores/centroCosto/store', 'CentroCostoController@store')->name("contaparroquial.mantenedores.centroCosto.index");
        Route::get('/mantenedores/centroCosto/editar/{cod}', 'CentroCostoController@editar')->name("contaparroquial.mantenedores.centroCosto.editar");
        Route::post('/mantenedores/centroCosto/edit/{datos}', 'CentroCostoController@edit')->name("contaparroquial.mantenedores.centroCosto.index");
        Route::get('/centroCosto/eliminar/{id}', 'CentroCostoController@eliminar');

        //AUXILIAR
        Route::get('/mantenedores/auxiliares', 'AuxiliarController@index')->name("contaparroquial.mantenedores.auxiliares");
        Route::get('/mantenedores/auxiliares/crear', 'AuxiliarController@crear')->name("contaparroquial.mantenedores.auxiliares.crear");
        Route::post('/mantenedores/auxiliares/store', 'AuxiliarController@store')->name("contaparroquial.mantenedores.auxiliares.index");
        Route::get('/mantenedores/auxiliares/editar/{cod}', 'AuxiliarController@editar')->name("contaparroquial.mantenedores.auxiliares.editar");
        Route::post('/mantenedores/auxiliares/edit/{datos}', 'AuxiliarController@edit')->name("contaparroquial.mantenedores.auxiliares.index");
        Route::get('/auxiliares/eliminar/{id}', 'AuxiliarController@eliminar');

        //AREA DE NEGOCIO
        Route::get('/mantenedores/areaNegocio', 'AreaNegocioController@index')->name("contaparroquial.mantenedores.areaNegocio");
        Route::get('/mantenedores/areaNegocio/crear', 'AreaNegocioController@crear')->name("contaparroquial.mantenedores.areaNegocio.crear");
        Route::post('/mantenedores/areaNegocio/store', 'AreaNegocioController@store')->name("contaparroquial.mantenedores.areaNegocio.index");
        Route::get('/mantenedores/areaNegocio/editar/{cod}', 'AreaNegocioController@editar')->name("contaparroquial.mantenedores.areaNegocio.editar");
        Route::post('/mantenedores/areaNegocio/edit/{datos}', 'AreaNegocioController@edit')->name("contaparroquial.mantenedores.areaNegocio.index");
        Route::get('/areaNegocio/eliminar/{id}', 'AreaNegocioController@eliminar');

        //PERIODO
        Route::get('/mantenedores/periodo', 'PeriodoController@index')->name("contaparroquial.mantenedores.periodo");
        Route::get('/mantenedores/periodo/crear', 'PeriodoController@crear')->name("contaparroquial.mantenedores.periodo.crear");
        Route::post('/mantenedores/periodo/store', 'PeriodoController@store')->name("contaparroquial.mantenedores.periodo.index");
        Route::get('/mantenedores/periodo/editar/{cod}', 'PeriodoController@editar')->name("contaparroquial.mantenedores.periodo.editar");
        Route::post('/mantenedores/periodo/edit/{datos}', 'PeriodoController@edit')->name("contaparroquial.mantenedores.periodo.index");
        Route::get('/periodo/eliminar/{id}', 'PeriodoController@eliminar');

        //TIPO DOCUMENTO
        Route::get('/mantenedores/tipoDocumento', 'TipoDocumentoController@index')->name("contaparroquial.mantenedores.tipoDocumento");
        Route::get('/mantenedores/tipoDocumento/crear', 'TipoDocumentoController@crear')->name("contaparroquial.mantenedores.tipoDocumento.crear");
        Route::post('/mantenedores/tipoDocumento/store', 'TipoDocumentoController@store')->name("contaparroquial.mantenedores.tipoDocumento.index");
        Route::get('/mantenedores/tipoDocumento/editar/{cod}', 'TipoDocumentoController@editar')->name("contaparroquial.mantenedores.tipoDocumento.editar");
        Route::post('/mantenedores/tipoDocumento/edit/{datos}', 'TipoDocumentoController@edit')->name("contaparroquial.mantenedores.tipoDocumento.index");
        Route::get('/tipoDocumento/eliminar/{id}', 'TipoDocumentoController@eliminar');

        //PLAN DE CUENTAS
        Route::get('/mantenedores/planDeCuentas', 'PlanDeCuentasController@index')->name("contaparroquial.mantenedores.planDeCuentas");
        Route::get('/mantenedores/planDeCuentas/crear', 'PlanDeCuentasController@crear')->name("contaparroquial.mantenedores.planDeCuentas.crear");
        Route::post('/mantenedores/planDeCuentas/store', 'PlanDeCuentasController@store')->name("contaparroquial.mantenedores.planDeCuentas.index");
        Route::post('/mantenedores/planDeCuentas/buscar', 'PlanDeCuentasController@buscar')->name("contaparroquial.mantenedores.planDeCuentas.buscar");
        Route::get('/mantenedores/planDeCuentas/editar/{cod}', 'PlanDeCuentasController@editar')->name("contaparroquial.mantenedores.planDeCuentas.editar");
        Route::post('/mantenedores/planDeCuentas/edit/{datos}', 'PlanDeCuentasController@edit')->name("contaparroquial.mantenedores.planDeCuentas.index");
        Route::get('/planDeCuentas/eliminar/{id}', 'PlanDeCuentasController@eliminar');
        Route::post('/mantenedores/planDeCuentas/cargaMasiva', 'PlanDeCuentasController@cargaMasiva')->name("contaparroquial.mantenedores.planDeCuentas.cargaMasiva");

        //REPORTES
        Route::get('/mantenedores/reportes/downloadAreaNegocio', 'ReportesController@downloadAreaNegocio');
        Route::get('/mantenedores/reportes/downloadCentroCosto', 'ReportesController@downloadCentroCosto');
        Route::get('/mantenedores/reportes/downloadTipoDocumento', 'ReportesController@downloadTipoDocumento');
        Route::get('/mantenedores/reportes/downloadPlanDeCuentas', 'ReportesController@downloadPlanDeCuentas');
        Route::get('/mantenedores/reportes/downloadAuxiliares', 'ReportesController@downloadAuxiliares');
        Route::get('/mantenedores/reportes/downloadGeneral', 'ReportesController@downloadGeneral');
        Route::get('/mantenedores/reportes', 'ReportesController@index')->name("contaparroquial.mantenedores.reportes");
    });

    // 1% Parroquial
    Route::prefix('unoporciento')->group(function () {

        // Contribuyentes
        Route::get('/contribuyentes/crear-contribuyente', function () {
            return view('modulos.unoporciento.contribuyentes.create');
        });
        Route::get('/contribuyentes/ver-contribuyente', function () {
            return view('modulos.unoporciento.contribuyentes.show');
        });
        Route::get('/contribuyentes', function () {
            return view('modulos.unoporciento.contribuyentes.index');
        });

        // Cartas y Etiquetas
        Route::get('/cartas/carta-cobranza', function () {
            return view('modulos.unoporciento.cartas.cobranza');
        });
        Route::get('/cartas/carta-resumen', function () {
            return view('modulos.unoporciento.cartas.resumen');
        });
        Route::get('/cartas/etiquetas', function () {
            return view('modulos.unoporciento.cartas.etiquetas');
        });

        // Pagos
        Route::get('/pagos/mandatos/cargar-mandato', function () {
            return view('modulos.unoporciento.pagos.cargar-mandato');
        });
        Route::get('/pagos/mandatos/captura', function () {
            return view('modulos.unoporciento.pagos.captura-mandato');
        });
        Route::get('/pagos/mandatos', function () {
            return view('modulos.unoporciento.pagos.mandatos');
        });
        Route::get('/pagos/comprobantes/ingreso-comprobante', function () {
            return view('modulos.unoporciento.pagos.ingreso-comprobante');
        });
        Route::get('/pagos/comprobantes', function () {
            return view('modulos.unoporciento.pagos.comprobantes');
        });

        // Rendición
        Route::get('/rendicion', function () {
            return view('modulos.unoporciento.contribuyentes.rendicion');
        });
    });

    //Route::get('/porciento-parroquial/contribuyentes', 'PorcientoParroquial\ContribuyentesController@contribuyentes');
    Route::get('/porciento-parroquial/ver-contribuyente', 'PorcientoParroquial\ContribuyentesController@verContribuyente');
    Route::get('/porciento-parroquial/rendicion', 'PorcientoParroquial\ContribuyentesController@rendicion');
    Route::get('/porciento-parroquial/pagos', 'PorcientoParroquial\ContribuyentesController@pagos');
    Route::get('/porciento-parroquial/ingreso', 'PorcientoParroquial\ContribuyentesController@ingreso');
});
// * Fin Middleware de Autenticacion

Route::get('/home', 'HomeController@index')->name('home');
