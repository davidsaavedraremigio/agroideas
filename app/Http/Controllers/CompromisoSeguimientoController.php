<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CompromisoSeguimientoFormRequest;
use App\Evento;
use App\EventoCompromiso;
use App\EventoCompromisoSeguimiento;
use App\TipoCompromisoEtapa;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class CompromisoSeguimientoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.ejec-compromiso';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    #3. Muestro el formulario para el registro de avance
    public function create($id)
    {
        #1. Obtengo los datos del evento
        $evento         =   Evento::findOrFail($id);
        #2. Obtengo la relacion de compromisos
        $compromisos    =   EventoCompromiso::getData($evento->id);
        #3. Obtengo la relacion de estados situacionales
        $estados        =   TablaValor::getDetalleTabla('EstadoCompromiso');
        #4. Envío la información al formulario
        return view($this->path.'.create', compact('evento', 'compromisos', 'estados'));
    }

    #4. Guardo la información de avance del compromiso
    public function store(CompromisoSeguimientoFormRequest $request)
    {
        #1. Obtenemos la información del archivo File
        $new_file   =   $request->file('evidencia');
        $file_name  =   'EvidenciaEjecucionCompromiso_ID_'.rand().time().'.pdf';
        $file_url   =   env('APP_URL_FILE').$file_name;
        
        #2. Verificamos si el archivo existe
        if($new_file)
        {
            #2.1. Cargamos la evidencia seleccionada
            $request->file('evidencia')->storeAs('files', $file_name);
            #2.2. Procedemos a guardar la informacion
            try 
            {
                $ejecucion                          =   new EventoCompromisoSeguimiento;
                $ejecucion->compromisoID            =   $request->get('compromiso');
                $ejecucion->codEtapaActividad       =   $request->get('etapa');
                $ejecucion->fecha                   =   $request->get('fecha');
                $ejecucion->responsable             =   $request->get('responsable');
                $ejecucion->resultados              =   $request->get('resultado');
                $ejecucion->observaciones           =   $request->get('observaciones');
                $ejecucion->evidencia               =   $file_name;
                $ejecucion->estado                  =   1;
                $ejecucion->created_auth            =   Auth::user()->id;
                $ejecucion->updated_auth            =   Auth::user()->id;
                $ejecucion->save();

                #2.3. Actualizamos el estado del compromiso
                try 
                {
                    $compromiso                 =   EventoCompromiso::findOrFail($ejecucion->compromisoID);
                    $compromiso->codEstado      =   $request->get('estado');
                    $compromiso->updated_auth   =   Auth::user()->id;
                    $compromiso->update();

                    #3. Retornamos al menu principal
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
        else
        {
            try 
            {
                $ejecucion                          =   new EventoCompromisoSeguimiento;
                $ejecucion->compromisoID            =   $request->get('compromiso');
                $ejecucion->codEtapaActividad       =   $request->get('etapa');
                $ejecucion->fecha                   =   $request->get('fecha');
                $ejecucion->responsable             =   $request->get('responsable');
                $ejecucion->resultados              =   $request->get('resultado');
                $ejecucion->observaciones           =   $request->get('observaciones');
                $ejecucion->estado                  =   1;
                $ejecucion->created_auth            =   Auth::user()->id;
                $ejecucion->updated_auth            =   Auth::user()->id;
                $ejecucion->save();

                #2.3. Actualizamos el estado del compromiso
                try 
                {
                    $compromiso                 =   EventoCompromiso::findOrFail($ejecucion->compromisoID);
                    $compromiso->codEstado      =   $request->get('estado');
                    $compromiso->updated_auth   =   Auth::user()->id;
                    $compromiso->update();

                    #3. Retornamos al menu principal
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
    }

    #5. Muestro la información registrada
    public function show($id)
    {
        #1. Obtengo los datos
        $resultados     =   EventoCompromisoSeguimiento::getData($id);
        #2. Cargo la información a la vista
        return view($this->path.'.data', compact('resultados'));
    }

    #6. Realizo la edición de los avances
    public function edit($id)
    {
        #1. Obtengo los datos de la ejecucion
        $ejecucion      =   EventoCompromisoSeguimiento::findOrFail($id);
        #2. Obtengo el compromiso
        $compromiso     =   EventoCompromiso::findOrFail($ejecucion->compromisoID);
        #3. Obtengo los datos del evento
        $evento         =   Evento::findOrFail($compromiso->eventoID);
        #4. Obtengo la relacion de compromisos
        $compromisos    =   EventoCompromiso::getData($evento->id);
        #5. Obtengo la relacion de estados situacionales
        $estados        =   TablaValor::getDetalleTabla('EstadoCompromiso');
        #6. Obtengo las estapas que corresponden al compromiso seleccionado
        $etapas         =   TipoCompromisoEtapa::getEtapaCompromiso($compromiso->codTipoCompromiso);
        #7. Retorno al menu de edicion
        return view($this->path.'.edit', compact('ejecucion', 'evento', 'compromisos', 'estados', 'compromiso', 'etapas'));
    }

    #7. Realizo la actualizacion de la información
    public function update(CompromisoSeguimientoFormRequest $request, $id)
    {
        #1. Actualizamos la informacion de ejecucion
        try 
        {
            $ejecucion      =   EventoCompromisoSeguimiento::findOrFail($id);
            $ejecucion->compromisoID        =   $request->get('compromiso');
            $ejecucion->codEtapaActividad   =   $request->get('etapa');
            $ejecucion->fecha               =   $request->get('fecha');
            $ejecucion->responsable         =   $request->get('responsable');
            $ejecucion->resultados          =   $request->get('resultados');
            $ejecucion->observaciones       =   $request->get('observaciones');
            $ejecucion->updated_auth        =   Auth::user()->id;
            $ejecucion->update();

            #2. Actualizamos el estado situacional
            try 
            {
                $compromiso             =   EventoCompromiso::findOrFail($ejecucion->compromisoID);
                $compromiso->codEstado  =   $request->get('estado');
                $compromiso->update();

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

    #8. Elimino el registro indicado
    public function destroy($id)
    {
        try 
        {
            $ejecucion      =   EventoCompromisoSeguimiento::find($id);
            $ejecucion->delete();

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
