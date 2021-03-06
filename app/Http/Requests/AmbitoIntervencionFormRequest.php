<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmbitoIntervencionFormRequest extends FormRequest
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
            'region'        =>  'required',
            'provincia'     =>  'required',
            'distrito'      =>  'required',
            'latitud'       =>  'nullable|max:255',
            'longitud'      =>  'nullable|max:255',
            'descripcion'   =>  'max:600',
            'principal'     =>  'required',
        ];
    }
}
