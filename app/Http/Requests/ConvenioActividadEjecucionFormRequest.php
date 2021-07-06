<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvenioActividadEjecucionFormRequest extends FormRequest
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
            'actividad'         =>  'required',
            'responsable'       =>  'required',
            'fecha'             =>  'required',
            'meta_ejecutada'    =>  'required|numeric',
            'acciones'          =>  'required|max:3000',
            'situacion'         =>  'required',
        ];
    }
}
