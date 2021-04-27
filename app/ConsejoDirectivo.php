<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConsejoDirectivo extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'ConsejoDirectivo';
    public $timestamps          =   false;

    #2. obtengo los datos del consejo directivo
}
