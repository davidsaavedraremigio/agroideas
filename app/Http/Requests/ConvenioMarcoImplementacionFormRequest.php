<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvenioMarcoImplementacionFormRequest extends FormRequest
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
            'compromiso'        =>  'required',
            'fecha'             =>  'required|date',
            'resultados'        =>  'required|max:6000',
            'dificultades'      =>  'max:6000',
            'recomendaciones'   =>  'max:6000',
        ];
    }
}
