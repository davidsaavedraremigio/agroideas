<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ComponenteFormRequest;
use App\MarcoLogico;
use App\Postulante;
use Carbon\Carbon;
use DB;
use Auth;

class ComponenteController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-prp.componente';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. 
    public function create($id)
    {
        $postulante         =   Postulante::findOrFail($id);
        return view($this->path.'.create', compact('postulante'));
    }

    #4.
    public function store(ComponenteFormRequest $request)
    {
        try 
        {
            $componente                     =   new MarcoLogico;
            $componente->codPostulante      =   $request->get('codigo');
            $componente->codTipo            =   2;
            $componente->nombre             =   $request->get('descripcion');
            $componente->orden              =   $request->get('nro_orden');
            $componente->estado             =   1;
            $componente->created_auth       =   Auth::user()->id;
            $componente->updated_auth       =   Auth::user()->id;
            $componente->save();

            #2. retorno al menu principal
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
        $tipo       =   2;
        $data       =   MarcoLogico::getDataML($tipo, $id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $componente         =   MarcoLogico::findOrFail($id);
        return view($this->path.'.edit', compact('componente'));
    }

    #7. 
    public function update(ComponenteFormRequest $request, $id)
    {
        try 
        {
            $componente                     =   MarcoLogico::findOrFail($id);
            $componente->nombre             =   $request->get('descripcion');
            $componente->orden              =   $request->get('nro_orden');
            $componente->updated_auth       =   Auth::user()->id;
            $componente->update();

            #2. retorno al menu principal
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
        try 
        {
            $componente                     =   MarcoLogico::find($id);
            $componente->estado             =   0;
            $componente->updated_auth       =   Auth::user()->id;
            $componente->update();

            #2. retorno al menu principal
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
