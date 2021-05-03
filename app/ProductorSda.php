<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductorSda extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicBeneficiarioSda';
    public $timestamps          =   false; 

    #2. Obtengo los datos de los beneficiarios
    public static function getData($id)
    {
        return DB::select("SELECT * FROM vw_data_productor_sda a WHERE a.codPostulante = $id AND a.estado = 1");
    }

}
