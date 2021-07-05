<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioActividadProgramacionFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoCompromiso;
use App\ConvenioActividadProgramacion;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioActividadProgramacionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-actividad-programacion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        $compromisos    =   ConvenioMarcoCompromiso::getData($convenio->id);

        return view($this->path.'.create', compact('convenio', 'compromisos'));
    }

    #4.
    public function store(ConvenioActividadProgramacionFormRequest $request)
    {
        try 
        {
            $actividad                                      =   new ConvenioActividadProgramacion;
            $actividad->codInicConvenioMarcoCompromiso      =   $request->get('compromiso');
            $actividad->nombreActividad                     =   $request->get('actividad');
            $actividad->descripcion                         =   $request->get('descripcion');
            $actividad->metaFisica                          =   $request->get('meta_fisica');
            $actividad->fechaLimite                         =   $request->get('fecha_limite');
            $actividad->estadoImplementacion                =   1;
            $actividad->estado                              =   1;
            $actividad->created_auth                        =   Auth::user()->id; 
            $actividad->created_at                          =   Carbon::now();
            $actividad->save();

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
        $data   =   ConvenioActividadProgramacion::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $actividad          =   ConvenioActividadProgramacion::findOrFail($id);
        $compromiso         =   ConvenioMarcoCompromiso::findOrFail($actividad->codInicConvenioMarcoCompromiso);
        $convenio           =   ConvenioMarco::findOrFail($compromiso->codInicConvenioMarco);
        $compromisos        =   ConvenioMarcoCompromiso::getData($convenio->id);

        return view($this->path.'.edit', compact('actividad', 'convenio', 'compromisos'));
    }

    #7.
    public function update(ConvenioActividadProgramacionFormRequest $request, $id)
    {
        try 
        {
            $actividad                                      =   ConvenioActividadProgramacion::findOrFail($id);
            $actividad->codInicConvenioMarcoCompromiso      =   $request->get('compromiso');
            $actividad->nombreActividad                     =   $request->get('actividad');
            $actividad->descripcion                         =   $request->get('descripcion');
            $actividad->metaFisica                          =   $request->get('meta_fisica');
            $actividad->fechaLimite                         =   $request->get('fecha_limite');
            $actividad->updated_auth                        =   Auth::user()->id; 
            $actividad->updated_at                          =   Carbon::now();
            $actividad->update();

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
            $actividad                  =   ConvenioActividadProgramacion::findOrFail($id);
            $actividad->estado          =   0;
            $actividad->updated_auth    =   Auth::user()->id; 
            $actividad->updated_at      =   Carbon::now();
            $actividad->update();

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
