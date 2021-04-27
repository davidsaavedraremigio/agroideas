<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ActividadFormRequest;
use App\MarcoLogico;
use App\Postulante;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class ActividadController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-prp.actividad';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $postulante     =   Postulante::findOrFail($id);
        $componentes    =   MarcoLogico::where([
                                'codPostulante' => $id,
                                'codTipo'       =>  '2'
                            ])->get();
        $unidades       =   TablaValor::getDetalleTabla('Unidad');

        return view($this->path.'.create', compact('postulante', 'componentes', 'unidades'));
    }

    #4.
    public function store(ActividadFormRequest $request)
    {
        try 
        {
            $actividad                      =   new MarcoLogico;
            $actividad->codPostulante       =   $request->get('codigo');
            $actividad->codTipo             =   3;
            $actividad->nombre              =   $request->get('descripcion');
            $actividad->codUnidadMedida     =   $request->get('unidad');
            $actividad->precioUnitario      =   $request->get('precio');
            $actividad->metaFisica          =   $request->get('meta_fisica');
            $actividad->metaFinanciera      =   $request->get('precio')*$request->get('meta_fisica');
            $actividad->aporteAgroideas     =   0;
            $actividad->aporteEntidad       =   0;
            $actividad->parent              =   $request->get('componente');
            $actividad->orden               =   $request->get('nro_orden');
            $actividad->estado              =   1;
            $actividad->created_auth        =   Auth::user()->id;
            $actividad->updated_auth        =   Auth::user()->id;
            $actividad->save();

            #2. retorno al menu principal
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
        $tipo       =   3;
        $data       =   MarcoLogico::getDataML($tipo, $id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $actividad      =    MarcoLogico::findOrFail($id);
        $componentes    =   MarcoLogico::where([
                                'codPostulante' => $actividad->codPostulante,
                                'codTipo'       =>  '2'
                            ])->get();
        $unidades       =   TablaValor::getDetalleTabla('Unidad');

        return view($this->path.'.edit', compact('actividad', 'componentes', 'unidades'));
    }

    #7.
    public function update(ActividadFormRequest $request, $id)
    {
        try 
        {
            $actividad                      =   MarcoLogico::findOrFail($id);
            $actividad->nombre              =   $request->get('descripcion');
            $actividad->codUnidadMedida     =   $request->get('unidad');
            $actividad->precioUnitario      =   $request->get('precio');
            $actividad->metaFisica          =   $request->get('meta_fisica');
            $actividad->metaFinanciera      =   $request->get('precio')*$request->get('meta_fisica');
            $actividad->aporteAgroideas     =   0;
            $actividad->aporteEntidad       =   0;
            $actividad->parent              =   $request->get('componente');
            $actividad->orden               =   $request->get('nro_orden');
            $actividad->updated_auth        =   Auth::user()->id;
            $actividad->update();

            #2. retorno al menu principal
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
        try 
        {
            $actividad              =   MarcoLogico::findOrFail($id);
            $actividad->estado      =   0;
            $actividad->update();

            #2. retorno al menu principal
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
