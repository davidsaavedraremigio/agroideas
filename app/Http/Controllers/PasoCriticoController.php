<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\PasoCriticoFormRequest;
use App\Postulante;
use App\PasoCritico;
use Carbon\Carbon;
use DB;
use Auth;

class PasoCriticoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.paso-critico';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3.
    public function create($id)
    {
        $postulante     =   Postulante::findOrFail($id);
        return view($this->path.'.create', compact('postulante'));
    }

    #4
    public function store(PasoCriticoFormRequest $request)
    {
        try 
        {
            $pc                     =   new PasoCritico;
            $pc->codPostulante      =   $request->get('codigo');
            $pc->resultadoEsperado  =   $request->get('resultado');
            $pc->inicio             =   $request->get('inicio');
            $pc->termino            =   $request->get('termino');
            $pc->estado             =   1;
            $pc->created_auth       =   Auth::user()->id;
            $pc->updated_auth       =   Auth::user()->id;
            $pc->save();

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
        $data       =   PasoCritico::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        $pc         =   PasoCritico::findOrFail($id);
        return view($this->path.'.edit', compact('pc'));
    }

    #7.
    public function update(PasoCriticoFormRequest $request, $id)
    {
        try 
        {
            $pc                     =   PasoCritico::findOrFail($id);
            $pc->resultadoEsperado  =   $request->get('resultado');
            $pc->inicio             =   $request->get('inicio');
            $pc->termino            =   $request->get('termino');
            $pc->updated_auth       =   Auth::user()->id;
            $pc->update();

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
        //
    }
}
