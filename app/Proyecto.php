<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Proyecto extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicProyecto';
    public $timestamps          =   false; 

    #2. Obtengo la relación de Proyectos registrados por contratos
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            c.nroDocumento ruc,
            c.nombre razon_social,
            a.tituloProyecto titulo,
            LTRIM(RIGHT('0000' + CAST(d.nroContrato AS varchar(4)), 4))+'-'+LTRIM(YEAR(d.fechaFirma)) nroContrato,
            a.duracion,
            a.fecha_inicio,
            a.fecha_termino,
            a.nro_beneficiarios,
            a.inversion_pcc,
            a.inversion_entidad,
            a.inversion_total
        FROM InicProyecto a
        LEFT JOIN (
            SELECT * FROM InicPostulante
        ) b ON b.id = a.codPostulante
        LEFT JOIN (
            SELECT * FROM Entidad
        ) c ON c.id = b.codEntidad
        LEFT JOIN (
            SELECT * FROM InicContrato
        ) d ON d.codPostulante = a.codPostulante
        WHERE b.codTipoIncentivo NOT IN (2)");
    }
}
