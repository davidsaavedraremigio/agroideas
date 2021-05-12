<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PostulanteResultado extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteResultados';
    public $timestamps          =   false; 

    #2. Muestro los indicadores que corresponden a un proyecto
    public static function getData($id)
    {
        return DB::select("SELECT * FROM vw_data_indicador_resultado a WHERE a.codPostulante = $id");
    }
}
