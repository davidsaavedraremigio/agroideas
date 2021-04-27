<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\DifusionEntidadFormRequest;
use App\Difusion;
use App\DifusionRendicion;
use App\DifusionEjecucion;
use App\DifusionEntidadParticipante;
use App\TablaValor;
use App\Ubigeo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class DifusionEntidadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.difusion-entidad-participante';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        #1. Obtengo las variables a enviar
        $implementacion     =   DifusionEjecucion::findOrFail($id);
        $difusion           =   Difusion::findOrFail($implementacion->codInicDifusion);
        $tipo_entidad       =   TablaValor::getDetalleTabla('TipoEntidad');
        $regiones           =   Ubigeo::getRegiones();

        #2. Retorno al menu principal
        return view($this->path.'.create', compact('implementacion', 'difusion', 'tipo_entidad', 'regiones'));

    }

    #4. 
    public function store(DifusionEntidadFormRequest $request)
    {
        try 
        {
            $entidad                        =   new DifusionEntidadParticipante;
            $entidad->codInicDifusion       =   $request->get('codigo');
            $entidad->ruc                   =   $request->get('ruc');
            $entidad->razonSocial           =   $request->get('razon_social');
            $entidad->codTipoEntidad        =   $request->get('tipo_entidad');
            $entidad->ubigeo                =   $request->get('distrito');
            $entidad->direccion             =   $request->get('direccion');
            $entidad->nombrePersonaContacto =   $request->get('nombre_contacto');
            $entidad->nroTelefono           =   $request->get('telefono');
            $entidad->email                 =   $request->get('email');
            $entidad->cargoPersonaContacto  =   $request->get('cargo');
            $entidad->estado                =   1;
            $entidad->created_auth          =   Auth::user()->id;
            $entidad->updated_auth          =   Auth::user()->id;
            $entidad->save();

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

    #5.
    public function show($id)
    {
        $implementacion     =   DifusionEjecucion::findOrFail($id);
        $data               =   DifusionEntidadParticipante::getData($implementacion->codInicDifusion);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        #1. Obtengo la relacion de variables
        $entidad            =   DifusionEntidadParticipante::findOrFail($id);
        $tipo_entidad       =   TablaValor::getDetalleTabla('TipoEntidad');
        $regiones           =   Ubigeo::getRegiones();
        
        #3. Retornamos al formulario
        return view($this->path.'.edit', compact('entidad', 'tipo_entidad', 'regiones'));
    }

    #7.
    public function update(DifusionEntidadFormRequest $request, $id)
    {
        try 
        {
            $entidad                        =   DifusionEntidadParticipante::findOrFail($id);
            $entidad->ruc                   =   $request->get('ruc');
            $entidad->razonSocial           =   $request->get('razon_social');
            $entidad->codTipoEntidad        =   $request->get('tipo_entidad');
            $entidad->ubigeo                =   $request->get('distrito');
            $entidad->direccion             =   $request->get('direccion');
            $entidad->nombrePersonaContacto =   $request->get('nombre_contacto');
            $entidad->nroTelefono           =   $request->get('telefono');
            $entidad->email                 =   $request->get('email');
            $entidad->cargoPersonaContacto  =   $request->get('cargo');
            $entidad->updated_auth          =   Auth::user()->id;
            $entidad->update();

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

    #8
    public function destroy($id)
    {
        try 
        {
            $entidad        =   DifusionEntidadParticipante::find($id);
            $entidad->delete();

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
