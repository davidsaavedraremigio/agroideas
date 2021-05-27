<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MantenimientoExpedienteUrFormRequest extends FormRequest
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
            'fecha_recepcion_ur'            =>  'required|date',
            'responsable_geo'               =>  'required',
            'fecha_solicitud_geo'           =>  'required|date',
            'fecha_informe_geo'             =>  'required|date',
            'responsable_doc'               =>  'nullable',
            'nro_informe_doc'               =>  'nullable|digits_between:1,4',
            'fecha_informe_doc'             =>  'nullable|date',
            'fecha_derivacion'              =>  'nullable|date',
            'responsable_archiva'           =>  'nullable',
            'nro_informe_archiva'           =>  'nullable|integer',
            'fecha_informe_archiva'         =>  'nullable|date',
            'nro_carta_archiva'             =>  'nullable|digits_between:1,4',
            'fecha_carta_archiva'           =>  'nullable|date',
            'responsable_observa'           =>  'nullable',
            'nro_informe_observa'           =>  'nullable|digits_between:1,4',
            'fecha_informe_observa'         =>  'nullable|date',
            'nro_carta_observa'             =>  'nullable|digits_between:1,4',
            'fecha_carta_observa'           =>  'nullable|date',
            'observacion'                   =>  'nullable|max:1500',
            'fecha_levanta_observacion'     =>  'nullable|date',
            'fecha_recepcion_observacion'   =>  'nullable|date',
        ];
    }
}
