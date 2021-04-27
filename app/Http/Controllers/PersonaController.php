<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use App\Persona;
use App\PersonaEntidad;
use App\TablaValor;
use App\Ubigeo;
use Carbon\Carbon;
use DB;
use Auth;

class PersonaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sp.beneficiario';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }        
    
    #3. Mostramos el formulario para el registro de nuevos beneficiarios
    public function create($id)
    {
        #1. Obtengo el codigo del proyecto
        $idProyecto =   $id;
        #2. Obtengo los valores minimos y máximos para las edades
        $maxDate    =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate    =   ((Carbon::now())->subYears(100))->format('Y-m-d');
        #3. Retorno a la vista principal
        return view($this->path.'.create', compact('idProyecto', 'maxDate', 'minDate'));
    }

    #4. Guardamos la información del beneficiario
    public function store(PersonaFormRequest $request)
    {
        #1. Guardamos los datos de la persona
        try 
        {
            $persona        =   Persona::updateOrCreate(['dni' => $request->get('nro_documento')],[
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
            #2. Guardamos los datos correspondientes a la asignación en la entidad
            try 
            {
                $beneficiario                   =   new PersonaEntidad;
                $beneficiario->dniPersona       =   $persona->dni;
                $beneficiario->codEntidad       =   $request->get('codEntidad');
                $beneficiario->estado           =   1;
                $beneficiario->created_auth     =   Auth::user()->id;
                $beneficiario->updated_auth     =   Auth::user()->id;
                $beneficiario->save();

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

    #5. Mostramos la relación de beneficiarios de la entidad
    public function show($id)
    {
        $data       =   PersonaEntidad::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6. Mostramos el formulario para la edición de registros
    public function edit($id)
    {
        #1. Obtengo los datos del beneficiario
        $productor  =   PersonaEntidad::findOrFail($id);
        #2. Obtengo los datos de la persona
        $persona    =   Persona::findOrFail($productor->dniPersona);
        #3. Obtengo los valores minimos y máximos para las edades
        $maxDate    =   ((Carbon::now())->subYears(18))->format('Y-m-d');
        $minDate    =   ((Carbon::now())->subYears(100))->format('Y-m-d');
        #4. Retorno al formulario de edición de datos
        return view($this->path.'.edit', compact('productor', 'persona', 'maxDate', 'minDate'));
    }

    #7. Actualizamos la información de beneficiarios
    public function update(PersonaFormRequest $request, $id)
    {
        #1. Actualizamos la información de beneficiario
        try 
        {
            $beneficiario                   =   PersonaEntidad::findOrFail($id);
            $beneficiario->updated_auth     =   Auth::user()->id;
            $beneficiario->update();

            #2. Actualizamos la información de la persona
            try 
            {
                $persona                    =   Persona::findOrFail($beneficiario->dniPersona);
                $persona->nombres           =   $request->get('nombres');
                $persona->paterno           =   $request->get('paterno');
                $persona->materno           =   $request->get('materno');
                $persona->fechaNacimiento   =   $request->get('fecha');
                $persona->sexo              =   $request->get('sexo');
                $persona->direccion         =   $request->get('direccion');
                $persona->validado_reniec   =   1;
                $persona->updated_auth      =   Auth::user()->id;
                $persona->update();

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

    #8. Doy de baja a una persona
    public function destroy($id)
    {
        //
    }
}
