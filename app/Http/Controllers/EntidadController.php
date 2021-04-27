<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EntidadFormRequest;
use App\Entidad;
use App\TablaValor;
use App\Ubigeo;
use Carbon\Carbon;
use DB;
use Auth;

class EntidadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sp.opa';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }    
    
    #3. Mostramos el panel principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Mostramos el formulario de registro de entidades
    public function create()
    {
        #1. Obtengo los tipos de documentos
        $tipo_doc       =   TablaValor::getDetalleTabla('TipoDocumento');
        #2. Obtengo los tipos de entidades
        $tipo_entidad   =   TablaValor::getDetalleTabla('TipoEntidad');
        #3. Obtengo la información de las regiones
        $regiones       =   Ubigeo::getRegiones();
        #4. Retorno al formulario de registro
        return view($this->path.'.create', compact('tipo_doc', 'tipo_entidad', 'regiones'));
    }

    #5. Procesamos la información generada
    public function store(EntidadFormRequest $request)
    {
        try 
        {
            $entidad        =   Entidad::firstOrCreate(['nroDocumento' => $request->get('nro_documento')],[
                                    'codTipoDocumento'      =>  1,
                                    'codTipoEntidad'        =>  $request->get('tipo_entidad'),
                                    'nombre'                =>  $request->get('nombre'),
                                    'ubigeo'                =>  $request->get('ubigeo'),
                                    'direccion'             =>  $request->get('direccion'),
                                    'condicionDomicilio'    =>  $request->get('estado_domicilio'),
                                    'estadoContribuyente'   =>  $request->get('estado_contribuyente'),
                                    'fechaRRPP'             =>  $request->get('fecha_rrpp'),
                                    'estado'                =>  1,
                                    'created_auth'          =>  Auth::user()->id,
                                    'updated_auth'          =>  Auth::user()->id
                                ]);
            #2, retorno al menú principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $entidad->id,
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

    #6. Muestro los registros 
    public function show()
    {
        #1. Obtengo la relación de entidades registradas
        $data   =   Entidad::getData();
        #2. Retorno a la vista de datos
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro el formulario de edición
    public function edit($id)
    {
        #1. Obtengo los tipos de documentos
        $tipo_doc       =   TablaValor::getDetalleTabla('TipoDocumento');
        #2. Obtengo los tipos de entidades
        $tipo_entidad   =   TablaValor::getDetalleTabla('TipoEntidad');
        #3. Obtengo la información de la entidad
        $entidad        =   Entidad::findOrFail($id);
        #4. Retorno al formulario de edición
        return view($this->path.'.edit', compact('tipo_doc', 'tipo_entidad', 'entidad'));
    }

    #8. Guardo la información
    public function update(EntidadFormRequest $request, $id)
    {
        try 
        {
            $entidad                        =   Entidad::findOrFail($id);
            $entidad->nroDocumento          =   $request->get('nro_documento');
            $entidad->codTipoEntidad        =   $request->get('tipo_entidad');
            $entidad->nombre                =   $request->get('nombre');
            $entidad->ubigeo                =   $request->get('ubigeo');
            $entidad->direccion             =   $request->get('direccion');
            $entidad->condicionDomicilio    =   $request->get('estado_domicilio');
            $entidad->estadoContribuyente   =   $request->get('estado_contribuyente');
            $entidad->fechaRRPP             =   $request->get('fecha_rrpp');
            $entidad->updated_auth          =   Auth::user()->id;
            $entidad->update();

            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $entidad->id,
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

    #9. Deshabilito la entidad correspondiente
    public function destroy($id)
    {
        try 
        {
            $opa            =   Entidad::findOrFail($id);
            $opa->estado    =   0;
            $opa->update();

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
}
