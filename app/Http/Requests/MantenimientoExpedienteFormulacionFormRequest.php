<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MantenimientoExpedienteFormulacionFormRequest extends FormRequest
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
            'especialista_formulacion'  =>  'nullable',
            'nro_informe_form'          =>  'nullable|digits_between:1,4',
            'fecha_informe_form'        =>  'nullable|date',
            'nro_memo'                  =>  'nullable',
            'fecha_memo'                =>  'nullable|date',
        ];
    }
}
