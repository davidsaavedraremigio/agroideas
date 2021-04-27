<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarco extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarco';
    public $timestamps          =   false; 

    #2. Obtengo los datos
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            a.numero,
            a.duracion,
            a.fecha_firma,
            a.fecha_termino,
            a.objetivo,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            c.nombre estado
        FROM InicConvenioMarco a
        LEFT JOIN (
            SELECT
                a.codInicConvenioMarco,
                b.nro_documento ruc,
                b.nombre razon_social,
                e.nombre region,
                d.nombre provincia,
                c.nombre distrito
            FROM InicConvenioMarcoCooperante a
            LEFT JOIN (
                SELECT * FROM EntidadCooperante
            ) b ON b.id = a.codEntidadCooperante
            LEFT JOIN (
                SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 6
            ) c ON c.id = b.ubigeo
            LEFT JOIN (
                SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 4
            ) d ON d.id = SUBSTRING(b.ubigeo,1,4)
            LEFT JOIN (
                SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 2
            ) e ON e.id = SUBSTRING(b.ubigeo,1,2)
            WHERE a.estado = 1
        ) b ON b.codInicConvenioMarco = a.id
        LEFT JOIN (
            SELECT * FROM vw_data_tablas a WHERE a.tabla = 'EstadoConvenio'
        ) c ON c.orden = a.cod_estado");
    }

    #3. Obtengo un reporte resumen de los convenios registrados en el sistema
    public static function getConvenios($tipo = 100, $estado = 100)
    {
        return DB::select("EXEC uspGetConsolidadoConvenio @tipo = $tipo, @estado = $estado");
    }

    #4. Obtengo la data de seguimiento a convenios
    public static function getSeguimientoConvenios($tipo = 100, $estado = 100, $periodo = 100)
    {
        return DB::select("EXECUTE uspGetSeguimientoConvenio @tipo = $tipo, @estado = $estado, @periodo = $periodo");
    }

    #5. 
    public static function getListado($tipo = 100, $periodo = 100, $estado = 100)
    {
        return DB::select("EXECUTE uspGetListadoConvenio @tipo = $tipo, @periodo = $periodo, @estado = $estado");
    }

}
