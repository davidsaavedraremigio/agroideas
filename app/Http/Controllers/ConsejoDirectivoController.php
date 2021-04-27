<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ConsejoDirectivoFormRequest;
use App\ConsejoDirectivo;
use App\Expediente;
use App\ExpedienteSdaUn;
use App\ExpedienteSdaUaj;
use App\Proyecto;
use App\PostulanteEstado;
use App\PostulanteAprobacion;
use App\Postulante;
use Carbon\Carbon;
use DB;
use Auth;


class ConsejoDirectivoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='sda.cd';

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
        return view($this->path.'.create');
    }

    #5.
    public function store(ConsejoDirectivoFormRequest $request)
    {
        try 
        {
            $cd                 =   new ConsejoDirectivo;
            $cd->numero         =   $request->get('numero');
            $cd->fecha          =   $request->get('fecha');
            $cd->descripcion    =   $request->get('objetivo');
            $cd->created_auth   =   Auth::user()->id;
            $cd->updated_auth   =   Auth::user()->id;
            $cd->save();

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

    #6.
    public function show()
    {
        $data   =   ConsejoDirectivo::getData();
        #2. Retornamos al menu principal
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        $cd         =   ConsejoDirectivo::findOrFail($id);
        return view($this->path.'.edit', compact('cd'));
    }

    #8.
    public function update(ConsejoDirectivoFormRequest $request, $id)
    {
        try 
        {
            try 
            {
                $cd                 =   ConsejoDirectivo::findOrFail($id);
                $cd->numero         =   $request->get('numero');
                $cd->fecha          =   $request->get('fecha');
                $cd->descripcion    =   $request->get('objetivo');
                $cd->updated_auth   =   Auth::user()->id;
                $cd->update();

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
            $cd         =   ConsejoDirectivo::find($id);
            $cd->delete();

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

    #10. Muestro un formulario para la asignación de Solicitudes de apoyo a un consejo directivo
    public function asignaSdaForm($id)
    {
        #1. Obtengo las variables requeridas
        $cd         =   ConsejoDirectivo::findOrFail($id);
        $estado     =   2;
        $expediente =   ExpedienteSdaUn::getDataExpediente($estado);

        #2. Retorno a la vista del formulario
        return view($this->path.'.asigna', compact('cd', 'expediente'));
    }

    #11. Realizo la asignacion de un expediente a un consejo directivo
    public function asignaSda(Request $request)
    {
        #1. Actualizo la información del expediente
        try 
        {
            $expediente                 =   Expediente::findOrFail($request->get('expediente'));
            $expediente->updated_auth   =   Auth::user()->id;
            $expediente->update();

            #2. Actualizo la información del expediente UAJ
            try 
            {
                $uaj                        =   ExpedienteSdaUaj::where('codExpediente', $expediente->id)->first();
                $uaj->fecha_derivacion      =   $request->get('fecha_aprobacion');
                $uaj->cod_consejo_directivo =   $request->get('codigo');
                $uaj->cod_estado_proceso    =   2;
                $uaj->updated_auth          =   Auth::user()->id;
                $uaj->update();

                #3. Genero la aprobación del incentivo
                try 
                {
                    $aprobacion                 =   new PostulanteAprobacion;
                    $aprobacion->codPostulante  =   $expediente->codPostulante;
                    $aprobacion->fechaAprobacion=   $request->get('fecha_aprobacion');
                    $aprobacion->created_auth   =   Auth::user()->id;
                    $aprobacion->updated_auth   =   Auth::user()->id;
                    $aprobacion->save();
                    
                    #4. Actualizo el estado situacional de la iniciativa
                    try 
                    {
                        $estado                         =   PostulanteEstado::where('codPostulante', $expediente->codPostulante)->first();
                        $estado->codEstadoSituacional   =   1;
                        $estado->updated_auth           =   Auth::user()->id;
                        $estado->update();

                        #5. Retorno al menu principal
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #12. Muestro todas las entidades aprobadas
    public function showAsignaSda($id)
    {
        $data   =   ConsejoDirectivo::getExpedientes($id);
        #2. Retornamos a la vista  
        return view($this->path.'.data-aprobado', compact('data'));
    }

}
