<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ConvenioActividadProgramacionFormRequest extends FormRequest
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
            'compromiso'            =>  'required',
            'actividad'             =>  'required|max:600',
            'descripcion'           =>  'max:3000',
            'meta_fisica'           =>  'required|numeric',
            'fecha_limite'          =>  'required|date',
        ];
    }
}
