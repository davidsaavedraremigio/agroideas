<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class EventoCompromisoSeguimiento extends Model
{
    protected 	$table 			=	'InicEventoCompromisoSeg';
    public $timestamps          =   false; 

    #1. Obtengo la relación de tareas realizadas de acuerdo al codigo de evento
    public static function getData($evento)
    {
        return DB::select("SELECT
            a.id,
            d.nombre tipoCompromiso,
            b.compromiso,
            e.descripcion etapa,
            a.fecha,
            a.responsable,
            a.resultados,
            a.observaciones,
            a.evidencia,
            c.nombre estado
        FROM InicEventoCompromisoSeg a
        LEFT JOIN (
            SELECT * FROM InicEventoCompromiso x
        ) b ON b.id = a.compromisoID
        LEFT JOIN (
            SELECT * FROM vw_data_tablas x WHERE x.tabla = 'EstadoCompromiso'
        ) c ON c.orden = b.codEstado
        LEFT JOIN (
            SELECT * FROM vw_data_tablas x WHERE x.tabla = 'TipoCompromiso'
        ) d ON d.orden = b.codTipoCompromiso
        LEFT JOIN (
            SELECT * FROM MaestroTipoCompromisoEtapa
        ) e ON e.id = a.codEtapaActividad
        WHERE b.eventoID = $evento
        ORDER BY a.fecha ASC");
    }
}
