<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormDerivaExpedienteFormRequest extends FormRequest
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
            'especialista'          =>  'required',
            'nro_informe'           =>  'required|integer',
            'fecha_informe'         =>  'required|date',
            'nro_memo'              =>  'required|integer',
            'fecha_memo'            =>  'required|date',
            'fecha_derivacion'      =>  'nullable|date',
        ];
    }
}
