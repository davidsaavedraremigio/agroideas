<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\PostulanteProductorFormRequest;
use App\Http\Requests\UpdateEvaluacionFinalProductorFormRequest;
use App\Http\Requests\EvaluacionCampoProductorFormRequest;
use App\Http\Requests\BalanceHidricoProductorFormRequest;
use App\Postulante;
use App\Persona;
use App\PersonaEntidad;
use App\ProductorPrp;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class PostulanteProductorController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.socio';

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
        #1. obtengo los datos del postulante
        $postulante     =   Postulante::findOrFail($id);
        $maxDate        =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate        =   ((Carbon::now())->subYears(100))->format('Y-m-d');
        #2. Obtengo las variables que iran a los combos
        $cargos         =   TablaValor::getDetalleTabla('CargoDirectivo');
        #3. Retorno al formulario
        return view($this->path.'.create', compact('cargos', 'postulante', 'minDate', 'maxDate'));
    }

    #5.
    public function store(PostulanteProductorFormRequest $request)
    {
        #1. Guardamos la información de la persona
        try 
        {
            $persona                =   Persona::updateOrCreate(['dni' => $request->get('nro_documento')],[
                                            'nombres'           =>  $request->get('nombres'),
                                            'paterno'           =>  $request->get('paterno'),
                                            'materno'           =>  $request->get('materno'),
                                            'fechaNacimiento'   =>  $request->get('fecha'),
                                            'sexo'              =>  $request->get('sexo'),
                                            'direccion'         =>  $request->get('direccion'),
                                            'validado_reniec'   =>  1,
                                            'created_auth'      =>  Auth::user()->id,
                                            'updated_auth'      =>  Auth::user()->id,
                                        ]);

            #2. Guardamos la información de la entidad
            try 
            {
                #2.1. Obtengo el codigo de la entidad
                $postulante                 =   Postulante::findOrFail($request->get('codigo'));
                $personaEntidad             =   new PersonaEntidad;
                $personaEntidad             =   PersonaEntidad::updateOrCreate([
                                                    'dniPersona'    => $request->get('nro_documento'), 
                                                    'codEntidad'    => $postulante->codEntidad],[
                                                    'estado'        =>  1,
                                                    'created_auth'  =>  Auth::user()->id,
                                                    'updated_auth'  =>  Auth::user()->id,
                                                ]);
                #3. Guardamos la información del productor
                try 
                {
                    $productor                          =   new ProductorPrp;
                    $productor->codPersonaEntidad       =   $personaEntidad->id;
                    $productor->tipoPropietario         =   $request->get('tipo_propietario');
                    $productor->nroHaSolicitaReconvertir=   $request->get('nro_ha_solicitada');
                    $productor->nroHaPropiedad          =   $request->get('nro_ha');
                    $productor->codPostulante           =   $postulante->id;
                    $productor->cod_estado                  =   1;
                    $productor->created_auth            =   Auth::user()->id;
                    $productor->updated_auth            =   Auth::user()->id;
                    $productor->save();

                    #4. Retorno al menu principal
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

    #6.
    public function show($id)
    {
        $data       =   ProductorPrp::getData($id);
        #2. Retorno a la vista principal
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        #1. Obtenemos los datos del Productor
        $productor      =   ProductorPrp::findOrFail($id);
        $personaEntidad =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
        $persona        =   Persona::findOrFail($personaEntidad->dniPersona);
        $maxDate        =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate        =   ((Carbon::now())->subYears(100))->format('Y-m-d');
        $cargos         =   TablaValor::getDetalleTabla('CargoDirectivo');
        #2. Retorno al formulario
        return view($this->path.'.edit', compact('productor', 'personaEntidad', 'persona', 'maxDate', 'minDate', 'cargos'));
    }

    #8.
    public function update(PostulanteProductorFormRequest $request, $id)
    {
        #1. Guardamos la información del productor
        try 
        {
            $productor                              =   ProductorPrp::findOrFail($id);
            $productor->tipoPropietario             =   $request->get('tipo_propietario');
            $productor->nroHaSolicitaReconvertir    =   $request->get('nro_ha_solicitada');
            $productor->nroHaPropiedad              =   $request->get('nro_ha');
            $productor->updated_auth                =   Auth::user()->id;
            $productor->update();

            #2. Guardamos la información 
            try 
            {
                $personaEntidad                     =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
                $personaEntidad->updated_auth       =   Auth::user()->id;
                $personaEntidad->update();

                #3. Actualizamos los datos de la persona
                try 
                {
                    $persona                    =   Persona::findOrFail($personaEntidad->dniPersona);
                    $persona->nombres           =   $request->get('nombres');
                    $persona->paterno           =   $request->get('paterno');
                    $persona->materno           =   $request->get('materno');
                    $persona->fechaNacimiento   =   $request->get('fecha');
                    $persona->sexo              =   $request->get('sexo');
                    $persona->direccion         =   $request->get('direccion');
                    $persona->validado_reniec   =   1;
                    $persona->updated_auth      =   Auth::user()->id;
                    $persona->update();

                    #4. Retorno al menu principal
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

    #9.
    public function destroy($id)
    {
        //
    }

    #10. Muestro los datos de los resultados de evaluación final
    public function showResultado($id)
    {
        $data       =   ProductorPrp::getData($id);
        return view('proceso-prp.resultado.data', compact('data'));
    }

    #11. Muestro el formulario para la actualización de resultados final de evaluacion
    public function editResultado($id)
    {
        #1. Obtengo las variables a actualizar
        $productor      =   ProductorPrp::findOrFail($id);
        $personaEntidad =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
        $persona        =   Persona::findOrFail($personaEntidad->dniPersona);

        #2. Retorno al formulario
        return view('proceso-prp.resultado.edit', compact('persona', 'personaEntidad', 'productor'));
    }

    #12. Realizamos la actualización de la información de evaluación
    public function updateResultado(UpdateEvaluacionFinalProductorFormRequest $request, $id)
    {
        #1. Actualizamos la info del productor
        try 
        {
            $productor                              =   ProductorPrp::findOrFail($id);
            $productor->nroHaSolicitaReconvertir    =   $request->get('nro_ha_solicitada');
            $productor->nroHaPropiedad              =   $request->get('nro_ha');
            $productor->nroHaReconvertir            =   $request->get('nro_ha_final');
            $productor->resultadoFinal              =   $request->get('resultado_final');
            $productor->cod_estado                      =   $request->get('resultado_final');
            $productor->comentarioResultadoFinal    =   $request->get('comentarios');
            $productor->updated_auth                =   Auth::user()->id;
            $productor->update();

            #2. Si el beneficiario resulta no habilitado entonces lo damos de baja
            if ($productor->resultadoFinal == 0) 
            {
                #2.1. Actualizo el estado de la persona
                try 
                {
                    $personaEntidad         =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
                    $personaEntidad->estado =   0;
                    $personaEntidad->update();

                    #2.2. Retorno al menu principal
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
            #4. Caso contrario retorno al menu principal
            else
            {
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  '',
                    'mensaje'   =>  'La información se procesó de manera exitosa.'
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

    #13. Muestro los datos de los resultados de la evaluación de campo
    public function showEvaluacionCampo($id)
    {
        $data       =   ProductorPrp::getData($id);
        return view('proceso-prp.campo.data', compact('data'));
    }

    #14. Muestro el formulario para la actualizacion de los resultados de la evaluacion de campo
    public function editEvaluacionCampo($id)
    {
        #1. Obtengo las variables a actualizar
        $productor      =   ProductorPrp::findOrFail($id);
        $personaEntidad =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
        $persona        =   Persona::findOrFail($personaEntidad->dniPersona);

        #2. Retorno al formulario
        return view('proceso-prp.campo.edit', compact('persona', 'personaEntidad', 'productor'));
    }

    #15. Actualizamos la información de la verificacion de campo
    public function updateEvaluacionCampo(EvaluacionCampoProductorFormRequest $request, $id)
    {
        #1. Actualizamos la info del productor
        try 
        {
            $productor                              =   ProductorPrp::findOrFail($id);
            $productor->nroHaSolicitaReconvertir    =   $request->get('nro_ha_solicitada');
            $productor->nroHaPropiedad              =   $request->get('nro_ha');
            $productor->nroHaReconvertirPlano       =   $request->get('nro_ha_plano');
            $productor->nroHaRiego                  =   $request->get('nro_ha_riego');
            $productor->nroHaDisponible             =   $request->get('nro_ha_geo');
            $productor->resultadoEvaluacionCampo    =   $request->get('resultado_final');
            $productor->comentarioEvaluacionCampo   =   $request->get('comentario');
            $productor->updated_auth                =   Auth::user()->id;
            $productor->update();

            #2. Actualizo el numero de productores aprobados

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

    #16. Muestro los datos de los resultados del balance hidrico
    public function showBalanceHidrico($id)
    {
        $data       =   ProductorPrp::getData($id);
        return view('proceso-prp.hidrico.data', compact('data'));
    }

    #17. Muestro el formulario para la actualizacion de los resultados de la evaluacion de campo
    public function editBalanceHidrico($id)
    {
        #1. Obtengo las variables a actualizar
        $productor      =   ProductorPrp::findOrFail($id);
        $personaEntidad =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
        $persona        =   Persona::findOrFail($personaEntidad->dniPersona);

        #2. Retorno al formulario
        return view('proceso-prp.hidrico.edit', compact('persona', 'personaEntidad', 'productor'));
    }

    #18. Actualizamos la información de la verificacion de campo
    public function updateBalanceHidrico(BalanceHidricoProductorFormRequest $request, $id)
    {
        #1. Actualizamos la info del productor
        try 
        {
            $productor                              =   ProductorPrp::findOrFail($id);
            $productor->nroHaSolicitaReconvertir    =   $request->get('nro_ha_solicitada');
            $productor->nroHaPropiedad              =   $request->get('nro_ha');
            $productor->resultadoAnalisisSuelo      =   $request->get('resultado_suelo');
            $productor->resultadoAnalisisAgua       =   $request->get('resultado_agua');
            $productor->resultadoBalanceHidrico     =   $request->get('resultado_hidrico');
            $productor->comentarioBalanceHidrico    =   $request->get('comentario');
            $productor->updated_auth                =   Auth::user()->id;
            $productor->update();

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
