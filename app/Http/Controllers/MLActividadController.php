<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\MLActividadFormRequest;
use App\MLProyecto;
use App\MLResultado;
use Carbon\Carbon;
use DB;
use Auth;

class MLActividadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proyecto.actividad';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }    

    #3. 
    public function create($id)
    {
        $proyecto       =   MLProyecto::findOrFail($id);
        $tipo           =   'C';
        $componentes    =   MLResultado::getData($proyecto->id, $tipo);
        return view($this->path.'.create', compact('proyecto', 'componentes'));
    }

    #4.
    public function store(MLActividadFormRequest $request)
    {
        try 
        {
            $actividad                      =   new MLResultado;
            $actividad->SYSProyectoID       =   $request->get('codigo');
            $actividad->tipo                =   'A';
            $actividad->nroOrden            =   $request->get('nro_orden');
            $actividad->descripcion         =   $request->get('descripcion');
            $actividad->estado              =   1;
            $actividad->referenciaID        =   $request->get('componente');
            $actividad->save();

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

    #5.
    public function show($id)
    {
        $tipo       =   'A';
        $data       =   MLResultado::getData($id, $tipo);
        return view($this->path.'.data', compact('data'));
    }

    #6
    public function edit($id)
    {
        $actividad        =   MLResultado::findOrFail($id);
        $tipo             =   'C';
        $componentes      =   MLResultado::getData($actividad->SYSProyectoID, $tipo);
        return view($this->path.'.edit', compact('actividad', 'componentes'));
    }

    #7.
    public function update(MLActividadFormRequest $request, $id)
    {
        try 
        {
            $actividad                      =   MLResultado::findOrFail($id);
            $actividad->nroOrden            =   $request->get('nro_orden');
            $actividad->descripcion         =   $request->get('descripcion');
            $actividad->referenciaID        =   $request->get('componente');
            $actividad->update();

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

    #8.
    public function destroy($id)
    {
        //
    }
}
