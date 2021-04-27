<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConsejoDirectivo extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'ConsejoDirectivo';
    public $timestamps          =   false;

    #2. Obtengo la relación de Consejos directivos registrados
    public static function getData()
    {
        return ConsejoDirectivo::orderBy('fecha', 'asc')->get();
    }

    #3. Obtengo la relación de expedientes asignados a un Consejo Directivo
    public static function getExpedientes($id)
    {
        return DB::select("SELECT
            a.id,
            b.tipo_incentivo,
            b.nro_expediente,
            b.ruc,
            b.razon_social,
            b.tituloProyecto,
            b.region,
            b.provincia,
            b.distrito,
            b.cadena,
            a.fecha_derivacion
        FROM InicExpedienteSdaUaj a
        LEFT JOIN (
            SELECT * FROM vw_data_expediente
        ) b ON b.id = a.codExpediente
        WHERE a.cod_consejo_directivo = $id");
    }
}
