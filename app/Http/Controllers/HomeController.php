<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Expediente;
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
        #1. Obtengo los datos por año
        $prpa   =   Expediente::getEjecucionFisicaMensual(date('Y'), 2);
        $asoc   =   Expediente::getEjecucionFisicaMensual(date('Y'), 3);
        $gest   =   Expediente::getEjecucionFisicaMensual(date('Y'), 4);
        $tec    =   Expediente::getEjecucionFisicaMensual(date('Y'), 5);

        #2. Obtengo las cadenas con mayor demanda
        $cadenas    =   DB::select("SELECT TOP 10 a.cadena, COUNT(a.id) total FROM vw_data_incentivo a  WHERE a.cod_estado IN (1, 3, 4, 5, 6, 7) GROUP BY a.cadena ORDER BY total DESC");

        
        #2. Retorno al menu principal
        return view('home', compact('prpa', 'asoc', 'gest', 'tec', 'cadenas'));
    }
}
