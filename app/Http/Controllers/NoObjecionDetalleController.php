<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\NoObjecionDetalleFormRequest;
use App\NoObjecion;
use App\NoObjecionDetalle;
use App\Proveedor;
use App\TablaValor;
use Carbon\Carbon;
use DB;
use Auth;

class NoObjecionDetalleController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='monitoreo.nobjecion-detalle';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    #3.
    public function create($id)
    {
        #1. Obtengo las variables requeridas
        $informe        =   NoObjecion::findOrFail($id);
        $bancos         =   TablaValor::getDetalleTabla('Ifi');
        $tipo_gastos    =   TablaValor::getDetalleTabla('TipoDeGasto');
        $tipo_cuenta    =   TablaValor::getDetalleTabla('TipoCuentaBancaria');

        #2. retorno al formulario
        return view($this->path.'.create', compact('informe', 'bancos', 'tipo_gastos', 'tipo_cuenta'));
    }

    #4.
    public function store(NoObjecionDetalleFormRequest $request)
    {
        #1. Guardamos la data del Productor
        try 
        {
            $proveedor        =     Proveedor::updateOrCreate(['nroRuc' => $request->get('ruc')],[
                                        'razonSocial'           =>  $request->get('razon_social'),
                                        'direccion'             =>  $request->get('direccion'),
                                        'tipoProveedor'         =>  $request->get('tipo_proveedor'),
                                        'estaHabido'            =>  $request->get('esta_habido'),
                                        'estaActivo'            =>  $request->get('esta_activo'),
                                        'codEntidadFinanciera'  =>  $request->get('banco'),
                                        'nroCuentaBancaria'     =>  $request->get('nro_cuenta'),
                                        'nroCCI'                =>  $request->get('nro_cci'),
                                        'tipoCuenta'            =>  $request->get('tipo_cuenta'),
                                        'estado'                =>  1,
                                        'created_auth'          =>  Auth::user()->id,
                                        'created_at'            =>  now(),
                                        'updated_auth'          =>  Auth::user()->id,
                                        'updated_at'            =>  now()
                                    ]);
            
            #2. Guardamos la información del item
            try 
            {
                $item                       =   new NoObjecionDetalle;
                $item->codProveedor         =   $proveedor->id;
                $item->codInformeNoObjecion =   $request->get('codigo');
                $item->descripcion          =   $request->get('descripcion');
                $item->nroPoa               =   $request->get('nro_poa');
                $item->importe              =   $request->get('importe');
                $item->codTipoGasto         =   $request->get('tipo_gasto');
                $item->evidencia            =   '-';
                $item->codEstadoProceso     =   1;
                $item->estado               =   1;
                $item->created_auth         =   Auth::user()->id;
                $item->created_at           =   now();
                $item->updated_auth         =   Auth::user()->id;
                $item->updated_at           =   now();
                $item->save();

                #3. retorno al menú principal
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

    #5.
    public function show($id)
    {
        $data   =   NoObjecionDetalle::getData($id);
        return view($this->path.'.data', compact('data'));
    }

    #6.
    public function edit($id)
    {
        #1. Obtengo las variables requeridas
        $detalle        =   NoObjecionDetalle::findOrFail($id);
        $informe        =   NoObjecion::findOrFail($detalle->codInformeNoObjecion);
        $bancos         =   TablaValor::getDetalleTabla('Ifi');
        $tipo_gastos    =   TablaValor::getDetalleTabla('TipoDeGasto');
        $tipo_cuenta    =   TablaValor::getDetalleTabla('TipoCuentaBancaria');

        #2.  Retorno al formulario
        return view($this->path.'.edit', compact('detalle', 'informe', 'bancos', 'tipo_gastos', 'tipo_cuenta'));
    }

    #7.
    public function update(NoObjecionDetalleFormRequest $request, $id)
    {
        #1. Guardo la información del Proveedor
        try 
        {
            $proveedor        =     Proveedor::updateOrCreate(['nroRuc' => $request->get('ruc')],[
                'razonSocial'           =>  $request->get('razon_social'),
                'direccion'             =>  $request->get('direccion'),
                'tipoProveedor'         =>  $request->get('tipo_proveedor'),
                'estaHabido'            =>  $request->get('esta_habido'),
                'estaActivo'            =>  $request->get('esta_activo'),
                'codEntidadFinanciera'  =>  $request->get('banco'),
                'nroCuentaBancaria'     =>  $request->get('nro_cuenta'),
                'nroCCI'                =>  $request->get('nro_cci'),
                'tipoCuenta'            =>  $request->get('tipo_cuenta'),
                'estado'                =>  1,
                'created_auth'          =>  Auth::user()->id,
                'created_at'            =>  now(),
                'updated_auth'          =>  Auth::user()->id,
                'updated_at'            =>  now()
            ]);

            #2. Guardo la información del proceso
            try 
            {
                $item                       =   NoObjecionDetalle::findOrFail($id);
                $item->codProveedor         =   $proveedor->id;
                $item->descripcion          =   $request->get('descripcion');
                $item->nroPoa               =   $request->get('nro_poa');
                $item->importe              =   $request->get('importe');
                $item->codTipoGasto         =   $request->get('tipo_gasto');
                $item->updated_auth         =   Auth::user()->id;
                $item->updated_at           =   now();
                $item->update();

                #3. retorno al menú principal
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

    #8.
    public function destroy($id)
    {
        try 
        {
            $item                   =   NoObjecionDetalle::findOrFail($id);
            $item->estado           =   0;
            $item->updated_auth     =   Auth::user()->id;
            $item->updated_at       =   now();
            $item->update();

            #2. retorno al menú principal
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
