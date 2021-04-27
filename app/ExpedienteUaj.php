<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteUaj extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedienteUaj';
    public $timestamps          =   false; 

    #2. Ontengo la información del Expediente
    public static function getData($expediente)
    {
        return ExpedienteUaj::where('codExpediente', $expediente)->first();
    } 

    #3.
    public static function getConsolidado($estado)
    {
        return DB::SELECT("SELECT
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
        FROM InicExpedienteUaj a
        LEFT JOIN (
        SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.codEstadoProceso = $estado");
    }
}

