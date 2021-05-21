<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CapacitacionParticipanteFormRequest;
use App\CapacitacionParticipante;
use App\CapacitacionEjecucion;
use App\Capacitacion;
use App\CadenaProductiva;
use App\TablaValor;
use App\Entidad;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;


class CapacitacionParticipanteController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.capacitacion-participante';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Muestro el formulario para nuevos registros
    public function create($id)
    {
        #1. Obtengo las variables a enviar
        $implementacion         =   CapacitacionEjecucion::findOrFail($id);
        $capacitacion           =   Capacitacion::findOrFail($implementacion->codInicCapacitacion);
        $actividad_productor    =   TablaValor::getDetalleTabla('ActividadProductorCapacitacion');
        $actividad_participante =   TablaValor::getDetalleTabla('ActividadParticipanteCapacitacion');
        $cadena_agricola        =   CadenaProductiva::getCadenaSector(1);
        $cadena_pecuaria        =   CadenaProductiva::getCadenaSector(2);
        $cadena_forestal        =   CadenaProductiva::getCadenaSector(3);
        $tipo_entidad           =   TablaValor::getDetalleTabla('TipoEntidad');

        #2. Retorno al formulario
        return view($this->path.'.create', compact('capacitacion', 'actividad_productor', 'actividad_participante', 'tipo_entidad', 'cadena_agricola', 'cadena_pecuaria', 'cadena_forestal'));
    }

    #4. Guardo la información
    public function store(CapacitacionParticipanteFormRequest $request)
    {
        #1. Defino una serie de variables que me serviran posteriormente
        $ruc                    =   $request->get('ruc');
        $tipo_participante      =   ($request->get('actividad_participante') != 0)?'2':'1';
        #2. Guardo la información del participante
        try 
        {
            $fecha                      =   Carbon::now();
            $participante               =   CapacitacionParticipante::updateOrCreate( ['codInicCapacitacion' => $request->get('codigo'), 'dni' => $request->get('dni')], [
                'nombres'                   =>  $request->get('nombres'),
                'paterno'                   =>  $request->get('paterno'),
                'materno'                   =>  $request->get('materno'),
                'fecha'                     =>  $fecha->subYears($request->get('edad')),
                'sexo'                      =>  $request->get('sexo'),
                'codTipo'                   =>  $tipo_participante,
                'codActividadProductor'     =>  $request->get('actividad_productor'),
                'codActividadParticipante'  =>  $request->get('actividad_participante'),
                'detallaOtraActividad'      =>  $request->get('detalla_otro'),
                'codCadenaAgricola'         =>  $request->get('cadena_agricola'),
                'codCadenaPecuaria'         =>  $request->get('cadena_pecuaria'),
                'codCadenaForestal'         =>  $request->get('cadena_forestal'),
                'estado'                    =>  1,
                'created_auth'              =>  Auth::user()->id,
                'updated_auth'              =>  Auth::user()->id,
            ]);
            #3. Si el participante pertenece a una organizacion, entonces la registramos
            if(isset($ruc))
            {
                try 
                {
                    $entidad            =   Entidad::updateOrCreate(['nroDocumento' =>  $request->get('ruc')],[
                        'codTipoDocumento'          =>  2,
                        'codTipoEntidad'            =>  $request->get('tipo_entidad'),
                        'nombre'                    =>  $request->get('razon_social'),
                        'ubigeo'                    =>  $request->get('ubigeo'),
                        'direccion'                 =>  $request->get('direccion'),
                        'fechaRRPP'                 =>  $request->get('fecha_inicio'),
                        'estado'                    =>  1,
                        'created_auth'              =>  Auth::user()->id,
                        'updated_auth'              =>  Auth::user()->id,
                    ]);
                    #4. Actualizo la información del participante
                    try 
                    {
                        $beneficiario                   =   CapacitacionParticipante::findOrFail($participante->id);
                        $beneficiario->codEntidad       =   $entidad->id;
                        $beneficiario->updated_auth     =   Auth::user()->id;
                        $beneficiario->update();

                        #5. Retorno al menu principal
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
            else
            {
                #4. Retorno al menú principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
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

    #5. Muestro los datos de los participantes registrados
    public function show($id)
    {
        $implementacion     =   CapacitacionEjecucion::findOrFail($id);
        $data               =   CapacitacionParticipante::getData($implementacion->codInicCapacitacion);
        return view($this->path.'.data', compact('data'));
    }

    #6. Muestro el formulario para la edición de registros
    public function edit($id)
    {
        #1. Obtengo las variables a actualizar
        $participante           =   CapacitacionParticipante::findOrFail($id);
        $capacitacion           =   Capacitacion::findOrFail($participante->codInicCapacitacion);
        $actividad_productor    =   TablaValor::getDetalleTabla('ActividadProductorCapacitacion');
        $actividad_participante =   TablaValor::getDetalleTabla('ActividadParticipanteCapacitacion');
        $cadena_agricola        =   CadenaProductiva::getCadenaSector(1);
        $cadena_pecuaria        =   CadenaProductiva::getCadenaSector(2);
        $cadena_forestal        =   CadenaProductiva::getCadenaSector(3);
        $entidad                =   Entidad::find($participante->codEntidad);
        $tipo_entidad           =   TablaValor::getDetalleTabla('TipoEntidad');
        $edad                   =   Carbon::createFromDate($participante->fecha)->age;

        #2. Retorno al formulario
        if($entidad == null)
        {
            $opa    =   [];
            return view($this->path.'.edit', compact('participante', 'capacitacion', 'actividad_productor', 'actividad_participante', 'cadena_agricola', 'cadena_pecuaria', 'cadena_forestal', 'opa', 'tipo_entidad', 'edad'));
        }
        else
        {
            $opa    =   $entidad;
            return view($this->path.'.edit', compact('participante', 'capacitacion', 'actividad_productor', 'actividad_participante', 'cadena_agricola', 'cadena_pecuaria', 'cadena_forestal', 'opa', 'tipo_entidad', 'edad'));
        }
    }

    #7. Realizo la actualizacion de la información
    public function update(CapacitacionParticipanteFormRequest $request, $id)
    {
        $ruc                    =   $request->get('ruc');
        $tipo_participante      =   ($request->get('actividad_participante') != 0)?'2':'1';

        #1. Actualizamos la información del participante
        try 
        {
            $fecha                                      =   Carbon::now();
            $participante                               =   CapacitacionParticipante::findOrFail($id);
            $participante->dni                          =   $request->get('dni');
            $participante->nombres                      =   $request->get('nombres');
            $participante->paterno                      =   $request->get('paterno');
            $participante->materno                      =   $request->get('materno');
            $participante->fecha                        =   $fecha->subYears($request->get('edad'));
            $participante->sexo                         =   $request->get('sexo');
            $participante->codTipo                      =   $tipo_participante;
            $participante->codActividadProductor        =   $request->get('actividad_productor');
            $participante->codActividadParticipante     =   $request->get('actividad_participante');
            $participante->detallaOtraActividad         =   $request->get('detalla_otro');
            $participante->codCadenaAgricola            =   $request->get('cadena_agricola');
            $participante->codCadenaPecuaria            =   $request->get('cadena_pecuaria');
            $participante->codCadenaForestal            =   $request->get('cadena_forestal');
            $participante->updated_auth                 =   Auth::user()->id;
            $participante->update();

            #2. Si existe la info de entidad procedemos a actualizarla
            if(isset($ruc))
            {
                try 
                {
                    $entidad                        =   Entidad::where('nroDocumento', $ruc)->first();
                    $entidad->codTipoEntidad        =   $request->get('tipo_entidad');
                    $entidad->nombre                =   $request->get('razon_social');
                    $entidad->ubigeo                =   $request->get('ubigeo');
                    $entidad->direccion             =   $request->get('direccion');
                    $entidad->fechaRRPP             =   $request->get('fecha_inicio');
                    $entidad->updated_auth          =   Auth::user()->id;
                    $entidad->update();

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
            else
            {
                #4. Retorno al menú principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
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

    #8. Realizo la eliminación de registros
    public function destroy($id)
    {
        #1. Realizo la eliminación de la informacion
        try 
        {
            $participante           =   CapacitacionParticipante::find($id);
            $participante->delete();

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
