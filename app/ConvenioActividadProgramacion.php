<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioActividadProgramacion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoActividadProgramacion';
    public $timestamps          =   false;

    #2. Obtengo la relacion de datos asociados a un convenio
    public static function getData($convenio)
    {
        return DB::select("SELECT
            a.id,
            b.descripcion compromiso,
            a.nombreActividad actividad,
            a.metaFisica meta,
            a.fechaLimite fecha,
            a.descripcion tareas,
            a.estado
        FROM InicConvenioMarcoActividadProgramacion a
        LEFT JOIN (
            SELECT * FROM InicConvenioMarcoCompromiso
        ) b ON b.id = a.codInicConvenioMarcoCompromiso
        WHERE b.codInicConvenioMarco = $convenio");
    }
}
