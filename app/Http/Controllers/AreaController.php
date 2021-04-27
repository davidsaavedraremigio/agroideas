<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\AreaFormRequest;
use App\Area;
use Carbon\Carbon;
use DB;
use Auth;

class AreaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.area';

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
        return view($this->path.'.create');
    }

    #5. 
    public function store(AreaFormRequest $request)
    {
        try 
        {
            $area               =   new Area;
            $area->descripcion  =   $request->get('descripcion');
            $area->sigla        =   $request->get('sigla');
            $area->save();

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
        $data       =   Area::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function edit($id)
    {
        $area       =   Area::findOrFail($id);
        return view($this->path.'.edit', compact('area'));
    }

    #8.
    public function update(AreaFormRequest $request, $id)
    {
        try 
        {
            $area               =   Area::findOrFail($id);
            $area->descripcion  =   $request->get('descripcion');
            $area->sigla        =   $request->get('sigla');
            $area->update();

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
            $area           =   Area::findOrFail($id);
            $area->estado   =   0;
            $area->delete();

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
