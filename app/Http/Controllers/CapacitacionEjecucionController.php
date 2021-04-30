<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CapacitacionEjecucionFormRequest;
use App\Usuario;
use App\Capacitacion;
use App\CapacitacionEjecucion;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;


class CapacitacionEjecucionController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.capacitacion-implementacion';

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
        $capacitaciones     =   Capacitacion::getCapacitaciones(1);

        #2. Retorno al menu principal        
        return view($this->path.'.create', compact('capacitaciones'));
    }

    #5.
    public function store(CapacitacionEjecucionFormRequest $request)
    {
        #1. Genero información de implementacion
        try 
        {
            $implementacion                         =   new CapacitacionEjecucion;
            $implementacion->codInicCapacitacion    =   $request->get('capacitacion');
            $implementacion->fechaRendicion         =   $request->get('fecha');
            $implementacion->hora_inicio            =   $request->get('hora_inicio');
            $implementacion->hora_termino           =   $request->get('hora_termino');
            $implementacion->estado                 =   1;
            $implementacion->created_auth           =   Auth::user()->id;
            $implementacion->updated_auth           =   Auth::user()->id;
            $implementacion->save();

            #2. Actualizamos la información del evento de capacitación
            try 
            {
                $capacitacion               =   Capacitacion::findOrFail($request->get('capacitacion'));
                $capacitacion->resultados   =   $request->get('resultados');
                $capacitacion->acuerdos     =   $request->get('acuerdos');
                $capacitacion->comentarios  =   $request->get('comentarios');
                $capacitacion->codEstado    =   2; #Indica que el evento fue ejecutado
                $capacitacion->update();

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
        $data   =   CapacitacionEjecucion::getData();
        #2. Retorno al menu principal
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        #1. obtengo la información a actualizar
        $capacitaciones     =   Capacitacion::getCapacitaciones(2);
        $implementacion     =   CapacitacionEjecucion::findOrFail($id);
        $capacitacion       =   Capacitacion::findOrFail($implementacion->codInicCapacitacion);

        #2. Retorno al formulario de edicion
        return view($this->path.'.edit', compact('capacitaciones', 'implementacion', 'capacitacion'));
    }

    #8.
    public function update(CapacitacionEjecucionFormRequest $request, $id)
    {
        try 
        {
            $implementacion                         =   CapacitacionEjecucion::findOrFail($id);
            $implementacion->fechaRendicion         =   $request->get('fecha');
            $implementacion->hora_inicio            =   $request->get('hora_inicio');
            $implementacion->hora_termino           =   $request->get('hora_termino');
            $implementacion->updated_auth           =   Auth::user()->id;
            $implementacion->update();

            #2. Actualizo la información del evento de capacitacion
            try 
            {
                $capacitacion               =   Capacitacion::findOrFail($implementacion->codInicCapacitacion);
                $capacitacion->resultados   =   $request->get('resultados');
                $capacitacion->acuerdos     =   $request->get('acuerdos');
                $capacitacion->comentarios  =   $request->get('comentarios');
                $capacitacion->updated_auth =   Auth::user()->id;
                $capacitacion->update();

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
