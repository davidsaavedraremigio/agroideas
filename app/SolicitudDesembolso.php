<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudDesembolso extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteSolicitudDesembolso';
    public $timestamps          =   false; 

    #2. Consulto la relación de solicitudes
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            LTRIM(RIGHT('0000' + CAST(a.numero AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fecha)) nro_solicitud,
            a.fecha fecha_solicitud,
            b.nombres+' '+b.paterno+' '+b.materno especialista,
            LTRIM(RIGHT('0000' + CAST(a.numeroMemo AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaMemo)) nro_memo,
            a.fechaMemo fecha_memo,
            LTRIM(RIGHT('0000' + CAST(a.numeroInforme AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaInforme)) nro_informe,
            a.fechaInforme fecha_informe,
            a.importe
        FROM InicPostulanteSolicitudDesembolso a
        LEFT JOIN (
            SELECT * FROM vw_data_usuario
        ) b ON b.id = a.codEspecialistaResponsable");
    }
}
