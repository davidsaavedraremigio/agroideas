<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProductorSdaFormRequest;
use App\Postulante;
use App\Persona;
use App\PersonaEntidad;
use App\ProductorSda;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ProductorSdaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.productor';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        #1. obtengo los datos del postulante
        $postulante     =   Postulante::findOrFail($id);
        $maxDate        =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate        =   ((Carbon::now())->subYears(100))->format('Y-m-d');

        #2. Retorno al formulario de registro
        return view($this->path.'.create', compact('postulante', 'maxDate', 'minDate'));
    }

    #4.
    public function store(ProductorSdaFormRequest $request)
    {
        #1. Registro la información de la persona
        try 
        {
            $persona                =   Persona::updateOrCreate(['dni' => $request->get('dni')],[
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

            #2. Asigno el productor a la Entidad
            try 
            {
                $postulante                 =   Postulante::findOrFail($request->get('codigo'));
                $personaEntidad             =   PersonaEntidad::updateOrCreate(['dniPersona'    => $request->get('dni'), 'codEntidad'    => $postulante->codEntidad],[
                                                    'estado'        =>  1,
                                                    'created_auth'  =>  Auth::user()->id,
                                                    'updated_auth'  =>  Auth::user()->id,
                                                ]);

                #3. Guardamos la información del productor
                try 
                {
                    $productor                      =   new ProductorSda;
                    $productor->codPersonaEntidad   =   $personaEntidad->id;
                    $productor->codPostulante       =   $postulante->id;
                    $productor->tipoPropietario     =   $request->get('tipo');
                    $productor->nroHa               =   $request->get('nro_ha');
                    $productor->aporte              =   $request->get('aporte');
                    $productor->fechaIncorporacion  =   Carbon::now();
                    $productor->estado              =   1;
                    $productor->created_auth        =   Auth::user()->id;
                    $productor->updated_auth        =   Auth::user()->id;
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

    #5.
    public function show($id)
    {
        $data   =   ProductorSda::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #5. 
    public function edit($id)
    {
        #1. Obtenemos la información requerida
        $productor      =   ProductorSda::findOrFail($id);
        $personaEntidad =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
        $persona        =   Persona::findOrFail($personaEntidad->dniPersona);
        $maxDate        =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate        =   ((Carbon::now())->subYears(100))->format('Y-m-d');

        #2. Retorno al menu principal
        return view($this->path.'.edit', compact('productor', 'personaEntidad', 'persona', 'maxDate', 'minDate'));
    }

    #6.
    public function update(ProductorSdaFormRequest $request, $id)
    {
        #1. Actualizo la información del Productor
        try 
        {
            $productor                      =   ProductorSda::findOrFail($id);
            $productor->tipoPropietario     =   $request->get('tipo');
            $productor->nroHa               =   $request->get('nro_ha');
            $productor->aporte              =   $request->get('aporte');
            $productor->updated_auth        =   Auth::user()->id;
            $productor->update();

            #2. Actualizo la información de la tabla Persona Entidad
            try 
            {
                $personaEntidad                 =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
                $personaEntidad->updated_auth   =   Auth::user()->id;
                $personaEntidad->update();

                #3. Actualizo la información de la Persona
                try 
                {
                    $persona                    =   Persona::findOrFail($personaEntidad->dniPersona);
                    $persona->nombres           =   $request->get('nombres');
                    $persona->paterno           =   $request->get('paterno');
                    $persona->materno           =   $request->get('materno');
                    $persona->fechaNacimiento   =   $request->get('fecha');
                    $persona->sexo              =   $request->get('sexo');
                    $persona->direccion         =   $request->get('direccion');
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

    #7.
    public function destroy($id)
    {
        try 
        {
            $productor                      =   ProductorSda::findOrFail($id);
            $productor->estado              =   0;
            $productor->updated_auth        =   Auth::user()->id;
            $productor->update();

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
}
