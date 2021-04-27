<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Expediente;
use App\ExpedienteProceso;
use App\ExpedienteMonitoreo;
use App\Entidad;
use App\Postulante;
use App\Proyecto;
use App\PostulanteEstado;
use App\Area;
use App\Oficina;
use App\Usuario;
use App\Staff;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class ProcesoSdaUrController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-pdn.proceso-ur';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Mostramos la ventana principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Registro un nuevo expediente Sda
    public function create()
    {
        #1. Obtengo los datos de registro
        $incentivo      =   Postulante::getDataSda();
        $area           =   Area::getData();
        $oficina        =   Oficina::getData();
        $personal       =   Usuario::getArea(8);
        $situacion      =   TablaValor::getDetalleTabla('EstadoSituacional');
        $tipo_entidad   =   TablaValor::getDetalleTabla('TipoEntidad');
        $tipo_incentivo =   TablaValor::getDetalleTabla('TipoIncentivo');
        
        #2. Retorno al formulario
        return view($this->path.'.form-create', compact('incentivo', 'area', 'oficina', 'personal', 'situacion', 'tipo_entidad', 'tipo_incentivo'));
    }

    #5. Proceso el formulario de registro
    public function createProcess(Request $request)
    {
        #1. Guardo la info de la organizacion
        try 
        {
            $entidad        =   Entidad::updateOrCreate(['nroDocumento' => $request->get('ruc')],[
                'codTipoDocumento'      =>  1,
                'codTipoEntidad'        =>  $request->get('tipo_entidad'),
                'nombre'                =>  $request->get('razon_social'),
                'ubigeo'                =>  $request->get('ubigeo'),
                'direccion'             =>  $request->get('direccion'),
                'estadoContribuyente'   =>  $request->get('estado_contribuyente'),
                'fechaRRPP'             =>  $request->get('fecha_rrpp'),
                'estado'                =>  1,
                'created_auth'          =>  Auth::user()->id,
                'updated_auth'          =>  Auth::user()->id
            ]);

            #2. Genero un nuevo registro de postulante
            try 
            {
                $postulante                     =   new Postulante;
                $postulante->codEntidad         =   $entidad->id;
                $postulante->codTipoIncentivo   =   $request->get('tipo_iniciativa');
                $postulante->codConvocatoria    =   \date('Y');
                $postulante->estado             =   1;
                $postulante->created_auth       =   Auth::user()->id;
                $postulante->updated_auth       =   Auth::user()->id;
                $postulante->save();

                #3. Almaceno la información del estado situacional del postulante
                try 
                {
                    $estado                         =   new PostulanteEstado;
                    $estado->codPostulante          =   $postulante->id;
                    $estado->codEstadoSituacional   =   0;
                    $estado->created_auth           =   Auth::user()->id;
                    $estado->updated_auth           =   Auth::user()->id;
                    $estado->save();

                    #4. Genero un nuevo numero de expediente
                    try 
                    {
                        $expediente                         =   new Expediente;
                        $expediente->codPostulante          =   $postulante->id;
                        $expediente->nroCut                 =   $request->get('nro_cut');
                        $expediente->fechaCut               =   $request->get('fecha_cut');
                        $expediente->nroExpediente          =   $request->get('nro_expediente');
                        $expediente->fechaExpediente        =   $request->get('fecha_expediente');
                        $expediente->codOficina             =   $request->get('oficina');
                        $expediente->codPersonalAsignado    =   $request->get('personal');
                        $expediente->codArea                =   $request->get('area');
                        $expediente->codEstado              =   1;
                        $expediente->created_auth           =   Auth::user()->id;
                        $expediente->updated_auth           =   Auth::user()->id;
                        $expediente->save();

                        #5. Retorno al panel principal
                        return response()->json([
                            'estado'    =>  '1',
                            'dato'      =>  $expediente->id,
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

    #6. Muestro el formulario para la edición de información del expediente
    public function edit($id)
    {
        #1. Obtengo la información de las variables 
        $expediente     =   Expediente::findOrFail($id);
        $incentivo      =   Postulante::getDataSda();
        $area           =   Area::getData();
        $oficina        =   Oficina::getData();
        $personal       =   Usuario::getArea(8);
        $situacion      =   TablaValor::getDetalleTabla('EstadoSituacional');
        $tipo_entidad   =   TablaValor::getDetalleTabla('TipoEntidad');
        $tipo_incentivo =   TablaValor::getDetalleTabla('TipoIncentivo');
        $postulante     =   Postulante::findOrFail($expediente->codPostulante);
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        
        return view($this->path.'.form-edit', compact('expediente', 'incentivo', 'area', 'oficina', 'personal', 'situacion', 'tipo_entidad', 'tipo_incentivo', 'postulante', 'entidad'));
    }

    #7. Proceso el formulario de edicion
    public function editProcess(Request $request)
    {
        try 
        {
            //code...
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

    #8. Mostramos la información de los expedientes en Proceso
    public function data()
    {
        $data       =   Expediente::getDataUbicacionExpedienteSda(8, 1);
        return view($this->path.'.data-pendiente', compact('data'));
    }

    #9. Mostramos la información de los expedientes observados
    public function dataObservado()
    {
        $data       =   Expediente::getDataProcesoExpedienteSda(8, 4);
        return view($this->path.'.data-observado', compact('data'));
    }

    #10. Mostramos la información de expedientes declarados improcedentes
    public function dataImprocedente()
    {
        $data       =   Expediente::getDataProcesoExpedienteSda(8, 3);
        return view($this->path.'.data-improcedente', compact('data'));
    }

    #11. Mostramos la información de expedientes declarados favorables
    public function dataElegible()
    {
        $data       =   Expediente::getDataProcesoExpedienteSda(8, 2);
        return view($this->path.'.data-elegible', compact('data'));
    }

    #12. Mostramos un formulario para realizar observaciones
    public function observaForm($id)
    {
        #1. Obtengo la variables
        $expediente         =   Expediente::findOrFail($id);
        $postulante         =   Postulante::findOrFail($expediente->codPostulante);
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        $personal           =   Usuario::getArea(8);
        $tipo_doc           =   TablaValor::getDetalleTabla('TipoDocumentoProceso');

        #2. Retorno al formulario
        return view($this->path.'.form-observa', compact('expediente', 'postulante', 'entidad', 'personal', 'tipo_doc'));
    }

    #13. Procesamos la observacion del expediente
    public function observaProcess(Request $request)
    {
        #1. Guardo lo datos de la aobservaciones
        try 
        {
            $proceso                                =   new ExpedienteProceso;
            $proceso->codExpediente                 =   $request->get('codigo');
            $proceso->fecha_recepcion               =   $request->get('fecha_documento');
            $proceso->cod_responsable_asignado      =   $request->get('especialista');
            $proceso->cod_tipo_documento            =   $request->get('tipo_documento');
            $proceso->nro_documento                 =   $request->get('nro_documento');
            $proceso->fecha_documento               =   $request->get('fecha_documento');
            $proceso->fecha_derivacion              =   $request->get('fecha_documento');
            $proceso->cod_responsable_destinatario  =   $request->get('especialista');
            $proceso->cod_estado_proceso            =   4;
            $proceso->comentarios                   =   $request->get('observaciones');
            $proceso->created_auth                  =   Auth::user()->id;
            $proceso->updated_auth                  =   Auth::user()->id;
            $proceso->save();

            #2. Actualizo el estado situacional del expediente
            try 
            {
                $consulta               =   Staff::getArea($proceso->cod_responsable_destinatario);
                $area                   =   $consulta->cod_area;
                
                $expediente                         =   Expediente::findOrFail($proceso->codExpediente);
                $expediente->codPersonalAsignado    =   $proceso->cod_responsable_destinatario;
                $expediente->codArea                =   $area;
                $expediente->codEstado              =   $proceso->cod_estado_proceso;
                $expediente->updated_auth           =   Auth::user()->id;
                $expediente->update();

                #3. Retorno al servidor principal
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

    #14. Mostramos un formulario para declarar improcedente un expediente
    public function improcedenteForm($id)
    {
        #1. Obtengo la variables
        $expediente         =   Expediente::findOrFail($id);
        $postulante         =   Postulante::findOrFail($expediente->codPostulante);
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        $personal           =   Usuario::getArea(8);
        $tipo_doc           =   TablaValor::getDetalleTabla('TipoDocumentoProceso');

        #2. Retorno al formulario
        return view($this->path.'.form-improcedente', compact('expediente', 'postulante', 'entidad', 'personal', 'tipo_doc'));
    }

    #15. Procesamos la improcedencia del expediente
    public function improcedenteProcess(Request $request)
    {
        try 
        {
            $proceso                                =   new ExpedienteProceso;
            $proceso->codExpediente                 =   $request->get('codigo');
            $proceso->fecha_recepcion               =   $request->get('fecha_documento');
            $proceso->cod_responsable_asignado      =   $request->get('especialista');
            $proceso->cod_tipo_documento            =   $request->get('tipo_documento');
            $proceso->nro_documento                 =   $request->get('nro_documento');
            $proceso->fecha_documento               =   $request->get('fecha_documento');
            $proceso->fecha_derivacion              =   $request->get('fecha_documento');
            $proceso->cod_responsable_destinatario  =   $request->get('especialista');
            $proceso->cod_estado_proceso            =   3;
            $proceso->comentarios                   =   $request->get('observaciones');
            $proceso->created_auth                  =   Auth::user()->id;
            $proceso->updated_auth                  =   Auth::user()->id;
            $proceso->save();

            #2. Actualizo el estado situacional del expediente
            try 
            {
                $consulta               =   Staff::getArea($proceso->cod_responsable_destinatario);
                $area                   =   $consulta->cod_area;
                
                $expediente                         =   Expediente::findOrFail($proceso->codExpediente);
                $expediente->codPersonalAsignado    =   $proceso->cod_responsable_destinatario;
                $expediente->codArea                =   $area;
                $expediente->codEstado              =   $proceso->cod_estado_proceso;
                $expediente->updated_auth           =   Auth::user()->id;
                $expediente->update();

                #3. Retorno al servidor principal
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

    #16. Mostramos un formulario para declara favorable un expediente
    public function elegibleForm($id)
    {
        #1. Obtengo la variables
        $expediente         =   Expediente::findOrFail($id);
        $postulante         =   Postulante::findOrFail($expediente->codPostulante);
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        $personal           =   Usuario::getData();
        $tipo_doc           =   TablaValor::getDetalleTabla('TipoDocumentoProceso');

        #2. Retorno al formulario
        return view($this->path.'.form-elegible', compact('expediente', 'postulante', 'entidad', 'personal', 'tipo_doc'));
    }

    #17. 
    public function elegibleProcess(Request $request)
    {
        try 
        {
            $proceso                                =   new ExpedienteProceso;
            $proceso->codExpediente                 =   $request->get('codigo');
            $proceso->fecha_recepcion               =   $request->get('fecha_documento');
            $proceso->cod_responsable_asignado      =   $request->get('especialista');
            $proceso->cod_tipo_documento            =   $request->get('tipo_documento');
            $proceso->nro_documento                 =   $request->get('nro_documento');
            $proceso->fecha_documento               =   $request->get('fecha_documento');
            $proceso->fecha_derivacion              =   $request->get('fecha_documento');
            $proceso->cod_responsable_destinatario  =   $request->get('especialista');
            $proceso->cod_estado_proceso            =   2;
            $proceso->comentarios                   =   $request->get('observaciones');
            $proceso->created_auth                  =   Auth::user()->id;
            $proceso->updated_auth                  =   Auth::user()->id;
            $proceso->save();

            try 
            {
                $consulta               =   Staff::getArea($proceso->cod_responsable_destinatario);
                $area                   =   $consulta->cod_area;
                
                $expediente                         =   Expediente::findOrFail($proceso->codExpediente);
                $expediente->codPersonalAsignado    =   $proceso->cod_responsable_destinatario;
                $expediente->codArea                =   $area;
                $expediente->codEstado              =   $proceso->cod_estado_proceso;
                $expediente->updated_auth           =   Auth::user()->id;
                $expediente->update();

                #3. Retorno al servidor principal
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

}
