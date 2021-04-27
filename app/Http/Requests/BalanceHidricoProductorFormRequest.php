<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceHidricoProductorFormRequest extends FormRequest
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
            'nro_ha_solicitada'     =>  'required|numeric',
            'nro_ha'                =>  'required|numeric',
            'resultado_suelo'       =>  'required',
            'resultado_agua'        =>  'required',
            'resultado_hidrico'     =>  'required',
            'comentario'            =>  'max:1000',
        ];
    }
}
