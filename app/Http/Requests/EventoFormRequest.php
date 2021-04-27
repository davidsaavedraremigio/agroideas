<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoFormRequest extends FormRequest
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
            'tipo_evento'               =>  'required',
            'nombre'                    =>  'required|max:600',
            'region'                    =>  'required',
            'provincia'                 =>  'required',
            'distrito'                  =>  'required',
            'lugar'                     =>  'max:600',
            'fecha_evento'              =>  'required|date',
            'nombre_st'                 =>  'max:600',
            'representante_st'          =>  'max:255',
            'organizador'               =>  'required|max:600',
            'representante_organizador' =>  'max:255',
            'integrantes'               =>  'required|max:600',
            'representante_pcc'         =>  'required',
            'objetivo'                  =>  'max:3000',
            'resultadoEsperado'         =>  'max:3000',
            'evidencia'                 =>  'required|file|max:10000',
        ];
    }
}
