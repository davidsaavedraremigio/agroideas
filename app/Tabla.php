<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tabla extends Model
{
    #1. Configuramos los datos de la tabla
    protected 	$table 			=	'MaestroTabla';
    #protected $dateFormat       =   'Ymd G:i:s';
    public $timestamps          =   false;    
    

    #1. Obtengo el total de registros
    public static function getData()
    {
        $tablas =   Tabla::where('estado', 1)
                    ->orderBy('nombre', 'asc')
                    ->get();
        return $tablas;
    }
}
