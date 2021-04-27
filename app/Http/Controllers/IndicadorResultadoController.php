<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\IndicadorResultadoFormRequest;
use App\IndicadorResultado;
use App\CadenaProductiva;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class IndicadorResultadoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.indicador-resultado';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3. Mostramos el menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. 
    public function create()
    {
        $tipo_indicador =   TablaValor::getDetalleTabla('TipoIndicadorResultado');
        $unidades       =   TablaValor::getDetalleTabla('Unidad');
        return view($this->path.'.create', compact('tipo_indicador', 'unidades'));
    }

    #5.
    public function store(IndicadorResultadoFormRequest $request)
    {
        try 
        {
            $indicador                      =   new IndicadorResultado;
            $indicador->codTipo             =   $request->get('tipo');
            $indicador->descripcion         =   $request->get('descripcion');
            $indicador->codUnidadMedida     =   $request->get('unidad');
            $indicador->medioVerificacion   =   $request->get('medio_verificacion');
            $indicador->supuestos           =   $request->get('supuestos');
            $indicador->metodoCalculo       =   $request->get('metodo_calculo');
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

    #6.
    public function show()
    {
        $data   =   IndicadorResultado::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        $indicador      =   IndicadorResultado::findOrFail($id);
        $tipo_indicador =   TablaValor::getDetalleTabla('TipoIndicadorResultado');
        $unidades       =   TablaValor::getDetalleTabla('Unidad');

        return view($this->path.'.edit', compact('indicador', 'tipo_indicador', 'unidades'));
    }

    #8.
    public function update(IndicadorResultadoFormRequest $request, $id)
    {
        try
        {
            $indicador                      =   IndicadorResultado::findOrFail($id);
            $indicador->codTipo             =   $request->get('tipo');
            $indicador->descripcion         =   $request->get('descripcion');
            $indicador->codUnidadMedida     =   $request->get('unidad');
            $indicador->medioVerificacion   =   $request->get('medio_verificacion');
            $indicador->supuestos           =   $request->get('supuestos');
            $indicador->metodoCalculo       =   $request->get('metodo_calculo');
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

    #9.
    public function destroy($id)
    {
        //3
    }
}
