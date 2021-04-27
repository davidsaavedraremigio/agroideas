<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Producto extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'MaestroProducto';
    public $timestamps          =   false; 

    #2. Obtengo la relación de productos registrados
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            d.descripcion sector,
            c.descripcion linea,
            b.descripcion cadena,
            a.descripcion
        FROM MaestroProducto a
        LEFT JOIN (
            SELECT * FROM MaestroProductoCadena
        ) b ON b.id = a.maestroCadenaID
        LEFT JOIN (
            SELECT * FROM MaestroProductoLinea
        ) c ON c.id = b.maestroLineaID
        LEFT JOIN (
            SELECT * FROM MaestroProductoSector
        ) d ON d.id = c.maestroSectorID");
    }

    #3. Obtengo los Productos asociados a una determinada cadena
    public static function getProducto($cadena)
    {
        return Producto::where('maestroCadenaID', $cadena)->orderBy('descripcion', 'ASC')->get();
    }

}
