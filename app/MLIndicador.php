<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class MLIndicador extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'SYSIndicador';
    public $timestamps          =   false; 

    #2. obtengo la información del proyecto
    public static function getData($id, $tipo)
    {
        return DB::select("SELECT
        a.id,
        c.descripcion referencia,
        a.orden,
        a.codigo,
        a.descripcion,
        b.nombre unidad,
        a.medioVerificacion,
        a.supuestos
    FROM SYSIndicador a
    LEFT JOIN (
        SELECT * FROM vw_data_tablas x WHERE x.tabla = 'Unidad' 
    ) b ON b.orden = a.unidadMedidaID
    LEFT JOIN (
        SELECT * FROM SYSMarcoLogico
    ) c ON c.id = a.referenciaID
    WHERE c.SYSProyectoID = $id AND c.tipo = '".$tipo."'");
    }
}
