<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteUn extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedienteUn';
    public $timestamps          =   false; 

    #2. Ontengo la información del Expediente
    public static function getData($expediente)
    {
        return ExpedienteUn::where('codExpediente', $expediente)->first();
    }    
    
    #3.
    public static function getConsolidado($estado)
    {
        return DB::select("SELECT				
            a.codExpediente id,
            b.nro_expediente,
            b.nro_cut,
            b.ruc,
            a.fecha_derivacion fecha,
            a.fechaRecepcion,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            b.cadena,
            b.nro_ha,
            b.nro_beneficiarios,
            b.area_sigla,
            b.estado_proceso
        FROM InicExpedienteUn a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.codEstadoProceso = $estado");
    }

    #4. Obtengo los datos del expediente
    public static function getDataExpediente($estado)
    {
        return DB::select("SELECT * FROM vw_data_expediente_un a WHERE a.cod_estado_proceso = $estado");
    }

}
