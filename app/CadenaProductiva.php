<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CadenaProductiva extends Model
{
    protected 	$table 			=	'MaestroProductoCadena';
    public $timestamps          =   false; 

    #1. Obtengo la relación de cadenas productivas
    public static function getData()
    {
        return DB::select("SELECT 
            a.id,
            b.sector,
            b.descripcion linea,
            UPPER(a.descripcion) descripcion,
            a.potencialAgroexportador agroexportacion
        FROM MaestroProductoCadena a
        LEFT JOIN (
            SELECT 
                a.id,
                b.descripcion sector,
                a.descripcion
            FROM MaestroProductoLinea a
            LEFT JOIN (
                SELECT * FROM MaestroProductoSector
            ) b ON b.id = a.maestroSectorID
        ) b ON b.id = a.maestroLineaID
        ORDER BY  a.descripcion ASC");
    }

    #2. Obtengo las cadenas productivas correspondientes a una linea en especifico
    public static function getCadenaProductiva($linea)
    {
        return CadenaProductiva::where('maestroLineaID', $linea)->orderBy('descripcion', 'asc')->get();
    }

    #3. Obtengo las cadenas productivas correspondientes a un sector específico
    public static function getCadenaSector($sector)
    {
        return DB::select("SELECT
            a.id,
            UPPER(a.descripcion) descripcion
        FROM MaestroProductoCadena a
        LEFT JOIN (
            SELECT * FROM MaestroProductoLinea x
        ) b ON b.id = a.maestroLineaID
        WHERE b.maestroSectorID = $sector
        ORDER BY a.descripcion ASC");
    }
}
