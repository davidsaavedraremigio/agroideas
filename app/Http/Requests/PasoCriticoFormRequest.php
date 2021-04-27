<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasoCriticoFormRequest extends FormRequest
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
            'resultado'     =>  'required|max:900',
            'inicio'        =>  'required|numeric',
            'termino'       =>  'required|numeric',
        ];
    }
}
