<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DerivaExpedienteUajFormRequest extends FormRequest
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
            'nro_informe'       =>  'required|integer',
            'fecha_informe'     =>  'required|date',
            'nro_oficio'        =>  'nullable|digits_between:1,9999',
            'fecha_oficio'      =>  'nullable|date',
        ];
    }
}
