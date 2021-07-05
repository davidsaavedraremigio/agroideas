<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Actividad extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteActividad';
    public $timestamps          =   false; 
    protected $fillable         =   ['codPostulante', 'codigo', 'descripcion','unidad', 'meta_fisica', 'meta_financiera', 'precio', 'aporte_pcc', 'aporte_oa'];

    #2. Obtengo la relacion de actividades asociadas a un Proyecto
    public static function getData($proyecto)
    {
        return Actividad::where('codPostulante', $proyecto)->get();
    }
}
