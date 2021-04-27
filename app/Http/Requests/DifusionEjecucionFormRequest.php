<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DifusionEjecucionFormRequest extends FormRequest
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
            'difusion'          =>  'required',
            'fecha'             =>  'required|date',
            'hora_inicio'       =>  'required',
            'hora_termino'      =>  'required',
            'resultados'        =>  'required|max:3000',
            'acuerdos'          =>  'max:3000',
            'comentarios'       =>  'max:3000',
        ];
    }
}
