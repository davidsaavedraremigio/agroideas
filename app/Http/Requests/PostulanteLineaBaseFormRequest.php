<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostulanteLineaBaseFormRequest extends FormRequest
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
            'indicador'     =>  'required',
            'linea_base'    =>  'required|numeric',
            'anio_1'        =>  'required|numeric',
            'anio_2'        =>  'required|numeric',
            'anio_3'        =>  'required|numeric',
            'anio_4'        =>  'required|numeric',
            'anio_5'        =>  'required|numeric',
            'anio_6'        =>  'nullable|numeric',
            'anio_7'        =>  'nullable|numeric',
            'anio_8'        =>  'nullable|numeric',
            'anio_9'        =>  'nullable|numeric',
            'anio_10'       =>  'nullable|numeric', 
        ];
    }
}
