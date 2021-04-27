<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class EntidadCooperante extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'EntidadCooperante';
    protected   $fillable       =   ['tipo_documento', 'nro_documento', 'tipo_entidad', 'nombre', 'ubigeo', 'direccion', 'estado', 'created_auth', 'updated_auth'];
    public $timestamps          =   false; 
}
