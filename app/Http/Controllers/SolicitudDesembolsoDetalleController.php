<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudDesembolsoDetalleFormRequest;
use App\NoObjecion;
use App\SolicitudDesembolso;
use App\SolicitudDesembolsoDetalle;
use Carbon\Carbon;
use DB;
use Auth;


class SolicitudDesembolsoDetalleController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='monitoreo.solicitud-detalle';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3.
    public function create($id)
    {
        $solicitud          =   SolicitudDesembolso::findOrFail($id);
        $objeciones         =   NoObjecion::getData();
        return view($this->path.'.create', compact('objeciones', 'solicitud'));
    }

    #4.
    public function store(SolicitudDesembolsoDetalleFormRequest $request)
    {
        try 
        {
            $detalle                                        =   new SolicitudDesembolsoDetalle;
            $detalle->codPostulanteSolicitudDesembolso      =   $request->get('codigo');
            $detalle->codPostulanteNoObjecion               =   $request->get('no_objecion');
            $detalle->estado                                =   1;
            $detalle->created_auth                          =   Auth::user()->id;
            $detalle->created_at                            =   Carbon::now();
            $detalle->updated_auth                          =   Auth::user()->id;
            $detalle->updated_at                            =   Carbon::now();
            $detalle->save();

            #3. retorno al menú principal
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
        $data       =   SolicitudDesembolsoDetalle::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $detalle            =   SolicitudDesembolsoDetalle::findOrFail($id);
        $solicitud          =   SolicitudDesembolso::findOrFail($id);
        $objeciones         =   NoObjecion::getData();

        return view($this->path.'.edit', compact('detalle', 'solicitud', 'objeciones'));
    }

    #7.
    public function update(SolicitudDesembolsoDetalleFormRequest $request, $id)
    {
        try 
        {
            $detalle                                        =   SolicitudDesembolsoDetalle::findOrFail($id);
            $detalle->codPostulanteNoObjecion               =   $request->get('no_objecion');
            $detalle->updated_auth                          =   Auth::user()->id;
            $detalle->updated_at                            =   Carbon::now();
            $detalle->update();

            #2. retorno al menú principal
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
