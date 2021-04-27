<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoCoordinador extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoCoordinador';
    public $timestamps          =   false; 

    #2. Ontengo los datos
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            a.tipo,
            b.dni,
            b.nombres+' '+b.paterno+' '+b.materno nombres,
            b.cargo,
            b.area,
            b.oficina
        FROM InicConvenioMarcoCoordinador a
        LEFT JOIN (
            SELECT * FROM vw_data_usuario
        ) b ON b.id = a.codPersonal
        WHERE a.codInicConvenioMarco = $id AND a.estado = 1");
    }

}
