<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicadorResultadoFormRequest extends FormRequest
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
            'tipo'                  =>  'required',
            'unidad'                =>  'required',
            'descripcion'           =>  'required|max:300',
            'supuestos'             =>  'max:600',
            'medio_verificacion'    =>  'max:600',
            'metodo_calculo'        =>  'max:600',
        ];
    }
}
