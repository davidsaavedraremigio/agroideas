<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InicSdaFormRequest extends FormRequest
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
            'ruc'                           =>  'required|digits:11',
            'tipo_entidad'                  =>  'required',
            'nombre'                        =>  'required|max:600',
            'ubigeo'                        =>  'required|digits:6',
            'direccion'                     =>  'required|max:600',
            'cadena'                        =>  'required',
            'nro_ha_total'                  =>  'required|numeric',
            'nro_ha'                        =>  'required|numeric',
            'productores'                   =>  'required|integer',
            'productores_varones'           =>  'required|integer',
            'productores_mujeres'           =>  'required|integer',
            'tipo'                          =>  'required',
        ];
    }
}
