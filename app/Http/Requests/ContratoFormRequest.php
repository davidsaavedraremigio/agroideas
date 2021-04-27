<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoFormRequest extends FormRequest
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
            'nro_contrato'      =>  'required|integer',
            'fecha'             =>  'required|date',
            'duracion'          =>  'required|digits_between:1,100',
            'objetivo'          =>  'nullable|max:900',
        ];
    }
}
