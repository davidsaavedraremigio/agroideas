<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Postulante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulante';
    public $timestamps          =   false; 

    #2. Obtengo los datos registrados
    public static function getData($tipo_incentivo)
    {
        return DB::select("SELECT * FROM vw_data_incentivo a WHERE a.codTipoIncentivo = $tipo_incentivo");
    }

    #3. Obtengo los datos de los postulantes de acuerdo al estado
    public static function getDataEstado($tipo_incentivo, $estado)
    {
        return DB::select("SELECT * FROM vw_data_incentivo a WHERE a.codTipoIncentivo = $tipo_incentivo AND a.cod_estado = $estado");
    }

    #4. Obtengo los datos de los postulantes correspondientes a Solicitudes de apoyo
    public static function getDataSda()
    {
        return DB::select("SELECT * FROM vw_data_incentivo a WHERE a.codTipoIncentivo NOT IN (2)");
    }

    #5. Obtengo la relación de Proyectos
    public static function getConsolidado()
    {
        return DB::select("SELECT * FROM vw_data_incentivo a WHERE a.nro_contrato IS NOT NULL");
    }

    #6. Obtengo la relación de pedidos de SDA pendientes de atención
    public static function getSdaPendiente()
    {
        return DB::select("SELECT * FROM vw_data_incentivo a WHERE a.codTipoIncentivo NOT IN (2) AND a.cod_estado = 0");
    }


}   
