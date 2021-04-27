<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoCoordinadorFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoCoordinador;
use App\Usuario;
use Carbon\Carbon;
use DB;
use Auth;


class ConvenioMarcoCoordinadorController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-coordinador-pcc';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        $personal       =   Usuario::getData();

        return view($this->path.'.create', compact('convenio', 'personal'));
    }

    #4.
    public function store(ConvenioMarcoCoordinadorFormRequest $request)
    {
        try 
        {
            $coordinador                        =   new ConvenioMarcoCoordinador;
            $coordinador->codPersonal           =   $request->get('personal');
            $coordinador->tipo                  =   $request->get('tipo');
            $coordinador->codInicConvenioMarco  =   $request->get('codigo');
            $coordinador->referencia            =   $request->get('referencia');
            $coordinador->fecha_referencia      =   $request->get('fecha');
            $coordinador->estado                =   1;
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
        $data       =   ConvenioMarcoCoordinador::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $coordinador        =   ConvenioMarcoCoordinador::findOrFail($id);
        $convenio           =   ConvenioMarco::findOrFail($coordinador->codInicConvenioMarco);
        $personal           =   Usuario::getData();

        return view($this->path.'.edit', compact('coordinador', 'convenio', 'personal'));
    }

    #7.
    public function update(ConvenioMarcoCoordinadorFormRequest $request, $id)
    {
        try 
        {
            $coordinador                        =   ConvenioMarcoCoordinador::findOrFail($id);
            $coordinador->codPersonal           =   $request->get('personal');
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
