<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompromisoSeguimientoFormRequest extends FormRequest
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
            'compromiso'    =>  'required',
            'etapa'         =>  'required',
            'fecha'         =>  'required|date',
            'responsable'   =>  'required|max:900',
            'resultado'     =>  'required|max:3000',
            'observaciones' =>  'max:3000',
            'evidencia'     =>  'file|max:10000',
            'estado'        =>  'required',
        ];
    }
}
