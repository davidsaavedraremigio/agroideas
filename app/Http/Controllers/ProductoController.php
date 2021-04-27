<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoFormRequest;
use App\SectorProductivo;
use App\LineaProductiva;
use App\CadenaProductiva;
use App\Producto;
use Carbon\Carbon;
use DB;
use Auth;

class ProductoController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='admin.producto';

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
        $cadenas        =   CadenaProductiva::getData();
        return view($this->path.'.create', compact('cadenas'));
    }

    #5.
    public function store(ProductoFormRequest $request)
    {
        try 
        {
            $producto                       =   new Producto;
            $producto->maestroCadenaID      =   $request->get('cadena');
            $producto->descripcion          =   $request->get('descripcion');
            $producto->save();

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

    #6. 
    public function show()
    {
        $data       =   Producto::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        $producto       =   Producto::findOrFail($id);
        $cadenas        =   CadenaProductiva::getData();
        return view($this->path.'.edit', compact('producto', 'cadenas'));
    }

    #8. 
    public function update(ProductoFormRequest $request, $id)
    {
        try 
        {
            $producto                       =   Producto::findOrFail($id);
            $producto->maestroCadenaID      =   $request->get('cadena');
            $producto->descripcion          =   $request->get('descripcion');
            $producto->update();

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

    #9.
    public function destroy($id)
    {
        try 
        {
            $producto       =   Producto::find($id);
            $producto->delete();

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

    #10. Obtengo la relación de Lineas productivas
    public function obtieneLinea($id)
    {
        $linea      =   LineaProductiva::getLineaProductiva($id);
        return response()->json($linea);
    }

    #11. Obtengo la relación de Cadenas productivas
    public function obtieneCadena($id)
    {
        $cadena     =  CadenaProductiva::getCadenaProductiva($id);
        return response()->json($cadena); 
    }

    #12. Obtengo la relación de Productos
    public function obtieneProducto($id)
    {
        $producto   =   Producto::getProducto($id);
        return response()->json($producto);
    }
}
