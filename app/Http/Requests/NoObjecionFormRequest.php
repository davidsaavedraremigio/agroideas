<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoObjecionFormRequest extends FormRequest
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
            'nro_contrato'          =>  'required',
            'numero'                =>  'required|integer',
            'fecha'                 =>  'required|date',
            'nro_carta_solicitud'   =>  'required|digits_between:1,9999',
            'fecha_carta_solicitud' =>  'required|date',
            'justificacion'         =>  'nullable|max:900',
        ];
    }
}
