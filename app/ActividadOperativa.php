<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ActividadOperativa extends Model
{
    #1. Obtengo la relación de actividades operativas
    public static function getDataAll()
    {
        return DB::select("SELECT * FROM vw_actividad_operativa");
    }
}
