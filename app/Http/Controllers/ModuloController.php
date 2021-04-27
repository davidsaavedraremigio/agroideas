<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ModuloFormRequest;
use App\Menu;
use Carbon\Carbon;
use DB;
use Auth;

class ModuloController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='admin.modulo';
    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }
    #3. Muestro el menú principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para la creación de nuevos registros
    public function create()
    {
        return view($this->path.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuloFormRequest $request)
    {
        try 
        {
            $modulo             =   new Menu;
            $modulo->nombre     =   $request->get('nombre');
            $modulo->ruta       =   '';
            $modulo->icono      =   $request->get('icono');
            $modulo->parent     =   0;
            $modulo->orden      =   $request->get('orden');
            $modulo->estado     =   1;
            $modulo->descripcion=   $request->get('descripcion');
            $modulo->save();

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

    #6. Muestro la relación de registros
    public function show()
    {
        $modulos     =   Menu::getModulos();
        return view($this->path.'.data', compact('modulos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modulo     =   Menu::findOrFail($id);
        return view($this->path.'.edit', compact('modulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuloFormRequest $request, $id)
    {
        try 
        {
            $modulo     =   Menu::findOrFail($id);
            $modulo->nombre     =   $request->get('nombre');
            $modulo->icono      =   $request->get('icono');
            $modulo->orden      =   $request->get('orden');
            $modulo->descripcion=   $request->get('descripcion');
            $modulo->update();

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
            $modulo             =   Menu::findOrFail($id);
            $modulo->estado     =   0;
            $modulo->update();

            return response()->json([
                'estado'        =>  '1',
                'dato'          =>  '',
                'mensaje'       =>  'La información se procesó de manera exitosa.'
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
