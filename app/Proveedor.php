<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Proveedor extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicProveedor';
    public $timestamps          =   false; 
    protected   $fillable       =   ['nroRuc', 'razonSocial', 'direccion', 'tipoProveedor', 'estaHabido', 'estaActivo', 'codEntidadFinanciera', 'nroCuentaBancaria', 'nroCCI', 'tipoCuenta', 'estado', 'created_auth', 'created_at', 'updated_auth', 'updated_at'];
}
