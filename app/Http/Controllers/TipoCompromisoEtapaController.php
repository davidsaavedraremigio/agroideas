<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\TipoCompromisoEtapaFormRequest;
use App\TablaValor;
use App\TipoCompromisoEtapa;
use Carbon\Carbon;
use DB;
use Auth;


class TipoCompromisoEtapaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.etapa-compromiso';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Retorno al menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para generar nuevos registros
    public function create()
    {
        #1. Obtengo los tipos de compromisos
        $tipoCompromiso     =   TablaValor::getDetalleTabla('TipoCompromiso');
        #2. Retorno al formulario de registro de informacion
        return view($this->path.'.create', compact('tipoCompromiso'));
    }

    #5. Realizo el registro de información
    public function store(TipoCompromisoEtapaFormRequest $request)
    {
        try 
        {
            $etapa                      =   new TipoCompromisoEtapa;
            $etapa->codTipoCompromiso   =   $request->get('tipo_compromiso');
            $etapa->descripcion         =   $request->get('descripcion');
            $etapa->save();

            #2. Retorno al menu principal
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

    #6. Obtengo la data registrada
    public function show()
    {
        #1. obtengo los datos
        $etapas     =   TipoCompromisoEtapa::getData();
        #2. Retorno a la vista principal
        return view($this->path.'.data', compact('etapas'));
    }

    #7. Muestro el formulario para la edición de registros
    public function edit($id)
    {
        #1. Obtengo el registro consultado
        $etapa              =   TipoCompromisoEtapa::findOrFail($id);
        #2. Obtengo los tipos de compromisos
        $tipoCompromiso     =   TablaValor::getDetalleTabla('TipoCompromiso'); 
        #3. Retornamos al formulario de edicion de registros
        return view($this->path.'.edit', compact('etapa', 'tipoCompromiso'));
    }

    #8. Actualizamos la informacion
    public function update(TipoCompromisoEtapaFormRequest $request, $id)
    {
        try 
        {
            $etapa                      =   TipoCompromisoEtapa::findOrFail($id);
            $etapa->codTipoCompromiso   =   $request->get('tipo_compromiso');
            $etapa->descripcion         =   $request->get('descripcion');
            $etapa->update();

            #2. Retorno al menu principal
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

    #9. Elimino el registro seleccionado
    public function destroy($id)
    {
        try 
        {
            $etapa      =   TipoCompromisoEtapa::find($id);
            $etapa->delete();

            #2. Retorno al menu principal
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
