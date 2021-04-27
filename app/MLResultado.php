<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class MLResultado extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'SYSMarcoLogico';
    public $timestamps          =   false; 

    #2. obtengo la información del proyecto
    public static function getData($id, $tipo)
    {
        return DB::select("SELECT
                                a.id,
                                a.tipo,
                                a.nroOrden,
                                a.descripcion,
                                b.descripcion referencia
                            FROM SYSMarcoLogico a
                            LEFT JOIN (
                                SELECT * FROM SYSMarcoLogico x WHERE x.tipo = 'C'
                            ) b ON b.id = a.referenciaID
                            WHERE a.SYSProyectoID = $id AND a.tipo = '".$tipo."' ORDER BY a.nroOrden ASC");
    }
}
