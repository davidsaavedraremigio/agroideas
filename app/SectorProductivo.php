<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class SectorProductivo extends Model
{
    protected 	$table 			=	'MaestroProductoSector';
    public $timestamps          =   false; 

    #1. Obtengo la relación de registros
    public static function getData()
    {
        return SectorProductivo::orderBy('descripcion', 'asc')->get();
    }
}
