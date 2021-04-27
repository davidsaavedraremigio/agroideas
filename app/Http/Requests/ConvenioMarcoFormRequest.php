<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvenioMarcoFormRequest extends FormRequest
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
            'nro_cut'               =>  'nullable|max:100',
            'fecha_cut'             =>  'nullable|date',
            'nro_convenio'          =>  'required|between:1,9999',
            'fecha_firma'           =>  'required|date',
            'duracion'              =>  'required|digits_between:1,72',
            'objetivo'              =>  'required|max:3000',
            'tipo'                  =>  'required',
            'nro_ley'               =>  'nullable|max:255',
            'importe'               =>  'required|numeric',
            'representante_pcc'     =>  'required',
        ];
    }
}
