<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ObjetivoEspecifico extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicObjetivoEspecifico';
    public $timestamps          =   false; 

    #2. Obtengo la relación de objetivos especificos de un  proyecto
    public static function getData($id)
    {
        return ObjetivoEspecifico::where([
            'codPostulante'     =>    $id,
            'estado'            =>  1
        ])->orderBy('orden', 'asc')->get();
    }
}
