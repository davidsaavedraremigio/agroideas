<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Expediente;
use Carbon\Carbon;
use DB;
use Auth;

class ConsolidadoPrpController extends Controller
{
    #1. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }



    #8. Muestro la ventana principal del consolidado
    public function indexConsolidadoUr()
    {
        return view('proceso-prp.consolidado.consolidado-ur.index');
    }

    #9. Genero la información consolidada
    public function showConsolidadoUr()
    {
        
        $data   =   Expediente::getDataExpedienteUr();
        return view('proceso-prp.consolidado.consolidado-ur.data', compact('data'));
    }

}
