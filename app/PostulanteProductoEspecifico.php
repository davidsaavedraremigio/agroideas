<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PostulanteProductoEspecifico extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicProductoEspecifico';
    public $timestamps          =   false; 

    #2. Obtengo la relación de productos con los que trabajará la iniciativa
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            e.descripcion sector,
            d.descripcion linea,
            c.descripcion cadena,
            b.descripcion producto,
            a.variedad,
            f.nombre tipo_produccion,
            a.nroHas,
            a.nroProductores,
            a.principal
        FROM InicProductoEspecifico a
        LEFT JOIN (
            SELECT * FROM MaestroProducto
        ) b ON b.id = a.codProducto
        LEFT JOIN (
            SELECT * FROM MaestroProductoCadena
        ) c ON c.id = b.maestroCadenaID
        LEFT JOIN (
            SELECT * FROM MaestroProductoLinea
        ) d ON d.id = c.maestroLineaID
        LEFT JOIN (
            SELECT * FROM MaestroProductoSector
        ) e ON e.id = d.maestroSectorID
        LEFT JOIN (
            SELECT
                x.orden,
                x.nombre,
                x.valor
            FROM vw_data_tablas x 
            WHERE x.tabla = 'TipoProduccion'
        ) f ON f.orden = a.tipoProduccion
        WHERE a.codPostulante = $id AND a.etapa = '1'
        ORDER BY a.principal DESC");
    }
}
