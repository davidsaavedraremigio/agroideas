<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class MLProyecto extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'SYSProyecto';
    public $timestamps          =   false; 

    #1. obtengo la información del proyecto
    public static function getData()
    {
        return MLProyecto::orderBy('razonSocial', 'asc')->get();
    }
}
