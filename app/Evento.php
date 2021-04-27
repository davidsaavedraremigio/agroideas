<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Evento extends Model
{
    protected 	$table 			=	'InicEvento';
    public $timestamps          =   false; 

    #1. Obtenemos la relación de eventos disponibles
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_eventos");
    }

    #2. Obtengo un consolidado de eventos y seguimiento a compromisos
    public static function getConsolidado()
    {
        return DB::select("SELECT * FROM vw_data_seguimiento_compromisos");
    }

    #3. Obtengo la matriz de compromisos del minagri
    public static function getDataMatriz()
    {
        return DB::select("SELECT * FROM vw_matriz_compromisos_minagri a ORDER BY a.nombre_evento ASC, a.compromiso ASC");
    }

    #4. Obtengo la información pra el reporte: Mesas tecnicas 1, 2, 3, 4 y 5
    public static function getDataReport01()
    {
        return DB::select("SELECT
            a.id,
            UPPER(a.nombre) nombre,
            a.region,
            a.provincia,
            a.distrito,
            b.compromiso,
            b.situacion,
            b.fecha_actualizacion,
            b.resultados,
            UPPER(b.responsable) responsable,
            a.integrantes actores,
            a.representante_organizadores representante
        FROM vw_data_eventos a
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos 
        ) b ON b.EventoID = a.id
        WHERE a.cod_tipo_evento = 1
        ORDER BY a.nombre ASC");
    }

    #5. Obtengo la informacion de avance del gore amazonas
    public static function getDataReport02()
    {
        return DB::select("SELECT
            a.id,
            a.nombre,
            a.objetivo,
            a.integrantes,
            b.compromiso,
            b.tipo,
            b.fecha_plazo,
            b.situacion,
            b.etapa,
            b.resultados,
            b.fecha_actualizacion,
            b.responsable
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.cod_tipo_evento = 4 AND a.id IN (48)");
    }

    #6. Obtengo la informacion del 11vo Gore ejecutivo
    public static function getDataReport03()
    {
        return DB::select("SELECT
            a.id,
            a.region,
            a.nombre,
            b.compromiso,
            b.responsable,
            c.etapa,
            a.organizadores,
            c.resultados,
            b.fecha,
            b.situacion
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        LEFT JOIN (
            SELECT * FROM vw_data_seguimiento_compromisos a WHERE a.compromisoID = 92
        ) c ON c.compromisoID = b.id
        WHERE a.cod_tipo_evento = 4 AND a.id IN (40, 11)");
    }

    #7.
    public static function getDataReport04()
    {
        return DB::select("SELECT
            a.id,
            a.region,
            b.compromiso,
            b.etapa,
            b.resultados,
            b.fecha,
            b.situacion
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.cod_tipo_evento = 4 AND a.id IN (22, 49, 39, 46, 33)
        ORDER BY a.nombre ASC");
    }

    #8. Mesa tecnica zarumilla
    public static function getDataReport05()
    {
        return DB::select("SELECT
            a.id,
            a.tipo_evento,
            a.nombre,
            a.region,
            b.compromiso,
            b.etapa,
            b.resultados,
            b.situacion
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.cod_tipo_evento = 2 AND a.id IN (35)
        ORDER BY a.region DESC");
    }

    #9. Compromisos Bagua
    public static function getDataReport06()
    {
        return DB::select("SELECT
            a.id,
            a.tipo_evento,
            a.nombre,
            b.responsable,
            b.compromiso,
            b.etapa,
            b.resultados
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (2)
        ORDER BY a.nombre DESC");
    }

    #10. Compromisos Condorcanqui
    public static function getDataReport07()
    {
        return DB::select("SELECT
            a.id,
            a.tipo_evento,
            a.nombre,
            b.responsable,
            b.compromiso,
            b.etapa,
            b.resultados
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (1)
        ORDER BY a.nombre DESC");
    }

    #11. Compromisos Moquegua
    public static function getDataReport08()
    {
        return DB::select("SELECT
            a.id,
            a.tipo_evento,
            a.nombre,
            a.region,
            b.responsable,
            b.compromiso,
            b.etapa,
            b.resultados
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (25)
        ORDER BY a.region DESC");
    }

    #12. Compromiso Olmos
    public static function getDataReport09()
    {
        return DB::select("SELECT
            a.id,
            a.region,
            a.provincia,
            a.distrito,
            a.nombre,
            b.compromiso,
            b.fecha,
            b.etapa,
            b.inversion,
            b.resultados,
            b.observaciones,
            b.situacion,
            b.responsable
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (13)
        ORDER BY a.region DESC");
    }

    #13. Compromisos San Martin
    public static function getDataReport10()
    {
        return DB::select("SELECT
            a.id,
            a.region,
            a.provincia,
            a.distrito,
            a.nombre,
            b.compromiso,
            b.fecha,
            b.etapa,
            b.resultados,
            b.observaciones,
            b.situacion,
            b.responsable
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.region IN ('San Martín')
        ORDER BY a.nombre ASC");
    }

    #14. Compromisos Alto amazonas
    public static function getDataReport11()
    {
        return DB::select("SELECT
            a.id,
            a.nombre,
            b.tipo,
            b.compromiso,
            b.etapa,
            b.situacion,
            b.resultados
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (23)
        ORDER BY a.nombre ASC");
    }

    #15. Compromiso Quellaveco
    public static function getDataReport12()
    {
        return DB::select("SELECT
            a.id,
            a.nombre,
            b.tipo,
            b.compromiso,
            b.etapa,
            b.situacion,
            b.resultados,
            b.responsable
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (25)
        ORDER BY a.nombre ASC");
    }

    #16. Compromisos Hidrovia amazónica
    public static function getDataReport13()
    {
        return DB::select("SELECT
            a.id,
            b.etapa,
            b.situacion,
            a.distrito,
            a.provincia,
            a.region,
            b.compromiso,
            b.resultados
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (21)
        ORDER BY a.nombre ASC");
    }

    #17. Mesa de diálogo Candarave
    public static function getDataReport14()
    {
        return DB::select("SELECT
            a.id,
            a.tipo_evento,
            a.region,
            a.nombre,
            b.compromiso,
            b.resultados,
            b.situacion
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (34)
        ORDER BY a.nombre ASC");
    }

    #18. Compromiso Vraem
    public static function getDataReport15()
    {
        return DB::select("SELECT
            a.id,
            a.region,
            a.provincia,
            a.distrito,
            a.nombre,
            b.compromiso,
            b.fecha,
            b.etapa,
            b.inversion,
            b.resultados,
            b.observaciones,
            b.situacion,
            b.responsable
        FROM vw_data_eventos a 
        LEFT JOIN (
            SELECT * FROM vw_data_compromisos
        ) b ON b.EventoID = a.id
        WHERE a.id IN (50)
        ORDER BY a.region DESC");
    }



}
