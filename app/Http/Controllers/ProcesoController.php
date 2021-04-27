<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProcesoFormRequest;
use App\Menu;
use Carbon\Carbon;
use DB;
use Auth;

class ProcesoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.proceso';
    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->path.'.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos    =  Menu::where('parent', 0)
                        ->orderBy('nombre', 'asc')
                        ->get();
        return view($this->path.'.create', compact('modulos')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcesoFormRequest $request)
    {
        try 
        {
            $proceso                =   new Menu;
            $proceso->nombre        =   $request->get('nombre');
            $proceso->ruta          =   $request->get('ruta');
            $proceso->icono         =   $request->get('icono');
            $proceso->parent        =   $request->get('parent');
            $proceso->orden         =   $request->get('orden');
            $proceso->descripcion   =   $request->get('descripcion');
            $proceso->save();

            #2. Retorno al servidor principal
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $procesos   =   Menu::getProcesos();
        return view($this->path.'.data', compact('procesos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modulos    =  Menu::where('parent', 0)
                        ->orderBy('nombre', 'asc')
                        ->get();
        $proceso    =   Menu::findOrFail($id);
        return view($this->path.'.edit', compact('proceso', 'modulos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcesoFormRequest $request, $id)
    {    
        try 
        {
            $proceso                =   Menu::findOrFail($id);
            $proceso->nombre        =   $request->get('nombre');
            $proceso->ruta          =   $request->get('ruta');
            $proceso->icono         =   $request->get('icono');
            $proceso->parent        =   $request->get('parent');
            $proceso->orden         =   $request->get('orden');
            $proceso->descripcion   =   $request->get('descripcion');
            $proceso->update();

            #2. Retorno al servidor principal
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $proceso            =   Menu::findOrFail($id);
            $proceso->estado    =   0;
            $proceso->update();

            #2. Retorno al servidor principal
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
