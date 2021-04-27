<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoPostulanteFormRequest;
use App\ConvenioMarco;
use App\Postulante;
use App\ConvenioMarcoPostulante;
use App\Usuario;
use Carbon\Carbon;
use DB;
use Auth;

class ConvenioMarcoPostulanteController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-postulante';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        $convenio       =   ConvenioMarco::findOrFail($id);
        $postulante     =   Postulante::getConsolidado();

        return view($this->path.'.create', compact('convenio', 'postulante'));
    }

    #4.
    public function store(ConvenioMarcoPostulanteFormRequest $request)
    {
        try 
        {
            $postulante                         =   new ConvenioMarcoPostulante;
            $postulante->codInicConvenioMarco   =   $request->get('codigo');
            $postulante->codPostulante          =   $request->get('postulante');
            $postulante->estado                 =   1;
            $postulante->created_auth           =   Auth::user()->id;
            $postulante->updated_auth           =   Auth::user()->id;
            $postulante->save();

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
        $data       =   ConvenioMarcoPostulante::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function destroy($id)
    {
        try 
        {
            $postulante             =   ConvenioMarcoPostulante::findOrFail($id);
            $postulante->estado     =   0;
            $postulante->update();

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
