<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoCooperante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoCooperante';
    public $timestamps          =   false; 

    #2. Obtengo la relacion de entidades cooperantes de un determinado convenio
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            b.nro_documento ruc,
            b.nombre razon_social,
            a.nro_documento representante_dni,
            a.nombres+' '+a.paterno+' '+a.materno representante_nombre,
            a.cargo representante_cargo
        FROM InicConvenioMarcoCooperante a
        LEFT JOIN (
            SELECT * FROM EntidadCooperante
        ) b ON b.id = a.codEntidadCooperante
        WHERE a.codInicConvenioMarco = $id AND a.estado = 1");
    }
}
