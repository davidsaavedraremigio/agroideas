<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoPrpaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo'            =>  'required|max:600',
            'inicio'            =>  'required|date',
            'duracion'          =>  'required|integer',
            'cultivo_inicial'   =>  'required',
            'cadena'            =>  'required',
            'tipo_produccion'   =>  'required',
            'nro_ha'            =>  'required|numeric',
            'prod_total'        =>  'required|numeric',
            'prod_hombre'       =>  'required|numeric',
            'prod_mujer'        =>  'required|numeric',
            'aporte_pcc'        =>  'required|numeric',
            'aporte_entidad'    =>  'required|numeric',
            'aporte_total'      =>  'required|numeric',      
        ];
    }
}
