<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoImplementacionFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoCompromiso;
use App\ConvenioMarcoImplementacion;
use Carbon\Carbon;
use DB;
use Auth;


class ConvenioMarcoImplementacionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-implementacion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        $compromisos    =   ConvenioMarcoCompromiso::getData($id);

        return view($this->path.'.create', compact('convenio', 'compromisos'));
    }

    #4.
    public function store(ConvenioMarcoImplementacionFormRequest $request)
    {
        try 
        {
            $implementacion                         =   new ConvenioMarcoImplementacion;
            $implementacion->codInicCompromiso      =   $request->get('compromiso');
            $implementacion->fecha                  =   $request->get('date');
            $implementacion->resultados             =   $request->get('resultados');
            $implementacion->dificultades           =   $request->get('dificultades');
            $implementacion->recomendaciones        =   $request->get('recomendaciones');
            $implementacion->estado                 =   1;
            $implementacion->created_auth           =   Auth::user()->id;  
            $implementacion->updated_auth           =   Auth::user()->id;
            $implementacion->save();

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
        $data       =   ConvenioMarcoImplementacion::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $implementacion         =   ConvenioMarcoImplementacion::findOrFail($id);
        $compromiso             =   ConvenioMarcoCompromiso::findOrFail($implementacion->codInicCompromiso);
        $compromisos            =   ConvenioMarcoCompromiso::getData($compromiso->codInicConvenioMarco);
        
        return view($this->path.'.edit', compact('implementacion', 'compromiso', 'compromisos'));
    }

    #7.
    public function update(ConvenioMarcoImplementacionFormRequest $request, $id)
    {
        //
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
