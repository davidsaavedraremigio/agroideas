<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PostulanteProceso extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteProceso';
    public $timestamps          =   false; 

    #2. Funcion para mostrar la data registrada
    public static function getData($id)
    {
        
    }
}
