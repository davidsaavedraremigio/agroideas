<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PersonaEntidad extends Model
{
    protected 	$table 			=	'PersonaEntidad';
    protected	$primaryKey		=	'id';
    protected $fillable         =   ['dniPersona', 'codEntidad', 'estado'];
    public $timestamps          =   false; 


    #1. Obtengo la relación de beneficiarios del Subproyecto
    public static function getData($entidad)
    {
        return DB::select("SELECT * FROM vw_data_beneficiarios WHERE codEntidad = $entidad");
    }
}
