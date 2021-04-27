<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoCoordinadorEntidad extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoCoordinadorContraparte';
    public $timestamps          =   false; 

    #2. Ontengo los datos
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            a.tipo,
            a.nro_documento dni,
            a.nombres+' '+a.paterno+' '+a.materno nombres,
            a.cargo,
            a.referencia
        FROM InicConvenioMarcoCoordinadorContraparte a
        WHERE a.codInicConvenioMarco = $id AND a.estado = 1");
    }
}
