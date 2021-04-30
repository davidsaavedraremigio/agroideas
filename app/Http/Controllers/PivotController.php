<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Expediente;
use App\Capacitacion;
use DB;

class PivotController extends Controller
{
    #1. Valido el login para poder trabajar con el controllador
    public function __construct()
    {
        $this->middleware('auth');
    }

    #2. Redirecciono al menu principal
    public function index_sda_aprobado()
    {
    	return view('proceso-pdn.pivot-pdn.index');
    }

    #3. 
    public function data_sda_aprobado()
    {
    	#1. Obtengo la relación de proyectos
        $incentivos     =   DB::select("SELECT * FROM vw_data_incentivo a WHERE a.codTipoIncentivo NOT IN (2)");
        $data           =   [];
        foreach ($incentivos as $fila)
        {
            $data[]     =   [
                'tipo_incentivo'            =>  $fila->tipo,
                'ruc'                       =>  $fila->ruc,
                'razon_social'              =>  $fila->razon_social,
                'tipo_entidad'              =>  $fila->tipo_entidad,
                'titulo'                    =>  $fila->tituloProyecto,
                'nro_convenio'              =>  $fila->nro_contrato,
                'fecha_convenio'            =>  $fila->fecha_contrato,
                'duracion'                  =>  $fila->duracion,
                'inicio'                    =>  $fila->fecha_inicio,
                'termino'                   =>  $fila->fecha_termino,
                'region'                    =>  $fila->region,
                'provincia'                 =>  $fila->provincia,
                'distrito'                  =>  $fila->distrito,
                'direccion'                 =>  $fila->direccion,
                'cadena_productiva'         =>  $fila->cadena,
                'productores'               =>  $fila->nro_beneficiarios,
                'productores_varones'       =>  $fila->nro_beneficiarios_varones,
                'productores_mujeres'       =>  $fila->nro_beneficiarios_mujeres,
                'inversion_pcc'             =>  $fila->inversion_pcc,
                'inversion_entidad'         =>  $fila->inversion_entidad,
                'inversion_total'           =>  $fila->inversion_total,
                'desembolso_pcc'            =>  $fila->ejecucion_pcc,
                'saldo_por_desembolsar_pcc' =>  $fila->saldo_pcc,
                'estado'                    =>  $fila->estado
            ];
        }
        #3. Retorno un array con la información
        return response()->json($data);
    }

    #4. Genero un reporte para los proyectos que contienen información de resoluciones ministeriales
    public function index_upfp_aprobado_rm()
    {
        return view('proceso-prp.consolidado.consolidado-rm.index');
    }
    public function data_upfp_aprobado_rm()
    {
        #1. Obtengo la información de proyectos
        $info   =   Expediente::getDataExpedienteRm();
        $data   =   [];
        foreach ($info as $fila)
        {
            $data[]     =   [
                'fecha expediente'          =>  $fila->fecha_ingreso,
                'nro cut'                   =>  $fila->nro_cut,
                'nro expediente'            =>  $fila->nro_expediente,
                'ruc'                       =>  $fila->ruc,
                'razon social'              =>  $fila->razon_social,
                'region'                    =>  $fila->region,
                'provincia'                 =>  $fila->provincia,
                'distrito'                  =>  $fila->distrito,
                'cultivo a reconvertir'     =>  $fila->cultivo_inicial,
                'cultivo a instalar'        =>  $fila->cadena,
                'nro ha'                    =>  $fila->nro_ha,
                'nro beneficiarios'         =>  $fila->nro_beneficiarios,
                'nro resolucion'            =>  $fila->nro_resolucion,
                'fecha'                     =>  $fila->fecha_resolucion,
                'inversion total'           =>  $fila->inversion_total,
                'inversion pcc'             =>  $fila->inversion_pcc,
                'inversion entidad'         =>  $fila->inversion_entidad,
                'porcentaje pcc'            =>  $fila->pp_inversion_pcc,
                'porcentaje entidad'        =>  $fila->pp_inversion_entidad,
            ];
        }
        #2. Retorno un array con la información
        return response()->json($data);
    }

