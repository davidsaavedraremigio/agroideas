<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ExpedienteSdaFormRequest;
use App\Entidad;
use App\Postulante;
use App\Expediente;
use App\TablaValor;
use App\Area;
use App\Oficina;
use App\Staff;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class ExpedienteSdaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-pdn.admision';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Muestro la pantalla principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para nuesvos registros
    public function create()
    {
        #1. Obtengo los datos de registro
        $incentivo      =   Postulante::getDataSda();
        $area           =   Area::getData();
        $oficina        =   Oficina::getData();
        $personal       =   Staff::getData();
        $situacion      =   TablaValor::getDetalleTabla('EstadoSituacional');
        $tipo_entidad   =   TablaValor::getDetalleTabla('TipoEntidad');
        $tipo_incentivo =   TablaValor::getDetalleTabla('TipoIncentivo');

        #2. Retorno la información al formulario
        return view($this->path.'.create', compact('incentivo', 'area', 'oficina', 'personal', 'situacion', 'tipo_entidad', 'tipo_incentivo'));
    }

    #5. Guardo la información registrada
    public function store(ExpedienteSdaFormRequest $request)
    {
        #1. Guardo la información de la organización
        try 
        {
            $entidad        =   Entidad::updateOrCreate(['nroDocumento' => $request->get('ruc')],[
                'codTipoDocumento'      =>  1,
                'codTipoEntidad'        =>  $request->get('tipo_entidad'),
                'nombre'                =>  $request->get('razon_social'),
                'ubigeo'                =>  $request->get('ubigeo'),
                'direccion'             =>  $request->get('direccion'),
                'estadoContribuyente'   =>  $request->get('estado_contribuyente'),
                'fechaRRPP'             =>  $request->get('fecha_rrpp'),
                'estado'                =>  1,
                'created_auth'          =>  Auth::user()->id,
                'updated_auth'          =>  Auth::user()->id
            ]);

            #2. Registramos al postulante
            try 
            {
                $postulante                     =   new Postulante;
                $postulante->codEntidad         =   $entidad->id;
                $postulante->codTipoIncentivo   =   $request->get('tipo_iniciativa');
                $postulante->codConvocatoria    =   \date('Y');
                $postulante->estado             =   1;
                $postulante->created_auth       =   Auth::user()->id;
                $postulante->updated_auth       =   Auth::user()->id;
                $postulante->save();

                #3. Genero un nuevo expediente
                try 
                {
                    $expediente                         =   new Expediente;
                    $expediente->codPostulante          =   $postulante->id;
                    $expediente->nroCut                 =   $request->get('nro_cut');
                    $expediente->fechaCut               =   $request->get('fecha_cut');
                    $expediente->nroExpediente          =   $request->get('nro_expediente');
                    $expediente->fechaExpediente        =   $request->get('fecha_expediente');
                    $expediente->codOficina             =   $request->get('oficina');
                    $expediente->codPersonalAsignado    =   $request->get('personal');
                    $expediente->codArea                =   $request->get('area');
                    $expediente->codEstado              =   $request->get('estado');
                    $expediente->created_auth           =   Auth::user()->id;
                    $expediente->updated_auth           =   Auth::user()->id;
                    $expediente->save();

                    #2. Retorno al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  $expediente->id,
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

    #6. Muestro la información registrada
    public function show()
    {
        #1. Obtengo la información registrada
        $data       =   Expediente::getDataExpedienteSda();
        #2. Retorno a la vista principal
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro el formulario para actualizar la información
    public function edit($id)
    {
        #1. Obtengo la información requerida
        $expediente     =   Expediente::findOrFail($id);
        $incentivo      =   Postulante::getDataSda();
        $area           =   Area::getData();
        $oficina        =   Oficina::getData();
        $personal       =   Staff::getData();
        $situacion      =   TablaValor::getDetalleTabla('EstadoSituacional');
        $tipo_entidad   =   TablaValor::getDetalleTabla('TipoEntidad');
        $tipo_incentivo =   TablaValor::getDetalleTabla('TipoIncentivo');
        $postulante     =   Postulante::findOrFail($expediente->codPostulante);
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        #2. Retorno al formulario de edicion
        return view($this->path.'.edit', compact('expediente', 'incentivo', 'area', 'oficina', 'personal', 'situacion', 'tipo_entidad', 'tipo_incentivo', 'postulante', 'entidad'));
    }

    #8. Realizamos la actualizacion de la información
    public function update(ExpedienteSdaFormRequest $request, $id)
    {
        #1. Actualizo la información del expediente
        try 
        {
            $expediente                         =   Expediente::findOrFail($id);
            $expediente->nroCut                 =   $request->get('nro_cut');
            $expediente->fechaCut               =   $request->get('fecha_cut');
            $expediente->nroExpediente          =   $request->get('nro_expediente');
            $expediente->fechaExpediente        =   $request->get('fecha_expediente');
            $expediente->codOficina             =   $request->get('oficina');
            $expediente->codPersonalAsignado    =   $request->get('personal');
            $expediente->codArea                =   $request->get('area');
            $expediente->codEstado              =   $request->get('estado');
            $expediente->updated_auth           =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información del postulante
            try 
            {
                $postulante                     =   Postulante::findOrFail($expediente->codPostulante);
                $postulante->codTipoIncentivo   =   $request->get('tipo_iniciativa');
                $postulante->updated_auth       =   Auth::user()->id;
                $postulante->update();

                #3. Actualizamos la información de la entidad
                try 
                {
                    $entidad                        =   Entidad::findOrFail($postulante->codEntidad);
                    $entidad->nroDocumento          =   $request->get('ruc');
                    $entidad->codTipoEntidad        =   $request->get('tipo_entidad');
                    $entidad->nombre                =   $request->get('razon_social');
                    $entidad->ubigeo                =   $request->get('ubigeo');
                    $entidad->direccion             =   $request->get('direccion');
                    $entidad->estadoContribuyente   =   $request->get('estado_sunat');
                    $entidad->fechaRRPP             =   $request->get('fecha_rrpp');
                    $entidad->updated_auth          =   Auth::user()->id;
                    $entidad->update();

                    #4. Retornamos al menu principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  $expediente->id,
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
}
