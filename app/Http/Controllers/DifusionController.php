<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\DifusionFormRequest;
use App\Usuario;
use App\Difusion;
use App\DifusionPoa;
use App\TablaValor;
use App\Ubigeo;
use App\ActividadOperativa;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class DifusionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.difusion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. 
    public function create()
    {
        #1. Obtengo los datos de los combos
        $regiones       =   Ubigeo::getRegiones();
        $personal       =   Usuario::getData();
        $fechaMinima    =   '2021-01-01';
        $fechaMaxima    =   '2021-12-31';
        $poa            =   ActividadOperativa::getDataAll();
        #2. Retorno al formulario
        return view($this->path.'.create', compact('regiones', 'personal', 'fechaMinima', 'fechaMaxima', 'poa'));
    }

    #5.
    public function store(DifusionFormRequest $request)
    {
        try 
        {
            $difusion                       =   new Difusion;
            $difusion->ubigeo               =   $request->get('distrito');
            $difusion->codTipo              =   $request->get('tipo_evento');
            $difusion->nombre               =   $request->get('nombre');
            $difusion->codResponsable       =   $request->get('responsable');
            $difusion->fecha                =   $request->get('fecha');
            $difusion->objetivo             =   $request->get('objetivo');
            $difusion->nro_participantes    =   $request->get('nro_participantes');
            $difusion->lugar                =   $request->get('lugar');
            $difusion->importe              =   $request->get('importe');
            $difusion->horas                =   $request->get('horas');
            $difusion->codEstado            =   1;
            $difusion->created_auth         =   Auth::user()->id;
            $difusion->updated_auth         =   Auth::user()->id;
            $difusion->save();

            #2. Guardo la información de la afectación presupuestal
            try 
            {
                $poa                        =   new DifusionPoa;
                $poa->codInicDifusion       =   $difusion->id;
                $poa->poa_id                =   $request->get('actividad_operativa');
                $poa->estado                =   1;
                $poa->created_auth          =   Auth::user()->id;
                $poa->updated_auth          =   Auth::user()->id;
                $poa->save();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $difusion->id,
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

    #6.
    public function show()
    {
        $data       =   Difusion::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        #1. Obtengo la información consultada
        $difusion       =   Difusion::findOrFail($id);
        $actividad      =   DifusionPoa::where('codInicDifusion', $difusion->id)->first();
        $regiones       =   Ubigeo::getRegiones();
        $provincias     =   Ubigeo::getProvincias(Str::substr($difusion->ubigeo, 0, 2));
        $distritos      =   Ubigeo::getDistritos(Str::substr($difusion->ubigeo, 0, 4));
        $personal       =   Usuario::getData();
        $fechaMinima    =   '2021-01-01';
        $fechaMaxima    =   '2021-12-31';        
        $poa            =   ActividadOperativa::getDataAll();

        #2. Retorno la información al formulario de edicion
        return view($this->path.'.edit', compact('difusion', 'actividad', 'regiones', 'provincias', 'distritos', 'personal', 'fechaMinima', 'fechaMaxima', 'poa'));
    }

    #8.
    public function update(DifusionFormRequest $request, $id)
    {
        try 
        {
            $difusion                       =   Difusion::findOrFail($id);
            $difusion->ubigeo               =   $request->get('distrito');
            $difusion->codTipo              =   $request->get('tipo_evento');
            $difusion->nombre               =   $request->get('nombre');
            $difusion->codResponsable       =   $request->get('responsable');
            $difusion->fecha                =   $request->get('fecha');
            $difusion->objetivo             =   $request->get('objetivo');
            $difusion->nro_participantes    =   $request->get('nro_participantes');
            $difusion->lugar                =   $request->get('lugar');
            $difusion->importe              =   $request->get('importe');
            $difusion->horas                =   $request->get('horas');
            $difusion->updated_auth         =   Auth::user()->id;
            $difusion->update();

            #2. Actualizo la información de la afectación presupuestal
            try 
            {
                $poa                        =   DifusionPoa::where('codInicDifusion', $id)->first();
                $poa->poa_id                =   $request->get('actividad_operativa');
                $poa->updated_auth          =   Auth::user()->id;
                $poa->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $difusion->id,
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

}
