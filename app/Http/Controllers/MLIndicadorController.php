<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\MLIndicadorFormRequest;
use App\MLProyecto;
use App\MLResultado;
use App\MLIndicador;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class MLIndicadorController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proyecto.indicador';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $proyecto       =   MLProyecto::findOrFail($id);
        $tipo           =   'C';
        $componentes    =   MLResultado::getData($id, $tipo);
        $unidades       =   TablaValor::getDetalleTabla('Unidad');
        return view($this->path.'.create', compact('proyecto', 'componentes', 'unidades'));
    }

    #4. 
    public function store(MLIndicadorFormRequest $request)
    {
        try 
        {
            $indicador                      =   new MLIndicador;
            $indicador->codigo              =   $request->get('codigo');
            $indicador->orden               =   $request->get('nro_orden');
            $indicador->descripcion         =   $request->get('descripcion');
            $indicador->unidadMedidaID      =   $request->get('unidad');
            $indicador->referenciaID        =   $request->get('componente');
            $indicador->medioVerificacion   =   $request->get('medio_verificacion');
            $indicador->supuestos           =   $request->get('supuestos');
            $indicador->frecuenciaMedicion  =   $request->get('frecuencia');
            $indicador->procedimientoFormula=   $request->get('formula');
            $indicador->valorLineaBase      =   0;
            $indicador->valorMeta           =   0;
            $indicador->valorLineaCierre    =   0;
            $indicador->save();
            
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

    #5.
    public function show($id)
    {
        $tipo       =   'C';
        $data       =   MLIndicador::getData($id, $tipo);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $indicador      =   MLIndicador::findOrFail($id);
        $tipo           =   'C';
        $componente     =   MLResultado::findOrFail($indicador->referenciaID);
        $proyecto       =   MLProyecto::findOrFail($componente->SYSProyectoID);
        $componentes    =   MLResultado::getData($proyecto->id, $tipo);
        $unidades       =   TablaValor::getDetalleTabla('Unidad');

        return view($this->path.'.edit', compact('indicador', 'componentes', 'unidades'));
    }

    #7.
    public function update(MLIndicadorFormRequest $request, $id)
    {
        try 
        {
            $indicador                      =   MLIndicador::findOrFail($id);
            $indicador->codigo              =   $request->get('codigo');
            $indicador->orden               =   $request->get('nro_orden');
            $indicador->descripcion         =   $request->get('descripcion');
            $indicador->unidadMedidaID      =   $request->get('unidad');
            $indicador->referenciaID        =   $request->get('componente');
            $indicador->medioVerificacion   =   $request->get('medio_verificacion');
            $indicador->supuestos           =   $request->get('supuestos');
            $indicador->frecuenciaMedicion  =   $request->get('frecuencia');
            $indicador->procedimientoFormula=   $request->get('formula');
            $indicador->valorLineaBase      =   0;
            $indicador->valorMeta           =   0;
            $indicador->valorLineaCierre    =   0;
            $indicador->update();

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
