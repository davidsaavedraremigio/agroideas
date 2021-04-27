<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class IndicadorIniciativa extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicIndicadorResultado';
    public $timestamps          =   false; 

    #2. Obtengo la relación de indicadores
    public static function getData($id)
    {
        return DB::SELECT("SELECT
            a.id,
            b.tipo,
            b.indicador,
            b.unidad,
            a.valorLineaBase,
            a.valorMeta,
            a.valorLineaCierre
        FROM InicIndicadorResultado a
        LEFT JOIN (
            SELECT
                d.id,
                c.nombre tipo,
                UPPER(a.descripcion) indicador,
                b.nombre unidad
            FROM MaestroIndicadorResultado a
            LEFT JOIN (
                SELECT * FROM vw_data_tablas x WHERE x.tabla = 'Unidad'
            ) b ON b.orden = a.codUnidadMedida
            LEFT JOIN (
                SELECT * FROM vw_data_tablas x WHERE x.tabla = 'TipoIndicadorResultado'
            ) c ON c.orden = a.codTipo
            LEFT JOIN (
                SELECT * FROM MaestroIndicadorResultadoCadena
            ) d ON d.codIndicadorResultado = a.id
        ) b ON b.id = a.id
        WHERE a.codPostulante = $id");
    }
}
