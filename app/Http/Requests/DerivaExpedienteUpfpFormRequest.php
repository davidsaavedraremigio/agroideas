<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DerivaExpedienteUpfpFormRequest extends FormRequest
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
            'especialista'  =>  'required',
            'nro_informe'   =>  'required|digits_between:1,9999',
            'fecha'         =>  'required|date',
        ];
    }
}
