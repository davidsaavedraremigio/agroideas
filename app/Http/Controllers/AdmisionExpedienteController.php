<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\AdmisionExpedienteFormRequest;

use App\Entidad;
use App\Postulante;
use App\Proyecto;
use App\PostulanteEstado;
use App\Contrato;
use App\ResolucionMinisterial;
use App\Expediente;
use App\TablaValor;
use App\Area;
use App\Oficina;
use App\Staff;
use App\CarteraPrp;
use DB;
use Auth;

class AdmisionExpedienteController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path = 'proceso-prp.admision';
    
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
        #1. Obtengo las variables que iran en los combos
        $tipo_iniciativa    =   2;  //Codigo de incentivos prp
        $estado_situacional =   0;  //Codigo de las iniciativas que aun no se han presentado a concurso
        $entidades          =   Postulante::getDataEstado($tipo_iniciativa, $estado_situacional);
        $oficinas           =   Oficina::getData();
        $personal           =   Staff::getData();
        $cartera            =   CarteraPrp::getData();

        #2. Retorno al formulario
        return view($this->path.'.create', compact('entidades', 'oficinas', 'personal', 'cartera'));
    }

    #5. 
    public function store(AdmisionExpedienteFormRequest $request)
    {
        #1. Obtengo el codigo de usuario del responsable
        $usuario        =   Staff::getUsuario($request->get('responsable'));
        $area           =   Staff::getArea($usuario->cod_usuario);
        #2. Guardo la información del expediente
        try 
        {   
            $expediente                         =   new Expediente;
            $expediente->codPostulante          =   $request->get('postulante');
            $expediente->nroCut                 =   $request->get('nro_cut');
            $expediente->fechaCut               =   $request->get('fecha_cut');
            $expediente->nroExpediente          =   $request->get('nro_expediente');
            $expediente->fechaExpediente        =   $request->get('fecha_expediente');
            $expediente->codOficina             =   $request->get('oficina');
            $expediente->codPersonalAsignado    =   $request->get('responsable');
            $expediente->codArea                =   $area->cod_area;
            $expediente->codEstado              =   1; #Estado pendiente
            $expediente->created_auth           =   Auth::user()->id;
            $expediente->updated_auth           =   Auth::user()->id;
            $expediente->save();

            #3. Genero un registro en el estado situacional de la iniciativa
            try 
            {
                $estado                         =   new PostulanteEstado;
                $estado->codPostulante          =   $request->get('postulante');
                $estado->codEstadoSituacional   =   1; #Estado pendiente
                $estado->created_auth           =   Auth::user()->id;
                $estado->updated_auth           =   Auth::user()->id;
                $estado->save();

                #4. Retornamos al menu principal
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

    #6.
    public function show()
    {
        $data       =   Expediente::getDataExpedienteAdmitido();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function reporte()
    {
        return view('proceso-prp.visor.index');
    }

    public function resumen()
    {
        return view('proceso-prp.resumen.index');
    }
}
