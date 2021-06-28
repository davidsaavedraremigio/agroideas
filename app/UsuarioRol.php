<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    protected 	$table 			=	'MaestroUsuarioRol';
    public $timestamps          =   false; 

    public static function getRolUsuario($usuario)
    {
        return UsuarioRol::where([
            'codMaestroUsuario' =>  $usuario,
            'estado'            =>  1
        ])->first();
    }
}
