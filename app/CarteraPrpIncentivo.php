<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CarteraPrpIncentivo extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicCarteraPrpIncentivo';
    public $timestamps          =   false;
}
