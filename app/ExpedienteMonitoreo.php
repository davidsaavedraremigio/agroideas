<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExpedienteMonitoreo extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedienteMonitoreo';
    public $timestamps          =   false; 
}
