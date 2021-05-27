<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MantenimientoExpedienteUpfpFormRequest extends FormRequest
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
            'especialista_asignado'     =>  'required',
            'fecha_recepcion'           =>  'required|date',
            'especialista_responsable'  =>  'nullable',
            'fecha_campo'               =>  'nullable|date',
            'fecha_suelo'               =>  'nullable|date',
            'fecha_agua'                =>  'nullable|date',
            'fecha_balance_hidrico'     =>  'nullable|date',
            'especialista_tecnico'      =>  'nullable',
            'nro_informe_tecnico'       =>  'nullable|digits_between:1,4',
            'fecha_informe_tecnico'     =>  'nullable|date',
            'habilita_formulacion'      =>  'required',
            'fecha_derivacion'          =>  'nullable|date',
            'especialista_formulacion'  =>  'nullable',
            'nro_informe_form'          =>  'nullable|digits_between:1,4',
            'fecha_informe_form'        =>  'nullable|date',
            'nro_memo'                  =>  'nullable',
            'fecha_memo'                =>  'nullable|date',
        ];
    }
}
