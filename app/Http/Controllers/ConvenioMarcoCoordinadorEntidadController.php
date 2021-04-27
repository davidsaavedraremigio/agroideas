<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoCoordinadorEntidadFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoCoordinadorEntidad;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioMarcoCoordinadorEntidadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-coordinador-entidad';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        return view($this->path.'.create', compact('convenio'));
    }

    #4.
    public function store(ConvenioMarcoCoordinadorEntidadFormRequest $request)
    {
        try 
        {
            $coordinador                        =   new ConvenioMarcoCoordinadorEntidad;
            $coordinador->nro_documento         =   $request->get('dni');
            $coordinador->nombres               =   $request->get('nombres');
            $coordinador->paterno               =   $request->get('paterno');
            $coordinador->materno               =   $request->get('materno');
            $coordinador->cargo                 =   $request->get('cargo');
            $coordinador->tipo                  =   $request->get('tipo');
            $coordinador->referencia            =   $request->get('referencia');
            $coordinador->codInicConvenioMarco  =   $request->get('codigo');
            $coordinador->estado                =   1;
            $coordinador->fecha_referencia      =   $request->get('fecha');
            $coordinador->created_auth          =   Auth::user()->id;  
            $coordinador->updated_auth          =   Auth::user()->id;  
            $coordinador->save();

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
        $data       =   ConvenioMarcoCoordinadorEntidad::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $coordinador        =   ConvenioMarcoCoordinadorEntidad::findOrFail($id);
        $convenio           =   ConvenioMarco::findOrFail($coordinador->codInicConvenioMarco);
        return view($this->path.'.edit', compact('coordinador', 'convenio'));
    }

    #7.
    public function update(ConvenioMarcoCoordinadorEntidadFormRequest $request, $id)
    {
        try 
        {
            $coordinador                        =   ConvenioMarcoCoordinadorEntidad::findOrFail($id);
            $coordinador->nro_documento         =   $request->get('dni');
            $coordinador->nombres               =   $request->get('nombres');
            $coordinador->paterno               =   $request->get('paterno');
            $coordinador->materno               =   $request->get('materno');
            $coordinador->cargo                 =   $request->get('cargo');
            $coordinador->tipo                  =   $request->get('tipo');
            $coordinador->referencia            =   $request->get('referencia');
            $coordinador->fecha_referencia      =   $request->get('fecha');
            $coordinador->updated_auth          =   Auth::user()->id;  
            $coordinador->update();

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
            $coordinador            =   ConvenioMarcoCoordinadorEntidad::findOrFail($id);
            $cooordinador->estado   =   0;
            $coordinador->save();

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
