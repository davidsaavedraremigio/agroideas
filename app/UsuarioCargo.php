<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class UsuarioCargo extends Model
{
    protected 	$table 			=	'MaestroUsuarioCargo';
    public $timestamps          =   false; 

    #1. Obtengo el cargo actual vigente
    public static function getCargoUsuario($usuario)
    {
        return UsuarioCargo::where([
            'codMaestroUsuario'     =>  $usuario,
            'estado'                =>  1
        ])->first();
    }
}
