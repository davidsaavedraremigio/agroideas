<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarteraPrpFormRequest extends FormRequest
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
            'descripcion'       =>  'required|max:4000',
            'nro_resolucion'    =>  'required|max:100',
            'fecha'             =>  'required|date',
            'importe'           =>  'required|numeric',
        ];
    }
}
