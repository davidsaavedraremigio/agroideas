<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\LineaProductivaFormRequest;
use App\SectorProductivo;
use App\LineaProductiva;
use Carbon\Carbon;
use DB;
use Auth;

class LineaProductivaController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='admin.linea';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3. Muestro la ventana principal
    public function index()
    {
        return view($this->path.'.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectores   =   SectorProductivo::getData();
        return view($this->path.'.create', compact('sectores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineaProductivaFormRequest $request)
    {
        try 
        {
            $linea                      =   new LineaProductiva;
            $linea->maestroSectorID     =   $request->get('sector');
            $linea->descripcion         =   $request->get('descripcion');
            $linea->save();

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data   =   LineaProductiva::getData();
        return view($this->path.'.data', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $linea      =   LineaProductiva::findOrFail($id);
        $sectores   =   SectorProductivo::getData();
        return view($this->path.'.edit', compact('linea', 'sectores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineaProductivaFormRequest $request, $id)
    {
        try 
        {
            $linea                      =   LineaProductiva::findOrFail($id);
            $linea->maestroSectorID     =   $request->get('sector');
            $linea->descripcion         =   $request->get('descripcion');
            $linea->update();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $linea          =   LineaProductiva::find($id);
            $linea->delete();

            #2. Retorno al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);
        } 
        catch (Exception $th) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #10. Obtengo las lineas correspondientes a determinado sector
    public function obtieneLinea($id)
    {
        $lineas     =   LineaProductiva::getLineaProductiva($id);
        return response()->json($lineas);
    }
}
