<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarco extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarco';
    public $timestamps          =   false; 

    #2. Obtengo los datos
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_convenios_marco");
    }

    #3. Obtengo un reporte resumen de los convenios registrados en el sistema
    public static function getConvenios($tipo = 100, $estado = 100)
    {
        return DB::select("EXEC uspGetConsolidadoConvenio @tipo = $tipo, @estado = $estado");
    }

    #4. Obtengo la data de seguimiento a convenios
    public static function getSeguimientoConvenios($tipo = 100, $estado = 100, $periodo = 100)
    {
        return DB::select("EXECUTE uspGetSeguimientoConvenio @tipo = $tipo, @estado = $estado, @periodo = $periodo");
    }

    #5. 
    public static function getListado($tipo = 100, $periodo = 100, $estado = 100)
    {
        return DB::select("EXECUTE uspGetListadoConvenio @tipo = $tipo, @periodo = $periodo, @estado = $estado");
    }

}
