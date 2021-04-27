<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DifusionformRequest extends FormRequest
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
            'distrito'              =>  'required',
            'tipo_evento'           =>  'required',
            'nombre'                =>  'required',
            'responsable'           =>  'required',
            'fecha'                 =>  'required|date',
            'objetivo'              =>  'required|max:900',
            'nro_participantes'     =>  'required|numeric',
            'lugar'                 =>  'required|max:300',
            'importe'               =>  'required|numeric',
            'horas'                 =>  'required|integer',
            //'actividad_operativa'   =>  'nullable',
        ];
    }
}
