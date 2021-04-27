<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\MLIndicadorActividadFormRequest;
use App\MLProyecto;
use App\MLResultado;
use App\MLIndicador;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class MLIndicadorActividadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proyecto.indicador-actividad';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $proyecto       =   MLProyecto::findOrFail($id);
        $tipo           =   'A';
        $actividades    =   MLResultado::getData($id, $tipo);
        $unidades       =   TablaValor::getDetalleTabla('Unidad');
        return view($this->path.'.create', compact('proyecto', 'actividades', 'unidades'));
    }

    #4.
    public function store(MLIndicadorActividadFormRequest $request)
    {
        try 
        {
            $indicador                      =   new MLIndicador;
            $indicador->codigo              =   $request->get('codigo');
            $indicador->orden               =   $request->get('nro_orden');
            $indicador->descripcion         =   $request->get('descripcion');
            $indicador->unidadMedidaID      =   $request->get('unidad');
            $indicador->referenciaID        =   $request->get('actividad');
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
        $tipo       =   'A';
        $data       =   MLIndicador::getData($id, $tipo);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $indicador      =   MLIndicador::findOrFail($id);
        $tipo           =   'A';
        $actividad      =   MLResultado::findOrFail($indicador->referenciaID);
        $proyecto       =   MLProyecto::findOrFail($actividad->SYSProyectoID);
        $actividades    =   MLResultado::getData($proyecto->id, $tipo);
        $unidades       =   TablaValor::getDetalleTabla('Unidad');

        return view($this->path.'.edit', compact('indicador', 'actividades', 'unidades'));
    }

    #7.
    public function update(MLIndicadorActividadFormRequest $request, $id)
    {
        try 
        {
            $indicador                      =   MLIndicador::findOrFail($id);
            $indicador->codigo              =   $request->get('codigo');
            $indicador->orden               =   $request->get('nro_orden');
            $indicador->descripcion         =   $request->get('descripcion');
            $indicador->unidadMedidaID      =   $request->get('unidad');
            $indicador->referenciaID        =   $request->get('actividad');
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

    #8.
    public function destroy($id)
    {
        //
    }
}
