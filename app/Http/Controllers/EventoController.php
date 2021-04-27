<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EventoFormRequest;
use App\Http\Requests\EventoFormRequestEdit;
use App\Usuario;
use App\Evento;
use App\TablaValor;
use App\Ubigeo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;

class EventoController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='iniciativa.evento';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }       
    
    #3. Muestro el acceso al menu principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. formulario para crear un nuevo evento
    public function create()
    {
        #1. Obtengo los tipos de eventos
        $tipoEvento     =   TablaValor::getDetalleTabla('TipoEvento');
        #2. Obtengo la relación de regiones
        $regiones       =   Ubigeo::getRegiones();
        #3. Obtengo la relación de personal del PCC
        $personal       =   Usuario::getArea(8);
        #4. Retorno al formulario
        return view($this->path.'.create', compact('tipoEvento', 'regiones', 'personal'));
    }

    #5. Guardo la información del evento
    public function store(EventoFormRequest $request)
    {
        #1. Obtenemos la información del archivo File
        $new_file   =   $request->file('evidencia');
        $file_name  =   'EvidenciaActaCompromiso_ID_'.rand().time().'.pdf';
        $file_url   =   env('APP_URL_FILE').$file_name;

        #2. Verificamos si el archivo existe
        if($new_file)
        {
            #2.1. Cargamos la evidencia seleccionada
            $request->file('evidencia')->storeAs('files', $file_name);
            #2.2. Guardamos la información de evento
            try 
            {
                $evento                                         =   new Evento;
                $evento->codTipoEvento                          =   $request->get('tipo_evento');
                $evento->nombre                                 =   $request->get('nombre');
                $evento->ubigeo                                 =   $request->get('distrito');
                $evento->lugar                                  =   $request->get('lugar');
                $evento->inicio                                 =   $request->get('fecha_evento');
                $evento->nombreSecretariaTecnica                =   $request->get('nombre_st');
                $evento->representanteSecretariaTecnica         =   $request->get('representante_st');
                $evento->nombreInstitucionOrganizadora          =   $request->get('organizador');
                $evento->representanteInstitucionOrganizadora   =   $request->get('representante_organizador');
                $evento->integrantes                            =   $request->get('integrantes');
                $evento->codRepresentantePCC                    =   $request->get('representante_pcc');
                $evento->objetivo                               =   $request->get('objetivo');
                $evento->resultadoEsperado                      =   $request->get('resultadoEsperado');
                $evento->evidencia                              =   $file_name;
                $evento->estado                                 =   1;
                $evento->created_auth                           =   Auth::user()->id;
                $evento->updated_auth                           =   Auth::user()->id;
                $evento->save();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $evento->id,
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

    #6. Muestro la información de eventos generados
    public function show()
    {
        #1. Obtengo los eventos generados
        $eventos    =   Evento::getData();
        #2. Retorno la información a la vista
        return view($this->path.'.data', compact('eventos'));
    }

    #7. Muestro el formulario para la edición de eventos
    public function edit($id)
    {
        #1. Obtengo los datos del evento
        $evento         =   Evento::findOrFail($id);
        #2. Obtengo los tipos de eventos existentes
        $tipoEvento     =   TablaValor::getDetalleTabla('TipoEvento');
        #3. Obtengo la relacion de regiones, provincias y distritos
        $regiones       =   Ubigeo::getRegiones();
        $provincias     =   Ubigeo::getProvincias(Str::substr($evento->ubigeo, 0, 2));
        $distritos      =   Ubigeo::getDistritos(Str::substr($evento->ubigeo, 0, 4));
        #4. Obtengo la relación de personal
        $personal       =   Usuario::getArea(8);
        #5. Retorno al formulario de edición
        return view($this->path.'.edit', compact('evento', 'tipoEvento', 'regiones', 'provincias', 'distritos', 'personal'));
    }

    #8. Actualizamos la información del evento
    public function update(EventoFormRequestEdit $request, $id)
    {
        #1. Obtenemos la información del archivo File
        $new_file   =   $request->file('evidencia');
        $file_name  =   'EvidenciaActaCompromiso_ID_'.rand().time().'.pdf';
        $file_url   =   env('APP_URL_FILE').$file_name;

        #2. Verificamos si existe evidencia cargada
        if($new_file)
        {
            #2.1. Cargamos la evidencia seleccionada
            $request->file('evidencia')->storeAs('files', $file_name);
            #2.2. Guardamos la información de evento
            try 
            {
                $evento                                         =   Evento::findOrFail($id);
                $evento->codTipoEvento                          =   $request->get('tipo_evento');
                $evento->nombre                                 =   $request->get('nombre');
                $evento->ubigeo                                 =   $request->get('distrito');
                $evento->lugar                                  =   $request->get('lugar');
                $evento->inicio                                 =   $request->get('fecha_evento');
                $evento->nombreSecretariaTecnica                =   $request->get('nombre_st');
                $evento->representanteSecretariaTecnica         =   $request->get('representante_st');
                $evento->nombreInstitucionOrganizadora          =   $request->get('organizador');
                $evento->representanteInstitucionOrganizadora   =   $request->get('representante_organizador');
                $evento->integrantes                            =   $request->get('integrantes');
                $evento->codRepresentantePCC                    =   $request->get('representante_pcc');
                $evento->objetivo                               =   $request->get('objetivo');
                $evento->resultadoEsperado                      =   $request->get('resultadoEsperado');
                $evento->evidencia                              =   $file_name;
                $evento->updated_auth                           =   Auth::user()->id;
                $evento->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $evento->id,
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
        #2.3. Guardo la información sin el archivo adjunto
        else
        {
            try 
            {
                $evento                                         =   Evento::findOrFail($id);
                $evento->codTipoEvento                          =   $request->get('tipo_evento');
                $evento->nombre                                 =   $request->get('nombre');
                $evento->ubigeo                                 =   $request->get('distrito');
                $evento->lugar                                  =   $request->get('lugar');
                $evento->inicio                                 =   $request->get('fecha_evento');
                $evento->nombreSecretariaTecnica                =   $request->get('nombre_st');
                $evento->representanteSecretariaTecnica         =   $request->get('representante_st');
                $evento->nombreInstitucionOrganizadora          =   $request->get('organizador');
                $evento->representanteInstitucionOrganizadora   =   $request->get('representante_organizador');
                $evento->integrantes                            =   $request->get('integrantes');
                $evento->codRepresentantePCC                    =   $request->get('representante_pcc');
                $evento->objetivo                               =   $request->get('objetivo');
                $evento->resultadoEsperado                      =   $request->get('resultadoEsperado');
                $evento->updated_auth                           =   Auth::user()->id;
                $evento->update();

                #3. Retorno al menu principal
                return response()->json([
                    'estado'    =>  '1',
                    'dato'      =>  $evento->id,
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

    #9. Eliminamos un evento del sistema
    public function destroy($id)
    {
        try 
        {
            $evento                 =   Evento::findOrFail($id);
            $evento->estado         =   0;
            $evento->updated_auth   =   Auth::user()->id;
            $evento->update();
            
            #2. retornamos al menu principal
            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '0',
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

    #10. Genero un reporte resumen en Power BI
    public function reporte()
    {
        return view('iniciativa.evento-reporte.index');
    }
}
