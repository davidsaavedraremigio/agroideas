<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests\InicSdaFormRequest;
use App\Usuario;
use App\Entidad;
use App\Postulante;
use App\PostulanteEstado;
use App\Proyecto;
use App\Expediente;
use App\PostulanteProductoEspecifico;
use App\CadenaProductiva;
use App\Producto;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class InicSdaController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.sda';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Muestro la pagina principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para la creación de registros
    public function create()
    {
        #1. Obtengo las variables requeridas
        $tipoEntidad    =   TablaValor::getDetalleTabla('TipoEntidad');
        $cadena         =   CadenaProductiva::getData();
        $tipoIncentivo  =   TablaValor::getDetalleTabla('TipoIncentivo');
        $tipoProduccion =   TablaValor::getDetalleTabla('TipoProduccion');
        #2. Retorno al formulario
        return view($this->path.'.create', compact('tipoEntidad', 'cadena', 'tipoIncentivo', 'tipoProduccion'));
    }

    #5. 
    public function store(InicSdaFormRequest $request)
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

            #2. Generamos el registro en Postulante
            try 
            {
                $postulante                     =   new Postulante;
                $postulante->codEntidad         =   $entidad->id;
                $postulante->codTipoIncentivo   =   $request->get('tipo');
                $postulante->codConvocatoria    =   date('Y');
                $postulante->estado             =   1;
                $postulante->created_auth       =   Auth::user()->id;
                $postulante->updated_auth       =   Auth::user()->id;
                $postulante->save();

                #3. Guardamos la info del Proyecto
                try 
                {
                    $proyecto                               =   new Proyecto;
                    $proyecto->codPostulante                =   $postulante->id;
                    $proyecto->area                         =   $request->get('nro_ha_total');
                    $proyecto->nro_beneficiarios            =   $request->get('productores');
                    $proyecto->nro_beneficiarios_varones    =   $request->get('productores_varones');
                    $proyecto->nro_beneficiarios_mujeres    =   $request->get('productores_mujeres');
                    $proyecto->inversion_total              =   $request->get('inversion');
                    $proyecto->estado                       =   1;
                    $proyecto->created_auth                 =   Auth::user()->id;
                    $proyecto->updated_auth                 =   Auth::user()->id;
                    $proyecto->save();

                    #4. Guardo la información de la cadena productiva
                    try 
                    {
                        $cadena                 =   new PostulanteProductoEspecifico;
                        $cadena->codPostulante  =   $postulante->id;
                        $cadena->codCadena      =   $request->get('cadena');
                        $cadena->nroHas         =   $request->get('nro_ha');
                        $cadena->nroProductores =   $request->get('productores');
                        $cadena->principal      =   1;
                        $cadena->etapa          =   1;
                        $cadena->created_auth   =   Auth::user()->id;
                        $cadena->updated_auth   =   Auth::user()->id;
                        $cadena->save();

                        #5. Creamos el estado situacional
                        try 
                        {
                            $estado                         =   new PostulanteEstado;
                            $estado->codPostulante          =   $postulante->id;
                            $estado->codEstadoSituacional   =   0;
                            $estado->created_auth           =   Auth::user()->id;
                            $estado->updated_auth           =   Auth::user()->id;
                            $estado->save();

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

    #6.
    public function show()
    {
        #1. Obtengo la información
        $data       =   Postulante::getDataSda();
        #2. Retornamos al menu principal
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        #1. Obtengo las datos a actualizar
        $postulante         =   Postulante::findOrFail($id);
        $proyecto           =   Proyecto::where('codPostulante', $postulante->id)->first();
        $producto           =   PostulanteProductoEspecifico::where('codPostulante', $postulante->id)->first();
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        #2. Obtengo las variables requeridas
        $tipoEntidad        =   TablaValor::getDetalleTabla('TipoEntidad');
        $cadena             =   CadenaProductiva::getData();
        $tipoIncentivo      =   TablaValor::getDetalleTabla('TipoIncentivo');
        $tipoProduccion     =   TablaValor::getDetalleTabla('TipoProduccion');

        #3. Cargo el formulario para la edicion
        return view($this->path.'.edit', compact('postulante', 'proyecto', 'producto', 'entidad', 'tipoEntidad', 'cadena', 'tipoIncentivo', 'tipoProduccion'));
    }

    #8.
    public function update(InicSdaFormRequest $request, $id)
    {
        #1. Actualizo la información del Postulante
        try 
        {
            $postulante                 =   Postulante::findOrFail($id);
            $postulante->updated_auth   =   Auth::user()->id;
            $postulante->update();

            #2. Actualizo los datos de la organizacion
            try 
            {
                $entidad                    =   Entidad::findOrFail($postulante->codEntidad);
                $entidad->codTipoEntidad    =   $request->get('tipo_entidad');
                $entidad->nombre            =   $request->get('nombre');
                $entidad->ubigeo            =   $request->get('ubigeo');
                $entidad->direccion         =   $request->get('direccion');
                $entidad->updated_auth      =   Auth::user()->id;
                $entidad->update();

                #3. Actualizo la información del Proyecto
                try 
                {
                    $proyecto                               =   Proyecto::where('codPostulante', $postulante->id)->first();
                    $proyecto->tituloProyecto               =   $request->get('titulo');
                    $proyecto->area                         =   $request->get('nro_ha');
                    $proyecto->nro_beneficiarios            =   $request->get('productores');
                    $proyecto->nro_beneficiarios_varones    =   $request->get('productores_varones');
                    $proyecto->nro_beneficiarios_mujeres    =   $request->get('productores_mujeres');
                    $proyecto->updated_auth                 =   Auth::user()->id;
                    $proyecto->update();

                    #4. Actualizo la información de la cadena Productiva
                    try 
                    {
                        $cadena                 =   PostulanteProductoEspecifico::where('codPostulante', $postulante->id)->first();
                        $cadena->codCadena      =   $request->get('cadena');
                        $cadena->nroHas         =   $request->get('nro_ha');
                        $cadena->nroProductores =   $request->get('productores');
                        $cadena->tipoProduccion =   $request->get('tipo_produccion');
                        $cadena->variedad       =   $request->get('variedad');
                        $cadena->updated_auth   =   Auth::user()->id;
                        $cadena->update();

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

    #9.
    public function destroy($id)
    {
        try 
        {
            $postulante                 =   Postulante::findOrFail($id);
            $postulante->estado         =   0;
            $postulante->updated_auth   =   Auth::user()->id;
            $postulante->update();
            
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
