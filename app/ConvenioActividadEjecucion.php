<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioActividadEjecucion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoActividadEjecucion';
    public $timestamps          =   false;

    #2. 
    public static function getData($id)
    {
        
    }
}
