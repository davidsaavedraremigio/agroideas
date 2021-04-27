<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DerivaExpedienteFormRequest extends FormRequest
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
            'fecha_derivacion'      =>  'date|required',
            'nro_informe_tec'       =>  'required|between:1,9999',
            'fecha_informe_tec'     =>  'required|date',
        ];
    }
}
