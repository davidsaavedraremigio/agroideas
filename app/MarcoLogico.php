<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class MarcoLogico extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicMarcoLogicoEstructura';
    public $timestamps          =   false; 

    #2. Obtengo la información del Marco Lógico
    public static function getDataML($tipo, $id)
    {
        return DB::select("SELECT
            a.id,
            a.nombre,
            b.nombre unidad,
            a.precioUnitario precio,
            a.metaFisica,
            a.metaFinanciera,
            a.aporteAgroideas,
            a.aporteEntidad
        FROM InicMarcoLogicoEstructura a
        LEFT JOIN (
            SELECT * FROM vw_data_tablas x  WHERE x.tabla = 'Unidad' 
        ) b ON b.orden = a.codUnidadMedida
        WHERE a.codTipo = $tipo AND a.codPostulante = $id
        ORDER BY a.orden ASC");
    }
}
