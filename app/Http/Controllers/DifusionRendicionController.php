<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\DifusionRendicionFormRequest;
use App\DifusionRendicion;
use App\DifusionEjecucion;
use App\Difusion;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class DifusionRendicionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.difusion-ejecucion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        #1. Obtengo las variables a enviar
        $implementacion     =   DifusionEjecucion::findOrFail($id);
        $difusion           =   Difusion::findOrFail($implementacion->codInicDifusion);

        #2. Retorno la información correspondiente a la rendicion
        return view($this->path.'.create', compact('difusion', 'implementacion'));
    }

    #4.
    public function store(DifusionRendicionFormRequest $request)
    {
        try 
        {
            $rendicion                          =   new DifusionRendicion;
            $rendicion->codInicDifusion         =   $request->get('codigo');
            $rendicion->concepto                =   $request->get('concepto');
            $rendicion->fecha                   =   $request->get('fecha');
            $rendicion->importe                 =   $request->get('importe');
            $rendicion->estado                  =   1;
            $rendicion->created_auth            =   Auth::user()->id;
            $rendicion->updated_auth            =   Auth::user()->id;
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

    #5.
    public function show($id)
    {
        $implementacion     =   DifusionEjecucion::findOrFail($id);
        $data               =   DifusionRendicion::getData($implementacion->codInicDifusion);
        return view($this->path.'.data', compact('data'));
    }

    #6. 
    public function edit($id)
    {
        $rendicion          =    DifusionRendicion::findOrFail($id);
        $difusion           =    Difusion::findOrFail($rendicion->codInicDifusion);
        return view($this->path.'.edit', compact('rendicion', 'difusion'));  
    }

    #7.
    public function update(DifusionRendicionFormRequest $request, $id)
    {
        try 
        {
            $rendicion                  =   DifusionRendicion::findOrFail($id);
            $rendicion->concepto        =   $request->get('concepto');
            $rendicion->fecha           =   $request->get('fecha');
            $rendicion->importe         =   $request->get('importe');
            $rendicion->updated_auth    =   Auth::user()->id;
            $rendicion->update();

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
            $rendicion          =   DifusionRendicion::find($id);
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
