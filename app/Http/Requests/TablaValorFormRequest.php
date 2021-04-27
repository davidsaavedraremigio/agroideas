<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TablaValorFormRequest extends FormRequest
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
            'tabla'     =>  'required',
            'nombre'    =>  'required|max:600',
            'valor'     =>  'required|max:3',
            'orden'     =>  'required'
        ];
    }
}
