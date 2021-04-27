<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CapacitacionRendicionFormRequest;
use App\CapacitacionRendicion;
use App\CapacitacionEjecucion;
use App\Capacitacion;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;


class CapacitacionRendicionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.capacitacion-ejecucion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Muestro el formulario para realizar nuevos registros
    public function create($id)
    {
        #1. Obtengo las variables a enviar
        $implementacion     =   CapacitacionEjecucion::findOrFail($id);
        $capacitacion       =   Capacitacion::findOrFail($implementacion->codInicCapacitacion);

        #2. Retorno la información correspondiente a la rendicion
        return view($this->path.'.create', compact('capacitacion', 'implementacion'));
    }

    #4. Realizo el registro de la información
    public function store(CapacitacionRendicionFormRequest $request)
    {
        try 
        {
            $rendicion                              =   new CapacitacionRendicion;
            $rendicion->codInicCapacitacion         =   $request->get('codigo');
            $rendicion->concepto                    =   $request->get('concepto');
            $rendicion->fecha                       =   $request->get('fecha');
            $rendicion->importe                     =   $request->get('importe');
            $rendicion->estado                      =   1;
            $rendicion->created_auth                =   Auth::user()->id;
            $rendicion->updated_auth                =   Auth::user()->id;
            $rendicion->save();

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

    #5. Muestro la relación de datos de la rendición
    public function show($id)
    {
        $implementacion     =   CapacitacionEjecucion::findOrFail($id);
        $data               =   CapacitacionRendicion::getData($implementacion->codInicCapacitacion);
        return view($this->path.'.data', compact('data'));
    }
    
    
    #6. Muestro el formulario para la edición de registros
    public function edit($id)
    {
        $rendicion          =    CapacitacionRendicion::findOrFail($id);
        $capacitacion       =    Capacitacion::findOrFail($rendicion->codInicCapacitacion);
        return view($this->path.'.edit', compact('rendicion', 'capacitacion'));   
    }
    
    #7. Actualizo la información de rendicion de gastos
    public function update(CapacitacionRendicionFormRequest $request, $id)
    {
        try 
        {
            $rendicion                  =   CapacitacionRendicion::findOrFail($id);
            $rendicion->concepto        =   $request->get('concepto');
            $rendicion->fecha           =   $request->get('fecha');
            $rendicion->importe         =   $request->get('importe');
            $rendicion->updated_auth    =   Auth::user()->id;
            $rendicion->update();
            
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

    #8. Elimino la información de rendición de gastos
    public function destroy($id)
    {
        try 
        {
            $rendicion          =   CapacitacionRendicion::find($id);
            $rendicion->delete();

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
