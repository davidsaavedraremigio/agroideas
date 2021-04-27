<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cargo extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'MaestroCargo';
    public $timestamps          =   false; 

    #2. Obtengo la relación de Cargos registrados
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            b.descripcion area,
            a.descripcion,
            a.estado
        FROM MaestroCargo a
        LEFT JOIN (
            SELECT * FROM MaestroArea x
        ) b ON b.id = a.codMaestroAreaID
        WHERE a.estado = 1");
    }
}
