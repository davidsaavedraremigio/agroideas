<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Requests\ExpedientePrpUrFormRequest;
use App\Http\Requests\ExpedientePrpFormRequest;
use App\Http\Requests\ExpedientePrpUpfpFormRequest;
use App\Http\Requests\ExpedientePrpUrEditFormRequest;
use App\Http\Requests\DerivaExpedienteFormRequest;
use App\Http\Requests\DerivaExpedienteUpfpFormRequest;
use App\Http\Requests\DerivaExpedienteUnFormRequest;
use App\Http\Requests\ExpedientePrpUrObservaFormRequest;
use App\Http\Requests\ExpedientePrpUrArchivaFormRequest;
use App\Http\Requests\ExpedientePrpUpfpObservaFormRequest;
use App\Http\Requests\RecepcionaExpedienteUnFormRequest;
use App\Http\Requests\RecepcionaExpedienteUajFormRequest;
use App\Http\Requests\DerivaExpedienteUajFormRequest;

use App\Entidad;
use App\Postulante;
use App\Proyecto;
use App\PostulanteEstado;
use App\Contrato;
use App\ResolucionMinisterial;
use App\Expediente;
use App\ExpedienteDocumento;
use App\ExpedienteMonitoreo;
use App\ExpedienteUr;
use App\ExpedienteUpfp;
use App\ExpedienteUn;
use App\ExpedienteUaj;
use App\TablaValor;
use App\Area;
use App\Oficina;
use App\Staff;
use App\CarteraPrp;
use App\Usuario;
use DB;
use Auth;

