<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class LineaProductiva extends Model
{
    protected 	$table 			=	'MaestroProductoLinea';
    public $timestamps          =   false; 

    #1. Obtengo la relación de lineas productivas
    public static function getData()
    {
        return DB::select("SELECT 
            a.id,
            b.descripcion sector,
            a.descripcion
        FROM MaestroProductoLinea a
        LEFT JOIN (
            SELECT * FROM MaestroProductoSector
        ) b ON b.id = a.maestroSectorID");
    }

    #2. Obtengo las lineas productivas correspondientes a un sector en especifico
    public static function getLineaProductiva($sector)
    {
        return LineaProductiva::where('maestroSectorID', $sector)->orderBy('descripcion', 'asc')->get();
    }
}
