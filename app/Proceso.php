<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Proceso extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'MaestroProceso';
    public $timestamps          =    false; 

    #2. Obtengo la información de los procesos registrados
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            c.nombre tipo_iniciativa,
            b.sigla area_sigla,
            b.descripcion area,
            a.orden,
            a.descripcion proceso
        FROM MaestroProceso a
        LEFT JOIN (
            SELECT * FROM MaestroArea
        ) b ON b.id = a.codMaestroArea
        LEFT JOIN (
            SELECT * FROM vw_data_tablas a WHERE a.tabla = 'TipoIncentivo'
        ) c ON c.orden = a.codTipoIniciativa
        WHERE a.estado = 1");
    }
}
