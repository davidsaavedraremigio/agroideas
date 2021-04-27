<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Capacitacion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCapacitacion';
    public $timestamps          =   false; 

    #2. Obtengo los datos de las Capacitaciones
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_capacitaciones a ORDER BY a.fecha ASC");
    }

    #3. Obtengo la información de Capacitaciones de acuerdo a su estado
    public static function getCapacitaciones($estado)
    {
        return DB::select("SELECT * FROM vw_data_capacitaciones a WHERE a.codEstado = $estado");
    }

    #4. Obtengo la información de SERVIAGRO
    public static function getDataServiagro()
    {
        return DB::select("SELECT * FROM vw_data_serviagro a ORDER BY a.fecha ASC");
    }
}
