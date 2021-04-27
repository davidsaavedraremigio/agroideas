<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CapacitacionFormRequest;
use App\Usuario;
use App\Capacitacion;
use App\CapacitacionPoa;
use App\TablaValor;
use App\Ubigeo;
use App\ActividadOperativa;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;


class CapacitacionController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.capacitacion';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Retorno al menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para nuevos registros
    public function create()
    {
        #1. Obtengo los datos de los combos
        $tipoEvento     =   TablaValor::getDetalleTabla('TipoEventoCapacitacion');
        $tematica       =   TablaValor::getDetalleTabla('TematicaCapacitacion');
        $organizacion   =   TablaValor::getDetalleTabla('OrganizacionEvento');
        $regiones       =   Ubigeo::getRegiones();
        $personal       =   Usuario::getData();
        $fechaMinima    =   '2021-01-01';
        $fechaMaxima    =   '2021-12-31';
        $poa            =   ActividadOperativa::getDataAll();
        #2. Retorno al formulario
        return view($this->path.'.create', compact('tipoEvento', 'tematica', 'regiones', 'personal', 'fechaMinima', 'fechaMaxima', 'poa', 'organizacion'));
    }

    #5. Guardo la información
    public function store(CapacitacionFormRequest $request)
    {
        try 
        {
            $capacitacion                   =   new Capacitacion;
            $capacitacion->ubigeo           =   $request->get('distrito');
            $capacitacion->codTipo          =   $request->get('tipo_evento');
            $capacitacion->codTematica      =   $request->get('tematica');
            $capacitacion->nombre           =   $request->get('nombre');
            $capacitacion->codResponsable   =   $request->get('responsable');
            $capacitacion->fecha            =   $request->get('fecha');
            $capacitacion->objetivo         =   $request->get('objetivo');
            $capacitacion->agenda           =   $request->get('agenda');
            $capacitacion->participantes    =   $request->get('nro_participantes');
            $capacitacion->lugar            =   $request->get('lugar');
            $capacitacion->importe          =   $request->get('importe');
            $capacitacion->horas            =   $request->get('horas');
            $capacitacion->codOrganizacion  =   $request->get('organizacion');
            $capacitacion->codEstado        =   1;
            $capacitacion->created_auth     =   Auth::user()->id;
            $capacitacion->updated_auth     =   Auth::user()->id;
            $capacitacion->save();

            #2. Guardo la información de la afectación presupuestal
            try 
            {
                $poa                        =   new CapacitacionPoa;
                $poa->codInicCapacitacion   =   $capacitacion->id;
                $poa->poaa_id               =   $request->get('actividad_operativa');
                $poa->estado                =   1;
                $poa->created_auth          =   Auth::user()->id;
                $poa->updated_auth          =   Auth::user()->id;
                $poa->save();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $capacitacion->id,
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

    #6. Muestro la información generada
    public function show()
    {
        $data       =   Capacitacion::getData();
        #2. Retorno a la vista de datos
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro el formulario para la edición de la información
    public function edit($id)
    {
        #1. Obtengo la información consultada
        $capacitacion   =   Capacitacion::findOrFail($id);
        $actividad      =   CapacitacionPoa::where('codInicCapacitacion', $capacitacion->id)->first();
        $tipoEvento     =   TablaValor::getDetalleTabla('TipoEventoCapacitacion');
        $tematica       =   TablaValor::getDetalleTabla('TematicaCapacitacion');
        $organizacion   =   TablaValor::getDetalleTabla('OrganizacionEvento');
        $regiones       =   Ubigeo::getRegiones();
        $provincias     =   Ubigeo::getProvincias(Str::substr($capacitacion->ubigeo, 0, 2));
        $distritos      =   Ubigeo::getDistritos(Str::substr($capacitacion->ubigeo, 0, 4));
        $personal       =   Usuario::getData();
        $fechaMinima    =   '2021-01-01';
        $fechaMaxima    =   '2021-12-31';        
        $poa            =   ActividadOperativa::getDataAll();   

        #2. Retorno la información al formulario de edicion
        return view($this->path.'.edit', compact('capacitacion', 'actividad', 'tipoEvento', 'tematica', 'regiones', 'provincias', 'distritos', 'personal', 'fechaMinima', 'fechaMaxima', 'poa', 'organizacion'));
    }

    #8. Actualizo la información solicitada
    public function update(CapacitacionFormRequest $request, $id)
    {
        try 
        {
            $capacitacion                   =   Capacitacion::findOrFail($id);
            $capacitacion->ubigeo           =   $request->get('distrito');
            $capacitacion->codTipo          =   $request->get('tipo_evento');
            $capacitacion->codTematica      =   $request->get('tematica');
            $capacitacion->nombre           =   $request->get('nombre');
            $capacitacion->codResponsable   =   $request->get('responsable');
            $capacitacion->fecha            =   $request->get('fecha');
            $capacitacion->objetivo         =   $request->get('objetivo');
            $capacitacion->agenda           =   $request->get('agenda');
            $capacitacion->participantes    =   $request->get('nro_participantes');
            $capacitacion->lugar            =   $request->get('lugar');
            $capacitacion->importe          =   $request->get('importe');
            $capacitacion->horas            =   $request->get('horas');
            $capacitacion->codOrganizacion  =   $request->get('organizacion');
            $capacitacion->updated_auth     =   Auth::user()->id;
            $capacitacion->update();

            #2. Actualizo la información de la afectación presupuestal
            try 
            {
                $poa                        =   CapacitacionPoa::where('codInicCapacitacion', $id)->first();
                $poa->poaa_id               =   $request->get('actividad_operativa');
                $poa->updated_auth          =   Auth::user()->id;
                $poa->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $capacitacion->id,
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
