<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PostulanteProductor extends Model
{
    #1. Asocio el modelo a la tabla en la base de datos
    protected 	$table 			=	'InicProductor';
    public $timestamps          =   false; 

    #2. Obtengo la relación de beneficiarios del proyecto
    public static function getData($id)
    {
        return DB::select("SELECT
            a.id,
            d.dni,
            d.nombres,
            d.paterno,
            d.materno,
            d.fechaNacimiento,
            b.descripcion cadena,
            a.nroHas,
            a.nroHasProyecto,
            c.nombre estado
        FROM InicProductor a
        LEFT JOIN (
            SELECT * FROM MaestroProductoCadena
        ) b ON b.id = a.codCadenaProductiva
        LEFT JOIN (
            SELECT * FROM vw_data_tablas x WHERE x.tabla = 'EstadoSituacionalBeneficiario'
        ) c ON c.orden = a.codEstado
        INNER JOIN (
            SELECT
                a.id,
                b.dni,
                b.nombres,
                b.paterno,
                b.materno,
                b.fechaNacimiento
            FROM PersonaEntidad a
            LEFT JOIN (
                SELECT * FROM Persona 
            ) b ON b.dni = a.dniPersona
        ) d ON d.id = a.codPersonaEntidad
        WHERE a.codPostulante = $id");
    }

    #3. Obtengo el numero de hectareas a reconvertir de un PRPA
    public static function getAreaReconvertida($codPostulante)
    {
        $query  =   DB::select("SELECT dbo.CalculateAreaReconvertida($codPostulante) area");
        $area   =   $query[0]->area;
        return $area;
    }

    #4. Obtengo el número total de productores
    public static function getNroBeneficiarios($codPostulante)
    {
        $query          =   DB::select("SELECT dbo.CalculateNroBeneficiarios($codPostulante) beneficiarios");
        $beneficiarios  =   $query[0]->beneficiarios;
        return $beneficiarios;   
    }
}
