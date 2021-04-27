<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ImportEjecPresupuesto extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'ImportEjecPresupuesto';
    protected $fillable         =   ['codigo', 'periodo', 'mes','importe'];
    public $timestamps          =   false; 
}
