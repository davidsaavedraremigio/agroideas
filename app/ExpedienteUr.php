<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteUr extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedienteUr';
    public $timestamps          =   false; 

    #2. Ontengo la información del Expediente
    public static function getData($expediente)
    {
        return ExpedienteUr::where('codExpediente', $expediente)->first();
    }

    #3. 
    public static function getConsolidado($estado)
    {
        return DB::select("SELECT
            a.codExpediente id,
            b.nro_expediente,
            b.nro_cut,
            a.fechaRecepcion fecha_recepcion,
            b.ruc,
            b.razon_social,
            b.duracion,
            b.fecha_inicio,
            b.fecha_termino,
            b.cadena,
            b.nro_ha,
            b.nro_beneficiarios,
            b.area_sigla,
            b.estado_proceso,
            a.codEstadoProceso
        FROM InicExpedienteUr a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.codEstadoProceso = $estado");
    }

    #4. Obtengo la relación de expedientes observados
    public static function getDataExpediente($estado)
    {
        return DB::select("SELECT 
            a.codExpediente id,
            b.nro_expediente,
            b.especialista_asignado,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            a.fechaRecepcion fecha_recepcion,
            a.fecha_solicitud_geo,
            a.responsable_geo,
            a.fecha_informe_geo,
            a.responsable_doc,
            a.fecha_informe_doc,
            a.responsable_tec,
            a.nro_informe_tec,
            a.nro_informe_observa,
            a.fecha_informe_doc_observa fecha_informe_observa,
            a.nro_carta_observa,
            a.fecha_carta_observa,
            a.observacion,
            a.nro_dias_observado,
            a.fecha_levanta_observacion,
            a.fecha_recibe_expediente_observado fecha_admite_observacion,
            nro_carta_improcedente,
            a.fecha_carta_improcedente,
            a.nro_carta_archivo,
            a.fecha_carta_archivo,
            a.fecha_derivacion,
            a.estado_proceso,
            CASE
                WHEN a.nro_dias_observado < 10 THEN 'bg-orange'
                WHEN a.nro_dias_observado > 9 THEN 'bg-red'
                ELSE 'bg-green' 
            END bg_color
        FROM vw_data_expediente_ur a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.codEstadoProceso = $estado");
    }
}
