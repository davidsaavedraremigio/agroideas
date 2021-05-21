<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CapacitacionExtensionistaFormRequest;
use App\Capacitacion;
use App\CapacitacionEjecucion;
use App\CapacitacionExtensionista;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class CapacitacionExtensionistaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.capacitacion-extensionista';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. 
    public function create($id)
    {
        #1. Obtengo las variables a enviar
        $implementacion     =   CapacitacionEjecucion::findOrFail($id);
        $capacitacion       =   Capacitacion::findOrFail($implementacion->codInicCapacitacion);

        #2. Retorno la información
        return view($this->path.'.create', compact('implementacion', 'capacitacion'));
    }

    #4. 
    public function store(CapacitacionExtensionistaFormRequest $request)
    {
        try 
        {
            $fecha                                  =   Carbon::now();
            $extensionista                          =   new CapacitacionExtensionista;
            $extensionista->codInicCapacitacion     =   $request->get('codigo');
            $extensionista->dni                     =   $request->get('dni');
            $extensionista->nombres                 =   $request->get('nombres');
            $extensionista->paterno                 =   $request->get('paterno');
            $extensionista->materno                 =   $request->get('materno');
            $extensionista->fecha                   =   $fecha->subYears($request->get('edad'));
            $extensionista->sexo                    =   $request->get('sexo');
            $extensionista->estado                  =   1;
            $extensionista->created_auth            =   Auth::user()->id;
            $extensionista->updated_auth            =   Auth::user()->id;
            $extensionista->save();

            #3. Retorno al menu principal
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
        $implementacion     =   CapacitacionEjecucion::findOrFail($id);
        $data       =   CapacitacionExtensionista::getDataExtensionista($implementacion->codInicCapacitacion);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $extensionista      =   CapacitacionExtensionista::findOrFail($id);
        $edad               =   Carbon::createFromDate($extensionista->fecha)->age;
        return view($this->path.'.edit', compact('extensionista', 'edad'));
    }

    #7.
    public function update(CapacitacionExtensionistaFormRequest $request, $id)
    {
        try 
        {
            $fecha                      =   Carbon::now();
            $extensionista              =   CapacitacionExtensionista::findOrFail($id);
            $extensionista->dni         =   $request->get('dni');
            $extensionista->nombres     =   $request->get('nombres');
            $extensionista->paterno     =   $request->get('paterno');
            $extensionista->materno     =   $request->get('materno');
            $extensionista->fecha       =   $fecha->subYears($request->get('edad'));
            $extensionista->sexo        =   $request->get('sexo');
            $extensionista->updated_auth=   Auth::user()->id;
            $extensionista->update();

            #3. Retorno al menu principal
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
            $extensionista              =   CapacitacionExtensionista::find($id);
            $extensionista->delete();

            #3. Retorno al menu principal
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
