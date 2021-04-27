<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class UsuarioSede extends Model
{
    protected 	$table 			=	'MaestroUsuarioOficina';
    public $timestamps          =   false; 

    #1. Obtengo la oficina actual del usuario
    public static function getSedeUsuario($usuario)
    {
        return UsuarioSede::where([
            'codMaestroUsuario'     =>  $usuario,
            'estado'                =>  1
        ])->first();
    }
}
