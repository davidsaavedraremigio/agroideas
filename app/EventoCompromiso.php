<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class EventoCompromiso extends Model
{
    protected 	$table 			=	'InicEventoCompromiso';
    public $timestamps          =   false; 

    #1. obtengo la relación de compromisos generados para determinado evento
    public static function getData($evento)
    {
        return DB::table('vw_data_compromisos')
        ->where('vw_data_compromisos.EventoID', $evento)
        ->orderBy('vw_data_compromisos.fecha_plazo','ASC')
        ->get();
    }

    #2. Obtengo un reporte resumen de los compromisos registrados en el sistema
    public static function getCompromisos($tipo = 100, $estado = 100)
    {
        return DB::select("EXECUTE uspGetResumenCompromiso @tipo = $tipo, @estado = $estado");
    }
}
