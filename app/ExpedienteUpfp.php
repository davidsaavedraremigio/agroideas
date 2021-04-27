<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteUpfp extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedienteUpfp';
    public $timestamps          =   false; 
    
    #2. Ontengo la información del Expediente
    public static function getData($expediente)
    {
        return ExpedienteUpfp::where('codExpediente', $expediente)->first();
    }

    #3.
    public static function getConsolidado($estado)
    {
        return DB::select("SELECT
            b.id,
            b.nro_expediente,
            a.especialista_asignado,
            a.fecha_recepcion,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            b.cadena,
            b.nro_beneficiarios,
            a.nro_informe_tec,
            a.fecha_informe_tec,
            a.aprueba_form,
            a.nro_informe_form,
            a.fecha_informe_form,
            a.fecha_derivacion,
            a.nro_informe_observacion,
            a.fecha_observacion,
            a.nro_carta_archivo,
            a.fecha_archiva,
            a.codEstadoProceso
        FROM vw_data_expediente_upfp a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.codEstadoProceso = $estado");
    }
}
