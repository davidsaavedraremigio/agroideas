<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InicPRPFormRequest extends FormRequest
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
            'tipo_entidad'          =>  'required',
            'nombre'                =>  'required|max:600',
            'ubigeo'                =>  'required|max:6',
            'direccion'             =>  'required|max:600',
            'cultivo'               =>  'required|max:300',
            'cadena'                =>  'required',
            'hectareas_sp'          =>  'required',
            'productores_total'     =>  'numeric|required',
        ];
    }
}
