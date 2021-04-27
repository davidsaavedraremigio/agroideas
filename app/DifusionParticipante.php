<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class DifusionParticipante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicDifusionParticipante';
    protected   $fillable       =   ['codInicDifusion', 'dni', 'nombres', 'paterno', 'materno', 'fecha', 'sexo', 'codTipo', 'codActividadProductor', 'codActividadParticipante', 'detallaOtraActividad', 'codCadenaAgricola', 'codCadenaPecuaria', 'codCadenaForestal', 'codEntidad', 'estado', 'created_auth', 'updated_auth'];
    protected 	$guarded        =   [];
    public $timestamps          =   false; 

    #2. Muestro los datos de los participantes registrados
    public static function getData($id)
    {

    }

}
