<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class AmbitoIntervencion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicAmbitoIntervencion';
    public $timestamps          =   false; 
    #2. Obtengo los datos de ubicación geográfica
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            d.nombre region,
            c.nombre provincia,
            b.nombre distrito,
            a.descripcion,
            a.latitud,
            a.longitud,
            a.principal
        FROM InicAmbitoIntervencion a
        LEFT JOIN (
            SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 6
        ) b ON b.id = a.ubigeo
        LEFT JOIN (
            SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 4
        ) c ON c.id = SUBSTRING(a.ubigeo,1,4)
        LEFT JOIN (
            SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 2
        ) d ON d.id = SUBSTRING(a.ubigeo,1,2)
        WHERE a.codPostulante = $id");
    }
}
