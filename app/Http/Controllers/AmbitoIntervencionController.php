<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\AmbitoIntervencionFormRequest;
use App\Postulante;
use App\AmbitoIntervencion;
use App\Ubigeo;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class AmbitoIntervencionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.ambito';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. 
    public function create($id)
    {
        $postulante         =   Postulante::findOrFail($id);
        $regiones           =   Ubigeo::getRegiones();  

        return view($this->path.'.create', compact('postulante', 'regiones'));
    }

    #4.
    public function store(AmbitoIntervencionFormRequest $request)
    {
        try 
        {
            $ambito                     =   new  AmbitoIntervencion;
            $ambito->codPostulante      =   $request->get('codigo');
            $ambito->ubigeo             =   $request->get('distrito');
            $ambito->latitud            =   $request->get('latitud');
            $ambito->longitud           =   $request->get('longitud');
            $ambito->descripcion        =   $request->get('descripcion');
            $ambito->principal          =   $request->get('principal');
            $ambito->created_auth       =   Auth::user()->id;
            $ambito->updated_auth       =   Auth::user()->id;
            $ambito->save();

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
        $data       =   AmbitoIntervencion::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $ubigeo         =   AmbitoIntervencion::findOrFail($id);
        $regiones       =   Ubigeo::getRegiones();
        $provincias     =   Ubigeo::getProvincias(Str::substr($ubigeo->ubigeo, 0, 2));
        $distritos      =   Ubigeo::getDistritos(Str::substr($ubigeo->ubigeo, 0, 4));

        return view($this->path.'.edit', compact('ubigeo', 'regiones', 'provincias', 'distritos'));
    }

    #7
    public function update(AmbitoIntervencionFormRequest $request, $id)
    {
        try 
        {
            $ubigeo                 =   AmbitoIntervencion::findOrFail($id);
            $ubigeo->ubigeo         =   $request->get('distrito');
            $ubigeo->latitud        =   $request->get('latitud');
            $ubigeo->longitud       =   $request->get('longitud');
            $ubigeo->descripcion    =   $request->get('descripcion');
            $ubigeo->principal      =   $request->get('principal');
            $ubigeo->updated_auth   =   Auth::user()->id;
            $ubigeo->update();

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

    #8.
    public function destroy($id)
    {
        //
    }
}
