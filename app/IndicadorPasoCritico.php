<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class IndicadorPasoCritico extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPasoCriticoIndicador';
    public $timestamps          =   false; 
}
