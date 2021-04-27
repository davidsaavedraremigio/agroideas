<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SectorProductivoFormRequest;
use App\SectorProductivo;
use Carbon\Carbon;
use DB;
use Auth;

class SectorProductivoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.sector';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }   

    #3. Muestro la ventana principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para generar nuevos registros
    public function create()
    {
        return view($this->path.'.create');
    }

    #5. Guardo la información
    public function store(SectorProductivoFormRequest $request)
    {
        try 
        {
            $sector                 =   new SectorProductivo;
            $sector->descripcion    =   $request->get('descripcion');
            $sector->save();

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

    #6. Muestro los registros generados
    public function show()
    {
        $data       =   SectorProductivo::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro el formulario para la edición de registros
    public function edit($id)
    {
        $sector     =   SectorProductivo::findOrFail($id);
        return view($this->path.'.edit', compact('sector'));
    }

    #8. Actualizamos la informacion
    public function update(SectorProductivoFormRequest $request, $id)
    {
        try 
        {
            $sector                 =   SectorProductivo::findOrFail($id);
            $sector->descripcion    =   $request->get('descripcion');
            $sector->update();

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

    #9. Elimino registros
    public function destroy($id)
    {
        try 
        {
            $sector     =   SectorProductivo::findOrFail($id);
            $sector->delete();

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
