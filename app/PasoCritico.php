<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PasoCritico extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPasoCritico';
    public $timestamps          =   false; 

    #2. Obtengo la relación de Pasos Criticos
    public static function getData($id)
    {
        return PasoCritico::where('codPostulante', $id)->orderBy('inicio', 'ASC')->get();
    }
}
