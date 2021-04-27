<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoPostulante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoPostulante';
    public $timestamps          =   false; 

    #2. Ontengo los datos
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            b.nro_contrato,
            b.tipo,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            b.inversion_pcc,
            b.estado
        FROM InicConvenioMarcoPostulante a
        LEFT JOIN (
            SELECT * FROM vw_data_incentivo
        ) b ON b.id = a.codPostulante
        WHERE a.codInicConvenioMarco = $id AND a.estado = 1");
    }
}
