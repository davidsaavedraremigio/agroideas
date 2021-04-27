<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\DesembolsoSdaFormRequest;
use App\EjecucionPresupuesto;
use App\Proyecto;
use App\Postulante;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Auth;


class DesembolsoSdaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-pdn.desembolso';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    } 

    #3. 
    public function create($id)
    {
        #1. Obtengo las variables
        $proyecto       =   Proyecto::findOrFail($id);
        $postulante     =   Postulante::findOrFail($proyecto->codPostulante);
        $programado     =   $proyecto->inversion_pcc;
        $consulta       =   EjecucionPresupuesto::getEjecucion($proyecto->codPostulante);
        $ejecutado      =   $consulta->total;
        $saldo          =   $programado-$ejecutado;
        $inicio         =   $proyecto->fecha_inicio;
        $termino        =   $proyecto->fecha_termino;
    
        #2. Retorno al formulario
        return view($this->path.'.create', compact('postulante', 'programado', 'inicio', 'termino', 'saldo'));
    }

    #4. 
    public function store(DesembolsoSdaFormRequest $request)
    {
        #1. Genero los datos adicionales
        $fecha                          =   Carbon::parse($request->get('fecha'));
        $fechaComoEntero                =   strtotime($fecha);
        $nro_mes                        =   (int)date("m", $fechaComoEntero);
        $nro_anio                       =   date("Y", $fechaComoEntero);
        
        #2. Guardo la info 
        try 
        {
            $desembolso                     =   new EjecucionPresupuesto;
            $desembolso->codPostulante      =   $request->get('codigo');
            $desembolso->nroExpedienteSiaf  =   $request->get('nroSiaf');
            $desembolso->fechaDesembolso    =   $request->get('fecha');
            $desembolso->periodo            =   $nro_anio;
            $desembolso->mes                =   $nro_mes;
            $desembolso->importe            =   $request->get('importe');
            $desembolso->created_auth       =   Auth::user()->id;
            $desembolso->updated_auth       =   Auth::user()->id;
            $desembolso->save();

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

    #5. 
    public function show($id)
    {
        $proyecto       =   Proyecto::findOrFail($id);
        $programado     =   $proyecto->inversion_pcc;
        $consulta       =   EjecucionPresupuesto::getEjecucion($proyecto->codPostulante);
        $ejecutado      =   $consulta->total;
        $saldo          =   $programado-$ejecutado;
        $data           =   EjecucionPresupuesto::getData($proyecto->codPostulante);

        #2. retorno al menu principal
        return view($this->path.'.data', compact('data', 'programado', 'ejecutado', 'saldo'));
    }

    #6. 
    public function edit($id)
    {
        $desembolso     =   EjecucionPresupuesto::findOrFail($id);
        $postulante     =   Postulante::findOrFail($desembolso->codPostulante);
        $proyecto       =   Proyecto::where('codPostulante', $postulante->id)->first();
        $programado     =   $proyecto->inversion_pcc;
        $consulta       =   EjecucionPresupuesto::getEjecucion($proyecto->codPostulante);
        $ejecutado      =   $consulta->total;
        $saldo          =   $programado-$ejecutado;
        $inicio         =   $proyecto->fecha_inicio;
        $termino        =   $proyecto->fecha_termino;

        #2. Retorno al formulario
        return view($this->path.'.edit', compact('desembolso', 'programado', 'inicio', 'termino', 'saldo'));
    }

    #7.
    public function update(DesembolsoSdaFormRequest $request, $id)
    {
        #1. Genero los datos adicionales
        $fecha                          =   Carbon::parse($request->get('fecha'));
        $fechaComoEntero                =   strtotime($fecha);
        $nro_mes                        =   (int)date("m", $fechaComoEntero);
        $nro_anio                       =   date("Y", $fechaComoEntero);

        #2. Guardo los datos del formulario
        try 
        {
            $desembolso                     =   EjecucionPresupuesto::findOrFail($id);
            $desembolso->nroExpedienteSiaf  =   $request->get('nroSiaf');
            $desembolso->fechaDesembolso    =   $request->get('fecha');
            $desembolso->periodo            =   $nro_anio;
            $desembolso->mes                =   $nro_mes;
            $desembolso->importe            =   $request->get('importe');
            $desembolso->updated_auth       =   Auth::user()->id;
            $desembolso->update();

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

    #8. Elimino un desembolso
    public function destroy($id)
    {
        try 
        {
            $desembolso         =   EjecucionPresupuesto::find($id);
            $desembolso->delete();

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
