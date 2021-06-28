<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class NoObjecion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteNoObjecion';
    public $timestamps          =   false; 

    #2. Muestro la información solicitada
    public static function getData()
    {
        
    }
}
