<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CapacitacionExtensionista extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCapacitacionExtensionista';
    public $timestamps          =   false; 

    #2. Muestro los datos de los extensionistas registrados
    public static function getDataExtensionista($capacitacion)
    {
        return DB::select("SELECT
            a.id,
            a.dni,
            a.nombres+' '+a.paterno+' '+a.materno nombres,
            DATEDIFF(YEAR, a.fecha, GETDATE()) edad,
            a.sexo
        FROM InicCapacitacionExtensionista a WHERE a.codInicCapacitacion = $capacitacion");
    }
}
