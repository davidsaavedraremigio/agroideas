<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostulanteProductorFormRequest extends FormRequest
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
            'nro_documento'     =>  'required|digits:8',
            'fecha'             =>  'required|date',
            'sexo'              =>  'required',
            'nombres'           =>  'required|max:50',
            'paterno'           =>  'required|max:50',
            'materno'           =>  'required|max:50',
            'direccion'         =>  'required|max:600',
            'tipo_propietario'  =>  'required',
            'nro_ha_solicitada' =>  'numeric|required',
            'nro_ha'            =>  'numeric|required',
        ];
    }
}
