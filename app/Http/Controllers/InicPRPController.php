<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\InicPRPFormRequest;
use App\Usuario;
use App\Postulante;
use App\PostulanteEstado;
use App\Proyecto;
use App\Contrato;
use App\ResolucionMinisterial;
use App\PostulanteProductoEspecifico;
use App\Expediente;
use App\CultivoInicial;
use App\CadenaProductiva;
use App\Producto;
use App\Entidad;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class InicPRPController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.prp';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }      

    #3. Mostramos el menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Mostramos el formulario para nuevos registros
    public function create()
    {
        #1. Obtengo los tipos de entidades
        $tipoEntidad    =  TablaValor::getDetalleTabla('TipoEntidad');
        #2. Obtengo la relacion de Cadenas Productivas
        $cadena         =   CadenaProductiva::getData();
        #3. Retorno al formulario de registro
        return view($this->path.'.create', compact('tipoEntidad', 'cadena')); 
    }

    #5. Guardamos cambios
    public function store(InicPRPFormRequest $request)
    {
        #1. Guardamos la información de la entidad
        try 
        {
            $entidad        =   Entidad::updateOrCreate(['nroDocumento' => $request->get('ruc')],[
                'codTipoDocumento'      =>  1,
                'codTipoEntidad'        =>  $request->get('tipo_entidad'),
                'nombre'                =>  $request->get('nombre'),
                'ubigeo'                =>  $request->get('ubigeo'),
                'direccion'             =>  $request->get('direccion'),
                'estado'                =>  1,
                'created_auth'          =>  Auth::user()->id,
                'updated_auth'          =>  Auth::user()->id
            ]);

            #2. Guardamos la información del Postulante
            try 
            {
                $postulante                     =   new Postulante;
                $postulante->codEntidad         =   $entidad->id;
                $postulante->codTipoIncentivo   =   2;
                $postulante->codConvocatoria    =   date('Y');
                $postulante->estado             =   1;
                $postulante->created_auth       =   Auth::user()->id;
                $postulante->updated_auth       =   Auth::user()->id;
                $postulante->save();

                #3. Guardamos la información del cultivo a reemplazar
                try 
                {
                    $cultivoInicial                     =   new CultivoInicial;
                    $cultivoInicial->codPostulante      =   $postulante->id;
                    $cultivoInicial->descripcion        =   $request->get('cultivo');
                    $cultivoInicial->hectareas          =   $request->get('hectareas_sp');
                    $cultivoInicial->beneficiarios      =   $request->get('productores_total');
                    $cultivoInicial->created_auth       =   Auth::user()->id;
                    $cultivoInicial->updated_auth       =   Auth::user()->id;
                    $cultivoInicial->save();

                    #4. Guardamos la información del cultivo a instalar
                    try 
                    {
                        $cultivoActual                  =   new PostulanteProductoEspecifico;
                        $cultivoActual->codPostulante   =   $postulante->id;
                        $cultivoActual->codCadena       =   $request->get('cadena');
                        $cultivoActual->nroHas          =   $request->get('hectareas_sp');
                        $cultivoActual->nroProductores  =   $request->get('productores_total');
                        $cultivoActual->principal       =   1;
                        $cultivoActual->etapa           =   1;
                        $cultivoActual->created_auth    =   Auth::user()->id;
                        $cultivoActual->updated_auth    =   Auth::user()->id;
                        $cultivoActual->save();

                        #5. Guardamos los datos del proyecto
                        try 
                        {
                            $proyecto                               =   new Proyecto;
                            $proyecto->codPostulante                =   $postulante->id;
                            $proyecto->inversion_total              =   0;
                            $proyecto->inversion_pcc                =   0;
                            $proyecto->inversion_entidad            =   0;
                            $proyecto->area                         =   $request->get('hectareas_sp');
                            $proyecto->nro_beneficiarios            =   $request->get('productores_total');
                            $proyecto->nro_beneficiarios_varones    =   0;
                            $proyecto->nro_beneficiarios_mujeres    =   0;
                            $proyecto->estado                       =   1;
                            $proyecto->created_auth                 =   Auth::user()->id;
                            $proyecto->updated_auth                 =   Auth::user()->id;
                            $proyecto->save();

                            #6. Generamos un registro con el estado situacional
                            try 
                            {
                                 $situacion                         =   new PostulanteEstado;
                                 $situacion->codPostulante          =   $postulante->id;
                                 $situacion->codEstadoSituacional   =   0; #En proceso de admision
                                 $situacion->created_auth           =   Auth::user()->id;
                                 $situacion->updated_auth           =   Auth::user()->id;
                                 $situacion->save();

                                #7. Retorno al menu principal
                                return response()->json([
                                    'estado'    =>  '1',
                                    'dato'      =>  $postulante->id,
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

    #6. Mostramos la información registrada
    public function show($id)
    {
        #1. Obtengo la informacion
        $data   =   Postulante::getData($id);
        #2. Retorno a la vista principal
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro el formulario de edicion
    public function edit($id)
    {
        #1. Obtengo los datos del postulante
        $postulante     =   Postulante::findOrFail($id);
        #2. Obtengo los datos de la entidad
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        #3. Obtengo los tipos de entidades
        $tipoEntidad    =   TablaValor::getDetalleTabla('TipoEntidad');
        #4. Obtengo la relación de cadenas productivas
        $cadena         =   CadenaProductiva::getData();
        #5. Obtengo la información del cultivo inicial
        $cultivo        =   CultivoInicial::where('codPostulante', $id)->first();
        #6. Obtengo la información de la cadena a instalar
        $producto       =   PostulanteProductoEspecifico::where([
                                'codPostulante'     =>  $id,
                                'principal'         =>  1
                            ])->first();
        #7. Obtengo la información del proyecto
        $proyecto       =   Proyecto::where('codPostulante', $id)->first();
        #8. Retorno al formulario de edicion
        return view($this->path.'.edit', compact('postulante', 'entidad', 'tipoEntidad', 'cultivo', 'producto', 'proyecto', 'cadena'));
    }

    #8. Actualizo los datos del proyecto
    public function update(InicPRPFormRequest $request, $id)
    {
        #1. Guardamos la info del proyecto
        try 
        {
            $postulante                 =   Postulante::findOrFail($id);
            $postulante->updated_auth   =   Auth::user()->id;
            $postulante->update();

            #2. Guardo los datos de la organizacion
            try 
            {
                $entidad                    =   Entidad::findOrFail($postulante->codEntidad);
                $entidad->codTipoEntidad    =   $request->get('tipo_entidad');
                $entidad->nombre            =   $request->get('nombre');
                $entidad->ubigeo            =   $request->get('ubigeo');
                $entidad->direccion         =   $request->get('direccion');
                $entidad->updated_auth      =   Auth::user()->id;
                $entidad->update();

                #3. Guardo la información del Proyecto
                try 
                {
                    $proyecto                               =   Proyecto::where('codPostulante', $id)->first();
                    $proyecto->area                         =   $request->get('hectareas_sp');
                    $proyecto->nro_beneficiarios            =   $request->get('productores_total');
                    $proyecto->updated_auth                 =   Auth::user()->id;
                    $proyecto->update();

                    #4. Guardo la información del producto a reconvertir
                    try 
                    {
                        $cultivoInicial                     =   CultivoInicial::where('codPostulante', $id)->first();
                        $cultivoInicial->descripcion        =   $request->get('cultivo');
                        $cultivoInicial->hectareas          =   $request->get('hectareas_sp');
                        $cultivoInicial->beneficiarios      =   $request->get('productores_total');
                        $cultivoInicial->updated_auth       =   Auth::user()->id;
                        $cultivoInicial->update();

                        #5. Actualizo el cultivo a reconvertir
                        try 
                        {
                            $cultivoActual                     =   PostulanteProductoEspecifico::where('codPostulante', $id)->first();
                            $cultivoActual->codCadena          =   $request->get('cadena');
                            $cultivoActual->nroHas             =   $request->get('hectareas_sp');
                            $cultivoActual->nroProductores     =   $request->get('productores_total');
                            $cultivoActual->updated_auth       =   Auth::user()->id;
                            $cultivoActual->update();

                            #5. retorno al menu principal
                            return response()->json([
                                'estado'    =>  '1',
                                'dato'      =>  $id,
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #9. Eliminamos un registro
    public function destroy($id)
    {
        //
    }
}
