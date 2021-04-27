<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CultivoInicial extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCultivoInicial';
    public $timestamps          =   false; 
}
