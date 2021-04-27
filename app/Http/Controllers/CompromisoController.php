<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CompromisoFormRequest;
use App\Evento;
use App\EventoCompromiso;
use App\TipoCompromisoEtapa;
use App\TablaValor;
use App\Ubigeo;
use Carbon\Carbon;
use DB;
use Auth;

class CompromisoController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.compromiso';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Muestro un formulario de registro
    public function create($id)
    {
        #1. Obtengo el codigo de evento
        $codEvento          =   $id;
        #2. Obtengo los estados de los compromisos
        $estadoCompromiso   =   TablaValor::getDetalleTabla('EstadoCompromiso');
        #3. Obtengo los tipos de compromisos
        $tipoCompromiso     =   TablaValor::getDetalleTabla('TipoCompromiso');
        #4. Obtengo los tipos de documentos con los que se sustenta el compromiso
        $tipoDocumento      =   TablaValor::getDetalleTabla('TipoDocumentoTramite');
        #5. Retorno al formulario de registro
        return view($this->path.'.create', compact('codEvento', 'estadoCompromiso', 'tipoCompromiso', 'tipoDocumento'));
    }

    #4. Generamos un nuevo compromiso
    public function store(CompromisoFormRequest $request)
    {
        try 
        {
            $compromiso                     =   new EventoCompromiso;
            $compromiso->eventoID           =   $request->get('evento');
            $compromiso->compromiso         =   $request->get('compromiso');
            $compromiso->responsable        =   $request->get('responsable');
            $compromiso->fechaPlazo         =   $request->get('fecha_plazo');
            $compromiso->inversion          =   $request->get('inversion');
            $compromiso->codTipoDocumento   =   $request->get('tipo_documento');
            $compromiso->nroDocumento       =   $request->get('nro_documento');
            $compromiso->fechaDocumento     =   $request->get('fecha_documento');
            $compromiso->codEstado          =   $request->get('estado_compromiso');
            $compromiso->codTipoCompromiso  =   $request->get('tipo_compromiso');
            $compromiso->nroEntidades       =   $request->get('nro_incentivo');
            $compromiso->created_auth       =   Auth::user()->id;
            $compromiso->updated_auth       =   Auth::user()->id;
            $compromiso->save();

            #2. Retornamos al menu principal
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

    #5. Mostramos la relación de compromisos generados para el evento seleccionado
    public function show($id)
    {
        $compromisos    =   EventoCompromiso::getData($id);
        return view($this->path.'.data', compact('compromisos'));
    }

    #6. Muestro el formulario para editar la información de compromisos
    public function edit($id)
    {
        #1. obtengo los datos del compromiso
        $compromiso         =   EventoCompromiso::findOrFail($id);
        #2. obtengo los estados situacionales
        $estadoCompromiso   =   TablaValor::getDetalleTabla('EstadoCompromiso');
        #3. Obtengo los tipos de compromisos
        $tipoCompromiso     =   TablaValor::getDetalleTabla('TipoCompromiso');
        #4. Obtengo los tipos de documentos con los que se sustenta el compromiso
        $tipoDocumento      =   TablaValor::getDetalleTabla('TipoDocumentoTramite');
        #5. Retorno al formulario de edición
        return view($this->path.'.edit', compact('compromiso', 'estadoCompromiso', 'tipoCompromiso', 'tipoDocumento'));
    }

    #7. Actualizo la información del compromiso
    public function update(CompromisoFormRequest $request, $id)
    {
        try 
        {
            $compromiso                     =   EventoCompromiso::findOrFail($id);
            $compromiso->compromiso         =   $request->get('compromiso');
            $compromiso->responsable        =   $request->get('responsable');
            $compromiso->fechaPlazo         =   $request->get('fecha_plazo');
            $compromiso->inversion          =   $request->get('inversion');
            $compromiso->codTipoDocumento   =   $request->get('tipo_documento');
            $compromiso->nroDocumento       =   $request->get('nro_documento');
            $compromiso->fechaDocumento     =   $request->get('fecha_documento');
            $compromiso->codEstado          =   $request->get('estado_compromiso');
            $compromiso->codTipoCompromiso  =   $request->get('tipo_compromiso');
            $compromiso->nroEntidades       =   $request->get('nro_incentivo');
            $compromiso->updated_auth       =   Auth::user()->id;
            $compromiso->update();

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

    #8. Eliminamos el compromiso seleccionado
    public function destroy($id)
    {
        try 
        {
            $compromiso         =   EventoCompromiso::find($id);
            $compromiso->delete();

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

    #9. Obtenemos los tipos de etapas de acuerdo al compromiso elegido
    public function obtieneEtapa($compromiso)
    {
        $compromiso     =   EventoCompromiso::findOrFail($compromiso);
        $tipoCompromiso =   $compromiso->codTipoCompromiso;
        #2. Obtengo la relación de etapas
        $etapas         =   TipoCompromisoEtapa::getEtapaCompromiso($tipoCompromiso);
        #3. Retorno un json
        return response()->json($etapas);
    }

    #10. Retornamos al indice de la consulta de resumen de compromisos
    public function indexCompromiso()
    {
        #1. Obtengo la relacion de variables
        $regiones           =   Ubigeo::getRegiones();
        $estadoCompromiso   =   TablaValor::getDetalleTabla('EstadoCompromiso');
        $tipoCompromiso     =   TablaValor::getDetalleTabla('TipoCompromiso');   
        #2. Retorno a la vista con los datos  
        return view('iniciativa.compromiso-reporte.index', compact('regiones', 'estadoCompromiso', 'tipoCompromiso'));
    }

    #11. Realizamos la consulta a la información resumen de compromisos
    public function dataCompromiso($tipo, $estado)
    {
        $data   =    EventoCompromiso::getCompromisos($tipo, $estado);
        return view('iniciativa.compromiso-reporte.data', compact('data'));
    }
}
