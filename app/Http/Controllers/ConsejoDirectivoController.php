<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ConsejoDirectivoFormRequest;
use App\ConsejoDirectivo;
use Carbon\Carbon;
use DB;
use Auth;


class ConsejoDirectivoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.cd';

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
    public function create()
    {
        return view($this->path.'.create');
    }

    #5.
    public function store(ConsejoDirectivoFormRequest $request)
    {
        try 
        {
            $cd                 =   new ConsejoDirectivo;
            $cd->numero         =   $request->get('numero');
            $cd->fecha          =   $request->get('fecha');
            $cd->descripcion    =   $request->get('objetivo');
            $cd->created_auth   =   Auth::user()->id;
            $cd->updated_auth   =   Auth::user()->id;
            $cd->save();

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

    #6.
    public function show()
    {
        return view($this->path.'.data');
    }

    #7.
    public function edit($id)
    {
        $cd         =   ConsejoDirectivo::findOrFail($id);
        return view($this->path.'.edit', compact('cd'));
    }

    #8.
    public function update(ConsejoDirectivoFormRequest $request, $id)
    {
        try 
        {
            try 
            {
                $cd                 =   ConsejoDirectivo::findOrFail($id);
                $cd->numero         =   $request->get('numero');
                $cd->fecha          =   $request->get('fecha');
                $cd->descripcion    =   $request->get('objetivo');
                $cd->updated_auth   =   Auth::user()->id;
                $cd->update();

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
        try 
        {
            $cd         =   ConsejoDirectivo::find($id);
            $cd->delete();

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
