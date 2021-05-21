<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapacitacionParticipanteFormRequest extends FormRequest
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
            'dni'                       =>  'required|digits:8',
            'nombres'                   =>  'required|max:100',
            'paterno'                   =>  'required|max:100',
            'materno'                   =>  'required|max:100',
            'edad'                      =>  'required|integer',
            'sexo'                      =>  'required',
            'actividad_productor'       =>  'nullable',
            'actividad_participante'    =>  'nullable',
            'detalla_otro'              =>  'nullable|max:255',
            'cadena_agricola'           =>  'nullable',
            'cadena_pecuaria'           =>  'nullable',
            'cadena_forestal'           =>  'nullable',
        ];
    }
}
