<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ActividadFormRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Postulante;
use App\Actividad;
use App\Imports\ActividadImport;
use Carbon\Carbon;
use DB;
use Auth;

class ActividadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proyecto.actividad';

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
    public function create($id)
    {
        $postulante         =   Postulante::findOrFail($id);
        return view($this->path.'.create', compact('postulante'));
    }

    #4.
    public function store(Request $request)
    {
        try 
        {
            $this->validate($request, [
                'file' => 'required|file|max:1024|mimes:xls,xlsx'
            ]);
            $import = new ActividadImport();
            Excel::import($import, request()->file('file'));

            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $import->getRowCount(),
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
    public function showProyecto()
    {
        $data     =       Postulante::getDataEstado(2, 3);
        return view($this->path.'.data-proyecto', compact('data'));
    }

    #6.
    public function show($id)
    {
        $data       =   Actividad::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $actividad      =   Actividad::findOrFail($id);
        $postulante     =   Postulante::findOrFail($actividad->codPostulante);
        return view($this->path.'.edit', compact('actividad', 'postulante'));
    }

    #7.
    public function update(ActividadFormRequest $request, $id)
    {
        try 
        {
            $actividad                      =   Actividad::findOrFail($id);
            $actividad->codigo              =   $request->get('orden');
            $actividad->descripcion         =   $request->get('descripcion');
            $actividad->unidad              =   $request->get('unidad');
            $actividad->meta_fisica         =   $request->get('meta_fisica');
            $actividad->meta_financiera     =   $request->get('meta_financiera');
            $actividad->precio              =   $request->get('precio');
            $actividad->aporte_pcc          =   $request->get('aporte_pcc');
            $actividad->aporte_oa           =   $request->get('aporte_oa');
            $actividad->updated_auth        =   Auth::user()->id;
            $actividad->updated_at          =   Carbon::now();
            $actividad->update();

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
            $actividad                  =   Actividad::findOrFail($id);
            $actividad->estado          =   0;
            $actividad->updated_auth    =   Auth::user()->id;
            $actividad->update();

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
