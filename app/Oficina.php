<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Oficina extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'MaestroOficina';
    public $timestamps          =   false; 

    #2. Obtengo la relación de oficinas
    public static function getData()
    {
        return Oficina::orderBy('descripcion', 'asc')->get();
    }
}
