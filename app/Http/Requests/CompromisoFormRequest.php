<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompromisoFormRequest extends FormRequest
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
            'compromiso'        =>  'required|max:900',
            'responsable'       =>  'required|max:900',
            'fecha_plazo'       =>  'required|date',
            'inversion'         =>  'numeric',
            'tipo_documento'    =>  'required',
            'nro_documento'     =>  'max:255',
            'fecha_documento'   =>  'required|date',
            'tipo_compromiso'   =>  'required',
            'nro_incentivo'     =>  'required',
            'estado_compromiso' =>  'required',
        ];
    }
}
