<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Tabla;
use DB;

class TablaValor extends Model
{
    protected 	$table 			=	'MaestroTablaValor';
    public $timestamps          =   false; 

    #1. Obtengo el total de registros
    public static function getData()
    {
        return DB::select('SELECT
            a.id,
            a.Orden,
            a.Nombre,
            a.Valor,
            b.nombre Tabla
        FROM MaestroTablaValor a
        LEFT JOIN (
            SELECT * FROM MaestroTabla b
        ) b ON b.id = a.MaestroTablaID
        ORDER BY b.nombre ASC, a.Nombre ASC');
    }

    #2. Obtengo los valores correspondientes a la tabla seleccionada
    public static function getDetalleTabla($tabla)
    {
        $maestro    =   Tabla::where('nombre', $tabla)->first();
        $codTabla   =   $maestro->id;

        return TablaValor::where('MaestroTablaID', $codTabla)->get();
    }
}
