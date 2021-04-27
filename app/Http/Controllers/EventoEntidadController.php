<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\EventoEntidadFormRequest;
use App\EventoEntidad;
use App\EventoCompromiso;
use App\Evento;
use App\TablaValor;
use App\CadenaProductiva;
use App\Entidad;
use Carbon\Carbon;
use DB;
use Auth;

class EventoEntidadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.evento-entidad';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Muestro el formulario para nuevos registros
    public function create($id)
    {
        #1. Obtengo el codigo de evento
        $codEvento          =   $id;
        #2. Obtengo los tipos de incentivos
        $tipoIncentivo      =   TablaValor::getDetalleTabla('TipoIncentivo');
        #3. Obtengo las cadenas productivas
        $cadenaProductiva   =   CadenaProductiva::getData();
        #4. Obtengo los tipos de entidades
        $tipoEntidad        =   TablaValor::getDetalleTabla('TipoEntidad');
        #5. Obtengo los compromisos correspondientes al evento seleccionado
        $compromisos        =   EventoCompromiso::getData($codEvento);
        #5. Retorno al formulario
        return view($this->path.'.create', compact('codEvento', 'tipoIncentivo', 'cadenaProductiva', 'tipoEntidad', 'compromisos'));
    }

    #4. Procedo a guardar la información
    public function store(EventoEntidadFormRequest $request)
    {
        #1. Verificamos si la entidad existe, si fuera el caso actualizamos, sino registramos un nuevo registro
        try 
        {
            $entidad        =   Entidad::firstOrCreate(['nroDocumento' => $request->get('ruc')],[
                                'codTipoDocumento'      =>  1,
                                'codTipoEntidad'        =>  $request->get('tipo_entidad'),
                                'nombre'                =>  $request->get('nombre'),
                                'ubigeo'                =>  $request->get('ubigeo'),
                                'direccion'             =>  $request->get('direccion'),
                                'estado'                =>  1,
                                'created_auth'          =>  Auth::user()->id,
                                'updated_auth'          =>  Auth::user()->id
            ]);

            #2. Guardo la información en la tabla 
            try 
            {
                $oa                         =   new EventoEntidad;
                $oa->compromisoID           =   $request->get('compromiso');
                $oa->entidadID              =   $entidad->id;
                $oa->incentivoID            =   $request->get('tipo_incentivo');
                $oa->codCadenaInicial       =   $request->get('cadena_inicial');
                $oa->codCadenaPropuesta     =   $request->get('cadena_propuesta');
                $oa->nroProductores         =   $request->get('nro_productores');
                $oa->nroHas                 =   $request->get('nro_hectareas');
                $oa->inversion              =   $request->get('inversion');
                $oa->created_auth           =   Auth::user()->id;
                $oa->updated_auth           =   Auth::user()->id;
                $oa->save();

                #2.1 retorno al menú principal
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

    #5. Muestro los datos generados
    public function show($id)
    {
        $data       =   EventoEntidad::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6. muestro el formulario de edición de información
    public function edit($id)
    {
        #1. Obtengo los datos del registro
        $oa                 =   EventoEntidad::findOrFail($id);
        #2. Obtengo los datos de la entidad
        $entidad            =   Entidad::findOrFail($oa->entidadID);
        #3. Obtengo los tipos de incentivo
        $tipoIncentivo      =   TablaValor::getDetalleTabla('TipoIncentivo');
        #4. Obtengo las cadenas productivas
        $cadenaProductiva   =   CadenaProductiva::getData();
        #5. Obtengo los tipos de entidades existentes
        $tipoEntidad        =   TablaValor::getDetalleTabla('TipoEntidad');
        #6. Obtengo la lista de compromisos
        $compromiso         =   EventoCompromiso::findOrFail($oa->compromisoID);
        $compromisos        =   EventoCompromiso::getData($compromiso->eventoID);
        #7. Retorno al menu de edición
        return view($this->path.'.edit', compact('oa', 'entidad', 'tipoIncentivo', 'cadenaProductiva', 'tipoEntidad', 'compromisos'));
    }

    #7. Actualizamos la información
    public function update(EventoEntidadFormRequest $request, $id)
    {
        #1. Actualizamos los datos de la entidad
        try 
        {
            $oa                         =   EventoEntidad::findOrFail($id);
            $oa->compromisoID           =   $request->get('compromiso');
            $oa->incentivoID            =   $request->get('tipo_incentivo');
            $oa->codCadenaInicial       =   $request->get('cadena_inicial');
            $oa->codCadenaPropuesta     =   $request->get('cadena_propuesta');
            $oa->nroProductores         =   $request->get('nro_productores');
            $oa->nroHas                 =   $request->get('nro_hectareas');
            $oa->inversion              =   $request->get('inversion');
            $oa->created_auth           =   Auth::user()->id;
            $oa->updated_auth           =   Auth::user()->id;
            $oa->update();

            #2. Actualizamos los datos de la OA
            try 
            {
                $entidad                    =   Entidad::findOrFail($oa->entidadID);
                $entidad->codTipoEntidad    =   $request->get('tipo_entidad');
                $entidad->nombre            =   $request->get('nombre');
                $entidad->ubigeo            =   $request->get('ubigeo');
                $entidad->direccion         =   $request->get('direccion');
                $entidad->updated_auth      =   Auth::user()->id;
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #8. Elimino el registro elegido
    public function destroy($id)
    {
        try 
        {
            $oa         =   EventoEntidad::find($id);
            $oa->delete();

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
