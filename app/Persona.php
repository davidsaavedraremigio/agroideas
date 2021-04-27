<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Persona extends Model
{
    protected 	$table 			=	'Persona';
    protected	$primaryKey		=	'dni';
    public 		$incrementing   =   false;
    protected 	$keyType        =   'string';

    protected   $fillable       =   ['dni', 'nombres', 'paterno', 'materno', 'fechaNacimiento', 'sexo', 'direccion', 'validado_reniec', 'created_auth', 'updated_auth'];
    protected 	$guarded        =   [];
    public $timestamps          =   false; 

    #2. Obtengo el numero de ruc a partir del numero de DNI
    public static function getNumeroRuc($dni)
    {
        $ruc = null;

        if (!empty($dni)) 
        {
            if (strlen($dni) == 8)
            {
                #1. Desagrego el Nro de DNI en partes
                $a  = substr($dni, 0, 1);
                $b  = substr($dni, 1, 1);
                $c  = substr($dni, 2, 1);
                $d  = substr($dni, 3, 1);
                $e  = substr($dni, 4, 1);
                $f  = substr($dni, 5, 1);
                $g  = substr($dni, 6, 1);
                $h  = substr($dni, 7, 1);

                #2. Multiplico cada digito con una cadena
                $aa = 3*$a;
                $ba = 2*$b;
                $ca = 7*$c;
                $da = 6*$d;
                $ea = 5*$e;
                $fa = 4*$f;
                $ga = 3*$g;
                $ha = 2*$h;

                #3. Sumo el resultado de la multiplicacion
                $suma = $aa+$ba+$ca+$da+$ea+$fa+$ga+$ha;

                #4. Obtengo el residuo de la suma
                $residuo = 11 - ($suma%11);

                #5. Obtengo el identificador
                $identificador = substr(678901123456, $residuo, 1);

                #6. Obtengo el N° de RUC
                $ruc = "10".$dni."".$identificador;

                return $ruc;
            } 
        }
    }
}
