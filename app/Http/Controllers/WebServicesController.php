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
                $url        =   'http://200.48.54.126/ApiPide/api/reniec/dni2/'.$dni;
                $respuesta  =   file_get_contents($url);
                $array      =   json_decode($respuesta);
                $estado     =   $array->operationCode;
                $ruc        =   Persona::getNumeroRuc($dni);
                
                #1. Verificamos el estado del Proveedor
                if ($estado == 200) 
                {
                    $data = array(
                        'estado'    =>  $estado,
                        'dato'      =>  'La consulta del documento fue exitosa',
                        'dni'       =>  $dni,
                        'nombre'    =>  $array->data->nombres,
                        'paterno'   =>  $array->data->apellidoPaterno,
                        'materno'   =>  $array->data->apellidoMaterno,
                        'direccion' =>  $array->data->direccion,
                        'foto'      =>  $array->data->foto,
                        'ruc'       =>  $ruc,
                        'bloqueo'   =>  'readonly',
                    );
                } 
                else 
                {
                    $data = array(
                        'estado'    =>  $estado,
                        'dato'      =>  'Se presentó un error al consultar el DNI',
                        'dni'       =>  '',
                        'nombre'    =>  '',
                        'paterno'   =>  '',
                        'materno'   =>  '',
                        'direccion' =>  '',
                        'foto'      =>  '',
                        'ruc'       =>  '',
                        'bloqueo'   =>  '',
                    );
                }
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
            $url        =   'http://192.190.42.128/apisunat/api/consultarruc/'.$ruc;
            $respuesta  =   file_get_contents($url);
            $array      =   json_decode($respuesta);
            $variables  =   array('"', "'"); #Nos permitirá guardar la información sin comillas simples

            $data = array(
                'estado'    =>  '1',
                'dato'      =>  trim(addslashes(str_replace($variables, "", $array->razonSocial))),
                'tipo'      =>  trim(addslashes(str_replace($variables, "", $array->tipoContribuyente))),
                'direccion' =>  trim(addslashes(str_replace($variables, "", $array->domicilioLegal))),
                'telefono'  =>  trim($array->telefono1),
                'ubigeo'    =>  trim($array->ubicacionGeografica),
                'regimen'   =>  trim($array->tipoPersona),
                'sigla'     =>  trim($array->nombreComercial),
                'domicilio' =>  trim($array->condicionDomicilio),
                'situacion' =>  trim($array->estadoContribuyente),
                'fecha'     =>  substr($array->fechaAlta, 6, 4)."-".substr($array->fechaAlta, 3, 2)."-".substr($array->fechaAlta, 0, 2),
                'codigo'    =>  trim($array->codigoTipoContribuyente),
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
