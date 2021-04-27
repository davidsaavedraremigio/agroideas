<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResolucionMinisterialFormRequest extends FormRequest
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
            'nro_resolucion'        =>  'required|digits_between:1,9999',
            'fecha'                 =>  'required|date',
            'aporte_pcc'            =>  'required|numeric',
            'aporte_entidad'        =>  'required|numeric',
            'aporte_total'          =>  'required|numeric',
        ];
    }
}
