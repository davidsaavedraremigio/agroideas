<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioActividadEjecucionFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoCompromiso;
use App\ConvenioActividadProgramacion;
use App\ConvenioActividadEjecucion;
use App\Usuario;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioActividadEjecucionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-actividad-ejecucion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        $actividades    =   ConvenioActividadProgramacion::getData($convenio->id);
        $personal       =   Usuario::getData();

        return view($this->path.'.create', compact('convenio', 'actividades', 'personal'));
    }

    #4.
    public function store(ConvenioActividadEjecucionFormRequest $request)
    {
        #1. Generamos un nuevo registro de avance
        try 
        {
            $ejecucion                              =   new ConvenioActividadEjecucion;
            $ejecucion->codActividadProgramacion    =   $request->get('actividad');
            $ejecucion->codResponsable              =   $request->get('responsable');
            $ejecucion->fecha                       =   $request->get('fecha');
            $ejecucion->metaEjecutada               =   $request->get('meta_ejecutada');
            $ejecucion->acciones                    =   $request->get('acciones');
            $ejecucion->estado                      =   1;
            $ejecucion->created_auth                =   Auth::user()->id; 
            $ejecucion->created_at                  =   Carbon::now();
            $ejecucion->save();

            #2. Actualizamos el estado situacional de la actividad
            try 
            {
                $actividad                          =   ConvenioActividadProgramacion::findOrFail($ejecucion->codActividadProgramacion);
                $actividad->estadoImplementacion    =   $request->get('situacion');
                $actividad->updated_auth            =   Auth::user()->id; 
                $actividad->updated_at              =   Carbon::now();
                $actividad->update();

                #3. Retorno al menu principal
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

    #5.
    public function show($id)
    {
        $data       =   ConvenioActividadEjecucion::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $ejecucion          =   ConvenioActividadEjecucion::findOrFail($id);
        $actividad          =   ConvenioActividadProgramacion::findOrFail($ejecucion->codActividadProgramacion);
        $compromiso         =   ConvenioMarcoCompromiso::findOrFail($actividad->codInicConvenioMarcoCompromiso);
        $convenio           =   ConvenioMarco::findOrFail($compromiso->codInicConvenioMarco);
        $actividades        =   ConvenioActividadProgramacion::getData($convenio->id);
        $personal           =   Usuario::getData();

        return view($this->path.'.edit', compact('ejecucion', 'actividades', 'personal', 'actividad', 'convenio'));
    }

    #7.
    public function update(ConvenioActividadEjecucionFormRequest $request, $id)
    {
        try 
        {
            $ejecucion                      =   ConvenioActividadEjecucion::findOrFail($id);
            $ejecucion->codResponsable      =   $request->get('responsable');
            $ejecucion->fecha               =   $request->get('fecha');
            $ejecucion->metaEjecutada       =   $request->get('meta_ejecutada');
            $ejecucion->acciones            =   $request->get('acciones');
            $ejecucion->updated_auth        =   Auth::user()->id; 
            $ejecucion->updated_at          =   Carbon::now();
            $ejecucion->update();

            #3. Retorno al menu principal
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
            $ejecucion                  =   ConvenioActividadEjecucion::findOrFail($id);
            $ejecucion->estado          =   0;
            $ejecucion->updated_auth    =   Auth::user()->id; 
            $ejecucion->updated_at      =   Carbon::now();
            $ejecucion->update();

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
