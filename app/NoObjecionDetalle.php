<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class NoObjecionDetalle extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteNoObjecionDetalle';
    public $timestamps          =   false; 

    #2. obtengo los datos del detalle de las No Objeciones
    public static function getData($id)
    {
        return DB::select("SELECT * FROM vw_data_no_objecion_detalle WHERE codInforme = $id");
    }
}
