<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductorPrpaFormRequest extends FormRequest
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
            'dni'           =>  'required|digits:8',
            'nombres'       =>  'required|max:255',
            'paterno'       =>  'required|max:255',
            'materno'       =>  'required|max:255',
            'sexo'          =>  'required',
            'fecha'         =>  'required|date',
            'direccion'     =>  'required|max:600',
            'tipo'          =>  'required',
            'latitud'       =>  'nullable|max:255',
            'longitud'      =>  'nullable|max:255',
            'altitud'       =>  'nullable|integer',
            'nro_ha_total'  =>  'nullable|integer',
            'nro_ha'        =>  'required|numeric',
            'importe'       =>  'required|numeric',
        ];
    }
}
