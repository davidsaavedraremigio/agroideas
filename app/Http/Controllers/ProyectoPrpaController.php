<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProyectoPrpaFormRequest;
use App\Postulante;
use App\Proyecto;
use App\Contrato;
use App\PostulanteProductoEspecifico;
use App\CultivoInicial;
use App\CadenaProductiva;
use App\Entidad;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class ProyectoPrpaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='prpa.proyecto';

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
    public function show()
    {
        $data       =   Contrato::getDataPrp();
        return view($this->path.'.data', compact('data'));
    }

    #5.
    public function edit($id)
    {
        $contrato       =   Contrato::findOrFail($id);
        $postulante     =   Postulante::findOrFail($contrato->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $cadena         =   PostulanteProductoEspecifico::where('codPostulante', $postulante->id)->first();
        $cinicial       =   CultivoInicial::where('codPostulante', $postulante->id)->first();
        $cadenas        =   CadenaProductiva::getData();

        return view($this->path.'.edit', compact('contrato', 'postulante', 'proyecto', 'entidad', 'cadena', 'cadenas', 'cinicial'));
    }

    #6.
    public function update(ProyectoPrpaFormRequest $request, $id)
    {
        try 
        {
            $proyecto                                   =   Proyecto::findOrFail($id);
            $proyecto->tituloProyecto                   =   $request->get('titulo');
            $proyecto->duracion                         =   $request->get('duracion');
            $proyecto->fecha_inicio                     =   Carbon::parse($request->get('inicio'))->addMonths($request->get('duracion'));
            $proyecto->inversion_total                  =   $request->get('aporte_total');
            $proyecto->inversion_pcc                    =   $request->get('aporte_pcc');
            $proyecto->inversion_entidad                =   $request->get('aporte_entidad');
            $proyecto->area                             =   $request->get('nro_ha');
            $proyecto->nro_beneficiarios                =   $request->get('prod_total');
            $proyecto->nro_beneficiarios_varones        =   $request->get('prod_hombre');
            $proyecto->nro_beneficiarios_mujeres        =   $request->get('prod_mujer');
            $proyecto->updated_auth                     =   Auth::user()->id;
            $proyecto->update();

            #2. Actualizamos la información del cultivo Inicial
            try 
            {
                $cultivo                =   CultivoInicial::where('codPostulante', $proyecto->codPostulante)->first();
                $cultivo->descripcion   =   $request->get('cultivo_inicial');
                $cultivo->hectareas     =   $request->get('nro_ha');
                $cultivo->beneficiarios =   $request->get('prod_total');
                $cultivo->updated_auth  =   Auth::user()->id;
                $cultivo->update();

                #3. Actualizamos la información de la cadena productiva
                try 
                {
                    $cadena                     =   CadenaProductiva::where('codPostulante', $proyecto->codPostulante)->first();
                    $cadena->codCadena          =   $request->get('cadena');
                    $cadena->nroHas             =   $request->get('nro_ha');
                    $cadena->nroProductores     =   $request->get('nro_productores');
                    $cadena->tipoProduccion     =   $request->get('tipo_produccion');
                    $cadena->principal          =   1;
                    $cadena->updated_auth       =   Auth::user()->id;
                    $cadena->update();

                    #4. Retorno a la pagina principal
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
