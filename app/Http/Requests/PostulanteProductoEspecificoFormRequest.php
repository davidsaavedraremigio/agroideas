<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PostulanteProductoEspecificoFormRequest extends FormRequest
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
            'cadena'            =>  'required',
            'producto'          =>  'required',
            'tipo_produccion'   =>  'required',
            'hectareas'         =>  'required|numeric',
            'productores'       =>  'required|numeric',
            'variedad'          =>  'max:255',
            'principal'         =>  'required',
        ];
    }
}
