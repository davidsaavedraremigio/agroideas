<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MantenimientoExpedienteFormRequest extends FormRequest
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
            'nro_cut'                   =>  'required|integer',
            'fecha_recepcion'           =>  'required|date',
            'nro_expediente'            =>  'required|integer',
            'fecha_expediente'          =>  'required|date',
            'especialista_asignado'     =>  'required',
            'oficina'                   =>  'required',
        ];
    }
}
