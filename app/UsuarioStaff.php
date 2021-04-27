<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class UsuarioStaff extends Model
{
    #1. Obtengo el nombre de la tabla
    protected 	$table 			=	'MaestroUsuarioStaff';
    public $timestamps          =   false; 

    #2. Obtengo los datos del personal vigentes
    public static function getStaffUsuario($usuario)
    {
        return UsuarioStaff::where([
            'codMaestroUsuario'     =>  $usuario,
            'estado'                =>  1
        ])->first();
    }
}
