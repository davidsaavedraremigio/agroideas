<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProductorPrpaFormRequest;
use App\Postulante;
use App\Persona;
use App\PersonaEntidad;
use App\ProductorPrp;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ProductorPrpaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='prpa.productor';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        #1. Obtengo los datos 
        $postulante     =   Postulante::findOrFail($id);
        $maxDate        =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate        =   ((Carbon::now())->subYears(100))->format('Y-m-d');
        
        #2. Retorno al formulario
        return view($this->path.'.create', compact('postulante', 'minDate', 'maxDate'));
    }

    #4.
    public function store(ProductorPrpaFormRequest $request)
    {
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
        #1. Obtengo la información de los Productores
        $data   =   ProductorPrp::getAprobados($id);
        #2. Retorno a la vista
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        #1. Obtenemos la información requerida
        $productor      =   ProductorPrp::findOrFail($id);
        $personaEntidad =   PersonaEntidad::findOrFail($productor->codPersonaEntidad);
        $persona        =   Persona::findOrFail($personaEntidad->dniPersona);
        $maxDate        =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate        =   ((Carbon::now())->subYears(100))->format('Y-m-d');

        #2. Retornamos al formulario
        return view($this->path.'.edit', compact('productor', 'personaEntidad', 'persona', 'maxDate', 'minDate'));
    }

    #7.
    public function update(ProductorPrpaFormRequest $request, $id)
    {
        #1. Actualizo la información del productor
        try 
        {
            $productor                      =   ProductorPrp::findOrFail($id);
            $productor->tipoPropietario     =   $request->get('tipo');
            $productor->latitud             =   $request->get('latitud');
            $productor->longitud            =   $request->get('longitud');
            $productor->altitud             =   $request->get('altitud');
            $productor->nro_ha_final        =   $request->get('nro_ha');
            $productor->aporte             =   $request->get('importe');
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

    #8.
    public function destroy($id)
    {
        //
    }
}
