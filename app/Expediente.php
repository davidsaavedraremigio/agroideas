<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Expediente extends Model
{
    #1. Obtenemos el numero de expediente
    protected 	$table 			=	'InicExpedientePostulante';
    public $timestamps          =   false; # Se habilita nuevamente el bloqueo de control de cambios

    #2. Obtengo la información de los expediente de acuerdo al área origen y el tipo de incentivo
    public static function getData($area, $incentivo)
    {
        return DB::select("SELECT * 
        FROM vw_data_expediente a
        WHERE a.codTipoIncentivo = $incentivo AND a.cod_area = $area");
    }

    #3. Obtengo el historial de seguimiento del documento
    public static function getDataMonitoreo($id)
    {
        return DB::select("SELECT * FROM vw_data_expediente_monitoreo a WHERE a.cod_expediente = $id");
    }

    #3. Obtengo la información de los expedientes que han sido admitidos
    public static function getDataExpedienteAdmitido()
    {
        return DB::select("SELECT
            a.id,
            LTRIM(RIGHT('0000' + CAST(a.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaExpediente)) nro_expediente,
            LTRIM(RIGHT('0000' + CAST(a.nroCut AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaCut)) nro_cut,
            a.fechaCut fecha_presentacion,
            d.nroDocumento,
            d.nombre,
            e.cadena,
            d.region,
            d.provincia,
            d.distrito,
            b.descripcion oficina,
            c.nombres+' '+c.paterno+' '+c.materno responsable
        FROM InicExpedientePostulante a
        LEFT JOIN (
            SELECT * FROM MaestroOficina
        ) b ON b.id = a.codOficina
        LEFT JOIN (
            SELECT * FROM MaestroStaff
        ) c ON c.id = a.codPersonalAsignado
        LEFT JOIN (
            SELECT * FROM vw_data_opa
        ) d ON d.id = a.codPostulante
        LEFT JOIN (
            SELECT
                a.codPostulante,
                b.descripcion cadena
            FROM InicProductoEspecifico a
            LEFT JOIN (
                SELECT * FROM MaestroProductoCadena
            ) b ON b.id = a.codCadena
            WHERE a.principal = 1
        ) e ON e.codPostulante = a.codPostulante
        WHERE a.codArea IN (6, 8) AND a.codEstado = 1");
    }

    #4. Obtengo la lista de expedientes disponibles para formulacion
    public static function getDataExpedienteFormulacion()
    {
        return DB::select("SELECT
            a.id,
            LTRIM(RIGHT('0000' + CAST(a.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaExpediente)) nro_expediente,
            LTRIM(RIGHT('0000' + CAST(a.nroCut AS varchar(4)), 4))+'-'+LTRIM(YEAR(a.fechaCut)) nro_cut,
            b.ruc,
            b.razon_social,
            b.region,
            b.provincia,
            b.distrito,
            b.tituloProyecto,
            b.cadena,
            d.HabilitaFormulacion, 
            c.nombres+' '+c.paterno+' '+c.materno responsable
        FROM InicExpedientePostulante a
        LEFT JOIN (
            SELECT * FROM vw_data_incentivo
        ) b ON b.id = a.codPostulante
        LEFT JOIN (
            SELECT * FROM MaestroStaff
        ) c ON c.id = a.codPersonalAsignado
        LEFT JOIN (
            SELECT * FROM InicExpedienteUpfp
        ) d ON d.codExpediente = a.id
        WHERE d.HabilitaFormulacion = 1");
    }

    #5. Obtengo la relación de expedientes con Resolución Ministerial
    public static function getDataExpedienteRm()
    {
        return DB::select("SELECT
            b.fechaExpediente fecha_ingreso,
            LTRIM(RIGHT('0000' + CAST(b.nroCut AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaCut)) nro_cut,
            LTRIM(RIGHT('0000' + CAST(b.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaExpediente))+'-PRP' nro_expediente,
            a.ruc,
            a.razon_social,
            a.region,
            a.provincia,
            a.distrito,
            c.descripcion cultivo_inicial,
            a.cadena,
            a.nro_ha,
            a.nro_beneficiarios,
            a.nro_resolucion,
            a.fecha_resolucion,
            a.inversion_total,
            a.inversion_pcc,
            ROUND(a.inversion_pcc/a.inversion_total * 100,0) pp_inversion_pcc,
            a.inversion_entidad,
            ROUND(a.inversion_entidad/a.inversion_total * 100,0) pp_inversion_entidad
        FROM vw_data_incentivo a 
        LEFT JOIN (
            SELECT * FROM InicExpedientePostulante a
        ) b ON b.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM InicCultivoInicial
        ) c ON c.codPostulante = a.id
        WHERE 
        a.codTipoIncentivo = 2
        AND a.nro_resolucion IS NOT NULL");
    }

    #6. Obtengo la relación de expedientes aprobados
    public static function getDataExpedienteAprobado()
    {
        return DB::select("SELECT
            b.fechaExpediente fecha_ingreso,
            LTRIM(RIGHT('0000' + CAST(b.nroCut AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaCut)) nro_cut,
            LTRIM(RIGHT('0000' + CAST(b.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaExpediente))+'-PRP' nro_expediente,
            a.ruc,
            a.razon_social,
            a.region,
            a.provincia,
            a.distrito,
            c.descripcion cultivo_inicial,
            a.cadena,
            a.nro_ha,
            a.nro_beneficiarios,
            a.nro_resolucion,
            a.fecha_resolucion,
            d.sigla area,
            a.inversion_total,
            a.inversion_pcc,
            ROUND(a.inversion_pcc/a.inversion_total * 100,0) pp_inversion_pcc,
            a.inversion_entidad,
            ROUND(a.inversion_entidad/a.inversion_total * 100,0) pp_inversion_entidad
        FROM vw_data_incentivo a 
        LEFT JOIN (
            SELECT * FROM InicExpedientePostulante a
        ) b ON b.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM InicCultivoInicial
        ) c ON c.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM MaestroArea a
        ) d ON d.id = b.codArea
        WHERE 
        a.codTipoIncentivo = 2
        AND a.cod_estado in (12,13,14,15)");
    }

    #7. Obtengo la relación de expeduentes en UPFP
    public static function getDataExpedienteFormulado()
    {
        return DB::select("SELECT
            b.fechaExpediente fecha_ingreso,
            LTRIM(RIGHT('0000' + CAST(b.nroCut AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaCut)) nro_cut,
            LTRIM(RIGHT('0000' + CAST(b.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaExpediente))+'-PRP' nro_expediente,
            a.ruc,
            a.razon_social,
            a.region,
            a.provincia,
            a.distrito,
            c.descripcion cultivo_inicial,
            a.cadena,
            a.nro_ha,
            a.nro_beneficiarios,
            a.nro_resolucion,
            a.fecha_resolucion,
            d.sigla area,
            a.inversion_total,
            a.inversion_pcc,
            ROUND(a.inversion_pcc/a.inversion_total * 100,0) pp_inversion_pcc,
            a.inversion_entidad,
            ROUND(a.inversion_entidad/a.inversion_total * 100,0) pp_inversion_entidad
        FROM vw_data_incentivo a 
        LEFT JOIN (
            SELECT * FROM InicExpedientePostulante a
        ) b ON b.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM InicCultivoInicial
        ) c ON c.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM MaestroArea a
        ) d ON d.id = b.codArea
        WHERE 
        a.codTipoIncentivo = 2
        AND a.cod_estado in (12)");
    }

    #8. Obtengo la relación de expedientes asignados a las UR
    public static function getDataExpedienteUr()
    {
        return DB::select("SELECT
            b.fechaExpediente fecha_ingreso,
            LTRIM(RIGHT('0000' + CAST(b.nroCut AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaCut)) nro_cut,
            LTRIM(RIGHT('0000' + CAST(b.nroExpediente AS varchar(4)), 4))+'-'+LTRIM(YEAR(b.fechaExpediente))+'-PRP' nro_expediente,
            a.ruc,
            a.razon_social,
            a.region,
            a.provincia,
            a.distrito,
            c.descripcion cultivo_inicial,
            a.cadena,
            e.fecha_solicitud_geo,
            e.fecha_informe_geo,
            e.nro_informe_doc,
            e.fecha_informe_doc,
            e.nro_informe_doc_observa,
            e.fecha_informe_doc_observa,
            e.fecha_carta_observa,
            e.fecha_levanta_observacion,
            e.nro_carta_improcedente,
            e.fecha_carta_improcedente,
            e.nro_carta_archivo,
            e.fecha_carta_archivo,
            a.nro_ha,
            a.inversion_pcc,
            a.nro_beneficiarios,
            f.descripcion oficina,
            d.sigla area
        FROM vw_data_incentivo a 
        LEFT JOIN (
            SELECT * FROM InicExpedientePostulante a
        ) b ON b.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM InicCultivoInicial
        ) c ON c.codPostulante = a.id
        LEFT JOIN (
            SELECT * FROM MaestroArea a
        ) d ON d.id = b.codArea
        LEFT JOIN (
            SELECT * FROM InicExpedienteUr
        ) e ON e.codExpediente = b.id
        LEFT JOIN (
            SELECT
                x.id,
                x.descripcion
            FROM MaestroOficina x
        ) f ON f.id = b.codOficina
        WHERE 
        a.codTipoIncentivo = 2
        AND a.cod_estado in (0, 9, 10)");
    }

    #10. Obtengo la relación de expedientes de Incentivos de apoyo registrados
    public static function getDataExpedienteSda()
    {
        return DB::select("SELECT * FROM vw_data_expediente a WHERE a.codTipoIncentivo NOT IN (2)");
    }

    #11. Obtengo la relación de expedientes de SDA que se encuentran en la UR en estado pendiente
    public static function getDataUbicacionExpedienteSda($area, $estado)
    {
        return DB::select("SELECT * FROM vw_data_expediente_iniciativa a WHERE a.codTipoIncentivo NOT IN (2) AND a.codArea = $area AND a.codEstado = $estado");
    }

    #12. Obtengo la relación de expediente de SDA de acuerdo al proceso en el que se encuentran
    public static function getDataProcesoExpedienteSda($area, $estado)
    {
        return DB::select("SELECT * FROM vw_data_expediente_iniciativa_resumen a WHERE a.codTipoIncentivo NOT IN (2) AND a.cod_area = $area AND a.cod_estado_proceso = $estado");
    }
}
