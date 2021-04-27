<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DerivaExpedienteUnFormRequest extends FormRequest
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
            'nro_informe'       =>  'required|integer',
            'nro_memo'          =>  'required|integer',
            'fecha_informe'     =>  'required|date',
            'fecha_derivacion'  =>  'required|date',
            'especialista'      =>  'required',
        ];
    }
}
