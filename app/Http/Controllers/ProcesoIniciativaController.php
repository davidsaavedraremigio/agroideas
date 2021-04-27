<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProcesoIniciativaFormRequest;
use App\Proceso;
use App\Area;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ProcesoIniciativaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.proceso-iniciativa';

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
        $tipo_iniciativa    =   TablaValor::getDetalleTabla('TipoIncentivo');
        $areas              =   Area::getData();
        return view($this->path.'.create', compact('tipo_iniciativa', 'areas'));
    }

    #5.
    public function store(ProcesoIniciativaFormRequest $request)
    {
        try 
        {
            $proceso                        =   new Proceso;
            $proceso->codTipoIniciativa     =   $request->get('tipo_iniciativa');
            $proceso->codMaestroArea        =   $request->get('area');
            $proceso->orden                 =   $request->get('nro_orden');
            $proceso->descripcion           =   $request->get('descripcion');
            $proceso->estado                =   1;
            $proceso->save();

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

    #6.
    public function show()
    {
        $data       =   Proceso::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function edit($id)
    {
        $tipo_iniciativa    =   TablaValor::getDetalleTabla('TipoIncentivo');
        $areas              =   Area::getData();
        $proceso            =   Proceso::findOrFail($id);

        return view($this->path.'.edit', compact('tipo_iniciativa', 'areas', 'proceso'));
    }

    #8.
    public function update(ProcesoIniciativaFormRequest $request, $id)
    {
        try 
        {
            $proceso                        =   Proceso::findOrFail($id);
            $proceso->codTipoIniciativa     =   $request->get('tipo_iniciativa');
            $proceso->codMaestroArea        =   $request->get('area');
            $proceso->orden                 =   $request->get('nro_orden');
            $proceso->descripcion           =   $request->get('descripcion');
            $proceso->update();

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

    #9. 
    public function destroy($id)
    {
        try 
        {
            $proceso        =   Proceso::findOrFail($id);
            $proceso->estado=   0;
            $proceso->update();

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
