<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\PostulanteProcesoFormRequest;
use App\Http\Requests\PostulanteCierreFormRequest;
use App\Postulante;
use App\PostulanteProceso;
use App\PostulanteEstado;
use App\Contrato;
use App\Area;
use App\Usuario;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class PostulanteProcesoController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='iniciativa.proceso';

    #2. Muestro un formulario para generar el proceso de cierre
    public function createProcesoCierre($id)
    {
        #1. Obtengo los datos requeridos
        $contrato       =   Contrato::findOrFail($id);
        $postulante     =   Postulante::findOrFail($contrato->codPostulante);
        $tipoDocumento  =   TablaValor::getDetalleTabla("TipoDocumentoProceso");
        $personal       =   Usuario::getData();

        #2. Retorno al formulario
        return view('iniciativa.proceso.proceso-cierre.create', compact('tipoDocumento', 'postulante', 'tipoDocumento', 'personal'));        
    }

    #3. Proceso el formulario
    public function storeProcesoCierre(PostulanteProcesoFormRequest $request)
    {
        #1. Genero la información del Proceso
        try 
        {
            $proceso                        =   new PostulanteProceso;
            $proceso->codPostulante         =   $request->get('codigo');
            $proceso->codTipoDocumento      =   $request->get('tipo_documento');
            $proceso->nroDocumento          =   $request->get('nro_documento');
            $proceso->fechaDocumento        =   $request->get('fecha');
            $proceso->codEspecialista       =   $request->get('especialista');
            $proceso->codProceso            =   4; #Proceso de cierre
            $proceso->fechaProceso          =   Carbon::now();
            $proceso->comentario            =   $request->get('comentario');
            $proceso->created_auth          =   Auth::user()->id;
            $proceso->updated_auth          =   Auth::user()->id;
            $proceso->save();

            #2. Actualizamos el estado situacional
            try 
            {
                $estado                         =   PostulanteEstado::where('codPostulante', $proceso->codPostulante)->first();
                $estado->codEstadoSituacional   =   6; #En proceso de cierre
                $estado->updated_auth           =   Auth::user()->id;
                $estado->updated_at             =   now();
                $estado->update();

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

    #4. Muestro la información registrada
    public function showProcesoCierre($id)
    {
        return view($this->path.'.proceso-cierre.data');
    }

    #5. Muestro un formulario para generar el cierre
    public function createCierre($id)
    {
        #1. Obtengo los datos requeridos
        $contrato           =   Contrato::findOrFail($id);
        $postulante         =   Postulante::findOrFail($contrato->codPostulante);
        $tipoDocumento      =   TablaValor::getDetalleTabla("TipoDocumentoProceso");
        $monitoreo          =   Usuario::getArea(4);
        $uaj                =   Usuario::getArea(3);

        #2. Retorno al formulario
        return view($this->path.'.cierre.create', compact('tipoDocumento', 'uaj', 'monitoreo', 'postulante'));  
    }

    #6. Proceso el formulario
    public function storeCierre(PostulanteCierreFormRequest $request)
    {
        #1. Guardamos la información correspondiente al especialista de Monitoreo
        try 
        {
            $proceso                        =   new PostulanteProceso;
            $proceso->codPostulante         =   $request->get('codigo');
            $proceso->codTipoDocumento      =   $request->get('tipo_documento_me');
            $proceso->nroDocumento          =   $request->get('nro_documento_me');
            $proceso->fechaDocumento        =   $request->get('fecha_me');
            $proceso->codEspecialista       =   $request->get('especialista_me');
            $proceso->codProceso            =   5;#En cierre
            $proceso->fechaProceso          =   Carbon::now();
            $proceso->comentario            =   $request->get('comentario_me');
            $proceso->created_auth          =   Auth::user()->id;
            $proceso->updated_auth          =   Auth::user()->id;
            $proceso->save(); 

            #2. Guardamos la información correspondiente al especialista de UAJ
            try 
            {
                $proceso                        =   new PostulanteProceso;
                $proceso->codPostulante         =   $request->get('codigo');
                $proceso->codTipoDocumento      =   $request->get('tipo_documento_uaj');
                $proceso->nroDocumento          =   $request->get('nro_documento_uaj');
                $proceso->fechaDocumento        =   $request->get('fecha_uaj');
                $proceso->codEspecialista       =   $request->get('especialista_uaj');
                $proceso->codProceso            =   5;#En cierre
                $proceso->fechaProceso          =   Carbon::now();
                $proceso->comentario            =   $request->get('comentario_uaj');
                $proceso->created_auth          =   Auth::user()->id;
                $proceso->updated_auth          =   Auth::user()->id;
                $proceso->save(); 

                #3. Actualizamos el estado Situacional
                try 
                {
                    $estado                         =   PostulanteEstado::where('codPostulante', $id)->first();
                    $estado->codEstadoSituacional   =   7;
                    $estado->updated_auth           =   Auth::user()->id;
                    $estado->update();

                    #4. Retorno al menu principal
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

    #7. Muestro la información registrada
    public function showCierre($id)
    {
        return view($this->path.'.cierre.data');
    }
}
