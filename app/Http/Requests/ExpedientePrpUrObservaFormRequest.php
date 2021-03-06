<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedientePrpUrObservaFormRequest extends FormRequest
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
            'responsable'       =>  'required',
            'nro_informe'       =>  'required|max:50',
            'fecha_informe'     =>  'required|date',
            'nro_carta'         =>  'required',
            'fecha_carta'       =>  'date|required',
        ];
    }
}
