<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\NoObjecionFormRequest;
use App\NoObjecion;
use Carbon\Carbon;
use DB;
use Auth;

class NoObjecionController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='monitoreo.nobjecion';

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
    public function store(NoObjecionFormRequest $request)
    {
        try 
        {
            $documento                      =   new NoObjecion;
            $documento->numero              =   $request->get('numero');
            $documento->fecha               =   $request->get('fecha');
            $documento->nroCartaSolicitud   =   $request->get('nro_carta_solicitud');
            $documento->fechaCartaSolicitud =   $request->get('fecha_carta_solicitud');
            $documento->justificacion       =   $request->get('justificacion');
            $documento->estado              =   1;
            $documento->created_auth        =   Auth::user()->id;
            $documento->created_at          =   Carbon::now();
            $documento->updated_auth        =   Auth::user()->id;
            $documento->updated_at          =   Carbon::now();
            $documento->save();

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

    #6.
    public function show()
    {
        return view($this->path.'.data');
    }

    #7.
    public function edit($id)
    {
        $nobjecion      =   NoObjecion::findOrFail($id);
        return view($this->path.'.edit', compact('nobjecion'));
    }

    #8.
    public function update(NoObjecionFormRequest $request, $id)
    {
        try 
        {
            $documento                      =   NoObjecion::findOrFail($id);
            $documento->numero              =   $request->get('numero');
            $documento->fecha               =   $request->get('fecha');
            $documento->nroCartaSolicitud   =   $request->get('nro_carta_solicitud');
            $documento->fechaCartaSolicitud =   $request->get('fecha_carta_solicitud');
            $documento->justificacion       =   $request->get('justificacion');
            $documento->updated_auth        =   Auth::user()->id;
            $documento->updated_at          =   Carbon::now();
            $documento->update();

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

    #9.
    public function destroy($id)
    {
        try 
        {
            $documento                      =   NoObjecion::findOrFail($id);
            $documento->estado              =   0;
            $documento->updated_auth        =   Auth::user()->id;
            $documento->updated_at          =   Carbon::now();
            $documento->update();

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
