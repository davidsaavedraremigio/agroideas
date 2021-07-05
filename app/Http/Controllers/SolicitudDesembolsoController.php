<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SolicitudDesembolsoFormRequest;
use App\SolicitudDesembolso;
use App\Usuario;
use Carbon\Carbon;
use DB;
use Auth;

class SolicitudDesembolsoController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='monitoreo.solicitud';

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
        $area               =   4;
        $personal           =   Usuario::getArea($area);
        return view($this->path.'.create', compact('personal'));
    }

    #5.
    public function store(SolicitudDesembolsoFormRequest $request)
    {
        try 
        {
            $solicitud                              =   new SolicitudDesembolso;
            $solicitud->numero                      =   $request->get('numero');
            $solicitud->fecha                       =   $request->get('fecha');
            $solicitud->numeroMemo                  =   $request->get('numero_memo');
            $solicitud->fechaMemo                   =   $request->get('fecha_informe');
            $solicitud->numeroInforme               =   $request->get('numero_informe');
            $solicitud->fechaInforme                =   $request->get('fecha_informe');
            $solicitud->codEspecialistaResponsable  =   $request->get('especialista');
            $solicitud->importe                     =   0;
            $solicitud->codEstadoProceso            =   1;
            $solicitud->estado                      =   1;
            $solicitud->created_auth                =   Auth::user()->id;
            $solicitud->created_at                  =   Carbon::now();
            $solicitud->updated_auth                =   Auth::user()->id;
            $solicitud->updated_at                  =   Carbon::now();
            $solicitud->save();

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
        $data       =   SolicitudDesembolso::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        $solicitud          =   SolicitudDesembolso::findOrFail($id);
        $area               =   4;
        $personal           =   Usuario::getArea($area);
        #2. retorno al menu principal
        return view($this->path.'.edit', compact('solicitud', 'personal'));
    }

    #8.
    public function update(SolicitudDesembolsoFormRequest $request, $id)
    {
        try 
        {
            $solicitud                              =   SolicitudDesembolso::findOrFail($id);
            $solicitud->numero                      =   $request->get('numero');
            $solicitud->fecha                       =   $request->get('fecha');
            $solicitud->numeroMemo                  =   $request->get('numero_memo');
            $solicitud->fechaMemo                   =   $request->get('fecha_informe');
            $solicitud->numeroInforme               =   $request->get('numero_informe');
            $solicitud->fechaInforme                =   $request->get('fecha_informe');
            $solicitud->codEspecialistaResponsable  =   $request->get('especialista');
            $solicitud->updated_auth                =   Auth::user()->id;
            $solicitud->updated_at                  =   Carbon::now();
            $solicitud->update();

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
            $solicitud              =   SolicitudDesembolso::findOrFail($id);
            $solicitud->estado      =   0;
            $solicitud->updated_auth=   Auth::user()->id;
            $solicitud->updated_at  =   Carbon::now();  
            
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
