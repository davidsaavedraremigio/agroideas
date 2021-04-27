<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class DifusionEntidadParticipante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicDifusionEntidadParticipante';
    public $timestamps          =   false;

    #2. Obtengo los datos de las rendiciones de capacitación
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            a.ruc,
            a.razonSocial,
            b.nombre tipoEntidad,
            a.ubigeo,	
            e.nombre region,
            d.nombre provincia,
            c.nombre distrito,
            a.direccion,
            a.nombrePersonaContacto nombreContacto,
            a.cargoPersonaContacto cargoContacto,
            a.nroTelefono telefono,
            a.email
        FROM InicDifusionEntidadParticipante a
        LEFT JOIN (
            SELECT * FROM vw_data_tablas x WHERE x.tabla = 'TipoEntidad'
        ) b ON b.orden = a.codTipoEntidad
        LEFT JOIN (
            SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 6
        ) c ON c.id = a.ubigeo
        LEFT JOIN (
            SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 4
        ) d ON d.id = SUBSTRING(a.ubigeo,1,4)
        LEFT JOIN (
            SELECT * FROM MaestroUbigeo x WHERE LEN(x.id) = 2
        ) e ON e.id = SUBSTRING(a.ubigeo,1,2)
        WHERE a.codInicDifusion = $id");
    }

}
