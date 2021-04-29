<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteSdaUr extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicExpedienteSdaUr';
    public $timestamps          =   false;

    #2. obtengo la relación de expedientes por estado situacional
    public static function getDataExpediente($estado)
    {
        return DB::select("SELECT
            a.codExpediente id,
            b.nro_expediente,
            b.nro_cut,
            b.tipo_incentivo,
	        b.fecha_presentacion,
            b.especialista_asignado,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            b.cadena,
            b.nro_ha,
	        b.nro_beneficiarios,
            a.fecha_recepcion,
            a.responsable_evaluacion,
            a.nro_informe,
            a.fecha_informe,
            a.nro_carta_aprobacion,
            a.fecha_carta_aprobacion,
            a.nro_carta_observacion,
            a.fecha_carta_observacion,
            a.observacion,
            a.nro_carta_archivamiento,
            a.fecha_carta_archivamiento,
            a.fecha_derivacion,
            a.estado_proceso,
            DATEDIFF(DAY,a.fecha_carta_observacion, GETDATE()) nro_dias_observacion
        FROM vw_data_expediente_sda_ur a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.cod_estado_proceso = $estado");
    }
}
