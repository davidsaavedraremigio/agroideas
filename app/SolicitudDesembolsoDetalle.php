<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudDesembolsoDetalle extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteSolicitudDesembolsoDetalle';
    public $timestamps          =   false; 

    #2. Obteno la relación de datos registrados
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            a.codPostulanteNoObjecion,
            c.actividad,
            c.descripcion item,
            c.tipo,
            c.ruc,
            c.razonSocial,
            c.banco,
            c.nroCCI,
            c.importe
        FROM InicPostulanteSolicitudDesembolsoDetalle a
        LEFT JOIN (
            SELECT * FROM InicPostulanteNoObjecion
        ) b ON b.id = a.codPostulanteNoObjecion
        LEFT JOIN (
            SELECT * FROM vw_data_no_objecion_detalle
        ) c ON c.codInforme = b.id
        WHERE a.codPostulanteSolicitudDesembolso = $id");
    }
}
