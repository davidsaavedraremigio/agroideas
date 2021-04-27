<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CargoFormRequest;
use App\Cargo;
use App\Area;
use Carbon\Carbon;
use DB;
use Auth;

class CargoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.cargo';

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
        $area   =   Area::getData();
        return view($this->path.'.create', compact('area'));
    }

    #5. 
    public function store(CargoFormRequest $request)
    {
        try 
        {
            $cargo                      =   new Cargo;
            $cargo->codMaestroAreaID    =   $request->get('area');
            $cargo->descripcion         =   $request->get('descripcion');
            $cargo->save();

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
        $data   =   Cargo::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function edit($id)
    {
        $cargo      =   Cargo::findOrFail($id);
        $area       =   Area::getData();
        return view($this->path.'.edit', compact('cargo', 'area'));
    }

    #8.
    public function update(CargoFormRequest $request, $id)
    {
        try 
        {
            $cargo                      =   Cargo::findOrFail($id);
            $cargo->codMaestroAreaID    =   $request->get('area');
            $cargo->descripcion         =   $request->get('descripcion');
            $cargo->update();

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
            $cargo          =   Cargo::findOrFail($id);
            $cargo->estado  =   0;
            $cargo->update();

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
