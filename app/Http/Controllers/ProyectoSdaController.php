<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProyectoSdaFormRequest;
use App\Postulante;
use App\Proyecto;
use App\PostulanteProductoEspecifico;
use App\CadenaProductiva;
use App\Producto;
use App\Entidad;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class ProyectoSdaController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='proceso-pdn.proyecto';

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
        #1. Alcanzo las variables correspondientes
        $postulantes        =   Postulante::getDataSda();
        $cadena             =   CadenaProductiva::getData();
        $tipo_produccion    =   TablaValor::getDetalleTabla('TipoProduccion');

        #2. Retorno al formulario
        return view($this->path.'.create', compact('postulantes', 'cadena', 'tipo_produccion'));
    }

    #5. 
    public function store(ProyectoSdaFormRequest $request)
    {
        try 
        {
            $proyecto                               =   new Proyecto;
            $proyecto->codPostulante                =   $request->get('postulante');
            $proyecto->tituloProyecto               =   $request->get('titulo');
            $proyecto->mlProposito                  =   $request->get('proposito');
            $proyecto->duracion                     =   $request->get('duracion');
            $proyecto->fecha_inicio                 =   $request->get('fecha_inicio');
            $proyecto->fecha_termino                =   Carbon::parse($request->get('fecha_inicio'))->addMonths($request->get('duracion'));
            $proyecto->inversion_total              =   $request->get('inversion_total');
            $proyecto->inversion_pcc                =   $request->get('inversion_pcc');
            $proyecto->inversion_entidad            =   $request->get('inversion_entidad');
            $proyecto->area                         =   $request->get('nro_has');
            $proyecto->nro_beneficiarios            =   $request->get('beneficiarios_total');
            $proyecto->nro_beneficiarios_varones    =   $request->get('beneficiarios_varones');
            $proyecto->nro_beneficiarios_mujeres    =   $request->get('beneficiarios_mujeres');
            $proyecto->estado                       =   1;
            $proyecto->created_auth                 =   Auth::user()->id;
            $proyecto->updated_auth                 =   Auth::user()->id;
            $proyecto->save();

            #2. Guardo la información sobre la cadena productiva
            try 
            {
                $cadena                     =   new PostulanteProductoEspecifico;
                $cadena->codPostulante      =   $request->get('postulante');
                $cadena->codCadena          =   $request->get('cadena');
                $cadena->nroHas             =   $request->get('nro_has');
                $cadena->nroProductores     =   $request->get('beneficiarios_total');
                $cadena->tipoProduccion     =   $request->get('tipo_produccion');
                $cadena->principal          =   1;
                $cadena->etapa              =   1;
                $cadena->created_auth       =   Auth::user()->id;
                $cadena->updated_auth       =   Auth::user()->id;
                $cadena->save();

                #3. Retorno a la pagina principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $proyecto->id,
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

    #6. Muestro la relación de registros generados
    public function show()
    {
        $data       =   Proyecto::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        #1. Obtengo la información del Proyecto
        $proyecto           =   Proyecto::findOrFail($id);
        $postulantes        =   Postulante::getDataSda();
        $postulante         =   Postulante::findOrFail($proyecto->codPostulante);
        $cadena             =   CadenaProductiva::getData();
        $producto           =   PostulanteProductoEspecifico::where('codPostulante', $proyecto->codPostulante)->first();
        $tipo_produccion    =   TablaValor::getDetalleTabla('TipoProduccion');

        #2. Retorno a la vista principal
        return view($this->path.'.edit', compact('proyecto', 'postulantes', 'cadena', 'tipo_produccion', 'producto'));
    }

    #8.
    public function update(ProyectoSdaFormRequest $request, $id)
    {
        try 
        {
            $proyecto                               =   Proyecto::findOrFail($id);
            $proyecto->tituloProyecto               =   $request->get('titulo');
            $proyecto->mlProposito                  =   $request->get('proposito');
            $proyecto->duracion                     =   $request->get('duracion');
            $proyecto->fecha_inicio                 =   $request->get('fecha_inicio');
            $proyecto->fecha_termino                =   Carbon::parse($request->get('fecha_inicio'))->addMonths($request->get('duracion'));
            $proyecto->inversion_total              =   $request->get('inversion_total');
            $proyecto->inversion_pcc                =   $request->get('inversion_pcc');
            $proyecto->inversion_entidad            =   $request->get('inversion_entidad');
            $proyecto->area                         =   $request->get('nro_has');
            $proyecto->nro_beneficiarios            =   $request->get('beneficiarios_total');
            $proyecto->nro_beneficiarios_varones    =   $request->get('beneficiarios_varones');
            $proyecto->nro_beneficiarios_mujeres    =   $request->get('beneficiarios_mujeres');
            $proyecto->updated_auth                 =   Auth::user()->id;
            $proyecto->update();

            #2. Retorno a la pagina principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $proyecto->codPostulante,
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
