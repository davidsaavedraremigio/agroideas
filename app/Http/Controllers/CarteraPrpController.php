<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CarteraPrpFormRequest;
use App\Http\Requests\CarteraPrpIncentivoFormRequest;
use App\CarteraPrp;
use App\CarteraPrpUbigeo;
use App\CarteraPrpIncentivo;
use App\Postulante;
use App\Ubigeo;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class CarteraPrpController extends Controller
{

    #1. Defino la ruta de la raiz
    private $path ='proceso-prp.cartera-prp';

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
        $regiones       =   Ubigeo::getRegiones();
        $financiamiento =   TablaValor::getDetalleTabla('FuenteFinanciamientoPRP');
        return view($this->path.'.create', compact('regiones', 'financiamiento'));
    }

    #5.
    public function store(CarteraPrpFormRequest $request)
    {
        try 
        {
            $cartera                        =   new CarteraPrp;
            $cartera->descripcion           =   $request->get('descripcion');
            $cartera->nroResolucion         =   $request->get('nro_resolucion');
            $cartera->fechaResolucion       =   $request->get('fecha');
            $cartera->importe               =   $request->get('importe');
            $cartera->fuenteFinanciamiento  =   $request->get('financiamiento');
            $cartera->estado                =   1;
            $cartera->created_auth          =   Auth::user()->id;
            $cartera->created_at            =   Carbon::now();
            $cartera->updated_auth          =   Auth::user()->id;
            $cartera->updated_at            =   Carbon::now();
            $cartera->save();

            #6. Obtengo los ubigeos 
            $ubigeos                        =   $request->get('ubigeo');
            #7. Recorro el array
            for ($i =   0; $i < count($ubigeos); $i++) 
            { 
                $valores[]      =   [
                    'codInicCarteraPrp'     =>  $cartera->id,
                    'ubigeo'                =>  $ubigeos[$i],
                    'importe'               =>  0,
                    'created_auth'          =>  Auth::user()->id,
                    'updated_auth'          =>  Auth::user()->id
                ];
            }
            #8. Realizo la carga de la información
            try 
            {
                $ubigeoCartera          =   CarteraPrpUbigeo::insert($valores);

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
        $data   =   CarteraPrp::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7.
    public function edit($id)
    {
        $cartera        =   CarteraPrp::findOrFail($id);
        $regiones       =   Ubigeo::getRegiones();
        $financiamiento =   TablaValor::getDetalleTabla('FuenteFinanciamientoPRP');
        return view($this->path.'.edit', compact('cartera', 'regiones', 'financiamiento'));
    }

    #8.
    public function update(CarteraPrpFormRequest $request, $id)
    {
        try 
        {
            $cartera                        =   CarteraPrp::findOrFail($id);
            $cartera->descripcion           =   $request->get('descripcion');
            $cartera->fechaDisponibilidad   =   $request->get('fecha');
            $cartera->importe               =   $request->get('importe');
            $cartera->updated_auth          =   Auth::user()->id;
            $cartera->update();

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

    #9. 
    public function asignaPrp($id)
    {
        $cartera    =   CarteraPrp::findOrFail($id);
        $prp        =   CarteraPrp::getDataIncentivoPrp($id);
        return view($this->path.'.asigna-prp', compact('cartera', 'prp'));
    }


    #10. 
    public function procesaAsignaPrp(CarteraPrpIncentivoFormRequest $request)
    {
        $incentivos         =   $request->get('incentivo');
        #2. Recorro el array
        for ($i =   0; $i < count($incentivos); $i++) 
        { 
            $valores[]      =   [
                 'codInicCarteraPrp'     =>  $request->get('codigo'),
                 'codPostulante'         =>  $incentivos[$i],
                 'importe'               =>  0,
                 'created_auth'          =>  Auth::user()->id,
                 'updated_auth'          =>  Auth::user()->id
            ];
        }
        #3. Guardo la información
        try 
        {
            $incentivo      =   CarteraPrpIncentivo::insert($valores);

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

    #11.
    public function destroy($id)
    {
        //
    }
}
