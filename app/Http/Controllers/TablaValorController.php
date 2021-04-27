<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TablaValorFormRequest;
use App\Tabla;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class TablaValorController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.tabla-valor';
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
        $tablas     =   Tabla::where('estado', 1)
                            ->orderBy('nombre', 'asc')->get();
        return view($this->path.'.create', compact('tablas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TablaValorFormRequest $request)
    {
        try 
        {
            $variable                   =   new TablaValor;
            $variable->MaestroTablaID   =   $request->get('tabla');
            $variable->Nombre           =   $request->get('nombre');
            $variable->Valor            =   $request->get('valor');
            $variable->Orden            =   $request->get('orden');
            $variable->save();

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
        $data   =   TablaValor::getData();
        return view($this->path.'.data', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tablas     =   Tabla::where('estado', 1)
                            ->orderBy('nombre', 'asc')->get();
        $variable   =   TablaValor::findOrFail($id);
        return view($this->path.'.edit', compact('tablas', 'variable'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TablaValorFormRequest $request, $id)
    {
        try 
        {
            $variable                   =   TablaValor::findOrFail($id);
            $variable->MaestroTablaID   =   $request->get('tabla');
            $variable->Nombre           =   $request->get('nombre');
            $variable->Valor            =   $request->get('valor');
            $variable->Orden            =   $request->get('orden');
            $variable->update();

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
            $variable   =   TablaValor::find($id);
            $variable->delete();

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
