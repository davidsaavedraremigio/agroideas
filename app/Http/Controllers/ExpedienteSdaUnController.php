<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Postulante;
use App\PostulanteEstado;
use App\Proyecto;
use App\Expediente;
use App\ExpedienteSdaUr;
use App\ExpedienteSdaUn;
use App\ExpedienteSdaUaj;
use App\Usuario;
use App\Oficina;
use App\TablaValor;
use DB;
use Auth;

class ExpedienteSdaUnController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.evaluacion';

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
    public function create($id)
    {
        #1. Obtengo los datos a utilizar
        $expediente         =   Expediente::findOrFail($id);
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        $un                 =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();        
        #2. Retorno al formulario
        return view($this->path.'.create', compact('expediente', 'area', 'personal', 'un'));
    }   

    #5. 
    public function update(Request $request, $id)
    {
        #1. Actualizo la información del expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Realizo el proceso de admisión del expediente
            try 
            {
                $un                     =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();
                $un->fecha_recepcion    =   $request->get('fecha_recepcion');
                $un->cod_responsable    =   $request->get('responsable');
                $un->updated_auth       =   Auth::user()->id;
                $un->update();

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

    #6. 
    public function formObserva($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        $un                 =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();  
        #2. Retorno al formulario
        return view($this->path.'.observa', compact('expediente', 'area', 'personal', 'un'));
    }

    #7. 
    public function procesaObservacion(Request $request, $id)
    {
        #1. Actualizamos el estado del expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   4;#Estado Observado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo el expediente de la UN
            try 
            {
                $un                     =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();
                $un->nro_informe        =   $request->get('nro_informe');
                $un->fecha_informe      =   $request->get('fecha_informe');
                $un->nro_memo_observa   =   $request->get('nro_memo');
                $un->fecha_memo_observa =   $request->get('fecha_memo');
                $un->fecha_derivacion   =   $request->get('fecha_derivacion');
                $un->cod_estado_proceso =   4;#Estado Observado
                $un->updated_auth       =   Auth::user()->id;
                $un->update();

                #3. Actualizamos el estado situacional del Expediente
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

    #8. 
    public function formArchivo($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        $un                 =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();  
        #2. Retorno al formulario
        return view($this->path.'.archiva', compact('expediente', 'area', 'personal', 'un')); 
    }

    #9. 
    public function procesaArchivo(Request $request, $id)
    {
        #1. Actualizo al expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codEstado      =   3;#Estado archivado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Procedo a realizar el archivamiento del documento
            try 
            {
                $un                         =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();
                $un->nro_informe            =   $request->get('nro_informe');
                $un->fecha_informe          =   $request->get('fecha_informe');
                $un->nro_memo_no_favorable  =   $request->get('nro_memo');
                $un->fecha_memo_no_favorable=   $request->get('fecha_memo');
                $un->fecha_derivacion       =   $request->get('fecha_derivacion');
                $un->cod_estado_proceso     =   3;#Estado archivado 
                $un->updated_auth           =   Auth::user()->id;
                $un->update();

                #3. Actualizo el estado situacional del expediente
                try 
                {
                    $situacion                          =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                    $situacion->codEstadoSituacional    =   11; #archivado en evaluacion documentaria
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

    #10. 
    public function formDeriva($id)
    {
        #1. Obtengo las variables requeridas
        $expediente         =   Expediente::findOrFail($id);
        $area               =   5;
        $personal           =   Usuario::getArea($area);
        $un                 =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();  
        $proyecto           =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
        #2. Retorno al formulario
        return view($this->path.'.deriva', compact('expediente', 'area', 'personal', 'un', 'proyecto')); 
    }

    #11. 
    public function procesaDerivacion(Request $request, $id)
    {
        #1. Actualizo los datos del Expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->codArea        =   3;
            $expediente->codEstado      =   1;#Aprobado
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información  del expediente
            try 
            {
                $un                         =   ExpedienteSdaUn::where('codExpediente', $expediente->id)->first();
                $un->nro_informe            =   $request->get('nro_informe');
                $un->fecha_informe          =   $request->get('fecha_informe');
                $un->nro_memo_favorable     =   $request->get('nro_memo');
                $un->fecha_memo_favorable   =   $request->get('fecha_memo');
                $un->fecha_derivacion       =   $request->get('fecha_derivacion');
                $un->cod_estado_proceso     =   2;#Aprobado
                $un->updated_auth           =   Auth::user()->id;
                $un->update();

                #3. Actualizo la situacion del Proyecto
                try 
                {
                    $situacion                          =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                    $situacion->codEstadoSituacional    =   12;#Con opinión favorable
                    $situacion->updated_auth            =   Auth::user()->id;
                    $situacion->update();

                    #4. Actualizo la información de Proyecto
                    try 
                    {
                        $proyecto                   =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
                        $proyecto->inversion_total  =   $request->get('aporte_pcc')+$request->get('aporte_entidad');
                        $proyecto->inversion_pcc    =   $request->get('aporte_pcc');
                        $proyecto->inversion_entidad=   $request->get('aporte_entidad');
                        $proyecto->updated_auth     =   Auth::user()->id;
                        $proyecto->update();
                        
                        #5. Genero un registro de expediente en UAJ
                        try 
                        {
                            $uaj                    =   new ExpedienteSdaUaj;
                            $uaj->codExpediente     =   $expediente->id;
                            $uaj->fecha_recepcion   =   $request->get('fecha_derivacion');
                            $uaj->cod_estado_proceso=   1; #En proceso
                            $uaj->created_auth      =   Auth::user()->id;
                            $uaj->updated_auth      =   Auth::user()->id;
                            $uaj->save();

                            #5. Retorno al menu principal
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #12. Muestro los expedientes en proceso
    public function showDataPendiente()
    {
        #1. Obtengo la información solicitada
        $estado     =   1;
        $data       =   ExpedienteSdaUn::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-pendiente', compact('data'));
    }

    #13. Muestro los expedientes aprobados
    public function showDataAprobado()
    {
        #1. Obtengo la información solicitada
        $estado     =   2;
        $data       =   ExpedienteSdaUn::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-aprobado', compact('data'));
    }

    #14. Muestro los expedientes observados
    public function showDataObservado()
    {
        #1. Obtengo la información solicitada
        $estado     =   4;
        $data       =   ExpedienteSdaUn::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-observado', compact('data'));
    }

    #15. Muestro los expedientes archivados
    public function showDataArchivado()
    {
        #1. Obtengo la información solicitada
        $estado     =   3;
        $data       =   ExpedienteSdaUn::getDataExpediente($estado);
        #2. retorno al menu principal
        return view($this->path.'.data-archivado', compact('data'));
    }
}
