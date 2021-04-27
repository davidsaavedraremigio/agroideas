<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesembolsoSdaFormRequest extends FormRequest
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
            'nroSiaf'           =>  'nullable',
            'fecha'             =>  'required|date',
            'importe'           =>  'required|numeric',
            'nro_solicitud'     =>  'nullable',      
        ];
    }
}
