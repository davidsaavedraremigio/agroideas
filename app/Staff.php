<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Staff extends Model
{
    #1. Obtenemos el nombre de la tabla
    protected 	$table 			=	'MaestroStaff';
    public $timestamps          =   false; 

    #2. Obtenemos los datos registrados
    public static function getData()
    {
        return Staff::where('estado', '1')->orderBy('nombres', 'asc')->get();
    }

    #3. Obtengo el codigo de usuario de un trabajador staff
    public static function getUsuario($staff)
    {
        $query  =   DB::select("SELECT a.codMaestroUsuario cod_usuario
        FROM MaestroUsuarioStaff a WHERE a.codStaff = $staff");
        return $query[0];
    }

    #4. Obtengo el área de un usuario
    public static function getArea($usuario)
    {
        $query  =   DB::select("SELECT 
            e.codMaestroAreaID cod_area
        FROM MaestroUsuario a
        LEFT JOIN (
            SELECT * FROM MaestroUsuarioStaff
        ) b ON b.codMaestroUsuario = a.id
        LEFT JOIN (
            SELECT * FROM MaestroUsuarioCargo
        ) c ON c.codMaestroUsuario = a.id
        LEFT JOIN (
            SELECT * FROM MaestroUsuarioOficina
        ) d ON d.codMaestroUsuario = a.id
        LEFT JOIN (
            SELECT * FROM MaestroCargo
        ) e ON e.id = c.codMaestroCargo
        WHERE a.id = $usuario");
        return $query[0];
    }


}
