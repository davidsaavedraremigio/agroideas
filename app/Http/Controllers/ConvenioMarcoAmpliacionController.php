<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoAmpliacionFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoAmpliacion;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioMarcoAmpliacionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-ampliacion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. 
    public function create($id)
    {
        #1. Obtengo las variables requeridas
        $convenio       =   ConvenioMarco::findOrFail($id);
        $tipo           =   TablaValor::getDetalleTabla('TipoAmpliacion');

        #2. Retorno al formulario para el registro de nuevas ampliacion
        return view($this->path.'.create', compact('convenio', 'tipo'));
    }

    #4.
    public function store(ConvenioMarcoAmpliacionFormRequest $request)
    {
        #1. Genero la ampliación
        try 
        {
            $ampliacion                         =   new ConvenioMarcoAmpliacion;
            $ampliacion->codInicConvenioMarco   =   $request->get('codigo');
            $ampliacion->numero                 =   $request->get('numero');
            $ampliacion->fecha_firma            =   $request->get('fecha');
            $ampliacion->cod_tipo               =   $request->get('tipo');
            $ampliacion->objetivo               =   $request->get('objetivo');
            $ampliacion->fecha_termino          =   $request->get('termino');
            $ampliacion->created_auth           =   Auth::user()->id;
            $ampliacion->updated_auth           =   Auth::user()->id;
            $ampliacion->save();

            #2. Actualizo la fecha de Término del contrato
            try 
            {
                #1. Obtengo la diferencia entre dos meses

                $convenio                       =   ConvenioMarco::findOrFail($ampliacion->codInicConvenioMarco);
                $convenio->fecha_termino        =   $request->get('termino');
                $convenio->duracion             =   Carbon::parse($convenio->fecha_firma)->diffInMonths(Carbon::parse($request->get('termino')));
                $convenio->updated_auth         =   Auth::user()->id;
                $convenio->update();

                #2. Retorno al formulario para la edición de registris
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #5. obtengo los registros generados
    public function show($id)
    {
        $data       =   ConvenioMarcoAmpliacion::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $ampliacion     =   ConvenioMarcoAmpliacion::findOrFail($id);
        $tipo           =   TablaValor::getDetalleTabla('TipoAmpliacion');

        #2. Retorno al formulario de edicion
        return view($this->path.'.edit', compact('ampliacion', 'tipo'));
    }

    #7.
    public function update(ConvenioMarcoAmpliacionFormRequest $request, $id)
    {
        try 
        {
            $ampliacion                 =   ConvenioMarcoAmpliacion::findOrFail($id);
            $ampliacion->numero         =   $request->get('numero');
            $ampliacion->fecha_firma    =   $request->get('fecha');
            $ampliacion->cod_tipo       =   $request->get('tipo');
            $ampliacion->objetivo       =   $request->get('objetivo');
            $ampliacion->fecha_termino  =   $request->get('termino');
            $ampliacion->updated_auth   =   Auth::user()->id;
            $ampliacion->update();

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
        try 
        {
            $ampliacion         =   ConvenioMarcoAmpliacion::find($id);
            $ampliacion->delete();

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
}
