<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedienteProcesoFormRequest extends FormRequest
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
            'fecha_asignacion'      =>  'required|date',
            'responsable_asignado'  =>  'required',
            'tipo_documento'        =>  'required',
            'nro_documento'         =>  'required|integer',
            'fecha_documento'       =>  'required|date',
            'fecha_derivacion'      =>  'nullable|date',
            'destinatario'          =>  'nullable',
            'estado_proceso'        =>  'required',
            'comentarios'           =>  'max:900',
        ];
    }
}
