<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Persona;
use Auth;

class WebServicesController extends Controller
{
    #1. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #2. Consultamos el N° de DNI con la web de Reniec
    public function getDni($valor)
    {
        $respuesta   =   1;
        if (!empty($valor)) 
        {
            if (strlen($valor) == 8)
            {
                $dni        =   $valor;
                $url        =   'http://selv2.agroideas.gob.pe/PIDE/JsonConsultaReniecPide';
                $post       =   [
                                    'nroDniCon'     =>  $dni,
                                    'nroRucEnt'     =>  '20524605903',
                                    'pwdUsua'       =>  '40914955',
                                    'nroDniUsua'    =>  '40914955'
                                ];
                $ch         =   curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $respuesta  = curl_exec($ch);
                curl_close($ch);
                $array      =   json_decode($respuesta);

                $data = array(
                    'dni'       =>  $dni,
                    'nombre'    =>  $array->prenombres,
                    'paterno'   =>  $array->apPrimer,
                    'materno'   =>  $array->apSegundo,
                    'direccion' =>  $array->direccion,
                    'foto'      =>  $array->foto,
                    'bloqueo'   =>  'readonly',
                );

                return json_encode($data);
            }
        }

    }

    #3. Consultamos el N° de RUC con la web de Sunat
    public function getRuc($valor)
    {
        if (strlen($valor) == 11) 
        {
            $ruc        =   $valor;
            $url        =   'http://selv2.agroideas.gob.pe/PIDE/JsonConsultaSunatDPrinPide?nroRuc='.$ruc;
            $respuesta  =   file_get_contents($url);
            $array      =   json_decode($respuesta);
            $variables  =   array('"', "'"); #Nos permitirá guardar la información sin comillas simples

            $data = array(
                'estado'    =>  '1',
                'nombre'    =>  trim(addslashes(str_replace($variables, "", $array->ddp_nombre))),
                'tipo'      =>  trim(addslashes(str_replace($variables, "", $array->desc_tpoemp))),
                'direccion' =>  trim(addslashes(str_replace($variables, "", $array->ddp_nomvia))),
                'ubigeo'    =>  trim($array->ddp_ubigeo),
                'regimen'   =>  trim($array->desc_identi),
                'habido'    =>  trim($array->desc_flag22),
                'activo'    =>  trim($array->desc_estado),
                'fecha'     =>  substr($array->ddp_fecalt, 6, 4)."-".substr($array->ddp_fecalt, 3, 2)."-".substr($array->ddp_fecalt, 0, 2),
                'codigo'    =>  trim($array->ddp_tpoemp),
            ); 

            #2. Retornamos la información solicitada
            return json_encode($data);
        }
    }

    #4. Obtengo la información de Tipo de cambio
    public function getTc($fecha)
    {
        $fecha              =   $fecha;
        $url                =   'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha='.$fecha;
        $respuesta          =   file_get_contents($url);
        $array              =   json_decode($respuesta);
        $especialCaracter   =   array('"', "'"); #Nos permitirá guardar la información sin comillas simples

        $data = array(
            'origen'        =>  $array->origen,
            'moneda'        =>  $array->moneda,
            'compra'        =>  $array->compra,
            'venta'         =>  $array->venta,
        );

        #3. Retornamos la información solicitada
        return json_encode($data);
    }

    #5. Obtengo la información de acuerdo al RUC consultado
    public function getDataSunat($valor)
    {
        $ruc                =   $valor;
        $url                =   'https://api.apis.net.pe/v1/ruc?numero='.$ruc;
        $respuesta          =   file_get_contents($url);
        $array              =   json_decode($respuesta);
        $especialCaracter   =   array('"', "'"); #Nos permitirá guardar la información sin comillas simples    
        
        #2. Obtengo los valores requeridos
        $data   =   array(
            'estado'        =>  '1',
            'dato'          =>  trim(addslashes(str_replace($especialCaracter, "", $array->nombre))),
            'tipo'          =>  '',
            'direccion'     =>  trim(addslashes(str_replace($especialCaracter, "", $array->direccion))),
            'telefono'      =>  '',
            'ubigeo'        =>  trim($array->ubigeo),
            'regimen'       =>  '',
            'sigla'         =>  '-',
            'domicilio'     =>  trim($array->condicion),
            'situacion'     =>  trim($array->estado),
            'fecha'         =>  date('Y-m-d'),
            'codigo'        =>  '',
        );

        #3. Genero un archivo Json con los resultados de la consulta
        return json_encode($data);
    }
}
