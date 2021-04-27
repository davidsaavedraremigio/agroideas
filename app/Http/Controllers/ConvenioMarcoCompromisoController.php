<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ConvenioMarcoCompromisoFormRequest;
use App\ConvenioMarco;
use App\ConvenioMarcoCompromiso;
use Carbon\Carbon;
use DB;
use Auth;


class ConvenioMarcoCompromisoController extends Controller
{
    
    #1. Defino la ruta de la raiz
    private $path ='de.convenio-compromiso';

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
    public function store(ConvenioMarcoCompromisoFormRequest $request)
    {
        try 
        {
            $compromiso                             =   new ConvenioMarcoCompromiso;
            $compromiso->codInicConvenioMarco       =   $request->get('codigo');
            $compromiso->descripcion                =   $request->get('descripcion');
            $compromiso->cod_estado                 =   1;
            $compromiso->estado                     =   1;
            $compromiso->created_auth               =   Auth::user()->id;    
            $compromiso->updated_auth               =   Auth::user()->id;
            $compromiso->save();

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
        $data       =   ConvenioMarcoCompromiso::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6. 
    public function edit($id)
    {
        $compromiso     =   ConvenioMarcoCompromiso::findOrFail($id);
        $convenio       =   ConvenioMarco::findOrFail($compromiso->codInicConvenioMarco);
    
        #2. retorno al formulario
        return view($this->path.'.edit', compact('compromiso', 'convenio'));
    }

    #7.
    public function update(ConvenioMarcoCompromisoFormRequest $request, $id)
    {
        try 
        {
            $compromiso                 =   ConvenioMarcoCompromiso::findOrFail($id);    
            $compromiso->descripcion    =   $request->get('descripcion');    
            $compromiso->updated_auth   =   Auth::user()->id;
            $compromiso->update();

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

    #8.
    public function destroy($id)
    {
        //
    }
}
