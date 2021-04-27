<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MLIndicadorFormRequest extends FormRequest
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
            'codigo'                =>  'required',
            'nro_orden'             =>  'required',
            'descripcion'           =>  'required|max:900',
            'unidad'                =>  'required',
            'componente'            =>  'required',
            'medio_verificacion'    =>  'max:900',
            'supuestos'             =>  'max:900',
            'frecuencia'            =>  'max:900',
            'formula'               =>  'max:4000',
        ];
    }
}
