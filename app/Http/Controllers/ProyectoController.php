<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ProyectoFormRequest;
use App\Postulante;
use App\Proyecto;
use App\Contrato;
use App\PostulanteProductoEspecifico;
use App\CadenaProductiva;
use App\Entidad;
use App\TablaValor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class ProyectoController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='sda.proyecto';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Muestro el menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro la relación de proyectos
    public function show()
    {
        #1. Obtengo la relación de Proyectos en ejecución
        $data   =   Contrato::getDataSda();
        #2. Retorno al menu principal
        return view($this->path.'.data', compact('data'));
    }

    #5. Mostramos un formulario para la edición de la información
    public function edit($id)
    {
        #1. Obtengo los datos requeridos
        $contrato       =   Contrato::findOrFail($id);
        $postulante     =   Postulante::findOrFail($contrato->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $cadena         =   PostulanteProductoEspecifico::where('codPostulante', $postulante->id)->first();
        $cadenas        =   CadenaProductiva::getData();
        $incentivos     =   TablaValor::getDetalleTabla('TipoIncentivo');

        #2. retorno al formulario
        return view($this->path.'.edit', compact('contrato', 'postulante', 'proyecto', 'entidad', 'cadena', 'cadenas', 'incentivos'));
    }

    #6. Actualizamos la información 
    public function update(ProyectoFormRequest $request, $id)
    {
        #1. Actualizamos la información del Postulante
        try 
        {
            $postulante                     =   Postulante::findOrFail($id);
            $postulante->codTipoIncentivo   =   $request->get('incentivo');
            $postulante->updated_auth       =   Auth::user()->id;
            $postulante->updated_at         =   now();
            $postulante->update();

            #2. Actualizo la información del Proyecto
            try 
            {
                $proyecto                           =   Proyecto::where('codPostulante', $postulante->id)->first();
                $proyecto->tituloProyecto           =   $request->get('titulo');
                $proyecto->duracion                 =   $request->get('duracion');
                $proyecto->fecha_inicio             =   $request->get('inicio');
                $proyecto->fecha_termino            =   Carbon::parse($request->get('inicio'))->addMonths($request->get('duracion'));
                $proyecto->inversion_total          =   $request->get('aporte_total');
                $proyecto->inversion_pcc            =   $request->get('aporte_pcc');
                $proyecto->inversion_entidad        =   $request->get('aporte_entidad');
                $proyecto->area                     =   $request->get('area');
                $proyecto->nro_beneficiarios        =   $request->get('prod_total');
                $proyecto->nro_beneficiarios_varones=   $request->get('prod_var');
                $proyecto->nro_beneficiarios_mujeres=   $request->get('prod_muj');
                $proyecto->updated_auth             =   Auth::user()->id;
                $proyecto->updated_at               =   now();
                $proyecto->update();

                #3. Actualizamos la información de la cadena productiva
                try 
                {
                    $cadena                 =   PostulanteProductoEspecifico::where('codPostulante', $postulante->id)->first();
                    $cadena->codCadena      =   $request->get('cadena');
                    $cadena->nroHas         =   $request->get('area');
                    $cadena->nroProductores =   $request->get('prod_total');
                    $cadena->updated_auth   =   Auth::user()->id;
                    $cadena->updated_at     =   now();
                    $cadena->update();

                    #4. Retorno a la pagina principal
                    return response()->json([
                        'estado'    =>  '1',
                        'dato'      =>  $postulante->id,
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
