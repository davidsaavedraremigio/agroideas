<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UbigeoFormRequest;
use App\Ubigeo;
use Carbon\Carbon;
use DB;
use Auth;

class UbigeoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.ubigeo';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    #3. Mostramos el menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Mostramos el formulario para añadir ubigeos
    public function create()
    {
        return view($this->path.'.create');
    }

    #5. Guardamos la información de ubigeo
    public function store(UbigeoFormRequest $request)
    {
        try 
        {
            $ubigeo             =   new Ubigeo;
            $ubigeo->id         =   $request->get('codigo');
            $ubigeo->nombre     =   $request->get('nombre');
            $ubigeo->save();

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

    #6. Mostramos los ubigeos registrados
    public function show()
    {
        $ubigeo     =   Ubigeo::getData();
        return view($this->path.'.data', compact('ubigeo'));
    }

    #7. Mostramos el formulario para edición de ubigeos
    public function edit($id)
    {
        $ubigeo     =   Ubigeo::findOrFail($id);
        return view($this->path.'.edit', compact('ubigeo'));
    }

    #8. Actualizo la información de ubigeos
    public function update(UbigeoFormRequest $request, $id)
    {
        try 
        {
            $ubigeo         =   Ubigeo::findOrFail($id);
            $ubigeo->id     =   $request->get('codigo');
            $ubigeo->nombre =   $request->get('nombre');
            $ubigeo->update();

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

    #9. Elimino ubigeos
    public function destroy($id)
    {
        try 
        {
            $ubigeo     =   Ubigeo::find($id);
            $ubigeo->delete();

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

    #10. Obtengo las provincias correspondientes al departamento indicado
    public function obtieneProvincias($id)
    {
        $provincias =   Ubigeo::getProvincias($id);
        return response()->json($provincias);
    }

    #11. Obtengo los distritos correspondientes a la provincia indicada
    public function obtieneDistritos($id)
    {
        $distritos  =   Ubigeo::getDistritos($id);
        return response()->json($distritos);
    }
}
