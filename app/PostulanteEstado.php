<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PostulanteEstado extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicPostulanteEstadoSituacional';
    public $timestamps          =   false; 

    #2. Función para actualizar el estado de un convenio a Cerrado
    public static function setConvenioCerrado($id)
    {
        $estado                         =   PostulanteEstado::where('codPostulante', $id)->first();
        $estado->codEstadoSituacional   =   7;
        $estado->update();
    }
}
