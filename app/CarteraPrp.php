<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CarteraPrp extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCarteraPrp';
    public $timestamps          =   false;

    #2. Obtengo la relación de carteras registradas
    public static function getData()
    {
        return DB::select("SELECT
            a.id, 
            a.descripcion,
            a.nroResolucion nro_resolucion,
            a.fechaResolucion fecha,
            a.importe,
            dbo.getUbigeoCarteraPrp(a.id) ubigeo
        FROM InicCarteraPrp a");
    }

    #3. Obtengo la relación de iniciativas que corresponden al ubigeo indicado en la cartera
    public static function getDataIncentivoPrp($id)
    {
        return DB::select("SELECT
            a.id,
            LTRIM(RIGHT('0000' + CAST(a.nro_contrato AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fecha_contrato))+'-MINAGRI-PCC' nro_contrato,
            a.fecha_contrato,
            a.ruc,
            a.razon_social,
            a.ubigeo
        FROM vw_data_incentivo a
        WHERE a.codTipoIncentivo = 2 AND a.nro_contrato IS NOT NULL AND SUBSTRING(a.ubigeo, 1, 2) IN (SELECT a.ubigeo FROM InicCarteraPrpUbigeo a WHERE a.codInicCarteraPrp = $id)
        ORDER BY a.fecha_contrato ASC, a.nro_contrato ASC");
    }
}
