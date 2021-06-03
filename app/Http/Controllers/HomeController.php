<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Expediente;
use App\CadenaProductiva;
use Carbon\Carbon;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    #1. Muestro los datos en el menu principal
    public function index()
    {
        return view('home');
    }

    #2. Muestro el top x de las principales cadenas atendidas
    public function principalesCadenas($incentivo)
    {
        $data       =   CadenaProductiva::getTopCadenaProductiva($incentivo, 10);
        return view('main.cadena', compact('data'));
    }

    #3. Obtengo el numero de incentivos aprobados por mes para el año elegido
    public function ejecucionMensual($periodo)
    {
        #1. Obtengo los datos por años
        $prpa   =   Expediente::getEjecucionFisicaMensual($periodo, 2);
        $asoc   =   Expediente::getEjecucionFisicaMensual($periodo, 3);
        $gest   =   Expediente::getEjecucionFisicaMensual($periodo, 4);
        $tec    =   Expediente::getEjecucionFisicaMensual($periodo, 5);

        #2. Retorno a la vista
        return view('main.incentivo', compact('prpa', 'asoc', 'gest', 'tec'));
    }

    #4. Obtengo los datos resumen
    public function hojaResumen()
    {
        #1. Obtengo los datos requeridos
        $query      =   DB::select("SELECT 
                            COUNT(a.id) nro_sp,
                            SUM(a.inversion_pcc) pcc,
                            SUM(a.inversion_entidad) contrapartida,
                            SUM(a.ejecucion_pcc) ejecutado,
                            SUM(a.ejecucion_pcc)/SUM(a.inversion_pcc)*100 avance
                        FROM vw_data_incentivo a  WHERE a.cod_estado IN (3, 5, 6, 7)");
        $data   =   $query[0];
        
        return view('main.resumen', compact('data'));
    }
}
