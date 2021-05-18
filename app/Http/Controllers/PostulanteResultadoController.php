<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\PostulanteLineaBaseFormRequest;
use App\Http\Requests\PostulanteResultadoFormRequest;
use App\Http\Requests\PostulanteLineaCierreFormRequest;
use App\Postulante;
use App\Entidad;
use App\Proyecto;
use App\IndicadorResultado;
use App\PostulanteResultado;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;


class PostulanteResultadoController extends Controller
{
    #1. Defino las rutas del controllador
    private $path_lb    ='sda.linea-base';
    private $path_lc    ='sda.linea-cierre';
    private $path_ejec  ='sda.resultado';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. Mostramos el panel principal de la informacion de linea de base
    public function indexLineaBase()
    {
        return view($this->path_lb.'.index');
    }

    #4. Mostramos el formulario para añadir nuevos registros
    public function createLineaBase($id)
    {
        #1. Obtengo las variables requeridas
        $postulante     =   Postulante::findOrFail($id);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $indicadores    =   IndicadorResultado::getData();

        #2. Retorno al formulario
        return view($this->path_lb.'.create', compact('postulante', 'proyecto', 'entidad', 'indicadores'));
    }

    #5. Guardamos la información de los indicadores
    public function storeLineaBase(PostulanteLineaBaseFormRequest $request)
    {
        #1. Registro la información requerida
        try 
        {
            $indicador                          =   new PostulanteResultado;
            $indicador->codPostulante           =   $request->get('codigo');
            $indicador->codIndicador            =   $request->get('indicador');
            $indicador->valor_linea_base        =   $request->get('linea_base');
            $indicador->proyeccion_anio_1       =   $request->get('anio_1');
            $indicador->proyeccion_anio_2       =   $request->get('anio_2');
            $indicador->proyeccion_anio_3       =   $request->get('anio_3');
            $indicador->proyeccion_anio_4       =   $request->get('anio_4');
            $indicador->proyeccion_anio_5       =   $request->get('anio_5');
            $indicador->proyeccion_anio_6       =   $request->get('anio_6');
            $indicador->proyeccion_anio_7       =   $request->get('anio_7');
            $indicador->proyeccion_anio_8       =   $request->get('anio_8');
            $indicador->proyeccion_anio_9       =   $request->get('anio_9');
            $indicador->proyeccion_anio_10      =   $request->get('anio_10');
            $indicador->ejecucion_anio_1        =   0;
            $indicador->ejecucion_anio_2        =   0;
            $indicador->ejecucion_anio_3        =   0;
            $indicador->ejecucion_anio_4        =   0;
            $indicador->ejecucion_anio_5        =   0;
            $indicador->ejecucion_anio_6        =   0;
            $indicador->ejecucion_anio_7        =   0;
            $indicador->ejecucion_anio_8        =   0;
            $indicador->ejecucion_anio_9        =   0;
            $indicador->ejecucion_anio_10       =   0;
            $indicador->valor_linea_cierre      =   0;
            $indicador->estado                  =   1;
            $indicador->created_auth            =   Auth::user()->id;
            $indicador->updated_auth            =   Auth::user()->id;
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

    #6. Muestro los registros generados
    public function showLineaBase($id)
    {
        #1. Obtengo los datos requeridos
        $data       =   PostulanteResultado::getData($id);
        #2. Retorno al menu principal
        return view($this->path_lb.'.data', compact('data'));
    }

    #7. Muestro el formulario para la edicion de registros
    public function editLineaBase($id)
    {
        #1. Obtengo las variables solicitadas
        $indicador      =   PostulanteResultado::findOrFail($id);
        $postulante     =   Postulante::findOrFail($indicador->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $indicadores    =   IndicadorResultado::getData();

        #2. Retorno al formulario
        return view($this->path_lb.'.edit', compact('indicador', 'postulante', 'proyecto', 'entidad', 'indicadores'));
    }

    #8. Actualizamos la información de resultados
    public function updateLineaBase(PostulanteLineaBaseFormRequest $request, $id)
    {
        try 
        {
            $indicador                      =   PostulanteResultado::findOrFail($id);
            $indicador->valor_linea_base    =   $request->get('linea_base');
            $indicador->proyeccion_anio_1   =   $request->get('anio_1');
            $indicador->proyeccion_anio_2   =   $request->get('anio_2');
            $indicador->proyeccion_anio_3   =   $request->get('anio_3');
            $indicador->proyeccion_anio_4   =   $request->get('anio_4');
            $indicador->proyeccion_anio_5   =   $request->get('anio_5');
            $indicador->proyeccion_anio_6   =   $request->get('anio_6');
            $indicador->proyeccion_anio_7   =   $request->get('anio_7');
            $indicador->proyeccion_anio_8   =   $request->get('anio_8');
            $indicador->proyeccion_anio_9   =   $request->get('anio_9');
            $indicador->proyeccion_anio_10  =   $request->get('anio_10');
            $indicador->updated_auth        =   Auth::user()->id;
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

    #9. Mostramos los resultados de la ejecución de indicadores
    public function showEjecucion($id)
    {
        #1. Obtengo los datos requeridos
        $data       =   PostulanteResultado::getData($id);
        #2. Retornamos a la vista
        return view($this->path_ejec.'.data', compact('data'));
    }

    #10. Mostramos el formulario para la actualizacion de registros
    public function editEjecucion($id)
    {
        #1. Obtengo las variables solicitadas
        $indicador      =   PostulanteResultado::findOrFail($id);
        $postulante     =   Postulante::findOrFail($indicador->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $indicadores    =   IndicadorResultado::getData();

        #2. Retornamos al formulario
        return view($this->path_ejec.'.edit', compact('indicador', 'postulante', 'proyecto', 'entidad', 'indicadores'));
    }

    #11. Actualizamos el avance de los Indicadores
    public function updateEjecucion(PostulanteResultadoFormRequest $request, $id)
    {
        try 
        {
            $indicador                          =   PostulanteResultado::findOrFail($id);
            $indicador->ejecucion_anio_1        =   $request->get('anio_1');
            $indicador->ejecucion_anio_2        =   $request->get('anio_2');
            $indicador->ejecucion_anio_3        =   $request->get('anio_3');
            $indicador->ejecucion_anio_4        =   $request->get('anio_4');
            $indicador->ejecucion_anio_5        =   $request->get('anio_5');
            $indicador->ejecucion_anio_6        =   $request->get('anio_6');
            $indicador->ejecucion_anio_7        =   $request->get('anio_7');
            $indicador->ejecucion_anio_8        =   $request->get('anio_8');
            $indicador->ejecucion_anio_9        =   $request->get('anio_9');
            $indicador->ejecucion_anio_10       =   $request->get('anio_10');
            $indicador->updated_auth            =   Auth::user()->id;
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

    #12. Mostramos la información de linea de cierre
    public function showLineaCierre($id)
    {
        #1. Obtengo los datos requeridos
        $data       =   PostulanteResultado::getData($id);
        #2. Retornamos a la vista
        return view($this->path_lc.'.data', compact('data'));      
    }

    #13. Mostramos el formulario para la actualizacion de linea de cierre
    public function editLineaCierre($id)
    {
        #1. Obtengo las variables solicitadas
        $indicador      =   PostulanteResultado::findOrFail($id);
        $postulante     =   Postulante::findOrFail($indicador->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $entidad        =   Entidad::findOrFail($postulante->codEntidad);
        $indicadores    =   IndicadorResultado::getData();

        #2. Retornamos al formulario
        return view($this->path_lc.'.edit', compact('indicador', 'postulante', 'proyecto', 'entidad', 'indicadores'));
    }

    #14. Actualizamos la información de linea de cierre
    public function updateLineaCierre(PostulanteLineaCierreFormRequest $request, $id)
    {
        try 
        {
            $indicador                      =   PostulanteResultado::findOrFail($id);
            $indicador->valor_linea_cierre  =   $request->get('linea_cierre');
            $indicador->updated_auth        =   Auth::user()->id;
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
}
