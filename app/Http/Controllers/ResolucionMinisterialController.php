<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\ResolucionMinisterialFormRequest;
use App\Expediente;
use App\ResolucionMinisterial;
use App\Postulante;
use App\PostulanteEstado;
use App\PostulanteAprobacion;
use App\Proyecto;
use App\Entidad;
use Carbon\Carbon;
use DB;
use Auth;

class ResolucionMinisterialController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.rm';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }  

    #3. Muestro el menú principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para la creación de una nueva RM
    public function create($id)
    {
        #1. Obtengo los datos requeridos
        $expediente         =   Expediente::findOrFail($id);
        $postulante         =   Postulante::findOrFail($expediente->codPostulante);
        $proyecto           =   Proyecto::where('codPostulante', $expediente->codPostulante)->first();
        $entidad            =   Entidad::findOrFail($postulante->codEntidad);
        #2. retorno al formulario de registro
        return view($this->path.'.create', compact('expediente', 'postulante', 'proyecto', 'entidad'));
    }

    #5. Guardo la información solicitada
    public function store(ResolucionMinisterialFormRequest $request)
    {
        #1. Guardamos la información de la resolición Ministerial
        try 
        {
            $rm                     =   new ResolucionMinisterial;
            $rm->codPostulante      =   $request->get('codigo');
            $rm->nroResolucion      =   $request->get('nro_resolucion');
            $rm->fechaFirma         =   $request->get('fecha');
            $rm->created_auth       =   Auth::user()->id;
            $rm->updated_auth       =   Auth::user()->id;
            $rm->save();

            #2. Registro los datos de aprobacion
            try 
            {
                $aprobacion                     =   new PostulanteAprobacion;
                $aprobacion->codPostulante      =   $request->get('codigo');
                $aprobacion->fechaAprobacion    =   $request->get('fecha');
                $aprobacion->created_auth       =   Auth::user()->id;
                $aprobacion->updated_auth       =   Auth::user()->id;
                $aprobacion->save();

                #3. Actualizo los importes aprobados para el PRPA
                try 
                {
                    $proyecto                   =   Proyecto::where('codPostulante', $request->get('codigo'))->first();
                    $proyecto->inversion_total  =   $request->get('aporte_pcc')+$request->get('aporte_entidad');
                    $proyecto->inversion_pcc    =   $request->get('aporte_pcc');
                    $proyecto->inversion_entidad=   $request->get('aporte_entidad');
                    $proyecto->updated_auth     =   Auth::user()->id;
                    $proyecto->update();

                    #4. Actualizo el estado situacional del expediente
                    try 
                    {
                        $situacion                          =   PostulanteEstado::where('codPostulante', $request->get('codigo'))->first();
                        $situacion->codEstadoSituacional    =   1;#Aprobado pero sin convenio
                        $situacion->updated_auth            =   Auth::user()->id;
                        $situacion->update();

                        #3. Retorno al menu principal
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

    #6. Muestro la relación de expedientes aprobados en UAJ y sin RM
    public function showDataPendiente()
    {
        $data       =   ResolucionMinisterial::getDataExpediente();
        return view($this->path.'.data', compact('data'));
    }

    #7. Muestro la relación de Resoluciones Ministeriales emitidas
    public function showData()
    {
        $data       =   ResolucionMinisterial::getData();
        return view($this->path.'.data-rm', compact('data'));
    }

    #8. Muestro el formulario para editar registros
    public function edit($id)
    {
        #1. Obtengo los datos
        $rm             =   ResolucionMinisterial::findOrFail($id);
        $postulante     =   Postulante::findOrFail($rm->codPostulante);
        $expediente     =   Expediente::where('codPostulante', $postulante->id)->first();
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        
        #2. Retorno al formulario de edición
        return view($this->path.'.edit', compact('rm', 'postulante', 'expediente', 'proyecto')); 
    }

    #9. Realizo la actualización de la información
    public function update(ResolucionMinisterialFormRequest $request, $id)
    {
        #1. Actualizamos la información de la RM
        try 
        {
            $rm                     =   ResolucionMinisterial::findOrFail($id);
            $rm->nroResolucion      =   $request->get('nro_resolucion');
            $rm->fechaFirma         =   $request->get('fecha');
            $rm->updated_auth       =   Auth::user()->id;
            $rm->update();

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
