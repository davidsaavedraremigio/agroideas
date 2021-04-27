<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioSdaFormRequest;
use App\Contrato;
use App\Postulante;
use App\PostulanteEstado;
use App\Proyecto;
use App\Entidad;
use App\Expediente;
use App\ExpedienteSdaUaj;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioSdaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.convenio';

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
    public function create($id)
    {
        #1. Obtengo las variables solicitadas
        $postulante     =   Postulante::findOrFail($id);
        $proyecto       =   Proyecto::where('codPostulante', $id)->first();
        $expediente     =   Expediente::where('codPostulante', $id)->first();
        $uaj            =   ExpedienteSdaUaj::where('codExpediente', $expediente->id)->first();
        #2. Retorno a la vista
        return view($this->path.'.create', compact('postulante', 'proyecto', 'expediente', 'uaj'));
    }

    #5.
    public function store(ConvenioSdaFormRequest $request)
    {
        #1. Guardamos la informacion de contrato
        try 
        {
            $contrato                   =   new Contrato;
            $contrato->codPostulante    =   $request->get('codigo');
            $contrato->nroContrato      =   $request->get('numero');
            $contrato->fechaFirma       =   $request->get('fecha');
            $contrato->fechaTermino     =   Carbon::parse($request->get('fecha'))->addMonths($request->get('duracion'));
            $contrato->created_auth     =   Auth::user()->id;
            $contrato->updated_auth     =   Auth::user()->id;
            $contrato->save();

            #2. Actualizo la información del expediente
            try 
            {
                $expediente                 =   Expediente::where('codPostulante', $contrato->codPostulante)->first();
                $expediente->updated_auth   =   Auth::user()->id;
                $expediente->update();

                #3. Actualizo la información del informe de UAJ
                try 
                {
                    $uaj                                        =   ExpedienteSdaUaj::where('codExpediente', $expediente->id)->first();
                    $uaj->cod_responsable                       =   $request->get('responsable');
                    $uaj->nro_informe                           =   $request->get('nro_informe');
                    $uaj->fecha_informe                         =   $request->get('fecha_informe');
                    $uaj->nro_memo_disponibilidad_presupuestal  =   $request->get('nro_memo');
                    $uaj->fecha_memo_disponibilidad_presupuestal=   $request->get('fecha_memo');
                    $uaj->cod_estado_proceso                    =   2;
                    $uaj->updated_auth                          =   Auth::user()->id;
                    $uaj->update();

                    #4. Actualizo el estado del Incentivo
                    try 
                    {
                        $estado                             =   PostulanteEstado::where('codPostulante', $contrato->codPostulante)->first();
                        $estado->codEstadoSituacional       =   3;
                        $estado->updated_auth               =   Auth::user()->id;
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
    public function showDataPendiente()
    {
        return view($this->path.'.data-pendiente');
    }

    #7. 
    public function showDataAprobado()
    {
        return view($this->path.'.data-aprobado');
    }


    #8.
    public function edit($id)
    {
        //
    }

    #9.
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
