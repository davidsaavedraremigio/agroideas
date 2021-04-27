<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\PostulanteProductoEspecificoFormRequest;
use App\PostulanteProductoEspecifico;
use App\SectorProductivo;
use App\LineaProductiva;
use App\CadenaProductiva;
use App\Producto;
use App\Postulante;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class PostulanteProductoEspecificoController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.producto-especifico';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        $postulante     =   Postulante::findOrFail($id);
        $cadenas        =   CadenaProductiva::getData();
        $tipoProduccion =   TablaValor::getDetalleTabla('TipoProduccion');
        
        return view($this->path.'.create', compact('postulante', 'cadenas', 'tipoProduccion'));
    }

    #4
    public function store(PostulanteProductoEspecificoFormRequest $request)
    {
        try 
        {
            $producto                   =   new PostulanteProductoEspecifico;
            $producto->codPostulante    =   $request->get('codigo');
            $producto->codProducto      =   $request->get('producto');
            $producto->nroHas           =   $request->get('hectareas');
            $producto->nroProductores   =   $request->get('productores');
            $producto->tipoProduccion   =   $request->get('tipo_produccion');
            $producto->principal        =   $request->get('principal');
            $producto->variedad         =   $request->get('variedad');
            $producto->etapa            =   1;
            $producto->created_auth     =   Auth::user()->id;
            $producto->updated_auth     =   Auth::user()->id;
            $producto->save();

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
        $data       =   PostulanteProductoEspecifico::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $producto           =   PostulanteProductoEspecifico::findOrFail($id);
        $cadenas            =   CadenaProductiva::getData();
        $tipoProduccion     =   TablaValor::getDetalleTabla('TipoProduccion');
        $productoEspecifico =   Producto::findOrFail($producto->codProducto);
        $productos          =   Producto::getProducto($productoEspecifico->maestroCadenaID);

        return view($this->path.'.edit', compact('producto', 'cadenas', 'tipoProduccion', 'productos', 'productoEspecifico'));
    }

    #7. 
    public function update(PostulanteProductoEspecificoFormRequest $request, $id)
    {
        try 
        {
            $producto                   =   PostulanteProductoEspecifico::findOrFail($id);
            $producto->codProducto      =   $request->get('producto');
            $producto->nroHas           =   $request->get('hectareas');
            $producto->nroProductores   =   $request->get('productores');
            $producto->tipoProduccion   =   $request->get('tipo_produccion');
            $producto->principal        =   $request->get('principal');
            $producto->variedad         =   $request->get('variedad');
            $producto->updated_auth     =   Auth::user()->id;
            $producto->update();

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
        //
    }
}
