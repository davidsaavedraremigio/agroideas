<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConvenioMarcoCompromiso extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicConvenioMarcoCompromiso';
    public $timestamps          =   false; 

    #2. Obtengo la relacion de compromisos correspondiente a un convenio
    public static function getData($id)
    {
        return ConvenioMarcoCompromiso::where('codInicConvenioMarco', $id)->get();
    }
}
