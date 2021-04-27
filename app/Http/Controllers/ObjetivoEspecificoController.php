<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ObjetivoEspecificoFormRequest;
use App\ObjetivoEspecifico;
use App\Postulante;
use Carbon\Carbon;
use DB;
use Auth;

class ObjetivoEspecificoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-prp.objetivo-especifico';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        #1. obtengo las variables
        $postulante     =   Postulante::findOrFail($id);
        return view($this->path.'.create', compact('postulante'));
    }

    #4.
    public function store(ObjetivoEspecificoFormRequest $request)
    {
        try 
        {
            $objetivo                   =   new ObjetivoEspecifico;
            $objetivo->codPostulante    =   $request->get('codigo');
            $objetivo->orden            =   $request->get('nro_orden');
            $objetivo->descripcion      =   $request->get('descripcion');
            $objetivo->estado           =   1;
            $objetivo->created_auth     =   Auth::user()->id;
            $objetivo->updated_auth     =   Auth::user()->id;
            $objetivo->save();

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
        $data       =   ObjetivoEspecifico::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $objetivo       =   ObjetivoEspecifico::findOrFail($id);
        return view($this->path.'.edit', compact('objetivo'));
    }

    #7.
    public function update(ObjetivoEspecificoFormRequest $request, $id)
    {
        try 
        {
            $objetivo               =   ObjetivoEspecifico::findOrFail($id);
            $objetivo->orden        =   $request->get('nro_orden');
            $objetivo->descripcion  =   $request->get('descripcion');
            $objetivo->updated_auth =   Auth::user()->id;
            $objetivo->update();

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
            $objetivo               =   ObjetivoEspecifico::find($id);
            $objetivo->estado       =   0;
            $objetivo->updated_auth =   Auth::user()->id; 
            $objetivo->update();

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
