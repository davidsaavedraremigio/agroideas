<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class TipoCompromisoEtapa extends Model
{
    protected 	$table 			=	'MaestroTipoCompromisoEtapa';
    public $timestamps          =   false; 

    #1. Obtengo la relacion de registros
    public static function getData()
    {
        return DB::select("SELECT
            a.id,
            b.nombre tipo_compromiso,
            a.descripcion
        FROM MaestroTipoCompromisoEtapa a
        LEFT JOIN (
            SELECT * 
            FROM vw_data_tablas a WHERE a.tabla = 'TipoCompromiso'
        ) b ON b.orden = a.codTipoCompromiso");
    }
    
    #2. Obtengo las etapas de un tipo de compromiso específico
    public static function getEtapaCompromiso($compromiso)
    {
        return TipoCompromisoEtapa::where('codTipoCompromiso', $compromiso)->orderBy('descripcion', 'asc')->get();
    }
}