class ExpedienteController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path_prp = 'proceso-prp';
    private $path_pdn = 'proceso-pdn';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3. Obtenemos el index para los proyectos PRP
    public function indexPrpUr()
    {
        return view('proceso-prp.ur.index');
    }

    #2. Mostramos el formulario para generar nuevos expedientes
    public function createPrpUr()
    {
        #1. Obtengo las variables que iran en los combos
        $tipo_iniciativa    =   2;  //Codigo de incentivos prp
        $estado_situacional =   0;  //Codigo de las iniciativas que aun no se han presentado a concurso
        $entidades          =   Postulante::getDataEstado($tipo_iniciativa, $estado_situacional);
        $oficinas           =   Oficina::getData();
        $personal           =   Usuario::getData();
        $cartera            =   CarteraPrp::getData();

        #2. Retorno a la vista principal
        return view('proceso-prp.ur.create', compact('entidades', 'oficinas', 'personal', 'cartera'));
    }

    #3. Guardamos la información del expediente prp
    public function storePrpUr(ExpedientePrpUrFormRequest $request)
    {
        #1. Guardamos la información del expediente
        try 
        {
            $expediente                         =   new Expediente;
            $expediente->codPostulante          =   $request->get('entidad');
            $expediente->nroCut                 =   $request->get('nro_cut');
            $expediente->fechaCut               =   $request->get('fecha_recepcion');
            $expediente->nroExpediente          =   $request->get('nro_expediente');
            $expediente->fechaExpediente        =   $request->get('fecha_expediente');
            $expediente->codOficina             =   $request->get('oficina');
            $expediente->codPersonalAsignado    =   $request->get('especialista');
            $expediente->codArea                =   8;
            $expediente->codEstado              =   1; #Estado pendiente
            $expediente->created_auth           =   Auth::user()->id;
            $expediente->updated_auth           =   Auth::user()->id;
            $expediente->save(); 

            #2. Genero un registro para el documento Ur
            try 
            {
                $ur                     =   new ExpedienteUr;
                $ur->codExpediente      =   $expediente->id;
                $ur->fechaRecepcion     =   $request->get('fecha_recepcion');
                $ur->codEstadoProceso   =   1;
                $ur->created_auth       =   Auth::user()->id;
                $ur->updated_auth       =   Auth::user()->id;
                $ur->save();

                #3. Actualizamos el estado situacional del expediente
                try 
                {
                    $situacion                          =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                    $situacion->codEstadoSituacional    =   13;
                    $situacion->updated_auth            =   Auth::user()->id;
                    $situacion->update();

                    #4.- Retornamos al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  '',
                        'mensaje'   =>  'La información se procesó de manera exitosa.'
                    ]);
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #4. Muestro la información registrada
    public function showPrpUrPendiente()
    {
        #1. Obtengo los expedientes generados
        $estado         =   1;
        $expediente     =   ExpedienteUr::getConsolidado($estado);
        return view('proceso-prp.ur.data', compact('expediente'));
    }
    public function showPrpUrAprobado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   2;
        $expediente     =   ExpedienteUr::getDataExpediente($estado);
        return view('proceso-prp.ur.data-aprobado', compact('expediente'));
    }
    public function showPrpUrObservado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   4;
        $data           =   ExpedienteUr::getDataExpediente($estado);
        return view('proceso-prp.ur.data-observado', compact('data'));
    }
    public function showPrpUrArchivado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   3;
        $expediente     =   ExpedienteUr::getDataExpediente($estado);
        return view('proceso-prp.ur.data-archivado', compact('expediente'));
    }        

    #5. Actualizo la información del expediente
    public function editPrpUr($id)
    {
        #1. Obtengo los datos del expediente
        $expediente         =   Expediente::findOrFail($id);
        #2. Obtengo las variables que iran en los combos
        $tipo_iniciativa    =   2; //Codigo de incentivos prp
        $entidades          =   Postulante::getData($tipo_iniciativa);
        $oficinas           =   Oficina::getData();
        $personal           =   Usuario::getData();
        $ur                 =   ExpedienteUr::getData($id);
        $cartera            =   CarteraPrp::getData();
        #3. Retorno al formulario 
        return view('proceso-prp.ur.edit', compact('expediente', 'entidades', 'oficinas', 'personal', 'ur', 'cartera'));
    }

    #6. Realizo la actualización del expediente
    public function updatePrpUr(ExpedientePrpUrEditFormRequest $request, $id)
    {
        #1. Actualizo la información del expediente
        try 
        {
            $expediente                         =   Expediente::findOrFail($id);
            $expediente->nroCut                 =   $request->get('nro_cut');
            $expediente->fechaCut               =   $request->get('fecha_recepcion');
            $expediente->nroExpediente          =   $request->get('nro_expediente');
            $expediente->fechaExpediente        =   $request->get('fecha_expediente');
            $expediente->codOficina             =   $request->get('oficina');
            $expediente->codPersonalAsignado    =   $request->get('especialista');
            $expediente->updated_auth           =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información del expediente UR
            try 
            {
                $ur                             =   ExpedienteUr::getData($id);
                $ur->cod_responsable_geo        =   $request->get('responsable_informe_geo');
                $ur->fecha_solicitud_geo        =   $request->get('fecha_solicitud_geo');
                $ur->fecha_informe_geo          =   $request->get('fecha_informe_geo');
                $ur->cod_responsable_doc        =   $request->get('responsable_informe_doc');
                $ur->nro_informe_doc            =   $request->get('nro_informe_doc');
                $ur->fecha_informe_doc          =   $request->get('fecha_informe_doc');
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();

                #3. retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
                ]);
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }
    
    #7. Muestro el formulario para la observacion de expedientes
    public function observaExpedienteUr($id)
    {
        #1. Obtengo la información del expediente
        $expediente         =   Expediente::findOrFail($id);
        #2. Obtengo las variables que iran en los combos
        $personal           =   Usuario::getDataOficina($expediente->codOficina);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $ur                 =   ExpedienteUr::getData($id);
        #3. Retorno a la vista
        return view('proceso-prp.ur.observa', compact('expediente', 'personal', 'estado', 'ur'));
    }

    #8. Realizo el procesamiento de la observacion
    public function ProcesaObservacionPrpUr(ExpedientePrpUrObservaFormRequest $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   4; #Estado Observado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información de la observacion
            try 
            {
                $ur                             =   ExpedienteUr::getData($id);
                $ur->cod_responsable_doc        =   $request->get('responsable');
                $ur->nro_informe_doc_observa    =   $request->get('nro_informe');
                $ur->fecha_informe_doc_observa  =   $request->get('fecha_informe');
                $ur->nro_carta_observa          =   $request->get('nro_carta');
                $ur->fecha_carta_observa        =   $request->get('fecha_carta');
                $ur->codEstadoProceso           =   4; #Estado Observado
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();

                #3. Actualizamos el estado situacional del Postulante
                try 
                {
                    $situacion                          =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                    $situacion->codEstadoSituacional    =   10; #observado en evaluacion documentaria
                    $situacion->updated_auth            =   Auth::user()->id;
                    $situacion->update();

                    #4. retorno al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  '',
                        'mensaje'   =>  'La información se procesó de manera exitosa.'
                    ]);
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #9. Levanto la observación
    public function  formSubsanaObservacionUr($id)
    {
        #1. Obtengo los datos del expediente
        $expediente         =   Expediente::findOrFail($id);
        #2. Obtengo las variables que iran en los combos
        $personal           =   Usuario::getDataOficina($expediente->codOficina);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $ur                 =   ExpedienteUr::getData($id);
        #3. Retorno a la vista
        return view('proceso-prp.ur.subsana', compact('expediente', 'personal', 'estado', 'ur'));
    }

    #10. Procesa el levantamiento de las observaciones
    public function subsanaObservacionUr(Request $request, $id)
    {
        #1. Actualizamos el estado actual del expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   1; #Volvemos a estado Pendiente
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información del expediente de la UR
            try 
            {
                $ur                                     =   ExpedienteUr::getData($id);
                $ur->fecha_levanta_observacion          =   $request->get('fecha_respuesta');
                $ur->fecha_recibe_expediente_observado  =   $request->get('fecha_recepcion');
                $ur->codEstadoProceso                   =   1;
                $ur->updated_auth                       =   Auth::user()->id;
                $ur->update();

                #3. Actualizo el estado situacional del Postulante
                try 
                {
                    $situacion                          =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                    $situacion->codEstadoSituacional    =   13;#En proceso de evaluacion
                    $situacion->updated_auth            =   Auth::user()->id;
                    $situacion->update();

                    #4. retorno al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  '',
                        'mensaje'   =>  'La información se procesó de manera exitosa.'
                    ]);
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #11. Muestro el formulario para archivar expedientes
    public function archivaExpedientePrpUr($id)
    {
        #1. Obtengo la información del expediente
        $expediente         =   Expediente::findOrFail($id);
        #2. Obtengo las variables que iran en los combos
        $personal           =   Usuario::getDataOficina($expediente->codOficina);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $ur                 =   ExpedienteUr::getData($id);
        #3. Retorno a la vista
        return view('proceso-prp.ur.archiva', compact('expediente', 'personal', 'estado', 'ur'));        
    }

    #12. Realizo el procesamiento de la archivamiento
    public function ProcesaArchivoPrpUr(ExpedientePrpUrArchivaFormRequest $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   $request->get('estado_situacional');
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información de archivo
            try 
            {
                $ur                             =   ExpedienteUr::getData($id);
                $ur->cod_responsable_doc        =   $request->get('responsable');
                $ur->nro_carta_archivo          =   $request->get('nro_carta');
                $ur->fecha_carta_archivo        =   $request->get('fecha_carta');
                $ur->codEstadoProceso           =   $request->get('estado_situacional');
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();

                #3. Proceso la información de expedientes archivados
                try 
                {
                    $situacion                          =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                    $situacion->codEstadoSituacional    =   11;
                    $situacion->updated_auth            =   Auth::user()->id;
                    $situacion->update();

                    #4. retorno al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  '',
                        'mensaje'   =>  'La información se procesó de manera exitosa.'
                    ]);
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #7. Mostramos el formulario para derivacion de expedientes
    public function preparaExpediente($id)
    {
        #1. Obtengo la info del expediente
        $expediente         =   Expediente::findOrFail($id);
        $personal           =   Usuario::getData();
        $areas              =   Area::getData();
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $ur                 =   ExpedienteUr::getData($id);
        #2. Retorno al formulario
        return view('proceso-prp.ur.send', compact('expediente', 'personal', 'areas', 'estado', 'ur'));
    }

    #8. Generamos la derivación al área seleccionada
    public function derivaExpediente(DerivaExpedienteFormRequest $request, $id)
    {
       try 
       {
           $expediente              =   Expediente::findOrFail($id);
           $expediente->codArea     =   6; #Area correspondiente a UPFP
           $expediente->codEstado   =   2; #Corresponde al estado aprobado
           $expediente->updated_auth=   Auth::user()->id;
           $expediente->update();

           #2. Actualizo la información del expediente UR
           try 
           {
                $ur                             =   ExpedienteUr::getData($id);
                $ur->cod_responsable_geo        =   $request->get('responsable_informe_geo');
                $ur->fecha_solicitud_geo        =   $request->get('fecha_solicitud_geo');
                $ur->fecha_informe_geo          =   $request->get('fecha_informe_geo');
                $ur->cod_responsable_doc        =   $request->get('responsable_informe_doc');
                $ur->nro_informe_doc            =   $request->get('nro_informe_doc');
                $ur->fecha_informe_doc          =   $request->get('fecha_informe_doc');
                $ur->cod_responsable_tec        =   $request->get('responsable_informe_doc');
                $ur->nro_informe_tec            =   $request->get('nro_informe_tec');
                $ur->fecha_informe_tec          =   $request->get('fecha_informe_tec');
                $ur->fecha_derivacion           =   $request->get('fecha_derivacion');
                $ur->codEstadoProceso           =   2; #Corresponde al estado aprobado
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();

                #3. Genero un nuevo registro del expediente en el área de UPFP
                try 
                {
                    $upfp                       =   new ExpedienteUpfp;
                    $upfp->codExpediente        =   $expediente->id;
                    $upfp->codEstadoProceso     =   1; #Corresponde al estado En proceso
                    $upfp->created_auth         =   Auth::user()->id;
                    $upfp->updated_auth         =   Auth::user()->id;
                    $upfp->save();

                    #4. Retorno al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  '',
                        'mensaje'   =>  'La información se procesó de manera exitosa.'
                    ]);
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
           } 
           catch (Exception $e) 
           {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
           }
       } 
       catch (Exception $e) 
       {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
       }
    }

    #9. Muestro la información que se deriva al área de UPFP
    public function indexUpfp()
    {
        return view('proceso-prp.upfp.index');
    }

    #10. Muestro los documentos derivados de la UR a la UPFP
    public function showPrpUpfpPendiente()
    {
        #1. Obtengo los expedientes generados
        $estado         =   1;
        $expediente     =   ExpedienteUpfp::getConsolidado($estado);
        return view('proceso-prp.upfp.data', compact('expediente'));
    }
    public function showPrpUpfpAprobado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   2;
        $expediente     =   ExpedienteUpfp::getConsolidado($estado);
        return view('proceso-prp.upfp.data-aprobado', compact('expediente'));
    }
    public function showPrpUpfpObservado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   4;
        $expediente     =   ExpedienteUpfp::getConsolidado($estado);
        return view('proceso-prp.upfp.data-observado', compact('expediente'));
    }
    public function showPrpUpfpArchivado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   3;
        $expediente     =   ExpedienteUpfp::getConsolidado($estado);
        return view('proceso-prp.upfp.data-archivado', compact('expediente'));
    }

    #11. Muestro el formulario para la admisión de un expediente
    public function formAdmiteExpedienteUpfp($id)
    {
        #1. Obtengo los datos a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $areas              =   Area::getData();
        $ur                 =   ExpedienteUr::getData($id);
        $upfp               =   ExpedienteUpfp::getData($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $area               =   6;
        $personal           =   Usuario::getArea($area);
        #2. retorno al formulario
        return view('proceso-prp.upfp.admision', compact('expediente', 'upfp', 'personal'));
    }

    #12. Guardo la información de admisión
    public function admiteExpedienteUpfp(Request $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información del expediente de UPFP
            try 
            {
                $upfp                               =   ExpedienteUpfp::getData($expediente->id);
                $upfp->fechaRecepcion               =   $request->get('fecha');
                $upfp->codResponsableAsignado       =   $request->get('personal');
                $upfp->updated_auth                 =   Auth::user()->id;
                $upfp->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
                ]);
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    } 

    #13. Muestro el formulario para generar un nuevo documento
    public function editInformeUpfp($id)
    {
        #1. Obtengo las variables a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $postulante         =   Postulante::findOrFail($expediente->codPostulante);
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        $area               =   6;
        $upfp               =   ExpedienteUpfp::getData($id);
        #2. Obtengo la información que mostrare en los combos
        $personal           =   Usuario::getArea($area);

        #3. Retorno al formulario de registro
        return view('proceso-prp.upfp.edit', compact('expediente', 'postulante', 'entidad', 'upfp', 'personal'));
    }
    
    #14. Guardamos la información 
    public function updateInformeUpfp(ExpedientePrpUpfpFormRequest $request, $id)
    {
        #1. Actualizamos la información del expediente
        try 
        {
            $upfp                                   =   ExpedienteUpfp::getData($id);
            $upfp->fechaRecepcion                   =   $request->get('fecha_recepcion');
            $upfp->cod_responsable_eva_campo        =   $request->get('responsable_eval_campo');
            $upfp->fecha_eva_campo                  =   $request->get('fecha_eval_campo');
            $upfp->cod_responsable_analisis_suelo   =   $request->get('responsable_eval_suelo');
            $upfp->fecha_analisis_suelo             =   $request->get('fecha_eval_suelo');
            $upfp->cod_responsable_analisis_agua    =   $request->get('responsable_eval_agua');
            $upfp->fecha_analisis_agua              =   $request->get('fecha_eval_agua');
            $upfp->cod_responsable_balance_hidrico  =   $request->get('responsable_balance_hidrico');
            $upfp->fecha_balance_hidrico            =   $request->get('fecha_eval_balance_hidrico');
            $upfp->cod_responsable_form             =   $request->get('responsable_informe');
            $upfp->nro_informe_form                 =   $request->get('nro_informe');
            $upfp->fecha_informe_form               =   $request->get('fecha_informe');
            $upfp->HabilitaFormulacion              =   $request->get('habilita_formulacion');
            $upfp->updated_auth                     =   Auth::user()->id;
            $upfp->update();

            #2. Retorno a la vista de edicion
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $id,
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #13. Mostramos el formulario para la derivacion de expedientes
    public function informeExpedienteUpfp($id)
    {
        #1. obtengo las variables a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $areas              =   Area::getData();
        $ur                 =   ExpedienteUr::getData($id);
        $upfp               =   ExpedienteUpfp::getData($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $area               =   6;
        $personal           =   Usuario::getArea($area);
        #2. Retorno al formulario para procesar el expediente
        return view('proceso-prp.upfp.send', compact('expediente', 'areas', 'ur', 'upfp', 'estado', 'personal'));
    }

    #14. Procesamos la derivacion del informe
    public function procesaExpedienteUpfp(DerivaExpedienteUpfpFormRequest $request, $id)
    {
        #1. Actualizo los datos del expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codArea        =   $request->get('area');
            $expediente->codEstado      =   2; 
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();
            
            #2. Actualizo los datos del informe de UPFP
            try 
            {
                $upfp                           =   ExpedienteUpfp::getData($expediente->id);
                $upfp->cod_responsable_form     =   $request->get('especialista');
                $upfp->nro_informe_form         =   $request->get('nro_informe_form');
                $upfp->fecha_informe_form       =   $request->get('fecha_informe_form');
                $upfp->cod_responsable_tec      =   $request->get('especialista');
                $upfp->nro_informe_tec          =   $request->get('nro_informe_tec');
                $upfp->fecha_informe_tec        =   $request->get('fecha_informe_tec');
                $upfp->fecha_derivacion         =   $request->get('fecha_derivacion');
                $upfp->codEstadoProceso         =   2; #EstadoAprobado
                $upfp->updated_auth             =   Auth::user()->id;
                $upfp->update();

                #3. Genero el expediente en la Unidad de negocios
                try 
                {
                    $un                     =   new ExpedienteUn;
                    $un->codExpediente      =   $expediente->id;
                    $un->codEstadoProceso   =   1;
                    $un->created_auth       =   Auth::user()->id;
                    $un->updated_auth       =   Auth::user()->id;
                    $un->save();

                    #4. Retornamos al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  '',
                        'mensaje'   =>  'La información se procesó de manera exitosa.'
                    ]);
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #15. Muestro el formulario para la observacion de expedientes
    public function observaExpedienteUpfp($id)
    {
        #1. Obtengo la información del expediente
        $expediente         =   Expediente::findOrFail($id);
        #2. Obtengo las variables que iran en los combos
        $area               =   6;
        $personal           =   Usuario::getArea($area);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $upfp               =   ExpedienteUpfp::getData($id);
        #3. Retorno a la vista
        return view('proceso-prp.upfp.observa', compact('expediente', 'personal', 'estado', 'upfp'));
    }

    #16. Realizo el procesamiento de la observacion
    public function ProcesaObservacionPrpUpfp(ExpedientePrpUpfpObservaFormRequest $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   4; #Estado Observado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información de la observacion
            try 
            {
                $upfp                       =   ExpedienteUpfp::getData($id);
                $upfp->cod_responsable_tec  =   $request->get('responsable');
                $upfp->nro_informe_observa  =   $request->get('nro_informe');
                $upfp->fecha_informe_observa=   $request->get('fecha_informe');
                $upfp->codEstadoProceso     =   4; #Estado Observado
                $upfp->updated_auth         =   Auth::user()->id;
                $upfp->update();

                #3. retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
                ]);
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }    


    #17. Muestro el formulario para archivar el expediente de UPFP
    public function formArchivaExpedienteUpfp($id)
    {
        #1. Obtengo la información del expediente
        $expediente         =   Expediente::findOrFail($id);
        #2. Obtengo las variables que iran en los combos
        $area               =   6;
        $personal           =   Usuario::getArea($area);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $upfp               =   ExpedienteUpfp::getData($id);
        #3. Retorno a la vista
        return view('proceso-prp.upfp.archiva', compact('expediente', 'personal', 'estado', 'upfp'));
    }
    
    #18. Muestro la información que se deriva al área de UPFP
    public function indexUn()
    {
        return view('proceso-prp.un.index');
    }
    #19. Muestro los documentos derivados de la UPFP a la UN
    public function showPrpUnPendiente()
    {
        #1. Obtengo los expedientes generados
        $estado         =   1;
        $expediente     =   ExpedienteUn::getDataExpediente($estado);
        return view('proceso-prp.un.data', compact('expediente'));
    }
    public function showPrpUnAprobado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   2;
        $expediente     =   ExpedienteUn::getDataExpediente($estado);
        return view('proceso-prp.un.data-aprobado', compact('expediente'));
    }
    public function showPrpUnObservado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   4;
        $expediente     =   ExpedienteUn::getDataExpediente($estado);
        return view('proceso-prp.un.data-observado', compact('expediente'));
    }
    public function showPrpUnArchivado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   3;
        $expediente     =   ExpedienteUn::getDataExpediente($estado);
        return view('proceso-prp.un.data-archivado', compact('expediente'));
    }

    #19. Mostramos un formulario para la recepcion de expediente de Negocios
    public function createExpedienteUn($id)
    {
        $expediente         =   Expediente::findOrFail($id);
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        $postulante         =   Postulante::findOrfail($expediente->codPostulante);
        $un                 =   ExpedienteUn::getData($expediente->id);
        return view('proceso-prp.un.create', compact('expediente', 'personal', 'postulante', 'un'));
    }
    #20. Guardamos la informacion del expediente de Negocios
    public function storeExpedienteUn(RecepcionaExpedienteUnFormRequest $request)
    {
        try 
        {
            $un                     =   ExpedienteUn::findOrFail($request->codigo);
            $un->fechaRecepcion     =   $request->get('fecha_recepcion');
            $un->cod_responsable    =   $request->get('responsable');
            $un->updated_auth       =   Auth::user()->id;
            $un->update();

            #4. Retornamos al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);

        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }
    #21. Mostramos el formulario para la derivacion de expedientes
    public function informeExpedienteUn($id)
    {
        #1. obtengo las variables a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $proyecto           =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
        $areas              =   Area::getData();
        $ur                 =   ExpedienteUr::getData($id);
        $upfp               =   ExpedienteUpfp::getData($id);
        $un                 =   ExpedienteUn::getData($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        #2. Retorno al formulario para procesar el expediente
        return view('proceso-prp.un.send', compact('expediente', 'areas', 'ur', 'upfp', 'un', 'estado', 'personal', 'proyecto'));
    }
    #22. Realizamos la derivación del expediente de la UN a UAJ
    public function procesaExpedienteUn(DerivaExpedienteUnFormRequest $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codArea        =   3; #UAJ
            $expediente->codEstado      =   2; #Estado aprobado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información del Proyecto
            try 
            {
                $proyecto                       =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
                $proyecto->inversion_total      =   $request->get('aporte_pcc')+$request->get('aporte_entidad');
                $proyecto->inversion_pcc        =   $request->get('aporte_pcc');
                $proyecto->inversion_entidad   =   $request->get('aporte_entidad');
                $proyecto->updated_auth         =   Auth::user()->id;
                $proyecto->update();


                #3. Actualizo la información del expediente de la UN
                try 
                {
                    $un                     =   ExpedienteUn::getData($id);
                    $un->cod_responsable    =   $request->get('especialista');
                    $un->nro_informe        =   $request->get('nro_informe');
                    $un->fecha_informe      =   $request->get('fecha_informe');
                    $un->nro_memo           =   $request->get('nro_memo');
                    $un->fecha_memo         =   $request->get('fecha_informe');
                    $un->fecha_derivacion   =   $request->get('fecha_derivacion');
                    $un->codEstadoProceso   =   2;#Estado aprobado
                    $un->updated_auth       =   Auth::user()->id;
                    $un->update();

                    #3. Generamos un nuevo registro en la tabla de expediente UAJ
                    try 
                    {
                        $uaj                    =   new ExpedienteUaj;
                        $uaj->codExpediente     =   $un->codExpediente;
                        $uaj->codEstadoProceso  =   1;
                        $uaj->created_auth      =   Auth::user()->id;
                        $uaj->updated_auth      =   Auth::user()->id;
                        $uaj->save();

                        #4. Retornamos al menu principal
                        return response()->json([
                            'estado'    =>  '1',
                            'dato'      =>  '',
                            'mensaje'   =>  'La información se procesó de manera exitosa.'
                        ]);
                    } 
                    catch (Exception $e) 
                    {
                        return response()->json([
                            'estado'    =>  '2',
                            'dato'      =>  $e->getMessage(),
                            'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                        ]);
                    }
                } 
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #23. Observa Expediente
    public function formArchivaExpedienteUn($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $un                 =   ExpedienteUn::getData($id);
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        #2. retornamos al formulario
        return view('proceso-prp.un.archiva', compact('expediente', 'un', 'personal'));
    }

    #24. 
    public function archivaExpedienteUn(Request $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   3; #Estado aprobado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizamos la info de Negocios
            try 
            {
                $un                     =   ExpedienteUn::getData($id);
                $un->cod_responsable    =   $request->get('responsable');
                $un->nro_carta_archivo  =   $request->get('nro_carta');
                $un->fecha_carta_archivo=   $request->get('fecha_carta');
                $un->codEstadoProceso   =   3;
                $un->updated_auth       =   Auth::user()->id;
                $un->update();

                #4. Retornamos al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
                ]);
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #25. Muestro la información que se deriva al área de UAJ
    public function indexUaj()
    {
        return view('proceso-prp.uaj.index');
    }
    #24. Muestro los documentos derivados de la UN a la UAJ
    public function showPrpUajPendiente()
    {
        #1. Obtengo los expedientes generados
        $estado         =   1;
        $expediente     =   ExpedienteUaj::getConsolidado($estado);
        return view('proceso-prp.uaj.data', compact('expediente'));
    }
    public function showPrpUajAprobado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   2;
        $expediente     =   ExpedienteUaj::getConsolidado($estado);
        return view('proceso-prp.uaj.data-aprobado', compact('expediente'));
    }
    public function showPrpUajObservado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   3;
        $expediente     =   ExpedienteUaj::getConsolidado($estado);
        return view('proceso-prp.uaj.data-observado', compact('expediente'));
    }
    public function showPrpUajArchivado()
    {
        #1. Obtengo los expedientes generados
        $estado         =   3;
        $expediente     =   ExpedienteUaj::getConsolidado($estado);
        return view('proceso-prp.uaj.data-archivado', compact('expediente'));
    }
    #25. Mostramos un formulario para la recepcion de expediente de Uaj
    public function createExpedienteUaj($id)
    {
        $expediente         =   Expediente::findOrFail($id);
        $area               =   3;
        $personal           =   Usuario::getArea($area);
        $postulante         =   Postulante::findOrfail($expediente->codPostulante);
        $uaj                =   ExpedienteUaj::getData($expediente->id);
        return view('proceso-prp.uaj.create', compact('expediente', 'personal', 'postulante', 'uaj'));
    }
    #26. Guardo los datos de recepcion del expediente
    public function storeExpedienteUaj(RecepcionaExpedienteUajFormRequest $request)
    {
        try 
        {
            $uaj                    =   ExpedienteUaj::findOrFail($request->codigo);
            $uaj->fechaRecepcion    =   $request->get('fecha_recepcion');
            $uaj->codResponsable    =   $request->get('responsable');
            $uaj->updated_auth      =   Auth::user()->id;
            $uaj->update();

            #4. Retornamos al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);

        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }
    #27. Muestro el formulario para realizar la evaluacion de los expedientes
    public function informeExpedienteUaj($id)
    {
        #1. obtengo las variables a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $uaj                =   ExpedienteUaj::getData($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $area               =   3;
        $personal           =   Usuario::getData();
        $areas              =   Area::getData();

        #2. Retorno al formulario para procesar el expediente
        return view('proceso-prp.uaj.califica', compact('expediente', 'areas', 'uaj', 'estado', 'personal'));
    }
    #28. Procesa el formulario para evaluar el expediente
    public function procesaExpedienteUaj(DerivaExpedienteUajFormRequest $request, $id)
    {
        try 
        {
            $uaj                            =   ExpedienteUaj::getData($id);
            $uaj->nro_informe               =   $request->get('nro_informe');
            $uaj->fecha_informe             =   $request->get('fecha_informe');
            $uaj->nro_memo                  =   $request->get('nro_oficio');
            $uaj->fecha_memo                =   $request->get('fecha_oficio');
            $uaj->opinion_favorable         =   1;
            $uaj->updated_auth              =   Auth::user()->id;
            $uaj->update();

            #2. retorno al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    public function formObservaExpedienteUaj($id)
    {
        #1. obtengo las variables a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $uaj                =   ExpedienteUaj::getData($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $area               =   3;
        $personal           =   Usuario::getData();
        $areas              =   Area::getData();

        #2. retorno al formulaio
        return view('proceso-prp.uaj.observa', compact('expediente', 'uaj', 'personal'));
    }

    public function observaExpedienteUaj(Request $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   4; #Estado aprobado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            try 
            {
                $uaj                        =   ExpedienteUaj::getData($id);
                $uaj->codResponsable        =   $request->get('responsable');
                $uaj->nro_carta_archivo     =   $request->get('nro_informe');
                $uaj->fecha_carta_archivo   =   $request->get('fecha_informe');
                $uaj->codEstadoProceso      =   4;
                $uaj->updated_auth          =   Auth::user()->id;
                $uaj->update();

                #4. Retornamos al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
                ]);
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    public function formDerivaExpedienteUaj($id)
    {
        #1. obtengo las variables a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $uaj                =   ExpedienteUaj::getData($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $area               =   3;
        $personal           =   Usuario::getData();
        $areas              =   Area::getData();

        #2. Retorno al menu
        return view('proceso-prp.uaj.deriva', compact('expediente', 'uaj', 'personal'));
    }

    #
    public function derivaExpedienteUaj(Request $request, $id)
    {
        try 
        {
            $uaj                            =   ExpedienteUaj::getData($id);
            $uaj->fecha_derivacion          =   $request->get('fecha_derivacion');
            $uaj->fecha_recepcion_minagri   =   $request->get('fecha_derivacion');
            $uaj->codEstadoProceso          =   2; #Estado aprobado
            $uaj->updated_auth              =   Auth::user()->id;
            $uaj->update();

            #2. Actualizo el estado del expediente
            try 
            {
                $expediente                 =   Expediente::findOrFail($id);
                $expediente->codEstado      =   2; #Estado aprobado
                $expediente->updated_auth   =   Auth::user()->id;
                $expediente->update();

                #3. Retornamos al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
                ]);
            } 
            catch (Exception $e) 
            {
                return response()->json([
                    'estado'    =>  '2',
                    'dato'      =>  $e->getMessage(),
                    'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                ]);
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }































}
