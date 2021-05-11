<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoCooperanteFormRequest;
use App\TablaValor;
use App\ConvenioMarco;
use App\ConvenioMarcoCooperante;
use App\EntidadCooperante;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class ConvenioMarcoCooperanteController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='de.convenio-cooperante';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        return view($this->path.'.create', compact('convenio'));
    }

    #4.
    public function store(ConvenioMarcoCooperanteFormRequest $request)
    {
        #1. Guardo la información de la entidad cooperante
        try 
        {
            $entidad        =   EntidadCooperante::updateOrCreate(['nro_documento' => $request->get('ruc')],[
                'tipo_documento'        =>  1,
                'tipo_entidad'          =>  $request->get('tipo'),
                'nombre'                =>  $request->get('razon_social'),
                'ubigeo'                =>  $request->get('ubigeo'),
                'direccion'             =>  $request->get('direccion'),
                'estado'                =>  1,
                'created_auth'          =>  Auth::user()->id,
                'updated_auth'          =>  Auth::user()->id,
            ]);

            #2. Guardo la información de la entidad cooperante
            try 
            {
                $cooperante                             =   new ConvenioMarcoCooperante;
                $cooperante->codEntidadCooperante       =   $entidad->id;
                $cooperante->codInicConvenioMarco       =   $request->get('codigo');
                $cooperante->nro_documento              =   $request->get('dni');
                $cooperante->nombres                    =   $request->get('nombres');
                $cooperante->paterno                    =   $request->get('paterno');
                $cooperante->materno                    =   $request->get('materno');
                $cooperante->cargo                      =   $request->get('cargo');
                $cooperante->estado                     =   1;
                $cooperante->principal                  =   $request->get('principal');
                $cooperante->created_auth               =   Auth::user()->id;
                $cooperante->updated_auth               =   Auth::user()->id;
                $cooperante->save();

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

    #5. 
    public function show($id)
    {
        $data       =   ConvenioMarcoCooperante::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $cooperante         =   ConvenioMarcoCooperante::findOrFail($id);
        $entidad            =   EntidadCooperante::findOrFail($cooperante->codEntidadCooperante);
        $convenio           =   ConvenioMarco::findOrFail($cooperante->codInicConvenioMarco);
        return view($this->path.'.edit', compact('cooperante', 'entidad', 'convenio'));
    }

    #7.
    public function update(ConvenioMarcoCooperanteFormRequest $request, $id)
    {
        #1. Actualizo la información de la entidad cooperante
        try 
        {
            $cooperante                 =   ConvenioMarcoCooperante::findOrFail($id);
            $cooperante->nro_documento  =   $request->get('dni');
            $cooperante->nombres        =   $request->get('nombres');
            $cooperante->paterno        =   $request->get('paterno');
            $cooperante->materno        =   $request->get('materno');
            $cooperante->cargo          =   $request->get('cargo');
            $cooperante->principal      =   $request->get('principal');
            $cooperante->updated_auth   =   Auth::user()->id;
            $cooperante->updated_at     =   now();
            $cooperante->update();

            #2. Actualizo la información  
            try 
            {
                $entidad                =   EntidadCooperante::findOrFail($cooperante->codEntidadCooperante);
                $entidad->tipo_entidad  =   $request->get('tipo');
                $entidad->nombre        =   $request->get('razon_social');
                $entidad->ubigeo        =   $request->get('ubigeo');
                $entidad->direccion     =   $request->get('direccion');
                $entidad->updated_auth  =   Auth::user()->id;
                $entidad->updated_at    =   now();
                $entidad->updated();

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

    #8. Eliminamos a la entidad seleccionada
    public function destroy($id)
    {
        #1. Elimino a la entidad
        try 
        {
            $cooperante         =   ConvenioMarcoCooperante::find($id);
            $cooperante->delete();

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
