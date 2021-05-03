<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductorPrp extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicBeneficiarioPrp';
    public $timestamps          =   false; 

    #2. Obtengo los datos de los beneficiarios 
    public static function getData($id)
    {
        return DB::select("SELECT * FROM vw_data_beneficiario_prp a WHERE a.codPostulante = $id");
    }

    #3. Obtengo la relación de productores del PRPA (Ganadores)
    public static function getAprobados($id)
    {
        return DB::select("SELECT * FROM vw_data_productor_prpa a WHERE a.codPostulante = $id");
    }
}
