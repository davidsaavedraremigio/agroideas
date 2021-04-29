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


}
