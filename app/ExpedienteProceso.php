<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteProceso extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedienteProceso';
    public $timestamps          =   false; 

    #2. Obtengo la relación de Procesos correspondientes a un expediente
    public static function getData($id)
    {
        return db::select("SELECT * FROM vw_data_expediente_proceso a WHERE a.codExpediente = $id ORDER BY a.fecha_recepcion ASC");
    }
}
