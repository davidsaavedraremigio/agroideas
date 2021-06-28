<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Contrato extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicContrato';
    public $timestamps          =   false; 


    #2. Muestro la relación de convenios de PRPA
    public static function getDataPrp()
    {
        return DB::SELECT("SELECT * FROM vw_data_convenio_incentivo a WHERE a.cod_tipo_incentivo = 2");
    }

    #3. Muestro la relación de convenios de Planes de Negocio
    public static function getDataSda()
    {
        return DB::select("SELECT * FROM vw_data_convenio_incentivo a WHERE a.cod_tipo_incentivo NOT IN (2)");
    }

    #4. Obtengo los incentivos por convenio, tipo de incentivo y estadoi
    public static function getConvenios($tipo, $estado)
    {
        return DB::select("SELECT
            a.id,
            LTRIM(RIGHT('0000' + CAST(d.nroContrato AS varchar(4)), 4))+'-'+LTRIM(YEAR(d.fechaFirma)) numero,
            d.fechaFirma fecha,
            c.nroDocumento ruc,
            c.nombre razon_social,
            a.codTipoIncentivo tipo_incentivo,
            b.codEstadoSituacional cod_estado
        FROM InicPostulante a 
        LEFT JOIN (
            SELECT * FROM InicPostulanteEstadoSituacional
        ) b ON b.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM Entidad
        ) c ON c.id = a.codEntidad
        INNER JOIN (
            SELECT * FROM InicContrato
        ) d ON d.codPostulante = a.id
        WHERE codTipoIncentivo = $tipo AND b.codEstadoSituacional = $estado");
    }

}
