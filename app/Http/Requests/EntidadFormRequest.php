<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntidadFormRequest extends FormRequest
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
            'nro_documento'         =>  'required:max:50',
            'tipo_entidad'          =>  'required',
            'nombre'                =>  'required|max:600',
            'ubigeo'                =>  'required:digits:6',
            'direccion'             =>  'required|max:600',
            'estado_domicilio'      =>  'required|max:100',
            'estado_contribuyente'  =>  'required|max:100',
            'fecha_rrpp'            =>  'date',
        ];
    }
}
