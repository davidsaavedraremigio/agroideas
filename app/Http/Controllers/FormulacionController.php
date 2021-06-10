<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\FormulacionFormRequest;
use App\Http\Requests\FormDerivaExpedienteFormRequest;
use App\Expediente;
use App\ExpedienteUpfp;
use App\Postulante;
use App\Entidad;
use App\Proyecto;
use App\TablaValor;
use App\CadenaProductiva;
use App\PostulanteProductor;
use App\PostulanteProductoEspecifico;
use App\Ubigeo;
use App\Usuario;
use Carbon\Carbon;
use DB;
use Auth;


class FormulacionController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='proceso-prp.formulacion';

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
        #1. obtengo la relación de expedientes disponibles para formulacion
        $data   =   Expediente::getDataExpedienteFormulacion();
        #2. retorno a la vista
        return view($this->path.'.data', compact('data'));
    }

    #5.
    public function edit($id)
    {
        #1. Obtengo las variables
        $expediente         =   Expediente::findOrFail($id);
        $postulante         =   Postulante::findOrFail($expediente->codPostulante);
        $proyecto           =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        $tipo_entidad       =   TablaValor::getDetalleTabla('TipoEntidad');
        $cultivos           =   CadenaProductiva::getData();
        $area               =   PostulanteProductor::getAreaReconvertida($expediente->codPostulante);
        $producto           =   PostulanteProductoEspecifico::where([
                                                                'codPostulante'     =>  $expediente->codPostulante,
                                                                'principal'         =>  '1'
                                                            ])->first();
        $beneficiarios      =   PostulanteProductor::getNroBeneficiarios($expediente->codPostulante);
        $upfp               =   ExpedienteUpfp::getData($expediente->id);
        $personal           =   Usuario::getArea(6);

        
        #2. Retorno a la vista
        return view($this->path.'.edit', compact('expediente', 'postulante', 'proyecto', 'entidad', 'tipo_entidad', 'cultivos', 'area', 'producto', 'beneficiarios', 'upfp', 'personal'));
    }

    #6.
    public function update(FormulacionFormRequest $request, $id)
    {
        #1. Actualizo la información del expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizamos el informe de UPFP con los datos de la formulacion
            try 
            {
                $upfp                           =   ExpedienteUpfp::getData($expediente->id);
                $upfp->cod_responsable_form     =   $request->get('especialista');
                $upfp->nro_informe_form         =   $request->get('nro_informe');
                $upfp->fecha_informe_form       =   $request->get('fecha');
                $upfp->updated_auth             =   Auth::user()->id;
                $upfp->update();

                #2. Guardo la información del Proyecto
                try 
                {
                    $proyecto                       =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
                    $proyecto->mlProposito          =   $request->get('objetivo');
                    $proyecto->duracion             =   $request->get('duracion');
                    $proyecto->fecha_inicio         =   $request->get('fecha_inicio');
                    $proyecto->fecha_termino        =   Carbon::parse($request->get('fecha_inicio'))->addMonths($request->get('duracion'));
                    $proyecto->inversion_total      =   $request->get('aporte_pcc')+$request->get('aporte_entidad');
                    $proyecto->inversion_pcc        =   $request->get('aporte_pcc');
                    $proyecto->inversion_entidad    =   $request->get('aporte_entidad');
                    $proyecto->area                 =   $request->get('nro_ha');
                    $proyecto->nro_beneficiarios    =   $request->get('nro_productores');
                    $proyecto->updated_auth         =   Auth::user()->id;
                    $proyecto->update();

                    #3. Retorno a la pagina principal
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

    #7. Formulario para derivar expediente
    public function formDerivaExpediente($id)
    {
        #1. Obtengo los datos solicitados
        $expediente         =   Expediente::findOrFail($id);
        $upfp               =   ExpedienteUpfp::getData($id);
        $area               =   6;
        $personal           =   Usuario::getArea($area);

        #2. Retorno al formulario
        return view($this->path.'.form-deriva', compact('expediente', 'upfp', 'area', 'personal'));
    }

    #8. Procesamos la derivación de expediente
    public function derivaExpediente(FormDerivaExpedienteFormRequest $request, $id)
    {
        try 
        {
            $expediente                 =   Expediente::findOrFail($id);
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            try 
            {
                $upfp                           =   ExpedienteUpfp::getData($id);
                $upfp->cod_responsable_form     =   $request->get('especialista');
                $upfp->nro_informe_form         =   $request->get('nro_informe');
                $upfp->fecha_informe_form       =   $request->get('fecha_informe');
                $upfp->nro_memo_derivacion      =   $request->get('nro_memo');
                $upfp->fecha_memo_derivacion    =   $request->get('fecha_memo');
                $upfp->fecha_derivacion         =   $request->get('fecha_derivacion');
                $upfp->updated_auth             =   Auth::user()->id;
                $upfp->update();

                    #3. Bloqueo los datos del proyecto
                    try 
                    {
                        $postulante                 =   Postulante::findOrFail($expediente->codPostulante);
                        $proyecto                   =   Proyecto::where('codPostulante', $postulante->id)->first();
                        $proyecto->estado           =   0;
                        $proyecto->updated_auth     =   Auth::user()->id;
                        $proyecto->update();

                        #3. Retorno a la pagina principal
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
