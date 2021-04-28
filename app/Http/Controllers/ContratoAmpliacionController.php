<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ContratoAmpliacionFormRequest;
use App\Contrato;
use App\ContratoAmpliacion;
use App\Postulante;
use App\Proyecto;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;


class ContratoAmpliacionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.convenio-ampliacion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Muestro el formulario para generar una adenda
    public function create($id)
    {
        #1. Obtengo los datos requeridos
        $contrato           =   Contrato::findOrFail($id);
        $postulante         =   Postulante::findOrFail($contrato->codPostulante);
        $proyecto           =   Proyecto::where('codPostulante', $postulante->id)->first();
        $tipo               =   TablaValor::getDetalleTabla('TipoAmpliacion');
        #2. Retorno al formulario 
        return view($this->path.'.create', compact('contrato', 'postulante', 'proyecto', 'tipo'));
    }

    #4. Genero la adenda al contrato
    public function store(ContratoAmpliacionFormRequest $request)
    {        
        #1. Genero una ampliación al contrato
        try 
        {
            $ampliacion                     =   new ContratoAmpliacion;
            $ampliacion->codInicContrato    =   $request->get('codigo');
            $ampliacion->numero             =   $request->get('nro_ampliacion');
            $ampliacion->fecha_firma        =   $request->get('fecha_ampliacion');
            $ampliacion->cod_tipo           =   $request->get('tipo');
            $ampliacion->objetivo           =   $request->get('objetivo');
            $ampliacion->fecha_termino      =   Carbon::parse($request->get('fecha_ampliacion'))->addMonths($request->get('meses'));
            $ampliacion->created_auth       =   Auth::user()->id;
            $ampliacion->updated_auth       =   Auth::user()->id;
            $ampliacion->save();

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

    #5. Muestro las adendas generadas para un determinado contrato
    public function show($id)
    {
        return view($this->path.'.data');
    }

    #6.
    public function edit($id)
    {
        //
    }

    #7.
    public function update(Request $request, $id)
    {
        //
    }

    #8.
    public function destroy($id)
    {
        //
    }
}
