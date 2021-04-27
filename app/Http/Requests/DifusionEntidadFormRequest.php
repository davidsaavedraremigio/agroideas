<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DifusionEntidadFormRequest extends FormRequest
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
            'ruc'               =>  'nullable|digits:11',
            'razon_social'      =>  'required|max:255',
            'tipo_entidad'      =>  'required',
            'distrito'          =>  'required|digits:6',
            'direccion'         =>  'max:600',
            'nombre_contacto'   =>  'required|max:600',
            'cargo'             =>  'required|max:600',
            'telefono'          =>  'nullable|max:50',
            'email'             =>  'nullable|max:100',
        ];
    }
}
