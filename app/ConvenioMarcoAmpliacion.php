<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoAmpliacion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoAmpliacion';
    public $timestamps          =   false; 


    #2. Obtengo la relacion de compromisos correspondiente a un convenio
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            a.numero,
            a.fecha_firma,
            b.nombre tipo,
            a.objetivo,
            a.fecha_termino
        FROM InicConvenioMarcoAmpliacion a
        LEFT JOIN (
            SELECT * FROM vw_data_tablas a WHERE a.tabla = 'TipoAmpliacion'
        ) b ON b.orden = a.cod_tipo
        WHERE a.codInicConvenioMarco = $id
        ORDER BY a.numero ASC");
    }
}
