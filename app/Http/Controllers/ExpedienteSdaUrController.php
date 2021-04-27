<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Postulante;
use App\PostulanteEstado;
use App\Expediente;
use App\ExpedienteSdaUr;
use App\ExpedienteSdaUn;
use App\Usuario;
use App\Oficina;
use App\TablaValor;
use DB;
use Auth;


class ExpedienteSdaUrController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.admision';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3.
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. 
    public function create()
    {
        #1. Obtengo las variables requeridas
        $entidades          =   Postulante::getSdaPendiente();
        $oficinas           =   Oficina::getData();
        $personal           =   Usuario::getData();
        
        #2. Retorno al formulario
        return view($this->path.'.create', compact('entidades', 'oficinas', 'personal'));
    }

    #5.
    public function store(Request $request) 
    {
        #1. Guardamos la información de Expediente
        try 
        {
            $expediente                     =   new Expediente;
            $expediente->codPostulante      =   $request->get('postulante');
            $expediente->nroCut             =   $request->get('nro_cut');
            $expediente->fechaCut           =   $request->get('fecha_recepcion');
            $expediente->nroExpediente      =   $request->get('nro_expediente');
            $expediente->fechaExpediente    =   $request->get('fecha_expediente');
            $expediente->codOficina         =   $request->get('oficina');
            $expediente->codPersonalAsignado=   $request->get('especialista');
            $expediente->codArea            =   8;
            $expediente->codEstado          =   1;#Pendiente
            $expediente->created_auth       =   Auth::user()->id;
            $expediente->updated_auth       =   Auth::user()->id;
            $expediente->save();

            #2. Genero un registro para el expediente UR
            try 
            {
                $ur                             =   new ExpedienteSdaUr;
                $ur->codExpediente              =   $expediente->id;
                $ur->fecha_recepcion            =   $request->get('fecha_recepcion');
                $ur->cod_responsable_evaluacion =   $request->get('especialista');
                $ur->cod_estado_proceso         =   1;#Pendiente
                $ur->created_auth               =   Auth::user()->id;
                $ur->updated_auth               =   Auth::user()->id;
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

    #6. 
    public function edit($id)
    {
        #1. Obtengo las variables solicitadas
        $expediente         =   Expediente::findOrFail($id);
        $ur                 =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
        $entidades          =   Postulante::getDataSda();
        $oficinas           =   Oficina::getData();
        $personal           =   Usuario::getData();

        #2. Retorno al formulario
        return view($this->path.'.edit', compact('expediente', 'ur', 'entidades', 'oficinas', 'personal'));
    }

    #7. 
    public function update(Request $request, $id)
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

            #2. Actualizo el expediente de la UR
            try 
            {
                $ur                             =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
                $ur->fecha_recepcion            =   $request->get('fecha_recepcion');
                $ur->cod_responsable_evaluacion =   $request->get('especialista');
                $ur->nro_informe                =   $request->get('nro_informe');
                $ur->fecha_informe              =   $request->get('fecha_informe');
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();

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

    #8. Muestro el formulario para archivar expedientes
    public function formArchivo($id)
    {
        #1. Obtengo las variables solicitadas
        $expediente         =   Expediente::findOrFail($id);
        $ur                 =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
        $personal           =   Usuario::getDataOficina($expediente->codOficina);

        #2. Retorno a la vista principal
        return view($this->path.'.archiva', compact('expediente', 'ur', 'personal'));
    }

    #9. Procedo a realizar el archivamiento del expediente
    public function procesaArchivo(Request $request, $id)
    {
        #1. Actualizo el expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   3;#Proceso desaprobado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo el expediente de la UR
            try 
            {
                $ur                             =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
                $ur->observacion                =   $request->get('justificacion');
                $ur->nro_carta_archivamiento    =   $request->get('nro_carta');
                $ur->fecha_carta_archivamiento  =   $request->get('fecha_carta');
                $ur->fecha_derivacion           =   $request->get('fecha_carta');
                $ur->cod_estado_proceso         =   3;#Proceso desaprobado
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();

                #3. Actualizamos el estado situacional
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

    #10. Muestro un formulario para observar expedientes
    public function formObserva($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $personal           =   Usuario::getDataOficina($expediente->codOficina);
        $ur                 =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
        #2. Retorno al formulario
        return view($this->path.'.observa', compact('expediente', 'personal', 'ur'));
    }

    #11. Realizo la observación de los expediente
    public function procesaObservacion(Request $request, $id)
    {
        #1. Actualizo el expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   4;#Proceso observado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información de la observación
            try 
            {
                $ur                             =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
                $ur->nro_carta_observacion      =   $request->get('nro_carta');
                $ur->fecha_carta_observacion    =   $request->get('fecha_carta');
                $ur->observacion                =   $request->get('observacion');
                $ur->fecha_derivacion           =   $request->get('fecha_derivacion');
                $ur->cod_estado_proceso         =   4;#Proceso observado
                $ur->updated_auth               =   Auth::user()->id;
                $ur->update();
                
                #3. Actualizo el estado situacional del proyecto
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

    #12. Muestro un formulario para levantar observaciones
    public function formSubsanaObservacion($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $estado             =   TablaValor::getDetalleTabla('EstadoProceso');
        $personal           =   Usuario::getDataOficina($expediente->codOficina);
        $ur                 =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();

        #2. Retorno al formulario
        return view($this->path.'.subsana', compact('expediente', 'personal', 'ur', 'estado'));
    }

    #13. Realizo el levantamiento de observaciones
    public function subsanaObservacion(Request $request, $id)
    {
        #1. Actualizamos el expedientes
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   1;#Vuelve a estado Pendiente
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizamos y levantamos las observaciones
            try 
            {
                $ur                                     =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
                $ur->fecha_levanta_observacion          =   $request->get('fecha_respuesta');
                $ur->fecha_recibe_expediente_observado  =   $request->get('fecha_recepcion');
                $ur->cod_estado_proceso                 =   1;
                $ur->updated_auth                       =   Auth::user()->id;
                $ur->update();

                #3. Actualizamos el estado situacional
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

    #14. Muestro el formulario de derivacion de expdiente
    public function formDeriva($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $personal           =   Usuario::getDataOficina($expediente->codOficina);
        $ur                 =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
        #2. Retorno al formulario
        return view($this->path.'.deriva', compact('expediente', 'personal', 'ur'));
    }

    #15. Realizamos la derivación del expediente
    public function procesaDerivacion(Request $request, $id)
    {
        #1. Actualizo el expediente
        try 
        {
            $expediente              =   Expediente::findOrFail($id);
            $expediente->codArea     =   5; #Area correspondiente a UN
            $expediente->codEstado   =   2; #Corresponde al estado aprobado
            $expediente->updated_auth=   Auth::user()->id;
            $expediente->update();

            #2. Actualizamos la información del expediente en la UR
            try 
            {
                $ur                         =   ExpedienteSdaUr::where('codExpediente', $expediente->id)->first();
                $ur->nro_carta_aprobacion   =   $request->get('nro_carta');
                $ur->fecha_carta_aprobacion =   $request->get('fecha_carta');
                $ur->fecha_derivacion       =   $request->get('fecha_derivacion');
                $ur->cod_estado_proceso     =   2;#Corresponde al estado aprobado
                $ur->updated_auth           =   Auth::user()->id;
                $ur->update();

                #3. Genero un nuevo registro en el expediente de la UN
                try 
                {
                    $un                     =   new ExpedienteSdaUn;
                    $un->codExpediente      =   $expediente->id;
                    $un->fecha_recepcion    =   $request->get('fecha_derivacion');
                    $un->cod_estado_proceso =   1;#Corresponde al estado en proceso
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

    #16. Muestro los expedientes en proceso
    public function showDataPendiente()
    {
        #1. Obtengo la información solicitada
        $estado     =   1;
        $data       =   ExpedienteSdaUr::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-pendiente', compact('data'));
    }

    #17. Muestro los expedientes aprobados
    public function showDataAprobado()
    {
        #1. Obtengo la información solicitada
        $estado     =   2;
        $data       =   ExpedienteSdaUr::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-aprobado', compact('data'));
    }

    #18. Muestro los expedientes observados
    public function showDataObservado()
    {
        #1. Obtengo la información solicitada
        $estado     =   4;
        $data       =   ExpedienteSdaUr::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-observado', compact('data'));
    }

    #19. Muestro los expedientes archivados
    public function showDataArchivado()
    {
        #1. Obtengo la información solicitada
        $estado     =   3;
        $data       =   ExpedienteSdaUr::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-archivado', compact('data'));
    }
}
