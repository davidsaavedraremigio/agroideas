<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ExpedienteProcesoFormRequest;
use App\ExpedienteProceso;
use App\Expediente;
use App\TablaValor;
use App\Area;
use App\Oficina;
use App\Staff;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;


class ExpedienteProcesoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-pdn.proceso';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        #1. Obtengo las variables solicitadas
        $expediente     =   Expediente::findOrFail($id);
        $areas          =   Area::getData();
        $staff          =   Usuario::getData();
        $tipo_doc       =   TablaValor::getDetalleTabla('TipoDocumentoProceso');
        $estado         =   TablaValor::getDetalleTabla('EstadoProceso');

        #2. Retorno al formulario de registro
        return view($this->path.'.create', compact('expediente', 'areas', 'staff', 'tipo_doc', 'estado'));
    }

    #4.
    public function store(ExpedienteProcesoFormRequest $request)
    {
        #1. Procedemos a realizar el registro de los procesos
        try 
        {
            $proceso                                =   new ExpedienteProceso;
            $proceso->codExpediente                 =   $request->get('codigo');
            $proceso->fecha_recepcion               =   $request->get('fecha_asignacion');
            $proceso->cod_responsable_asignado      =   $request->get('responsable_asignado');
            $proceso->cod_tipo_documento            =   $request->get('tipo_documento');
            $proceso->nro_documento                 =   $request->get('nro_documento');
            $proceso->fecha_documento               =   $request->get('fecha_documento');
            $proceso->fecha_derivacion              =   $request->get('fecha_derivacion');
            $proceso->cod_responsable_destinatario  =   $request->get('destinatario');
            $proceso->cod_estado_proceso            =   $request->get('estado_proceso');
            $proceso->comentarios                   =   $request->get('comentarios');
            $proceso->created_auth                  =   Auth::user()->id;
            $proceso->updated_auth                  =   Auth::user()->id;
            $proceso->save();

            #2. Retorno al menu principal (Falta regularizar la actualizacion del area y el especialista en la tabla expedientePostulante)
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

    #5. 
    public function show($id)
    {
        $data       =   ExpedienteProceso::getData($id);
        #2. retorno al menu principal
        return view($this->path.'.data', compact('data'));
    }

    #6. 
    public function edit($id)
    {
        #1. obtengo las variables requeridas
        $proceso        =   ExpedienteProceso::findOrFail($id);
        $areas          =   Area::getData();
        $staff          =   Usuario::getData();
        $tipo_doc       =   TablaValor::getDetalleTabla('TipoDocumentoProceso');
        $estado         =   TablaValor::getDetalleTabla('EstadoProceso');

        #2. Retorno al formulario
        return view($this->path.'.edit', compact('proceso', 'areas', 'staff', 'tipo_doc', 'estado'));
    }

    #7.
    public function update(ExpedienteProcesoFormRequest $request, $id)
    {
        try 
        {
            $proceso                                =   ExpedienteProceso::findOrFail($id);
            $proceso->fecha_recepcion               =   $request->get('fecha_asignacion');
            $proceso->cod_responsable_asignado      =   $request->get('responsable_asignado');
            $proceso->cod_tipo_documento            =   $request->get('tipo_documento');
            $proceso->nro_documento                 =   $request->get('nro_documento');
            $proceso->fecha_documento               =   $request->get('fecha_documento');
            $proceso->fecha_derivacion              =   $request->get('fecha_derivacion');
            $proceso->cod_responsable_destinatario  =   $request->get('destinatario');
            $proceso->cod_estado_proceso            =   $request->get('estado_proceso');
            $proceso->comentarios                   =   $request->get('comentarios');
            $proceso->updated_auth                  =   Auth::user()->id;
            $proceso->update();

            #2. Retorno al menu principal (Falta regularizar la actualizacion del area y el especialista en la tabla expedientePostulante)
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
}
