<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MLProyectoFormRequest extends FormRequest
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
            'ruc'               =>  'required|digits:11',
            'razon_social'      =>  'required|max:900',
            'direccion'         =>  'max:900',
            'inicio'            =>  'required|digits:4',
            'termino'           =>  'required|digits:4',
            'fin'               =>  'required|max:3000',
            'proposito'         =>  'required|max:3000',
        ];
    }
}
