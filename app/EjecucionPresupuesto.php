<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class EjecucionPresupuesto extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicEjecPresupuesto';
    public $timestamps          =   false; 

    #2. Obtengo la relación de Desembolsos por Proyecto
    public static function getData($id)
    {
        return EjecucionPresupuesto::where([['codPostulante','=',$id], ['importe', '>', '0']])->orderBy('fechaDesembolso', 'ASC')->get();
    }

    #3. Obtengo la relación de desembolsos de SDA
    public static function getAll()
    {
        return DB::select("SELECT
            a.id,
            a.codPostulante,
            b.nro_contrato,
            b.ruc,
            b.razon_social,
            b.tituloProyecto,
            dbo.fnObtieneMes(a.mes) mes,
            a.periodo,
            a.importe
        FROM InicEjecPresupuesto a
        LEFT JOIN (
            SELECT * FROM vw_data_incentivo
        ) b ON b.id = a.codPostulante
        WHERE b.codTipoIncentivo NOT IN (2)
        ORDER BY a.periodo DESC, a.mes DESC");
    }

    #4. Obtengo el monto total ejecutado por proyecto
    public static function getEjecucion($id)
    {
        $consulta   =       db::select("SELECT Sum(a.importe) total
                            FROM InicEjecPresupuesto a WHERE a.codPostulante = $id");
        return $consulta[0];
    }

    #5. Realizo la consistencia y procesamiento de la importacion de archivos
    public static function procesaImportacionDesembolsoSda()
    {
        return DB::statement('EXEC procProcesaImportacionDesembolso');
    }


}
