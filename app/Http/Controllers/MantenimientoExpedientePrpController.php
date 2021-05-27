<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\MantenimientoExpedienteFormRequest;
use App\Http\Requests\MantenimientoExpedienteUrFormRequest;
use App\Http\Requests\MantenimientoExpedienteUpfpFormRequest;
use App\Entidad;
use App\Postulante;
use App\Expediente;
use App\ExpedienteUr;
use App\ExpedienteUpfp;
use App\ExpedienteUn;
use App\ExpedienteUaj;
use App\TablaValor;
use App\Area;
use App\Oficina;
use App\CarteraPrp;
use App\Usuario;
use DB;
use Auth;
use Carbon\Carbon;

class MantenimientoExpedientePrpController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path = 'proceso-prp.mantenimiento';

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
    public function show()
    {
        $data   =   DB::select("SELECT * FROM vw_data_expediente a WHERE a.cod_estado_proceso IN (1, 2, 4) AND a.codTipoIncentivo = 2");
        return view($this->path.'.data', compact('data'));
    }

    #5.
    public function edit($id)
    {
        #1. Obtengo los datos requeridos
        $expediente     =   Expediente::findOrFail($id);
        $postulante     =   Postulante::findOrFail($expediente->codPostulante);
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $ur             =   ExpedienteUr::where('codExpediente', $id)->first();
        $upfp           =   ExpedienteUpfp::where('codExpediente', $id)->first();
        $un             =   ExpedienteUn::where('codExpediente', $id)->first();
        $uaj            =   ExpedienteUaj::where('codExpediente', $id)->first();
        $oficinas       =   Oficina::getData();
        $personal       =   Usuario::getData();
        $estados        =   TablaValor::getDetalleTabla("EstadoProceso");
        $areas          =   Area::getData();
        #2. Retorno al formulario de consulta
        return view($this->path.'.edit', compact('expediente', 'postulante', 'entidad', 'ur', 'upfp', 'un', 'uaj', 'oficinas', 'personal', 'estados', 'areas'));
    }

    #6
    public function update(MantenimientoExpedienteFormRequest $request, $id)
    {
        try 
        {
            $expediente                         =   Expediente::findOrFail($id);
            $expediente->nroCut                 =   $request->get('nro_cut');
            $expediente->fechaCut               =   $request->get('fecha_recepcion');
            $expediente->nroExpediente          =   $request->get('nro_expediente');
            $expediente->fechaExpediente        =   $request->get('fecha_expediente');
            $expediente->codOficina             =   $request->get('oficina');
            $expediente->codPersonalAsignado    =   $request->get('especialista_asignado');
            $expediente->updated_auth           =   Auth::user()->id;
            $expediente->update();

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

    #7.
    public function formEditUr($id)
    {
        #1. Obtengo los datos solicitados
        $expediente     =   Expediente::findOrFail($id);
        $expediente_ur  =   ExpedienteUr::where('codExpediente', $expediente->id)->first();
        $personal       =   Usuario::getData();
        $estados        =   TablaValor::getDetalleTabla("EstadoProceso");
        return view($this->path.'.form-ur', compact('expediente', 'expediente_ur', 'personal', 'estados'));
    }

    #8. 
    public function updateExpedienteUr(MantenimientoExpedienteUrFormRequest $request, $id)
    {
        try 
        {
            $ur                                     =   ExpedienteUr::findOrFail($id);
            $ur->fechaRecepcion                     =   $request->get('fecha_recepcion_ur');
            $ur->cod_responsable_geo                =   $request->get('responsable_geo');
            $ur->fecha_solicitud_geo                =   $request->get('fecha_solicitud_geo');
            $ur->fecha_informe_geo                  =   $request->get('fecha_informe_geo');
            $ur->cod_responsable_doc                =   $request->get('responsable_doc');
            $ur->nro_informe_doc                    =   $request->get('nro_informe_doc');
            $ur->fecha_informe_doc                  =   $request->get('fecha_informe_doc');
            $ur->cod_responsable_tec                =   $request->get('responsable_archiva');
            $ur->nro_informe_tec                    =   $request->get('nro_informe_archiva');
            $ur->fecha_informe_tec                  =   $request->get('fecha_informe_archiva');
            $ur->nro_informe_doc_observa            =   $request->get('nro_informe_observa');
            $ur->fecha_informe_doc_observa          =   $request->get('fecha_informe_observa');
            $ur->nro_carta_observa                  =   $request->get('nro_carta_observa');
            $ur->fecha_carta_observa                =   $request->get('fecha_carta_observa');
            $ur->nro_carta_archivo                  =   $request->get('nro_carta_archiva');
            $ur->fecha_carta_archivo                =   $request->get('fecha_carta_archiva');
            $ur->fecha_levanta_observacion          =   $request->get('fecha_levanta_observacion');
            $ur->fecha_derivacion                   =   $request->get('fecha_derivacion');
            $ur->fecha_recibe_expediente_observado  =   $request->get('fecha_recepcion_observacion');
            $ur->observacion                        =   $request->get('observacion');
            $ur->updated_auth                       =   Auth::user()->id;
            $ur->update();

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

    #9. 
    public function formEditUpfp($id)
    {
        #1. Obtengo los datos solicitados
        $expediente     =   Expediente::findOrFail($id);
        $upfp           =   ExpedienteUpfp::where('codExpediente', $expediente->id)->first();
        $personal       =   Usuario::getData();
        $estados        =   TablaValor::getDetalleTabla("EstadoProceso");
        #2. Retorno al formulario
        return view($this->path.'.form-upfp', compact('expediente', 'upfp', 'personal', 'estados'));
    }

    #10. 
    public function updateExpedienteUpfp(MantenimientoExpedienteUpfpFormRequest $request, $id)
    {
        try 
        {
            $upfp                           =   ExpedienteUpfp::findOrFail($id);
            $upfp->fechaRecepcion           =   $request->get('fecha_recepcion');
            $upfp->fecha_eva_campo          =   $request->get('fecha_campo');
            $upfp->fecha_analisis_suelo     =   $request->get('fecha_suelo');
            $upfp->fecha_analisis_agua      =   $request->get('fecha_agua');
            $upfp->fecha_balance_hidrico    =   $request->get('fecha_balance_hidrico');
            $upfp->cod_responsable_tec      =   $request->get('especialista_tecnico');
            $upfp->nro_informe_tec          =   $request->get('nro_informe_tecnico');
            $upfp->fecha_informe_tec        =   $request->get('fecha_informe_tecnico');
            $upfp->cod_responsable_form     =   $request->get('especialista_formulacion');
            $upfp->nro_informe_form         =   $request->get('nro_informe_form');
            $upfp->fecha_informe_form       =   $request->get('fecha_informe_form');
            $upfp->fecha_derivacion         =   $request->get('fecha_derivacion');
            $upfp->HabilitaFormulacion      =   $request->get('habilita_formulacion');
            $upfp->codResponsableAsignado   =   $request->get('especialista_responsable');
            $upfp->updated_auth             =   Auth::user()->id;
            $upfp->update();

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

    #11.
    public function formEditUn($id)
    {
        return view($this->path.'.form-un');
    }

    #10. 
    public function formEditUaj($id)
    {
        return view($this->path.'.form-uaj');
    }

}
