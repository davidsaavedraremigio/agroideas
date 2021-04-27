<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\DifusionEjecucionFormRequest;
use App\Usuario;
use App\Difusion;
use App\DifusionEjecucion;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class DifusionEjecucionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.difusion-implementacion';

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
        #1. obtengo la información de eventos de capacitacion pendientes
        $eventos     =   Difusion::getEventos(1);
        #2. Retorno al menu principal        
        return view($this->path.'.create', compact('eventos'));
    }

    #5.
    public function store(DifusionEjecucionFormRequest $request)
    {
        try 
        {
            $implementacion                         =   new DifusionEjecucion;
            $implementacion->codInicDifusion        =   $request->get('difusion');
            $implementacion->fechaRendicion         =   $request->get('fecha');
            $implementacion->hora_inicio            =   $request->get('hora_inicio');
            $implementacion->hora_termino           =   $request->get('hora_termino');
            $implementacion->estado                 =   1;
            $implementacion->created_auth           =   Auth::user()->id;
            $implementacion->updated_auth           =   Auth::user()->id;
            $implementacion->save();

            #2. Actualizamos el estado situacional del evento de difusion
            try 
            {
                $difusion               =   Difusion::findOrFail($implementacion->codInicDifusion);
                $difusion->resultados   =   $request->get('resultados');
                $difusion->acuerdos     =   $request->get('acuerdos');
                $difusion->comentarios  =   $request->get('comentarios');
                $difusion->codEstado    =   2;
                $difusion->updated_auth =   Auth::user()->id;
                $difusion->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $implementacion->id,
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
        #1. Obtengo la información
        $data   =   DifusionEjecucion::getData();
        #2. Retorno al menu principal
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        #1. obtengo la información a actualizar
        $eventos            =   Difusion::getEventos(2);
        $implementacion     =   DifusionEjecucion::findOrFail($id);
        $difusion           =   Difusion::findOrFail($implementacion->codInicDifusion);
        #2. Retorno al formulario de edicion
        return view($this->path.'.edit', compact('eventos', 'implementacion', 'difusion'));
    }

    #8.
    public function update(DifusionEjecucionFormRequest $request, $id)
    {
        try 
        {
            $implementacion                         =   DifusionEjecucion::findOrFail($id);
            $implementacion->fechaRendicion         =   $request->get('fecha');
            $implementacion->hora_inicio            =   $request->get('hora_inicio');
            $implementacion->hora_termino           =   $request->get('hora_termino');
            $implementacion->updated_auth           =   Auth::user()->id;
            $implementacion->update();

            #2. Actualizo la información del evento de difusion
            try 
            {
                $difusion               =   Difusion::findOrFail($implementacion->codInicDifusion);
                $difusion->resultados   =   $request->get('resultados');
                $difusion->acuerdos     =   $request->get('acuerdos');
                $difusion->comentarios  =   $request->get('comentarios');
                $difusion->updated_auth =   Auth::user()->id;
                $difusion->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $implementacion->id,
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
