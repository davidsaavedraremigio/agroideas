<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaFormRequest extends FormRequest
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
            'nro_documento'         =>  'required|digits:8',
            'nombres'               =>  'required|max:255',
            'paterno'               =>  'required|max:255',
            'materno'               =>  'required|max:255',
            'fecha'                 =>  'required|date',
            'sexo'                  =>  'required',
            'direccion'             =>  'required|max:600',
        ];
    }
}
