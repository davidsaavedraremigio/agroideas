<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class EventoEntidad extends Model
{
    #1. Identifico a la tabla
    protected 	$table 			=	'InicEventoEntidad';
    public $timestamps          =   false; 

    #2. Obtengo la relación de entidades correspondientes a un determinado evento
    public static function getData($evento)
    {
        return DB::select("SELECT
            a.id,
            c.nombre tipoCompromiso,
            b.compromiso,
            d.nroDocumento,
            d.nombre,
            e.nombre tipoIncentivo,
            f.descripcion cadenaPropuesta,
            a.nroProductores,
            a.nroHas,
            a.inversion
        FROM InicEventoEntidad a
        LEFT JOIN (
            SELECT * FROM InicEventoCompromiso x
        ) b ON b.id = a.compromisoID
        LEFT JOIN (
            SELECT * FROM vw_data_tablas x WHERE x.tabla = 'TipoCompromiso'
        ) c ON c.orden = b.codTipoCompromiso
        LEFT JOIN (
            SELECT * FROM Entidad
        ) d ON d.id = a.entidadID
        LEFT JOIN (
        SELECT * FROM vw_data_tablas x WHERE x.tabla = 'TipoIncentivo' 
        ) e ON e.orden = a.incentivoID
        LEFT JOIN (
            SELECT
                a.id,
                a.descripcion
            FROM MaestroProductoCadena a
        ) f ON f.id = a.codCadenaPropuesta
        WHERE b.eventoID = $evento
        ORDER BY d.nombre ASC");
    }
}