    #5. Genero un reporte para los proyectos que resultaron aprobados
    public function index_upfp_formulado()
    {
        return view('proceso-prp.consolidado.consolidado-aprobado.index');
    }
    public function data_upfp_formulado()
    {
        #1. Obtengo la información de proyectos
        $info   =   Expediente::getDataExpedienteAprobado();
        $data   =   [];
        foreach ($info as $fila)
        {
            $data[]     =   [
                'fecha expediente'          =>  $fila->fecha_ingreso,
                'nro cut'                   =>  $fila->nro_cut,
                'nro expediente'            =>  $fila->nro_expediente,
                'ruc'                       =>  $fila->ruc,
                'razon social'              =>  $fila->razon_social,
                'region'                    =>  $fila->region,
                'provincia'                 =>  $fila->provincia,
                'distrito'                  =>  $fila->distrito,
                'cultivo a reconvertir'     =>  $fila->cultivo_inicial,
                'cultivo a instalar'        =>  $fila->cadena,
                'nro ha'                    =>  $fila->nro_ha,
                'nro beneficiarios'         =>  $fila->nro_beneficiarios,
                'area'                      =>  $fila->area,
                'inversion total'           =>  $fila->inversion_total,
                'inversion pcc'             =>  $fila->inversion_pcc,
                'inversion entidad'         =>  $fila->inversion_entidad,
                'porcentaje pcc'            =>  $fila->pp_inversion_pcc,
                'porcentaje entidad'        =>  $fila->pp_inversion_entidad,
            ];
        }
        #2. Retorno un array con la información
        return response()->json($data);
    }

    #6. Genero un  reporte para los proyectos que estan en proceso de formulacion
    public function index_upfp_formulacion()
    {
        return view('proceso-prp.consolidado.consolidado-prpa.index');
    }
    public function data_upfp_formulacion()
    {
        #1. Obtengo la información de proyectos
        $info   =   Expediente::getDataExpedienteFormulado();
        $data   =   [];
        foreach ($info as $fila)
        {
            $data[]     =   [
                'fecha expediente'          =>  $fila->fecha_ingreso,
                'nro cut'                   =>  $fila->nro_cut,
                'nro expediente'            =>  $fila->nro_expediente,
                'ruc'                       =>  $fila->ruc,
                'razon social'              =>  $fila->razon_social,
                'region'                    =>  $fila->region,
                'provincia'                 =>  $fila->provincia,
                'distrito'                  =>  $fila->distrito,
                'cultivo a reconvertir'     =>  $fila->cultivo_inicial,
                'cultivo a instalar'        =>  $fila->cadena,
                'nro ha'                    =>  $fila->nro_ha,
                'nro beneficiarios'         =>  $fila->nro_beneficiarios,
                'area'                      =>  $fila->area,
                'inversion total'           =>  $fila->inversion_total,
                'inversion pcc'             =>  $fila->inversion_pcc,
                'inversion entidad'         =>  $fila->inversion_entidad,
                'porcentaje pcc'            =>  $fila->pp_inversion_pcc,
                'porcentaje entidad'        =>  $fila->pp_inversion_entidad,
            ];
        }
        #2. Retorno un array con la información
        return response()->json($data);
    }

