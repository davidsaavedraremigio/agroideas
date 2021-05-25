<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoFormRequest;
use App\Http\Requests\UploadConvenioFormRequest;
use App\ConvenioMarco;
use App\TablaValor;
use App\Usuario;
use App\Staff;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioMarcoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio';

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
        #1. Obtengo las variables requeridas
        $tipo           =   TablaValor::getDetalleTabla('TipoConvenioMarco');
        $estado         =   TablaValor::getDetalleTabla('EstadoConvenio');
        $personal       =   Usuario::getData();
        #2. Retorno al formulario
        return view($this->path.'.create', compact('tipo', 'estado', 'personal')); 
    }

    #5.
    public function store(ConvenioMarcoFormRequest $request)
    {
        #1. Guardamos la información de convenio
        try 
        {
            $convenio                       =   new ConvenioMarco;
            $convenio->nro_cut              =   $request->get('nro_cut');
            $convenio->fecha_cut            =   $request->get('fecha_cut');
            $convenio->numero               =   $request->get('nro_convenio');
            $convenio->fecha_firma          =   $request->get('fecha_firma');
            $convenio->duracion             =   $request->get('duracion');
            $convenio->fecha_termino        =   Carbon::parse($request->get('fecha_firma'))->addMonths($request->get('duracion'));
            $convenio->objetivo             =   $request->get('objetivo');
            $convenio->tipo_convenio        =   $request->get('tipo');
            $convenio->importe              =   $request->get('importe');
            $convenio->cod_estado           =   1;
            $convenio->nro_ley              =   $request->get('nro_ley');
            $convenio->cod_representante_pcc=   $request->get('representante_pcc');
            $convenio->created_auth         =   Auth::user()->id;
            $convenio->updated_auth         =   Auth::user()->id;
            $convenio->save();

            #2. Retorno al formulario para la edición de registris
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $convenio->id,
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

    #6. 
    public function show()
    {
        $data       =   ConvenioMarco::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function edit($id)
    {
        #1. Obtengo las variables requeridas por el formulario
        $convenio       =   ConvenioMarco::findOrFail($id);
        $tipo           =   TablaValor::getDetalleTabla('TipoConvenioMarco');
        $estado         =   TablaValor::getDetalleTabla('EstadoConvenio');
        $personal       =   Usuario::getData();
        #2. Retorno al formulario de edicion
        return view($this->path.'.edit', compact('convenio', 'tipo', 'estado', 'personal'));
    }

    #8.
    public function update(ConvenioMarcoFormRequest $request, $id)
    {
        try 
        {
            $convenio                       =   ConvenioMarco::findOrFail($id);
            $convenio->nro_cut              =   $request->get('nro_cut');
            $convenio->fecha_cut            =   $request->get('fecha_cut');
            $convenio->numero               =   $request->get('nro_convenio');
            $convenio->fecha_firma          =   $request->get('fecha_firma');
            $convenio->duracion             =   $request->get('duracion');
            $convenio->fecha_termino        =   Carbon::parse($request->get('fecha_firma'))->addMonths($request->get('duracion'));
            $convenio->objetivo             =   $request->get('objetivo');
            $convenio->tipo_convenio        =   $request->get('tipo');
            $convenio->importe              =   $request->get('importe');
            $convenio->nro_ley              =   $request->get('nro_ley');
            $convenio->cod_representante_pcc=   $request->get('representante_pcc');
            $convenio->updated_auth         =   Auth::user()->id;
            $convenio->update();

            #2. Retorno al formulario para la edición de registris
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  $convenio->id,
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

    #9. Elimino el convenio seleccionado
    public function destroy($id)
    {
        try 
        {
            $convenio           =   ConvenioMarco::find($id);
            $convenio->delete();

            #2. Retorno al formulario para la edición de registris
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

    #10. Muestro un formulario para la carga de convenios
    public function formUpload($id)
    {
        #1. Obtengo las variables requeridas
        $convenio       =   ConvenioMarco::findOrFail($id);
        #2. Retorno al formulario
        return view($this->path.'.upload', compact('convenio'));
       
    }

    #11. Procedemos a realizar la carga de la información
    public function upload(UploadConvenioFormRequest $request, $id)
    {
        #1. Obtenemos la información del archivo File
        $new_file   =   $request->file('evidencia');
        $file_name  =   'Convenio_ID_'.rand().time().'.pdf';
        $file_url   =   env('APP_URL_FILE').$file_name;
        #2. Cargamos la evidencia
        $request->file('evidencia')->storeAs('files', $file_name);
        #3. Guardamos la información en la tabla
        try 
        {
            $convenio                       =   ConvenioMarco::findOrFail($id);
            $convenio->file_evidencia       =   Storage::url($file_name);
            $convenio->updated_auth         =   Auth::user()->id;
            $convenio->update();

            #2. Retorno al formulario para la edición de registris
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

    #12. Muestro un formulario para la actualización de convenios Marco
    public function formSituacion($id)
    {
        #1. Obtengo los datos solicitados
        $convenio           =   ConvenioMarco::findOrFail($id);
        $estados            =   TablaValor::getDetalleTabla('EstadoConvenio');
        $tipos_documentos   =   TablaValor::getDetalleTabla('TipoDocumentoTramite');

        #2. Retorno al formulario
        return view($this->path.'.situacion', compact('convenio', 'estados', 'tipos_documentos'));
    }

    #13. Proceso el estado situacional del convenio
    public function situacion(Request $request, $id)
    {
        try 
        {
            $convenio               =   ConvenioMarco::findOrFail($id);
            $convenio->cod_estado   =   $request->get('estado');
            $convenio->updated_auth =   Auth::user()->id;
            $convenio->updated_at   =   $request->get('fecha_actualizacion');
            $convenio->update();

            #2. Retorno al formulario para la edición de registris
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

    #14. Muestro un consolidado de informacion
    public function viewConsolidadoConvenio()
    {
        #1. Obtengo las variables a utilizar
        $estadoConvenio     =   TablaValor::getDetalleTabla('EstadoConvenio');
        $tipoConvenio       =   TablaValor::getDetalleTabla('TipoConvenioMarco'); 

        #2. Retorno al panel principal
        return view('de.convenio-reporte.index', compact('estadoConvenio', 'tipoConvenio'));
    }

    #15. Muestro el resultado de la consulta
    public function showConvenio($tipo, $estado)
    {
        $data   =    ConvenioMarco::getConvenios($tipo, $estado);
        return view('de.convenio-reporte.data', compact('data'));
    }

    #16. Muestro un consolidado de información de seguimiento de convenios
    public function viewConsolidadoSeguimientoConvenio()
    {
        #1. Obtengo las variables a utilizar
        $estadoConvenio     =   TablaValor::getDetalleTabla('EstadoConvenio');
        $tipoConvenio       =   TablaValor::getDetalleTabla('TipoConvenioMarco'); 

        #2. Retorno al panel principal
        return view('de.convenio-seguimiento.index', compact('estadoConvenio', 'tipoConvenio'));
    }

    #17. Muestro el resultado de la consulta
    public function showSeguimientoConvenio($tipo, $estado, $periodo)
    {
        $data   =    ConvenioMarco::getSeguimientoConvenios($tipo, $estado, $periodo);
        return view('de.convenio-seguimiento.data', compact('data'));
    }

    #18. Muestro el panel principal
    public function viewListadoConvenio()
    {
        #1. Obtengo las variables a utilizar
        $estadoConvenio     =   TablaValor::getDetalleTabla('EstadoConvenio');
        $tipoConvenio       =   TablaValor::getDetalleTabla('TipoConvenioMarco'); 
        #2. Retorno al panel principal
        return view('de.convenio-consolidado.index', compact('tipoConvenio', 'estadoConvenio'));
    }

    #19. Muestro el resultado de la consulta
    public function showListadoConvenio($tipo, $periodo, $estado)
    {
        $data   =    ConvenioMarco::getListado($tipo, $periodo, $estado);
        return view('de.convenio-consolidado.data', compact('data'));
    }    

}
