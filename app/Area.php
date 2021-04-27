<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Area extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'MaestroArea';
    public $timestamps          =   false; 

    #2. Obtengo la información de las áreas registradas
    public static function getData()
    {
        return Area::where('estado', '1')->orderBy('descripcion', 'ASC')->get();
    }
}
