<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostulanteResultadoFormRequest extends FormRequest
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
            'indicador'         =>  'required',
            'anio_1'            =>  'nullable|numeric',
            'anio_2'            =>  'nullable|numeric',
            'anio_3'            =>  'nullable|numeric',
            'anio_4'            =>  'nullable|numeric',
            'anio_5'            =>  'nullable|numeric',
            'anio_6'            =>  'nullable|numeric',
            'anio_7'            =>  'nullable|numeric',
            'anio_8'            =>  'nullable|numeric',
            'anio_9'            =>  'nullable|numeric',
            'anio_10'           =>  'nullable|numeric',
        ];
    }
}
