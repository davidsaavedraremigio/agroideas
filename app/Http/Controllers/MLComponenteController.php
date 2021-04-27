<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\MLComponenteFormRequest;
use App\MLProyecto;
use App\MLResultado;
use Carbon\Carbon;
use DB;
use Auth;

class MLComponenteController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proyecto.resultado';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $proyecto       =   MLProyecto::findOrFail($id);
        return view($this->path.'.create', compact('proyecto'));
    }

    #4. 
    public function store(MLComponenteFormRequest $request)
    {
        try 
        {
            $componente                     =   new MLResultado;
            $componente->SYSProyectoID      =   $request->get('codigo');
            $componente->tipo               =   'C';
            $componente->nroOrden           =   $request->get('nro_orden');
            $componente->descripcion        =   $request->get('descripcion');
            $componente->estado             =   1;
            $componente->save();

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
        $tipo       =   'C';
        $data       =   MLResultado::getData($id, $tipo);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $componente         =   MLResultado::findOrFail($id);
        return view($this->path.'.edit', compact('componente'));
    }

    #7.
    public function update(MLComponenteFormRequest $request, $id)
    {
        try 
        {
            $componente                     =   MLResultado::findOrFail($id);
            $componente->nroOrden           =   $request->get('nro_orden');
            $componente->descripcion        =   $request->get('descripcion');
            $componente->update();

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
