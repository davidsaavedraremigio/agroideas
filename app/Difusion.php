<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Difusion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicDifusion';
    public $timestamps          =   false; 

    #2. Obtengo los datos de las Difusiones
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_difusion a ORDER BY a.fecha ASC");
    }

    #3. Obtengo la información de Difusiones de acuerdo a su estado
    public static function getEventos($estado)
    {
        return DB::select("SELECT * FROM vw_data_difusion a WHERE a.codEstado = $estado");
    }    

}
