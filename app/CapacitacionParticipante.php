<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CapacitacionParticipante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCapacitacionParticipante';
    protected   $fillable       =   ['codInicCapacitacion', 'dni', 'nombres', 'paterno', 'materno', 'fecha', 'sexo', 'codTipo', 'codActividadProductor', 'codActividadParticipante', 'detallaOtraActividad', 'codCadenaAgricola', 'codCadenaPecuaria', 'codCadenaForestal', 'codEntidad', 'estado', 'created_auth', 'updated_auth'];
    protected 	$guarded        =   [];
    public $timestamps          =   false; 

    #2. Muestro los datos de los participantes registrados
    public static function getData($id)
    {
        return DB::select("SELECT * FROM vw_data_capacitaciones_participante a WHERE a.codInicCapacitacion = $id");
    }
}
