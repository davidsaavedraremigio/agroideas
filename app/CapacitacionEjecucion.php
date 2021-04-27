<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CapacitacionEjecucion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCapacitacionEjecucion';
    public $timestamps          =   false; 


    #2. Obtengo los datos de las rendiciones de capacitación
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_capacitaciones_ejecutadas");
    }
}
