<?php

Route::get('/', function () {
    return view('auth/login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('main/{incentivo}/cadena', 'HomeController@principalesCadenas')->name('home.cadena');
Route::get('main/{periodo}/incentivo', 'HomeController@ejecucionMensual')->name('home.incentivo');
Route::get('main/resumen', 'HomeController@hojaResumen')->name('home.resumen');







#1. Rutas del módulo administrativo
#1.1. Módulo para el registro de módulos del sistema
Route::resource('admin/modulo', 'ModuloController')->except(['show']);
Route::get('admin/modulo/data', 'ModuloController@show')->name('modulo.data');
#1.2. Módulo para el registro de procesos del sistema
Route::resource('admin/proceso', 'ProcesoController')->except(['show', 'destroy']);
Route::get('admin/proceso/data', 'ProcesoController@show')->name('proceso.data');
Route::post('admin/proceso/{proceso}/destroy', 'ProcesoController@destroy')->name('proceso.destroy');

#1.3. Módulo para el registro de tablas del sistema
Route::resource('admin/tabla', 'TablaController')->except(['show']);
Route::get('admin/tabla/data', 'TablaController@show')->name('tabla.data');
#1.4. Módulo para el registro de valores de las tablas del sistema
Route::resource('admin/tabla-valor', 'TablaValorController')->except(['show']);
Route::get('admin/tabla-valor/data', 'TablaValorController@show')->name('tabla-valor.data');
#1.5. Módulo para el registro de ubigeo nacional
Route::resource('admin/ubigeo', 'UbigeoController')->except(['show']);
Route::get('admin/ubigeo/data', 'UbigeoController@show')->name('ubigeo.data');
#1.6. Módulo para el registro de usuarios
Route::resource('admin/usuario', 'UsuarioController')->except(['show']);
Route::get('admin/usuario/data', 'UsuarioController@show')->name('usuario.data');
Route::get('admin/usuario/{usuario}/reset', 'UsuarioController@editPassword')->name('usuario.reset');
Route::post('admin/usuario/{usuario}', 'UsuarioController@updatePassword')->name('usuario.update-password');
Route::get('admin/usuario/{oficina}', 'UsuarioController@showUsuarioOficina')->name('usuario.show-oficina'); #Nos permite obtener los usuarios que pertenecen a determinada oficina
#1.7. Módulo para el registro de roles
Route::resource('admin/rol', 'RolController')->except(['show']);
Route::get('admin/rol/data', 'RolController@show')->name('rol.data');
#1.8. Módulo para el registro de etapas
Route::resource('admin/etapa-compromiso', 'TipoCompromisoEtapaController')->except(['show']);
Route::get('admin/etapa-compromiso/data', 'TipoCompromisoEtapaController@show')->name('etapa-compromiso.data');
#1.9. Módulo para el registro de sectores
Route::resource('admin/sector', 'SectorProductivoController')->except(['show']);
Route::get('admin/sector/data', 'SectorProductivoController@show')->name('sector.data');
#1.10. Módulo para el registro de lineas productivas
Route::resource('admin/linea', 'LineaProductivaController')->except(['show']);
Route::get('admin/linea/data', 'LineaProductivaController@show')->name('linea.data');
#1.11. Módulo para el registro de cadenas productivas
Route::resource('admin/cadena', 'CadenaProductivaController')->except(['show']);
Route::get('admin/cadena/data', 'CadenaProductivaController@show')->name('cadena.data');
#1.12. Módulo para el registro de productos
Route::resource('admin/producto', 'ProductoController')->except(['show']);
Route::get('admin/producto/data', 'ProductoController@show')->name('producto.data');
#1.13. Módulo para el registro de cargos de usuario
Route::resource('admin/cargo', 'CargoController')->except(['show']);
Route::get('admin/cargo/data', 'CargoController@show')->name('cargo.data');
#1.14. Módulo para el registro de áreas de usuario
Route::resource('admin/area', 'AreaController')->except(['show']);
Route::get('admin/area/data', 'AreaController@show')->name('area.data');
#1.15. Módulo para el registro de personal staff
Route::resource('admin/staff', 'StaffController')->except(['show']);
Route::get('admin/staff/data', 'StaffController@show')->name('staff.data');
#1.16. Módulo para el registro de procesos de los incentivos
Route::resource('admin/proceso-iniciativa', 'ProcesoIniciativaController')->except(['show']);
Route::get('admin/proceso-iniciativa/data', 'ProcesoIniciativaController@show')->name('proceso-iniciativa.data');
#1.17. Módulo para el registro de procesos de los incentivos
Route::resource('admin/indicador-resultado', 'IndicadorResultadoController')->except(['show']);
Route::get('admin/indicador-resultado/data', 'IndicadorResultadoController@show')->name('indicador-resultado.data');
#1.18. Genero combos dinamicos a partir de lo solicitado por el Ubigeo
Route::get('ubigeo/provincia/{codRegion}', 'UbigeoController@obtieneProvincias')->name('ubigeo.provincia');
Route::get('ubigeo/distrito/{codProvincia}', 'UbigeoController@obtieneDistritos')->name('ubigeo.distrito');
#1.19. Genero combos dinamicos a partir de lo solicitado por la Caracterizacion Productiva
Route::get('tipologia/linea/{codSector}', 'ProductoController@obtieneLinea')->name('tipologia.linea');
Route::get('tipologia/cadena/{codLinea}', 'ProductoController@obtieneCadena')->name('tipologia.cadena');
Route::get('tipologia/producto/{codCadena}', 'ProductoController@obtieneProducto')->name('tipologia.producto');

#2. Rutas para el módulo OPA
#2.1. Módulo para el registro de organizaciones
Route::resource('sp/opa', 'EntidadController')->except(['show', 'update']);
Route::get('sp/opa/data', 'EntidadController@show')->name('opa.data');
Route::post('sp/opa/{opa}', 'EntidadController@update')->name('opa.update');
#2.2. Módulo para el registro de beneficiarios
Route::resource('sp/beneficiario', 'PersonaController')->except(['show', 'create', 'destroy']);
Route::get('sp/beneficiario/{opa}/data', 'PersonaController@show')->name('beneficiario.data');
Route::get('sp/beneficiario/{opa}/create', 'PersonaController@create')->name('beneficiario.create');
Route::post('sp/beneficiario/{beneficiario}/destroy', 'PersonaController@destroy')->name('beneficiario.destroy');

#3. Rutas para el módulo de Eventos y compromisos
#3.1. Módulo para el registro de eventos
Route::resource('iniciativa/evento', 'EventoController')->except(['show', 'update', 'destroy']);
Route::get('iniciativa/evento/data', 'EventoController@show')->name('evento.data');
Route::post('iniciativa/evento/{evento}', 'EventoController@update')->name('evento.update');
Route::post('iniciativa/evento/{evento}/destroy', 'EventoController@destroy')->name('evento.destroy');
Route::get('iniciativa/evento/excel', 'ExportaExcelController@exportaMatrizCompromisos')->name('evento-excel');
Route::get('iniciativa/evento/excel-01', 'ExportaExcelController@exportaReport01')->name('evento-excel01');
Route::get('iniciativa/evento/excel-02', 'ExportaExcelController@exportaReport02')->name('evento-excel02');
Route::get('iniciativa/evento/excel-03', 'ExportaExcelController@exportaReport03')->name('evento-excel03');
Route::get('iniciativa/evento/excel-04', 'ExportaExcelController@exportaReport04')->name('evento-excel04');
Route::get('iniciativa/evento/excel-05', 'ExportaExcelController@exportaReport05')->name('evento-excel05');
Route::get('iniciativa/evento/excel-06', 'ExportaExcelController@exportaReport06')->name('evento-excel06');
Route::get('iniciativa/evento/excel-07', 'ExportaExcelController@exportaReport07')->name('evento-excel07');
Route::get('iniciativa/evento/excel-08', 'ExportaExcelController@exportaReport08')->name('evento-excel08');
Route::get('iniciativa/evento/excel-09', 'ExportaExcelController@exportaReport09')->name('evento-excel09');
Route::get('iniciativa/evento/excel-10', 'ExportaExcelController@exportaReport10')->name('evento-excel10');
Route::get('iniciativa/evento/excel-11', 'ExportaExcelController@exportaReport11')->name('evento-excel11');
Route::get('iniciativa/evento/excel-12', 'ExportaExcelController@exportaReport12')->name('evento-excel12');
Route::get('iniciativa/evento/excel-13', 'ExportaExcelController@exportaReport13')->name('evento-excel13');
Route::get('iniciativa/evento/excel-14', 'ExportaExcelController@exportaReport14')->name('evento-excel14');
Route::get('iniciativa/evento/excel-15', 'ExportaExcelController@exportaReport15')->name('evento-excel15');
Route::get('iniciativa/evento-reporte', 'EventoController@reporte')->name('evento.visor');

#3.2. Módulo para el registro de compromisos
Route::resource('iniciativa/compromiso', 'CompromisoController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/compromiso/{evento}/data', 'CompromisoController@show')->name('compromiso.data');
Route::get('iniciativa/compromiso/{evento}/create', 'CompromisoController@create')->name('compromiso.create');
Route::post('iniciativa/compromiso/{compromiso}/destroy', 'CompromisoController@destroy')->name('compromiso.destroy');
Route::get('iniciativa/compromiso/{compromiso}/etapa', 'CompromisoController@obtieneEtapa')->name('compromiso.etapa');
#3.3. Módulo para el registro al seguimiento de compromisos
Route::resource('iniciativa/ejec-compromiso', 'CompromisoSeguimientoController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/ejec-compromiso/{evento}/data', 'CompromisoSeguimientoController@show')->name('ejec-compromiso.data');
Route::get('iniciativa/ejec-compromiso/{evento}/create', 'CompromisoSeguimientoController@create')->name('ejec-compromiso.create');
Route::post('iniciativa/ejec-compromiso/{ejec_compromiso}/destroy', 'CompromisoSeguimientoController@destroy')->name('ejec-compromiso.destroy');
#3.4. Módulo para el registro de entidades identificadas
Route::resource('iniciativa/evento-entidad', 'EventoEntidadController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/evento-entidad/{evento}/data', 'EventoEntidadController@show')->name('evento-entidad.data');
Route::get('iniciativa/evento-entidad/{evento}/create', 'EventoEntidadController@create')->name('evento-entidad.create');
Route::post('iniciativa/evento-entidad/{evento_entidad}/destroy', 'EventoEntidadController@destroy')->name('evento-entidad.destroy');
#3.5. Reporte consolidado de compromisos
Route::get('iniciativa/compromiso-reporte', 'CompromisoController@indexCompromiso')->name('compromiso-reporte.index');
Route::get('iniciativa/compromiso-reporte/{region}/{estado}/data', 'CompromisoController@dataCompromiso')->name('compromiso-reporte.data');
Route::get('iniciativa/compromiso-reporte/{region}/{estado}/excel', 'ExportaExcelController@exportaCompromisoResumen')->name('compromiso-reporte.excel');

#4. Módulo para el registro de convenios marco
Route::resource('de/convenio', 'ConvenioMarcoController')->except(['show', 'update', 'delete']);
Route::get('de/convenio/data', 'ConvenioMarcoController@show')->name('convenio-marco.data');
Route::post('de/convenio/{convenio}', 'ConvenioMarcoController@update')->name('convenio-marco.update');
Route::post('de/convenio/{convenio}/destroy', 'ConvenioMarcoController@destroy')->name('convenio-marco.delete');
Route::get('de/convenio/{convenio}/upload', 'ConvenioMarcoController@formUpload')->name('convenio-marco.form-upload');
Route::post('de/convenio/upload/{convenio}', 'ConvenioMarcoController@upload')->name('convenio-marco.upload');
Route::get('de/convenio/{convenio}/situacion', 'ConvenioMarcoController@formSituacion')->name('convenio-marco.form-situacion');
Route::post('de/convenio/situacion/{convenio}', 'ConvenioMarcoController@situacion')->name('convenio-marco.situacion');
#4.1. Módulo para el registro de entidades cooperantes del convenio
Route::resource('de/convenio-cooperante', 'ConvenioMarcoCooperanteController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-cooperante/{convenio}/data', 'ConvenioMarcoCooperanteController@show')->name('convenio-cooperante.data');
Route::get('de/convenio-cooperante/{convenio}/create', 'ConvenioMarcoCooperanteController@create')->name('convenio-cooperante.create');
Route::post('de/convenio-cooperante/{cooperante}/destroy', 'ConvenioMarcoCooperanteController@destroy')->name('convenio-cooperante.destroy');
#4.2. Módulo para el registro de coordinadores del PCC
Route::resource('de/convenio-coordinador-pcc', 'ConvenioMarcoCoordinadorController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-coordinador-pcc/{convenio}/data', 'ConvenioMarcoCoordinadorController@show')->name('convenio-coordinador-pcc.data');
Route::get('de/convenio-coordinador-pcc/{convenio}/create', 'ConvenioMarcoCoordinadorController@create')->name('convenio-coordinador-pcc.create');
Route::post('de/convenio-coordinador-pcc/{coordinador}/destroy', 'ConvenioMarcoCoordinadorController@destroy')->name('convenio-coordinador-pcc.destroy');
#4.3. Módulo para el registro de coordinadores de la Entidad
Route::resource('de/convenio-coordinador-entidad', 'ConvenioMarcoCoordinadorEntidadController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-coordinador-entidad/{convenio}/data', 'ConvenioMarcoCoordinadorEntidadController@show')->name('convenio-coordinador-entidad.data');
Route::get('de/convenio-coordinador-entidad/{convenio}/create', 'ConvenioMarcoCoordinadorEntidadController@create')->name('convenio-coordinador-entidad.create');
Route::post('de/convenio-coordinador-entidad/{coordinador}/destroy', 'ConvenioMarcoCoordinadorEntidadController@destroy')->name('convenio-coordinador-entidad.destroy');
#4.4. Módulo para el registro de compromisos asumidos
Route::resource('de/convenio-compromiso', 'ConvenioMarcoCompromisoController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-compromiso/{convenio}/data', 'ConvenioMarcoCompromisoController@show')->name('convenio-compromiso.data');
Route::get('de/convenio-compromiso/{convenio}/create', 'ConvenioMarcoCompromisoController@create')->name('convenio-compromiso.create');
Route::post('de/convenio-compromiso/{compromiso}/destroy', 'ConvenioMarcoCompromisoController@destroy')->name('convenio-compromiso.destroy');
#4.5. Módulo para el registro de implementacion de compromisos
Route::resource('de/convenio-implementacion', 'ConvenioMarcoImplementacionController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-implementacion/{convenio}/data', 'ConvenioMarcoImplementacionController@show')->name('convenio-implementacion.data');
Route::get('de/convenio-implementacion/{convenio}/create', 'ConvenioMarcoImplementacionController@create')->name('convenio-implementacion.create');
Route::post('de/convenio-implementacion/{compromiso}/destroy', 'ConvenioMarcoImplementacionController@destroy')->name('convenio-implementacion.destroy');
#4.6. Módulo para la identificación de Entidades
Route::resource('de/convenio-postulante', 'ConvenioMarcoPostulanteController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-postulante/{convenio}/data', 'ConvenioMarcoPostulanteController@show')->name('convenio-postulante.data');
Route::get('de/convenio-postulante/{convenio}/create', 'ConvenioMarcoPostulanteController@create')->name('convenio-postulante.create');
Route::post('de/convenio-postulante/{postulante}/destroy', 'ConvenioMarcoPostulanteController@destroy')->name('convenio-postulante.destroy');
#4.7. Módulo para el registro de ampliaciones
Route::resource('de/convenio-ampliacion', 'ConvenioMarcoAmpliacionController')->except(['show', 'create', 'destroy']);
Route::get('de/convenio-ampliacion/{convenio}/data', 'ConvenioMarcoAmpliacionController@show')->name('convenio-ampliacion.data');
Route::get('de/convenio-ampliacion/{convenio}/create', 'ConvenioMarcoAmpliacionController@create')->name('convenio-ampliacion.create');
Route::post('de/convenio-ampliacion/{postulante}/destroy', 'ConvenioMarcoAmpliacionController@destroy')->name('convenio-ampliacion.destroy');
#4.8. Reporte consolidado de convenios interistitucionales
Route::get('de/convenio-reporte', 'ConvenioMarcoController@viewConsolidadoConvenio')->name('convenio-reporte.index');
Route::get('de/convenio-reporte/{tipo}/{estado}/data', 'ConvenioMarcoController@showConvenio')->name('convenio-reporte.data');
Route::get('de/convenio-reporte/{tipo}/{estado}/excel', 'ExportaExcelController@exportaConsolidadoConvenio')->name('convenio-reporte.excel');
#4.9. Reporte consolidado de seguimiento de convenios
Route::get('de/convenio-seguimiento', 'ConvenioMarcoController@viewConsolidadoSeguimientoConvenio')->name('convenio-seguimiento.index');
Route::get('de/convenio-seguimiento/{tipo}/{estado}/{periodo}/data', 'ConvenioMarcoController@showSeguimientoConvenio')->name('convenio-seguimiento.data');
Route::get('de/convenio-seguimiento/{tipo}/{estado}/{periodo}/excel', 'ExportaExcelController@exportaConsolidadoSeguimientoConvenio')->name('convenio-seguimiento.excel');
#4.10. Reporte consolidado de convenios en general
Route::get('de/convenio-consolidado', 'ConvenioMarcoController@viewListadoConvenio')->name('convenio-consolidado.index');
Route::get('de/convenio-consolidado/{tipo}/{periodo}/{estado}/data', 'ConvenioMarcoController@showListadoConvenio')->name('convenio-consolidado.data');
Route::get('de/convenio-consolidado/{tipo}/{periodo}/{estado}/excel', 'ExportaExcelController@exportaListadoConvenio')->name('convenio-consolidado.excel');

#4. Rutas para el módulo de PRP
#4.1. Módulo para el registro de proyectos
Route::resource('iniciativa/prp', 'InicPRPController')->except(['show', 'update']);
Route::get('iniciativa/prp/data/{tipo}', 'InicPRPController@show')->name('prp.data');
Route::post('iniciativa/prp/{iniciativa}', 'InicPRPController@update')->name('prp.update');
#4.2. Módulo para el registro del ambito de intervencion
Route::resource('iniciativa/ambito', 'AmbitoIntervencionController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/ambito/{iniciativa}/data', 'AmbitoIntervencionController@show')->name('ambito.data');
Route::get('iniciativa/ambito/{iniciativa}/create', 'AmbitoIntervencionController@create')->name('ambito.create');
Route::post('iniciativa/ambito/{ambito}/destroy', 'AmbitoIntervencionController@destroy')->name('ambito.destroy');
#4.3. Módulo para el registro de beneficiarios
Route::resource('iniciativa/socio', 'PostulanteProductorController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/socio/{iniciativa}/data', 'PostulanteProductorController@show')->name('socio.data');
Route::get('iniciativa/socio/{iniciativa}/create', 'PostulanteProductorController@create')->name('socio.create');
Route::post('iniciativa/socio/{socio}/destroy', 'PostulanteProductorController@destroy')->name('socio.destroy');
Route::get('proceso-prp/resultado/{iniciativa}/data', 'PostulanteProductorController@showResultado')->name('socio.data-resultado');
Route::get('proceso-prp/resultado/{socio}/edit', 'PostulanteProductorController@editResultado')->name('socio.edit-resultado');
Route::post('proceso-prp/resultado/{socio}', 'PostulanteProductorController@updateResultado')->name('socio.update-resultado');
Route::get('proceso-prp/campo/{iniciativa}/data', 'PostulanteProductorController@showEvaluacionCampo')->name('socio.data-campo');
Route::get('proceso-prp/campo/{socio}/edit', 'PostulanteProductorController@editEvaluacionCampo')->name('socio.edit-campo');
Route::post('proceso-prp/campo/{socio}', 'PostulanteProductorController@updateEvaluacionCampo')->name('socio.update-campo');
Route::get('proceso-prp/hidrico/{iniciativa}/data', 'PostulanteProductorController@showBalanceHidrico')->name('socio.data-hidrico');
Route::get('proceso-prp/hidrico/{socio}/edit', 'PostulanteProductorController@editBalanceHidrico')->name('socio.edit-hidrico');
Route::post('proceso-prp/hidrico/{socio}', 'PostulanteProductorController@updateBalanceHidrico')->name('socio.update-hidrico');
#4.4. Módulo para el mantenimiento de Productores aprobados en el PRPA
Route::resource('prpa/productor', 'ProductorPrpaController')->except(['index', 'create', 'store', 'show', 'destroy', 'update']);
Route::get('prpa/productor/{postulante}/data', 'ProductorPrpaController@show')->name('productor-prpa.data');
Route::get('prpa/productor/{postulante}/create', 'ProductorPrpaController@create')->name('productor-prpa.create');
Route::post('prpa/productor/store', 'ProductorPrpaController@store')->name('productor-prpa.store');
Route::post('prpa/productor/{productor}/destroy', 'ProductorPrpaController@destroy')->name('productor-prpa.destroy');
Route::post('prpa/productor/{productor}', 'ProductorPrpaController@update')->name('productor-prpa.update');
#4.5. Módulo para el mantenimiento de Información General de Proyectos PRPA en Ejecución
Route::get('prpa/proyecto', 'ProyectoPrpaController@index')->name('proyecto-prpa.index');
Route::get('prpa/proyecto/data', 'ProyectoPrpaController@show')->name('proyecto-prpa.data');
Route::get('prpa/proyecto/{contrato}/edit', 'ProyectoPrpaController@edit')->name('proyecto-prpa.edit');
Route::post('prpa/proyecto/edit/{contrato}', 'ProyectoPrpaController@update')->name('proyecto-prpa.update');














#5. Módulo para el proceso de evaluación de PRP
#5.1. Admisión de expediente
Route::resource('proceso-prp/admision', 'AdmisionExpedienteController')->except(['show', 'destroy']);
Route::get('proceso-prp/admision/data', 'AdmisionExpedienteController@show')->name('admision.data');
Route::get('proceso-prp/visor', 'AdmisionExpedienteController@reporte')->name('admision.visor');
Route::get('proceso-prp/resumen', 'AdmisionExpedienteController@resumen')->name('admision.resumen');
#5.2. Evaluación por parte de la UR
Route::get('proceso-prp/ur', 'ExpedienteController@indexPrpUr')->name('ur.index');
Route::get('proceso-prp/ur/create', 'ExpedienteController@createPrpUr')->name('ur.create');
Route::post('proceso-prp/ur', 'ExpedienteController@storePrpUr')->name('ur.store');
Route::get('proceso-prp/ur/{expediente}/edit', 'ExpedienteController@editPrpUr')->name('ur.edit');
Route::post('proceso-prp/ur/{expediente}', 'ExpedienteController@updatePrpUr')->name('ur.update');
Route::get('proceso-prp/ur/{expediente}/documento', 'ExpedienteController@preparaExpediente')->name('ur.documento');
Route::get('proceso-prp/ur/{area}/{tipo}/documento', 'ExpedienteController@showDocumentoUr')->name('ur.data-derivado');
Route::get('proceso-prp/ur/{expediente}/observa', 'ExpedienteController@observaExpedienteUr')->name('ur.observa');
Route::post('proceso-prp/ur/procesa-observacion/{expediente}', 'ExpedienteController@ProcesaObservacionPrpUr')->name('ur.procesa-observacion');
Route::get('proceso-prp/ur/{expediente}/subsana-observacion', 'ExpedienteController@formSubsanaObservacionUr')->name('ur.form-subsana-observacion');
Route::post('proceso-prp/ur/subsana-observacion/{expediente}', 'ExpedienteController@subsanaObservacionUr')->name('ur.subsana-observacion');
Route::get('proceso-prp/ur/{expediente}/archivo', 'ExpedienteController@archivaExpedientePrpUr')->name('ur.archivo');
Route::post('proceso-prp/ur/procesa-archivo/{expediente}', 'ExpedienteController@ProcesaArchivoPrpUr')->name('ur.procesa-archivo');
Route::post('proceso-prp/ur/procesa-envio/{expediente}', 'ExpedienteController@derivaExpediente')->name('ur.procesa-envio');
Route::get('proceso-prp/ur/data-pendiente', 'ExpedienteController@showPrpUrPendiente')->name('ur.data-pendiente');
Route::get('proceso-prp/ur/data-aprobado', 'ExpedienteController@showPrpUrAprobado')->name('ur.data-aprobado');
Route::get('proceso-prp/ur/data-observado', 'ExpedienteController@showPrpUrObservado')->name('ur.data-observado');
Route::get('proceso-prp/ur/data-archivado', 'ExpedienteController@showPrpUrArchivado')->name('ur.data-archivado');
#5.3. Evaluación por parte de la UPFP
Route::get('proceso-prp/upfp', 'ExpedienteController@indexUpfp')->name('upfp.index');
Route::get('proceso-prp/upfp/data-pendiente', 'ExpedienteController@showPrpUpfpPendiente')->name('upfp.data-pendiente');
Route::get('proceso-prp/upfp/data-aprobado', 'ExpedienteController@showPrpUpfpAprobado')->name('upfp.data-aprobado');
Route::get('proceso-prp/upfp/data-observado', 'ExpedienteController@showPrpUpfpObservado')->name('upfp.data-observado');
Route::get('proceso-prp/upfp/data-archivado', 'ExpedienteController@showPrpUpfpArchivado')->name('upfp.data-archivado');
Route::get('proceso-prp/upfp/{expediente}/admision', 'ExpedienteController@formAdmiteExpedienteUpfp')->name('upfp.admision');
Route::post('proceso-prp/upfp/admision/{expediente}', 'ExpedienteController@admiteExpedienteUpfp')->name('upfp.procesa-admision');
Route::get('proceso-prp/upfp/{expediente}/edit', 'ExpedienteController@editInformeUpfp')->name('upfp.edit');
Route::post('proceso-prp/upfp/{expediente}', 'ExpedienteController@updateInformeUpfp')->name('upfp.update');
Route::get('proceso-prp/upfp/{expediente}/informe', 'ExpedienteController@informeExpedienteUpfp')->name('upfp.informe');
Route::post('proceso-prp/upfp/procesa-informe/{expediente}', 'ExpedienteController@procesaExpedienteUpfp')->name('upfp.procesa-informe');
Route::get('proceso-prp/upfp/{expediente}/observa', 'ExpedienteController@observaExpedienteUpfp')->name('upfp.observa');
Route::post('proceso-prp/upfp/procesa-observacion/{expediente}', 'ExpedienteController@ProcesaObservacionPrpUpfp')->name('upfp.procesa-observacion');
Route::get('proceso-prp/upfp/{expediente}/archiva', 'ExpedienteController@formArchivaExpedienteUpfp')->name('upfp.archiva');
Route::post('proceso-prp/upfp/archiva/{expediente}', 'ExpedienteController@archivaExpedienteUpfp')->name('upfp.procesa-archiva');
#5.4. Evaluacion por parte de la UN
Route::get('proceso-prp/un', 'ExpedienteController@indexUn')->name('un.index');
Route::get('proceso-prp/un/data-pendiente', 'ExpedienteController@showPrpUnPendiente')->name('un.data-pendiente');
Route::get('proceso-prp/un/data-aprobado', 'ExpedienteController@showPrpUnAprobado')->name('un.data-aprobado');
Route::get('proceso-prp/un/data-observado', 'ExpedienteController@showPrpUnObservado')->name('un.data-observado');
Route::get('proceso-prp/un/data-archivado', 'ExpedienteController@showPrpUnArchivado')->name('un.data-archivado');
Route::get('proceso-prp/un/{expediente}/create', 'ExpedienteController@createExpedienteUn')->name('un.create');
Route::post('proceso-prp/un', 'ExpedienteController@storeExpedienteUn')->name('un.store');
Route::get('proceso-prp/un/{expediente}/informe', 'ExpedienteController@informeExpedienteUn')->name('un.informe');
Route::post('proceso-prp/un/procesa-informe/{expediente}', 'ExpedienteController@procesaExpedienteUn')->name('un.procesa-informe');
Route::get('proceso-prp/un/{expediente}/archiva', 'ExpedienteController@formArchivaExpedienteUn')->name('un.archivo');
Route::post('proceso-prp/un/archiva/{expediente}', 'ExpedienteController@archivaExpedienteUn')->name('un.procesa-archivo');
Route::get('proceso-prp/un/{expediente}/observa', 'ExpedienteController@formObservaExpedienteUn')->name('un.observa');
Route::post('proceso-prp/un/observa/{expediente}', 'ExpedienteController@observaExpedienteUn')->name('un.procesa-observacion');

#5.5. Evaluación por parte de la UAJ
Route::get('proceso-prp/uaj', 'ExpedienteController@indexUaj')->name('uaj.index');
Route::get('proceso-prp/uaj/data-pendiente', 'ExpedienteController@showPrpUajPendiente')->name('uaj.data-pendiente');
Route::get('proceso-prp/uaj/data-aprobado', 'ExpedienteController@showPrpUajAprobado')->name('uaj.data-aprobado');
Route::get('proceso-prp/uaj/data-observado', 'ExpedienteController@showPrpUajObservado')->name('uaj.data-observado');
Route::get('proceso-prp/uaj/data-archivado', 'ExpedienteController@showPrpUajArchivado')->name('uaj.data-archivado');
Route::get('proceso-prp/uaj/{expediente}/create', 'ExpedienteController@createExpedienteUaj')->name('uaj.create');
Route::post('proceso-prp/uaj', 'ExpedienteController@storeExpedienteUaj')->name('uaj.store');
Route::get('proceso-prp/uaj/{expediente}/califica', 'ExpedienteController@informeExpedienteUaj')->name('uaj.califica');
Route::post('proceso-prp/uaj/procesa-informe/{expediente}', 'ExpedienteController@procesaExpedienteUaj')->name('uaj.procesa-informe');
Route::get('proceso-prp/uaj/{expediente}/observa', 'ExpedienteController@formObservaExpedienteUaj')->name('uaj.observacion');
Route::post('proceso-prp/uaj/observa/{expediente}', 'ExpedienteController@observaExpedienteUaj')->name('uaj.procesa-observacion');
Route::get('proceso-prp/uaj/{expediente}/deriva', 'ExpedienteController@formDerivaExpedienteUaj')->name('uaj.derivacion');
Route::post('proceso-prp/uaj/deriva/{expediente}', 'ExpedienteController@derivaExpedienteUaj')->name('uaj.procesa-derivacion');
#5.6. Formulación del Proyecto
Route::resource('proceso-prp/formulacion', 'FormulacionController')->except(['show', 'destroy']);
Route::get('proceso-prp/formulacion/data', 'FormulacionController@show')->name('formulacion.data');
Route::get('proceso-prp/formulacion/{expediente}/derivar', 'FormulacionController@formDerivaExpediente')->name('formulacion.form-deriva-expediente');
Route::post('proceso-prp/formulacion/derivar/{expediente}', 'FormulacionController@derivaExpediente')->name('formulacion.deriva-expediente');




#5.7. Módulo para el registro de objetivos especificos
Route::resource('proceso-prp/objetivo-especifico', 'ObjetivoEspecificoController')->except('create', 'show', 'destroy');
Route::get('proceso-prp/objetivo-especifico/{postulante}/create', 'ObjetivoEspecificoController@create')->name('objetivo-especifico.create');
Route::get('proceso-prp/objetivo-especifico/{postulante}/data', 'ObjetivoEspecificoController@show')->name('objetivo-especifico.data');
#5.8. Módulo para el registro de componentes
Route::resource('proceso-prp/componente', 'ComponenteController')->except('create', 'show', 'destroy');
Route::get('proceso-prp/componente/{postulante}/create', 'ComponenteController@create')->name('componente.create');
Route::get('proceso-prp/componente/{postulante}/data', 'ComponenteController@show')->name('componente.data');
#5.9. Módulo para el registro de actividades
/*
Route::resource('proceso-prp/actividad', 'ActividadController')->except('create', 'show', 'destroy');
Route::get('proceso-prp/actividad/{postulante}/create', 'ActividadController@create')->name('actividad.create');
Route::get('proceso-prp/actividad/{postulante}/data', 'ActividadController@show')->name('actividad.data');
*/
#5.10. Módulo para el registro de indicadores de resultado
Route::resource('proceso-prp/indicador', 'IndicadorIniciativaController')->except('create', 'show', 'destroy');
Route::get('proceso-prp/indicador/{postulante}/create', 'IndicadorIniciativaController@create')->name('indicador.create');
Route::get('proceso-prp/indicador/{postulante}/data', 'IndicadorIniciativaController@show')->name('indicador.data');
#5.11. Módulo para el proceso de mantenimiento de Resoluciones Ministeriales
Route::resource('iniciativa/rm', 'ResolucionMinisterialController')->except(['show', 'destroy', 'create']);
Route::get('iniciativa/rm/{expediente}/create', 'ResolucionMinisterialController@create')->name('rm.create');
Route::get('iniciativa/rm/data', 'ResolucionMinisterialController@showDataPendiente')->name('rm.data');
Route::get('iniciativa/rm/data-rm', 'ResolucionMinisterialController@showData')->name('rm.data-rm');
#5.12. Módulo para el proceso de mantenimiento de Convenios
Route::resource('iniciativa/convenio', 'ContratoController')->except(['show', 'destroy', 'create']);
Route::get('iniciativa/convenio/{postulante}/create', 'ContratoController@create')->name('contrato.create');
Route::get('iniciativa/convenio/data', 'ContratoController@showDataPendiente')->name('contrato.data');
Route::get('iniciativa/convenio/data-convenio', 'ContratoController@showData')->name('contrato.data-convenio');
Route::get('iniciativa/convenio/{postulante}/estado', 'ContratoController@editEstadoContrato')->name('contrato.estado');
Route::post('iniciativa/convenio/estado/{contrato}', 'ContratoController@updateEstadoContrato')->name('contrato.estado-update');
#5.13. Módulo para el proceso de creación de adendas a Convenios
Route::resource('iniciativa/convenio-ampliacion', 'ContratoAmpliacionController')->except(['destroy', 'create']);
Route::get('iniciativa/convenio-ampliacion/{contrato}/create', 'ContratoAmpliacionController@create')->name('convenio-ampliacion.create');
#5.14. Módulo para el proceso de actualización de información de Expedientes PRPA
Route::resource('proceso-prp/mantenimiento', 'MantenimientoExpedientePrpController')->except(['destroy', 'create', 'store', 'show']);
Route::get('proceso-prp/mantenimiento/data', 'MantenimientoExpedientePrpController@show')->name('mantenimiento.data');
Route::get('proceso-prp/mantenimiento/{expediente}/ur', 'MantenimientoExpedientePrpController@formEditUr')->name('mantenimiento.edit-ur');
Route::post('proceso-prp/mantenimiento/ur/{expediente}', 'MantenimientoExpedientePrpController@updateExpedienteUr')->name('mantenimiento.update-ur');
Route::get('proceso-prp/mantenimiento/{expediente}/upfp', 'MantenimientoExpedientePrpController@formEditUpfp')->name('mantenimiento.edit-upfp');
Route::post('proceso-prp/mantenimiento/upfp/{expediente}', 'MantenimientoExpedientePrpController@updateExpedienteUpfp')->name('mantenimiento.update-upfp');
Route::get('proceso-prp/mantenimiento/{expediente}/formulacion', 'MantenimientoExpedientePrpController@formEditFormulacion')->name('mantenimiento.edit-formulacion');
Route::post('proceso-prp/mantenimiento/formulacion/{expediente}', 'MantenimientoExpedientePrpController@updateExpedienteFormulacion')->name('mantenimiento.update-formulacion');
Route::get('proceso-prp/mantenimiento/{expediente}/un', 'MantenimientoExpedientePrpController@formEditUn')->name('mantenimiento.edit-un');
Route::get('proceso-prp/mantenimiento/{expediente}/uaj', 'MantenimientoExpedientePrpController@formEditUaj')->name('mantenimiento.edit-uaj');















#6. Rutas para el módulo de Solicitudes de Apoyo
#6.1. Módulo para el registro de proyectos
Route::resource('iniciativa/sda', 'InicSdaController')->except(['show']);
Route::get('iniciativa/sda/data', 'InicSdaController@show')->name('sda.data');
#6.2. Módulo para el registro de productores
Route::resource('sda/productor', 'ProductorSdaController')->except(['index', 'create', 'show', 'destroy']);
Route::get('sda/productor/{postulante}/data', 'ProductorSdaController@show')->name('productor-sda.data');
Route::get('sda/productor/{postulante}/create', 'ProductorSdaController@create')->name('productor-sda.create');
Route::post('sda/productor/{contrato}/destroy', 'ProductorSdaController@destroy')->name('productor-sda.destroy');
#7. Módulo para el proceso de evaluación de SDA
#7.1. Evaluación por parte de la UR
Route::get('sda/admision', 'ExpedienteSdaUrController@index')->name('admision.index');
Route::get('sda/admision/create', 'ExpedienteSdaUrController@create')->name('admision.create');
Route::post('sda/admision', 'ExpedienteSdaUrController@store')->name('admision.store');
Route::get('sda/admision/{expediente}/edit', 'ExpedienteSdaUrController@edit')->name('admision.edit');
Route::post('sda/admision/{expediente}', 'ExpedienteSdaUrController@update')->name('admision.update');
Route::get('sda/admision/data-pendiente', 'ExpedienteSdaUrController@showDataPendiente')->name('admision.data-pendiente');
Route::get('sda/admision/data-aprobado', 'ExpedienteSdaUrController@showDataAprobado')->name('admision.data-aprobado');
Route::get('sda/admision/data-observado', 'ExpedienteSdaUrController@showDataObservado')->name('admision.data-observado');
Route::get('sda/admision/data-archivado', 'ExpedienteSdaUrController@showDataArchivado')->name('admision.data-archivado');
Route::get('sda/admision/{expediente}/archiva', 'ExpedienteSdaUrController@formArchivo')->name('admision.archiva');
Route::post('sda/admision/procesa-archivo/{expediente}', 'ExpedienteSdaUrController@procesaArchivo')->name('admision.procesa-archivo');
Route::get('sda/admision/{expediente}/observa', 'ExpedienteSdaUrController@formObserva')->name('admision.observa');
Route::post('sda/admision/procesa-observacion/{expediente}', 'ExpedienteSdaUrController@procesaObservacion')->name('admision.procesa-observacion');
Route::get('sda/admision/{expediente}/subsana-observacion', 'ExpedienteSdaUrController@formSubsanaObservacion')->name('admision.subsana');
Route::post('sda/admision/subsana-observacion/{expediente}', 'ExpedienteSdaUrController@subsanaObservacion')->name('admision.subsana-observacion');
Route::get('sda/admision/{expediente}/deriva', 'ExpedienteSdaUrController@formDeriva')->name('admision.deriva');
Route::post('sda/admision/procesa-derivacion/{expediente}', 'ExpedienteSdaUrController@procesaDerivacion')->name('admision.procesa-derivacion');
#7.2. Evaluación por parte de la UN
Route::get('sda/evaluacion', 'ExpedienteSdaUnController@index')->name('evaluacion.index');
Route::get('sda/evaluacion/{expediente}/create', 'ExpedienteSdaUnController@create')->name('evaluacion.create');
Route::post('sda/evaluacion/{expediente}', 'ExpedienteSdaUnController@update')->name('evaluacion.update');
Route::get('sda/evaluacion/{expediente}/observa', 'ExpedienteSdaUnController@formObserva')->name('evaluacion.observa');
Route::post('sda/evaluacion/procesa-observacion/{expediente}', 'ExpedienteSdaUnController@procesaObservacion')->name('evaluacion.procesa-observacion');
Route::get('sda/evaluacion/{expediente}/archivo', 'ExpedienteSdaUnController@formArchivo')->name('evaluacion.archivo');
Route::post('sda/evaluacion/procesa-archivo/{expediente}', 'ExpedienteSdaUnController@procesaArchivo')->name('evaluacion.procesa-archivo');
Route::get('sda/evaluacion/{expediente}/deriva', 'ExpedienteSdaUnController@formDeriva')->name('evaluacion.deriva');
Route::post('sda/evaluacion/procesa-derivacion/{expediente}', 'ExpedienteSdaUnController@procesaDerivacion')->name('evaluacion.procesa-derivacion');
Route::get('sda/evaluacion/data-pendiente', 'ExpedienteSdaUnController@showDataPendiente')->name('evaluacion.data-pendiente');
Route::get('sda/evaluacion/data-aprobado', 'ExpedienteSdaUnController@showDataAprobado')->name('evaluacion.data-aprobado');
Route::get('sda/evaluacion/data-observado', 'ExpedienteSdaUnController@showDataObservado')->name('evaluacion.data-observado');
Route::get('sda/evaluacion/data-archivado', 'ExpedienteSdaUnController@showDataArchivado')->name('evaluacion.data-archivado');
#7.3. Módulo para el registro y mantenimiento de consejos directivos
Route::resource('sda/cd', 'ConsejoDirectivoController')->except(['show', 'destroy']);
Route::get('sda/cd/data', 'ConsejoDirectivoController@show')->name('cd.data');
Route::get('sda/cd/{cd}/asigna', 'ConsejoDirectivoController@asignaSdaForm')->name('cd.asigna-sda-form');
Route::post('sda/cd/asigna', 'ConsejoDirectivoController@asignaSda')->name('cd.asigna-sda');
Route::get('sda/cd/{cd}/data-aprobado', 'ConsejoDirectivoController@showAsignaSda')->name('cd.data-aprobado');
#7.4. Módulo para el registro y mantenimiento de Convenios Sda
Route::resource('sda/convenio', 'ConvenioSdaController')->except(['show', 'destroy', 'create']);
Route::get('sda/convenio/data', 'ConvenioSdaController@show')->name('convenio.data');
Route::get('sda/convenio/{postulante}/create', 'ConvenioSdaController@create')->name('convenio.create');
Route::get('sda/convenio/data-pendiente', 'ConvenioSdaController@showDataPendiente')->name('convenio.data-pendiente');
Route::get('sda/convenio/data-aprobado', 'ConvenioSdaController@showDataAprobado')->name('convenio.data-aprobado');
Route::get('sda/convenio/{postulante}/estado', 'ConvenioSdaController@editEstadoContrato')->name('convenio.estado');
Route::post('sda/convenio/estado/{contrato}', 'ConvenioSdaController@updateEstadoContrato')->name('convenio.estado-update');
#7.5. Módulo para el mantenimiento de información general
Route::resource('sda/proyecto', 'ProyectoController')->except(['show','create', 'update', 'destroy']);
Route::post('sda/proyecto/{proyecto}', 'ProyectoController@update')->name('proyecto.update');
Route::get('sda/proyecto/data', 'ProyectoController@show')->name('proyecto.data');
#7.6. Módulo para el mantenimiento de Indicadores de Linea de base
Route::get('sda/linea-base', 'PostulanteResultadoController@indexLineaBase')->name('linea-base.index');
Route::get('sda/linea-base/{postulante}/create', 'PostulanteResultadoController@createLineaBase')->name('linea-base.create');
Route::post('sda/linea-base', 'PostulanteResultadoController@storeLineaBase')->name('linea-base.store');
Route::get('sda/linea-base/{postulante}/data', 'PostulanteResultadoController@showLineaBase')->name('linea-base.data');
Route::get('sda/linea-base/{indicador}/edit', 'PostulanteResultadoController@editLineaBase')->name('linea-base.edit');
Route::post('sda/linea-base/{indicador}', 'PostulanteResultadoController@updateLineaBase')->name('linea-base.update');
#7.7. Módulo para el registro de ejecución de indicadores
Route::get('sda/resultado/{postulante}/data', 'PostulanteResultadoController@showEjecucion')->name('indicador-resultado.data');
Route::get('sda/resultado/{indicador}/edit', 'PostulanteResultadoController@editEjecucion')->name('indicador-resultado.edit');
Route::post('sda/resultado/{indicador}', 'PostulanteResultadoController@updateEjecucion')->name('indicador-resultado.update');
#7.7. Módulo para el registro de Indicadores de Linea de cierre
Route::get('sda/linea-cierre/{postulante}/data', 'PostulanteResultadoController@showLineaCierre')->name('linea-cierre.data');
Route::get('sda/linea-cierre/{indicador}/edit', 'PostulanteResultadoController@editLineaCierre')->name('linea-cierre.edit');
Route::post('sda/linea-cierre/{indicador}', 'PostulanteResultadoController@updateLineaCierre')->name('linea-cierre.update');

#24. Módulo para importar información de Excel a una tabla
Route::get('proceso-pdn/import-desembolso', 'ImportDesembolsoSdaController@index')->name('import-sda.index');
Route::get('proceso-pdn/import-desembolso/data','ImportDesembolsoSdaController@show')->name('import-sda.data');
Route::get('proceso-pdn/import-desembolso/create','ImportDesembolsoSdaController@importForm')->name('import-sda.importForm');
Route::post('proceso-pdn/import-desembolso','ImportDesembolsoSdaController@import')->name('import-sda.import');
Route::post('proceso-pdn/import-desembolso/{desembolso}/destroy', 'ImportDesembolsoSdaController@destroy')->name('desembolso.destroy');
Route::get('proceso-pdn/import-desembolso/delete','ImportDesembolsoSdaController@formDelete')->name('import-sda.deleteForm');
Route::post('proceso-pdn/import-desembolso/delete','ImportDesembolsoSdaController@procesaDelete')->name('import-sda.delete');

#25. Módulo para registrar un proceso de no objecion
Route::resource('monitoreo/nobjecion', 'NoObjecionController')->except(['show','destroy']);
Route::get('monitoreo/nobjecion/data', 'NoObjecionController@show')->name('nobjecion.data');
Route::post('monitoreo/nobjecion/{documento}/destroy', 'NoObjecionController@destroy')->name('nobjecion.destroy');
#26. Módulo para registrar el detalle de una No Objecion
Route::resource('monitoreo/nobjecion-detalle', 'NoObjecionDetalleController')->except(['create','destroy']);
Route::get('monitoreo/nobjecion-detalle/{NoObjecion}/create', 'NoObjecionDetalleController@create')->name('nobjecion-detalle.create');
Route::post('monitoreo/nobjecion-detalle/{detalle}/destroy', 'NoObjecionDetalleController@destroy')->name('nobjecion-detalle.destroy');
#27. Módulo para el mantenimiento del Módulo Solicitudes de Desembolso
Route::resource('monitoreo/solicitud', 'SolicitudDesembolsoController')->except(['show','destroy']);
Route::get('monitoreo/solicitud/data', 'SolicitudDesembolsoController@show')->name('solicitud.data');
Route::post('monitoreo/solicitud/{solicitud}/destroy', 'SolicitudDesembolsoController@destroy')->name('solicitud.destroy');
#28. Módulo para el registro del detalle de Solicitudes de desembolso
Route::resource('monitoreo/solicitud-detalle', 'SolicitudDesembolsoDetalleController')->except(['create','destroy']);
Route::get('monitoreo/solicitud-detalle/{solicitud}/create', 'SolicitudDesembolsoDetalleController@create')->name('solicitud-detalle.create');
Route::post('monitoreo/solicitud-detalle/{detalle}/destroy', 'SolicitudDesembolsoDetalleController@destroy')->name('solicitud-detalle.destroy');


#29. Módulo para el registro de actividades
Route::resource('proyecto/actividad', 'ActividadController')->except('create','show', 'destroy');
Route::get('proyecto/actividad/{proyecto}/create', 'ActividadController@create')->name('actividad.create');
Route::get('proyecto/actividad/{proyecto}/data', 'ActividadController@show')->name('actividad.data');
Route::get('proyecto/actividad/data-sp', 'ActividadController@showProyecto')->name('actividad.data-sp');
Route::post('proyecto/actividad/{actividad}/destroy', 'ActividadController@destroy')->name('actividad.destroy');




















/*
#6. Módulo para el proceso de registro de Marco logico
#6.1. Registro de la matriz de Marco logico
Route::resource('proyecto/ml', 'MLProyectoController')->except(['show', 'destroy']);
Route::get('proyecto/ml/data', 'MLProyectoController@show')->name('ml.data');
#6.2. Registro de los resultados del Marco Logico
Route::resource('proyecto/resultado', 'MLComponenteController')->except(['create', 'show']);
Route::get('proyecto/resultado/{ml}/create', 'MLComponenteController@create')->name('resultado.create');
Route::get('proyecto/resultado/{ml}/data', 'MLComponenteController@show')->name('resultado.data');
#6.3. Registro de los indicadores del Marco Logico
Route::resource('proyecto/indicador', 'MLIndicadorController')->except(['create', 'show']);
Route::get('proyecto/indicador/{ml}/create', 'MLIndicadorController@create')->name('indicador.create');
Route::get('proyecto/indicador/{ml}/data', 'MLIndicadorController@show')->name('indicador.data');
#6.4. Registro de las actividades del Marco Logico
Route::resource('proyecto/actividad', 'MLActividadController')->except(['create', 'show']);
Route::get('proyecto/actividad/{ml}/create', 'MLActividadController@create')->name('resultado.create');
Route::get('proyecto/actividad/{ml}/data', 'MLActividadController@show')->name('resultado.data');
#6.5. Registro de los indicadores de las actividades del ML
Route::resource('proyecto/indicador-actividad', 'MLIndicadorActividadController')->except(['create', 'show']);
Route::get('proyecto/indicador-actividad/{ml}/create', 'MLIndicadorActividadController@create')->name('indicador-actividad.create');
Route::get('proyecto/indicador-actividad/{ml}/data', 'MLIndicadorActividadController@show')->name('indicador-actividad.data');
*/
#7. Módulo para registro de cartera de PRP
Route::resource('proceso-prp/cartera-prp', 'CarteraPrpController')->except(['show']);
Route::get('proceso-prp/cartera-prp/data', 'CarteraPrpController@show')->name('cartera-prp.data');
Route::get('proceso-prp/cartera-prp/{cartera}/asigna-prp', 'CarteraPrpController@asignaPrp')->name('cartera-prp.asigna-prp');
Route::post('proceso-prp/cartera-prp/procesa-prp', 'CarteraPrpController@procesaAsignaPrp')->name('cartera-prp.procesa-prp');
#9. Módulo para la visualizacion de información consolidada
Route::get('proceso-prp/consolidado/consolidado-rm','PivotController@index_upfp_aprobado_rm')->name('pivot-upfp-rm.index');
Route::get('proceso-prp/consolidado/consolidado-rm/data', 'PivotController@data_upfp_aprobado_rm')->name('pivot-upfp-rm.data');
Route::get('proceso-prp/consolidado/consolidado-aprobado','PivotController@index_upfp_formulado')->name('pivot-upfp-formulado.index');
Route::get('proceso-prp/consolidado/consolidado-aprobado/data', 'PivotController@data_upfp_formulado')->name('pivot-upfp-formulado.data');
Route::get('proceso-prp/consolidado/consolidado-prpa','PivotController@index_upfp_formulacion')->name('pivot-upfp-formulacion.index');
Route::get('proceso-prp/consolidado/consolidado-prpa/data', 'PivotController@data_upfp_formulacion')->name('pivot-upfp-formulacion.data');
Route::get('proceso-prp/consolidado/consolidado-ur','PivotController@index_upfp_cartera')->name('pivot-upfp-cartera.index');
Route::get('proceso-prp/consolidado/consolidado-ur/data', 'PivotController@data_upfp_cartera')->name('pivot-upfp-cartera.data');
/*
Route::get('proceso-prp/consolidado/consolidado-ur', 'ConsolidadoPrpController@indexConsolidadoUr')->name('proceso-prp.consolidado-ur-index');
Route::get('proceso-prp/consolidado/consolidado-ur/data', 'ConsolidadoPrpController@showConsolidadoUr')->name('proceso-prp.consolidado-ur-data');
*/

#10. Módulo para el registro de Eventos de capacitación
Route::resource('iniciativa/capacitacion', 'CapacitacionController')->except(['show', 'update']);
Route::get('iniciativa/capacitacion/pendiente', 'CapacitacionController@showPendiente')->name('capacitacion.data-pendiente');
Route::post('iniciativa/capacitacion/{capacitacion}', 'CapacitacionController@update')->name('capacitacion.update');
Route::get('iniciativa/capacitacion/{capacitacion}/reprograma', 'CapacitacionController@formReprograma')->name('capacitacion.form-reprograma');
Route::post('iniciativa/capacitacion/reprograma/{capacitacion}', 'CapacitacionController@reprograma')->name('capacitacion.reprograma');
Route::get('iniciativa/capacitacion/{capacitacion}/cancela', 'CapacitacionController@formCancela')->name('capacitacion.form-cancela');
Route::post('iniciativa/capacitacion/cancela/{capacitacion}', 'CapacitacionController@cancela')->name('capacitacion.cancela');




#11. Módulo para el registro de la implementación de Eventos de capacitación
Route::resource('iniciativa/capacitacion-implementacion', 'CapacitacionEjecucionController')->except(['show', 'create', 'update']);
Route::get('iniativa/capacitacion-implementacion/{capacitacion}/create', 'CapacitacionEjecucionController@create')->name('capacitacion-implementacion.create');
Route::get('iniciativa/capacitacion-implementacion/data', 'CapacitacionEjecucionController@show')->name('capacitacion-implementacion.data');
Route::post('iniciativa/capacitacion-implementacion/{capacitacion}', 'CapacitacionEjecucionController@update')->name('capacitacion-implementacion.update');
#12. Módulo para el registro de las rendiciones a las capacitaciones
Route::resource('iniciativa/capacitacion-ejecucion', 'CapacitacionRendicionController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/capacitacion-ejecucion/{capacitacion}/data', 'CapacitacionRendicionController@show')->name('capacitacion-ejecucion.data');
Route::get('iniciativa/capacitacion-ejecucion/{capacitacion}/create', 'CapacitacionRendicionController@create')->name('capacitacion-ejecucion.create');
Route::post('iniciativa/capacitacion-ejecucion/{ejecucion}/destroy', 'CapacitacionRendicionController@destroy')->name('capacitacion-ejecucion.destroy');
#13. Módulo para el registro de los participantes de las capacitaciones
Route::resource('iniciativa/capacitacion-participante', 'CapacitacionParticipanteController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/capacitacion-participante/{capacitacion}/data', 'CapacitacionParticipanteController@show')->name('capacitacion-participante.data');
Route::get('iniciativa/capacitacion-participante/{capacitacion}/create', 'CapacitacionParticipanteController@create')->name('capacitacion-participante.create');
Route::post('iniciativa/capacitacion-participante/{participante}/destroy', 'CapacitacionParticipanteController@destroy')->name('capacitacion-participante.destroy');
#14. Módulo para el registro de los extensionistas de las capacitaciones
Route::resource('iniciativa/capacitacion-extensionista', 'CapacitacionExtensionistaController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/capacitacion-extensionista/{capacitacion}/data', 'CapacitacionExtensionistaController@show')->name('capacitacion-extensionista.data');
Route::get('iniciativa/capacitacion-extensionista/{capacitacion}/create', 'CapacitacionExtensionistaController@create')->name('capacitacion-extensionista.create');
Route::post('iniciativa/capacitacion-extensionista/{extensionista}/destroy', 'CapacitacionExtensionistaController@destroy')->name('capacitacion-extensionista.destroy');
#14. Consolidado de información de Serviagro
Route::get('iniciativa/pivot-capacitacion','PivotController@index_serviagro')->name('pivot-capacitacion.index');
Route::get('iniciativa/pivot-capacitacion/data', 'PivotController@data_serviagro')->name('pivot-capacitacion.data');
#15. Módulo para el registro de Eventos de difusión
Route::resource('iniciativa/difusion', 'DifusionController')->except(['show', 'update']);
Route::get('iniciativa/difusion/data', 'DifusionController@show')->name('difusion.data');
Route::post('iniciativa/difusion/{difusion}', 'DifusionController@update')->name('difusion.update');
#16. Módulo para el registro de la implementación de Eventos de difusión
Route::resource('iniciativa/difusion-implementacion', 'DifusionEjecucionController')->except(['show', 'update']);
Route::get('iniciativa/difusion-implementacion/data', 'DifusionEjecucionController@show')->name('difusion-implementacion.data');
Route::post('iniciativa/difusion-implementacion/{difusion}', 'DifusionEjecucionController@update')->name('difusion-implementacion.update');
#17. Módulo para el registro de las rendiciones a las difusiones
Route::resource('iniciativa/difusion-ejecucion', 'DifusionRendicionController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/difusion-ejecucion/{difusion}/data', 'DifusionRendicionController@show')->name('difusion-ejecucion.data');
Route::get('iniciativa/difusion-ejecucion/{difusion}/create', 'DifusionRendicionController@create')->name('difusion-ejecucion.create');
Route::post('iniciativa/difusion-ejecucion/{ejecucion}/destroy', 'DifusionRendicionController@destroy')->name('difusion-ejecucion.destroy');
#18. Módulo para el registro de las entidades participantes en las difusiones
Route::resource('iniciativa/difusion-entidad-participante', 'DifusionEntidadController')->except(['show', 'create', 'destroy']);
Route::get('iniciativa/difusion-entidad-participante/{difusion}/data', 'DifusionEntidadController@show')->name('difusion-entidad.data');
Route::get('iniciativa/difusion-entidad-participante/{difusion}/create', 'DifusionEntidadController@create')->name('difusion-entidad.create');
Route::post('iniciativa/difusion-entidad-participante/{entidad}/destroy', 'DifusionEntidadController@destroy')->name('difusion-entidad.destroy');


#19. Módulo para guardar la información de Procesos de cierre y cierre
Route::get('iniciativa/proceso/proceso-cierre/{postulante}/create', 'PostulanteProcesoController@createProcesoCierre')->name('proceso-cierre.create');
Route::post('iniciativa/proceso/proceso-cierre', 'PostulanteProcesoController@storeProcesoCierre')->name('proceso-cierre.store');
Route::get('iniciativa/proceso/proceso-cierre/{postulante}/data', 'PostulanteProcesoController@showProcesoCierre')->name('proceso-cierre.data');
Route::get('iniciativa/proceso/cierre/{postulante}/create', 'PostulanteProcesoController@createCierre')->name('cierre.create');
Route::post('iniciativa/proceso/cierre', 'PostulanteProcesoController@storeCierre')->name('cierre.store');
Route::get('iniciativa/proceso/cierre/{postulante}/data', 'PostulanteProcesoController@showCierre')->name('cierre.data');







#1.17. Módulo para la consulta reniec y sunat
Route::get('dni/{dni}', 'WebServicesController@getDni')->name('servicio.dni');
Route::get('ruc/{ruc}', 'WebServicesController@getRuc')->name('servicio.ruc');
Route::get('tc/{fecha}', 'WebServicesController@getTc')->name('servicio.tc');
Route::get('sunat/{ruc}', 'WebServicesController@getDataSunat')->name('servicio.sunat');
