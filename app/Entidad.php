<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Entidad extends Model
{
    protected 	$table 			=	'Entidad';
    protected	$primaryKey	    =	'id';
    protected   $fillable       =   ['codTipoDocumento', 'nroDocumento', 'codTipoEntidad', 'nombre', 'ubigeo', 'direccion', 'condicionDomicilio', 'estadoContribuyente', 'fechaRRPP', 'estado', 'created_auth', 'updated_auth'];
    protected 	$guarded        =   [];
    public $timestamps          =   false; 

    #1. Obtengo la lista de organizaciones
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_opa");
    }
}
