<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ContratoFormRequest;
use App\Contrato;
use App\Postulante;
use App\PostulanteEstado;
use App\ResolucionMinisterial;
use App\Proyecto;
use App\Entidad;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ContratoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.convenio';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3. Muestro el panel principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para la creación del convenio
    public function create($id)
    {
        #1. Obtengo las variables solicitadas
        $postulante     =   Postulante::findOrFail($id);
        $proyecto       =   Proyecto::where('codPostulante', $id)->first();
        $rm             =   ResolucionMinisterial::where('codPostulante', $id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad)->first();

        #2. Retorno al formulario de registro
        return view($this->path.'.create', compact('postulante', 'proyecto', 'rm', 'entidad'));
    }

    #5.Realizo el registro de la información de contrato
    public function store(ContratoFormRequest $request)
    {
        #1. Guardo la información del convenio Marco
        try 
        {
            $convenio                   =   new Contrato;
            $convenio->codPostulante    =   $request->get('codigo');
            $convenio->nroContrato      =   $request->get('nro_contrato');
            $convenio->fechaFirma       =   $request->get('fecha');
            $convenio->fechaTermino     =   Carbon::parse($request->get('fecha'))->addMonths($request->get('duracion'));
            $convenio->created_auth     =   Auth::user()->id;
            $convenio->updated_auth     =   Auth::user()->id;
            $convenio->save();

            #2. actualizo el estado situacional del Postulante
            try 
            {
                $estado                         =   PostulanteEstado::where('codPostulante', $convenio->codPostulante)->first();
                $estado->codEstadoSituacional   =   3;#Vigente
                $estado->updated_auth           =   Auth::user()->id;
                $estado->update();

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

    #6. Ontengo las Resoluciones ministeriales que aun no tienen convenio
    public function showDataPendiente()
    {
        $data       =   DB::select("SELECT
                            b.id,
                            LTRIM(RIGHT('0000' + CAST(f.nroResolucion AS varchar(4)), 4))+'-'+LTRIM(YEAR(f.fechaFirma)) nro_rm,
                            d.nroDocumento ruc,
                            d.nombre,
                            d.region,
                            d.provincia,
                            d.distrito,
                            e.fecha_inicio,
                            e.duracion,
                            e.inversion_pcc,
                            e.inversion_entidad,
                            e.inversion_total
                        FROM InicResolucionMinisterial a
                        INNER JOIN (
                            SELECT * FROM InicPostulante
                        ) b ON b.id = a.codPostulante
                        LEFT JOIN (
                            SELECT * FROM InicContrato
                        ) c ON c.codPostulante = a.codPostulante
                        LEFT JOIN (
                            SELECT * FROM vw_data_opa
                        ) d ON d.id = b.codEntidad
                        LEFT JOIN (
                            SELECT * FROM InicProyecto
                        ) e ON e.codPostulante = a.codPostulante
                        LEFT JOIN (
                            SELECT * FROM InicResolucionMinisterial
                        ) f ON f.codPostulante = a.codPostulante
                        WHERE b.codTipoIncentivo = 2 AND c.id IS NULL");
        
        return view($this->path.'.data', compact('data'));
    }

    #7. Obtengo la relación de Convenios registrados
    public function showData()
    {
        $data       =   Contrato::getDataPrp();
        return view($this->path.'.data-convenio', compact('data'));
    }

    #8. Muestro el formulario de edicion de estados de convenios
    public function editEstadoContrato($id)
    {
        #1. Obtengo los datos requeridos
        $contrato           =   Contrato::findOrFail($id);
        $postulante         =   Postulante::findOrFail($contrato->codPostulante);
        $estado             =   PostulanteEstado::where('codPostulante', $postulante->id)->first();
        $estados            =   TablaValor::getDetalleTabla('EstadoSituacional');
        #2. Retorno al formulario
        return view($this->path.'.estado', compact('postulante', 'contrato', 'estado', 'estados'));
    }

    #9. Actualizo el estado situacional del Convenio
    public function updateEstadoContrato(Request $request, $id)
    {
        #1. Actualizo la información de Postulante
        try 
        {
            $postulante                 =   Postulante::findOrFail($id);
            $postulante->updated_auth   =   Auth::user()->id;
            $postulante->update();

            #2. Actualizo el estado situacional
            try 
            {
                $estado                         =   PostulanteEstado::where('codPostulante', $postulante->id)->first();
                $estado->codEstadoSituacional   =   $request->get('estado');
                $estado->updated_auth           =   Auth::user()->id;
                $estado->update();

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
}