    #7. Obtengo un reporte para los proyectos prp que se encuentran en cartera
    public function index_upfp_cartera()
    {
        return view('proceso-prp.consolidado.consolidado-ur.index');
    }
    public function data_upfp_cartera()
    {
        #1. Obtengo la información de proyectos
        $info   =   Expediente::getDataExpedienteUr();
        $data   =   [];
        foreach ($info as $fila)
        {
            $data[]     =   [
                'fecha ingreso'                             =>  $fila->fecha_ingreso,
                'nro cut'                                   =>  $fila->nro_cut,
                'nro expediente'                            =>  $fila->nro_expediente,
                'ruc'                                       =>  $fila->ruc,
                'razon social'                              =>  $fila->razon_social,
                'region'                                    =>  $fila->region,
                'provincia'                                 =>  $fila->provincia,
                'distrito'                                  =>  $fila->distrito,
                'cultivo a reconvertir'                     =>  $fila->cultivo_inicial,
                'cultivo a instalar'                        =>  $fila->cadena,
                'ubicacion expediente'                      =>  $fila->oficina,
                'especialista asignado'                     =>  '-',
                'fecha solicitud evaluacion geoespacial'    =>  $fila->fecha_solicitud_geo,
                'fecha informe evaluacion geoespacial'      =>  $fila->fecha_informe_geo,
                'nro de informe de observaciones'           =>  $fila->nro_informe_doc_observa,
                'fecha de informe de observaciones'         =>  $fila->fecha_informe_doc_observa,
                'fecha de envio de carta'                   =>  $fila->fecha_carta_observa,
                'fecha de levantamiento de observaciones'   =>  $fila->fecha_levanta_observacion,
                'nro ha'                                    =>  $fila->nro_ha,
                'nro productores'                           =>  $fila->nro_beneficiarios,
                'inversion pcc'                             =>  $fila->inversion_pcc
            ];
        }
        #2. Retorno un array con la información
        return response()->json($data);
    }

    #8. Obtengo un reporte para mostrar el formato requerido por SERVIAGRO
    public function index_serviagro()
    {
        return view('iniciativa.pivot-capacitacion.index');
    }
    public function data_serviagro()
    {
        #1. Obtengo la información solicitada
        $info       =   Capacitacion::getDataServiagro();
        $data       =   [];
        foreach ($info as $fila) 
        {
            $data[]     =   [
                'Region'                            =>  $fila->sede,
                'DNI'                               =>  $fila->dni,
                'Beneficiado - Apellidos'           =>  $fila->apellidos,
                'Beneficiado - Nombres'             =>  $fila->nombres,
                'Sexo'                              =>  $fila->sexo,
                'Edad'                              =>  $fila->edad,
                'Actividad del productor'           =>  $fila->actividad_productor,
                'Principal cultivo agricola'        =>  $fila->cadena_agricola,
                'Principal crianza'                 =>  $fila->cadena_pecuaria,
                'Principal plantacion forestal'     =>  $fila->cadena_forestal,
                'Actividad del participante'        =>  $fila->actividad_participante,
                'Detalle del tipo de participante'  =>  $fila->detallaOtraActividad,
                'Pertenece a alguna organizacion'   =>  $fila->miembro,
                'Tipo de organizacion'              =>  $fila->tipo_entidad,
                'Nombre de la organizacion'         =>  $fila->razon_social,
                'Ubigeo'                            =>  $fila->sede_ubigeo,
                'Departamento'                      =>  $fila->sede,
                'Provincia'                         =>  $fila->sede_provincia,
                'Distrito'                          =>  $fila->sede_distrito,
                'Sector'                            =>  $fila->direccion,
                'Tematica'                          =>  $fila->tematica,
                'Nombre del evento'                 =>  $fila->nombre,
                'Horas de capacitacion'             =>  $fila->horas,
                'Tipo de evento'                    =>  $fila->tipo_evento,
                'Fecha'                             =>  $fila->fecha,
                'Periodo del evento'                =>  $fila->periodo.'-'.$fila->cuatrimestre,
                'Fuente de financiamiento'          =>  $fila->financiamiento,
                'Categoria presupuestal'            =>  $fila->categoria,
                'Programa presupuestal'             =>  $fila->programa_presupuestal,
                'Responsable'                       =>  $fila->responsable,
            ];
        }
        #2. Retorno un array con la información
        return response()->json($data);
    }
}
