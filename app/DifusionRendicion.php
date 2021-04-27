<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class DifusionRendicion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicDifusionRendicion';
    public $timestamps          =   false; 

    #2. Obtengo las rendiciones asignadas a un evento
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            a.concepto,
            a.fecha,
            a.importe
        FROM InicDifusionRendicion a
        WHERE a.codInicDifusion = $id
        ORDER BY a.fecha ASC");
    }
}
