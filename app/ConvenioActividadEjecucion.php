<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioActividadEjecucion extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoActividadEjecucion';
    public $timestamps          =   false;

    #2. 
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            d.descripcion compromiso,
            a.fecha,
            b.nombres+' '+b.paterno+' '+b.materno responsable,
            c.nombreActividad actividad,
            c.metaFisica,
            a.metaEjecutada,
            a.acciones,
            CASE
                WHEN c.estadoImplementacion = 1 THEN 'Por implementar'
                WHEN c.estadoImplementacion = 2 THEN 'Implementado'
                ELSE 'Impedido/Cancelado'
            END situacion
        FROM InicConvenioMarcoActividadEjecucion a
        LEFT JOIN (
            SELECT * FROM vw_data_usuario
        ) b ON b.id = a.codResponsable
        LEFT JOIN (
            SELECT * FROM InicConvenioMarcoActividadProgramacion
        ) c ON c.id = a.codActividadProgramacion
        LEFT JOIN (
            SELECT * FROM InicConvenioMarcoCompromiso
        ) d ON d.id = c.codInicConvenioMarcoCompromiso
        WHERE d.codInicConvenioMarco = $id");
    }
}
