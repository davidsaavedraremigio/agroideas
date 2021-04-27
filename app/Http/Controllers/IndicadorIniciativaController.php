<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\IndicadorIniciativaFormRequest;
use App\IndicadorIniciativa;
use App\IndicadorResultado;
use App\Postulante;
use Carbon\Carbon;
use DB;
use Auth;

class IndicadorIniciativaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-prp.indicador';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $postulante     =   Postulante::findOrFail($id);
        $indicadores    =  IndicadorResultado::getIndicadores(24);
        return view($this->path.'.create', compact('indicadores', 'postulante'));
    }

    #4.
    public function store(IndicadorIniciativaFormRequest $request)
    {
        try 
        {
            $indicador                                      =   new IndicadorIniciativa;
            $indicador->codPostulante                       =   $request->get('codigo');
            $indicador->codMaestroIndicadorResultadoCadena  =   $request->get('indicador');
            $indicador->valorLineaBase                      =   $request->get('linea_base');
            $indicador->valorMeta                           =   $request->get('meta');
            $indicador->valorLineaCierre                    =   0;
            $indicador->created_auth                        =   Auth::user()->id;
            $indicador->updated_auth                        =   Auth::user()->id;
            $indicador->save();

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
        $data       =   IndicadorIniciativa::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $indicador      =   IndicadorIniciativa::findOrFail($id);
        $indicadores    =   IndicadorResultado::getIndicadores(24);
        return view($this->path.'.edit', compact('indicador', 'indicadores'));
    }

    #7.
    public function update(IndicadorIniciativaFormRequest $request, $id)
    {
        try 
        {
            $indicador                                      =   IndicadorIniciativa::findOrFail($id);
            $indicador->codMaestroIndicadorResultadoCadena  =   $request->get('indicador');
            $indicador->valorLineaBase                      =   $request->get('linea_base');
            $indicador->valorMeta                           =   $request->get('meta');
            $indicador->updated_auth                        =   Auth::user()->id;
            $indicador->update();

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
