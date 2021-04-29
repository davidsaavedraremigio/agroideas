<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteSdaUaj extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicExpedienteSdaUaj';
    public $timestamps          =   false;

    #2. Obtengo los datos de los expedientes derivados a UAJ
    public static function getDataExpediente($estado)
    {
        return db::select("SELECT
            a.codExpediente id,
            b.nro_expediente,
            b.nro_cut,
            b.fecha_presentacion,
            a.fecha_recepcion,
            b.tipo_incentivo,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            b.cadena,
            b.nro_ha,
            b.nro_beneficiarios,
            a.responsable_evaluacion,
            a.nro_informe,
            a.fecha_informe,
            a.nro_consejo_directivo,
            a.nro_memo,
            a.fecha_memo,
            a.fecha_derivacion,
            a.estado_proceso,
            a.nro_dias
        FROM vw_data_expediente_sda_uaj a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.cod_estado_proceso = $estado");
    }
}
