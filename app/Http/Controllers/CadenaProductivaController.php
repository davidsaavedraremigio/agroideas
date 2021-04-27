<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CadenaProductivaFormRequest;
use App\SectorProductivo;
use App\LineaProductiva;
use App\CadenaProductiva;
use Carbon\Carbon;
use DB;
use Auth;

class CadenaProductivaController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='admin.cadena';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3. Muestro el panel principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para el registro de nuevos registros
    public function create()
    {
        $sectores   =   SectorProductivo::getData();
        $lineas     =   LineaProductiva::getData();
        return view($this->path.'.create', compact('sectores', 'lineas'));
    }

    #5. Guardo la información
    public function store(CadenaProductivaFormRequest $request)
    {
        try 
        {
            $cadena                             =   new CadenaProductiva;
            $cadena->maestroLineaID             =   $request->get('linea');
            $cadena->descripcion                =   $request->get('descripcion');
            $cadena->icono                      =   $request->get('icono');
            $cadena->potencialAgroexportador    =   $request->get('agroexportacion');
            $cadena->save();

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

    #6. Muestro los registros generados
    public function show()
    {
        $data       =   CadenaProductiva::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro el formulario de edicion
    public function edit($id)
    {
        $cadena         =   CadenaProductiva::findOrFail($id);
        $lineas         =   LineaProductiva::getData();
        $sectores       =   SectorProductivo::getData();

        return view($this->path.'.edit', compact('cadena', 'lineas', 'sectores'));
    }

    #8. Actualizo los registros
    public function update(CadenaProductivaFormRequest $request, $id)
    {
        try 
        {
            $cadena                             =   CadenaProductiva::findOrFail($id);
            $cadena->maestroLineaID             =   $request->get('linea');
            $cadena->descripcion                =   $request->get('descripcion');
            $cadena->icono                      =   $request->get('icono');
            $cadena->potencialAgroexportador    =   $request->get('agroexportacion');
            $cadena->update();

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

    #9. Elimino el registro generado
    public function destroy($id)
    {
        try 
        {
            $cadena =   CadenaProductiva::find($id);
            $cadena->delete();

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

    #10. Obtengo las cadena productivas correspondientes a una linea
    public function obtieneCadenas($id)
    {
        $cadenas    =   CadenaProductiva::getCadenaProductiva($id);
        return response()->json($cadenas);
    }
}
