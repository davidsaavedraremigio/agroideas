<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluacionCampoProductorFormRequest extends FormRequest
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
            'nro_ha_solicitada'     =>  'required|numeric',
            'nro_ha'                =>  'required|numeric',
            'nro_ha_plano'          =>  'required|numeric',
            'nro_ha_geo'            =>  'required|numeric',
            'nro_ha_riego'          =>  'required|numeric',
            'resultado_final'       =>  'required',
            'comentario'            =>  'max:1000',
        ];
    }
}
