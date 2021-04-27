<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ResolucionMinisterial extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicResolucionMinisterial';
    public $timestamps          =   false; 

    #2. Muestro la relación de resoluciones 
    public static function getData()
    {
        return DB::SELECT("SELECT * FROM vw_data_rm");
    }

    #3. Muestro la relación de expedientes disponibles para generar RM
    public static function getDataExpediente()
    {
        return DB::select("SELECT
            a.id,
            LTRIM(RIGHT('0000' + CAST(a.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaExpediente)) nro_expediente,
            a.fechaExpediente fecha,
            d.nroDocumento ruc,
            d.nombre,
            d.region,
            d.provincia,
            d.distrito,
            e.descripcion oficina,
            f.nombres+' '+f.paterno+' '+f.materno responsable
        FROM InicExpedientePostulante a
        LEFT JOIN (
            SELECT * FROM InicResolucionMinisterial
        ) b ON b.codPostulante = a.codPostulante
        LEFT JOIN (
            SELECT * FROM InicPostulante
        ) c ON c.id = a.codPostulante
        LEFT JOIN (
            SELECT * FROM vw_data_opa
        ) d ON d.id = c.codEntidad
        LEFT JOIN (
            SELECT * FROM MaestroOficina
        ) e ON e.id = a.codOficina
        LEFT JOIN (
            SELECT * FROM vw_data_usuario
        ) f ON f.id = codPersonalAsignado
        WHERE a.codArea = 3 AND a.codEstado = 2 AND c.codTipoIncentivo = 2 AND b.id IS NULL");
    }
}
