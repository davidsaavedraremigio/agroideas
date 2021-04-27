<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\MLProyectoFormRequest;
use App\MLProyecto;
use Carbon\Carbon;
use DB;
use Auth;

class MLProyectoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proyecto.ml';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Muestro el menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4.
    public function create()
    {
        return view($this->path.'.create');
    }

    #5.
    public function store(MLProyectoFormRequest $request)
    {
        try 
        {
            $proyecto               =   new MLProyecto;
            $proyecto->razonSocial  =   $request->get('razon_social');
            $proyecto->ruc          =   $request->get('ruc');
            $proyecto->direccion    =   $request->get('direccion');
            $proyecto->periodoInicio=   $request->get('inicio');
            $proyecto->periodoFin   =   $request->get('termino');
            $proyecto->Fin          =   $request->get('fin');
            $proyecto->Proposito    =   $request->get('proposito');
            $proyecto->save();

            #2. Retorno al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $proyecto->id,
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
        $data       =   MLProyecto::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function edit($id)
    {
        $proyecto       =   MLProyecto::findOrFail($id);
        return view($this->path.'.edit', compact('proyecto'));
    }

    #8
    public function update(MLProyectoFormRequest $request, $id)
    {
        try 
        {
            $proyecto               =   MLProyecto::findOrFail($id);
            $proyecto->razonSocial  =   $request->get('razon_social');
            $proyecto->ruc          =   $request->get('ruc');
            $proyecto->direccion    =   $request->get('direccion');
            $proyecto->periodoInicio=   $request->get('inicio');
            $proyecto->periodoFin   =   $request->get('termino');
            $proyecto->Fin          =   $request->get('fin');
            $proyecto->Proposito    =   $request->get('proposito');
            $proyecto->update();

            #2. Retorno al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $proyecto->id,
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
