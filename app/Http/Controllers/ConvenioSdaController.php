<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioSdaFormRequest;
use App\Contrato;
use App\Postulante;
use App\PostulanteEstado;
use App\Proyecto;
use App\Entidad;
use App\Expediente;
use App\ExpedienteSdaUaj;
use App\ConsejoDirectivo;
use App\Usuario;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioSdaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.convenio';

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
        #1. Obtengo las variables solicitadas
        $expediente     =   Expediente::findOrFail($id);
        $postulante     =   Postulante::findOrFail($expediente->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $uaj            =   ExpedienteSdaUaj::where('codExpediente', $expediente->id)->first();
        $cd             =   ConsejoDirectivo::findOrFail($uaj->cod_consejo_directivo);
        $area           =   3;
        $personal       =   Usuario::getArea($area);
        #2. Retorno a la vista
        return view($this->path.'.create', compact('postulante', 'proyecto', 'expediente', 'uaj', 'cd', 'entidad', 'personal'));
    }

    #5.
    public function store(ConvenioSdaFormRequest $request)
    {
        #1. Guardamos la informacion de contrato
        try 
        {
            $contrato                   =   new Contrato;
            $contrato->codPostulante    =   $request->get('codigo');
            $contrato->nroContrato      =   $request->get('numero');
            $contrato->fechaFirma       =   $request->get('fecha');
            $contrato->fechaTermino     =   Carbon::parse($request->get('fecha'))->addMonths($request->get('duracion'));
            $contrato->created_auth     =   Auth::user()->id;
            $contrato->updated_auth     =   Auth::user()->id;
            $contrato->save();

            #2. Actualizo la información del expediente
            try 
            {
                $expediente                 =   Expediente::where('codPostulante', $contrato->codPostulante)->first();
                $expediente->updated_auth   =   Auth::user()->id;
                $expediente->update();

                #3. Actualizo la información del informe de UAJ
                try 
                {
                    $uaj                                        =   ExpedienteSdaUaj::where('codExpediente', $expediente->id)->first();
                    $uaj->cod_responsable                       =   $request->get('responsable');
                    $uaj->nro_memo_disponibilidad_presupuestal  =   $request->get('nro_memo');
                    $uaj->fecha_memo_disponibilidad_presupuestal=   $request->get('fecha_memo');
                    $uaj->cod_estado_proceso                    =   2;
                    $uaj->updated_auth                          =   Auth::user()->id;
                    $uaj->update();

                    #4. Actualizo el estado del Incentivo
                    try 
                    {
                        $estado                             =   PostulanteEstado::where('codPostulante', $contrato->codPostulante)->first();
                        $estado->codEstadoSituacional       =   3;
                        $estado->updated_auth               =   Auth::user()->id;
                        $estado->update();

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
    public function showDataPendiente()
    {
        #1. Obtengo la relación de Expedientes aprobados
        $estado     =   2;
        $data       =   ExpedienteSdaUaj::getDataExpediente($estado);
        #2. Retorno a la vista
        return view($this->path.'.data-pendiente', compact('data'));
    }

    #7. 
    public function showDataAprobado()
    {
        #1. Obtengo la relación de convenios generados
        $data       =   Contrato::getDataSda();
        #2. Retorno a la vista
        return view($this->path.'.data-aprobado', compact('data'));
    }


    #8. Muestro el formulario de edicion de estados de convenios
    public function editEstadoContrato($id)
    {
        #1. Obtengo los datos requeridos
        $contrato           =   Contrato::findOrFail($id);
        $postulante         =   Postulante::findOrFail($contrato->codPostulante);
        $estado             =   PostulanteEstado::where('codPostulante', $postulante->id)->first();
        $estados            =   TablaValor::getDetalleTabla('EstadoSituacional');
        #2. Retorno al formulario
        return view($this->path.'.estado', compact('postulante', 'contrato', 'estado', 'estados'));
    }

    #9. Actualizo el estado situacional del Convenio
    public function updateEstadoContrato(Request $request, $id)
    {
        #1. Actualizo la información de Postulante
        try 
        {
            $postulante                 =   Postulante::findOrFail($id);
            $postulante->updated_auth   =   Auth::user()->id;
            $postulante->update();

            #2. Actualizo el estado situacional
            try 
            {
                $estado                         =   PostulanteEstado::where('codPostulante', $postulante->id)->first();
                $estado->codEstadoSituacional   =   $request->get('estado');
                $estado->updated_auth           =   Auth::user()->id;
                $estado->update();

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
}
