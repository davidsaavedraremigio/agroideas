<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoImplementacion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoCompromisoImplementacion';
    public $timestamps          =   false; 

    #2. Ontengo los datos
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            b.descripcion compromiso,
            a.fecha,
            a.resultados,
            a.dificultades,
            a.recomendaciones
        FROM InicConvenioMarcoCompromisoImplementacion a
        LEFT JOIN (
            SELECT * FROM InicConvenioMarcoCompromiso
        ) b ON b.id = a.codInicCompromiso
        WHERE b.codInicConvenioMarco = $id");
    }
}
