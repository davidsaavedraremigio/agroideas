<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteSdaUn extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicExpedienteSdaUn';
    public $timestamps          =   false;

    #2. Obtengo la relación de expedientes por estado situacional
    public static function getDataExpediente($estado)
    {
        return db::select("SELECT
            a.codExpediente id,
            b.nro_expediente,
            b.nro_cut,
            b.fecha_presentacion,
            b.especialista_asignado,
            b.tipo_incentivo,
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
            a.nro_memo_favorable,
            a.fecha_memo_favorable,
            a.nro_memo_no_favorable,
            a.fecha_memo_no_favorable,
            a.nro_memo_observa,
            a.fecha_memo_observa,
            a.fecha_derivacion,
            a.estado_proceso,
            a.nro_dias
        FROM vw_data_expediente_sda_un a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.cod_estado_proceso = $estado");
    }

}
