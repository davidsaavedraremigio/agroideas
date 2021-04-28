<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoAmpliacionFormRequest extends FormRequest
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
            'tipo'              =>  'required',
            'nro_ampliacion'    =>  'required|digits_between:1,9',
            'fecha_ampliacion'  =>  'required|date',
            'meses'             =>  'required|digits_between:1,12',
            'objetivo'          =>  'nullable|max:900',
        ];
    }
}
