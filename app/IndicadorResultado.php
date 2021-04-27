<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class IndicadorResultado extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'MaestroIndicadorResultado';
    public $timestamps          =   false; 

    #2. Obtengo la informacion de indicadores
    public static function getData()
    {
        return db::select("SELECT
            a.id,
            c.nombre tipo,
            a.descripcion,
            b.nombre unidad
        FROM MaestroIndicadorResultado a
        LEFT JOIN (
            SELECT * FROM vw_data_tablas a WHERE a.tabla = 'Unidad'
        ) b ON b.orden = a.codUnidadMedida
        LEFT JOIN (
            SELECT * FROM vw_data_tablas a WHERE a.tabla = 'TipoIndicadorResultado'
        ) c ON c.orden = a.codTipo");
    }

    #3. Obtengo los indicadores correspondientes a una determinada cadena productiva
    public static function getIndicadores($cadena)
    {
        return DB::select("SELECT
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
        WHERE d.codCadenaProductiva = $cadena");
    }
}
