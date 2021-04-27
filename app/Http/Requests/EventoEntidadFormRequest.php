<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoEntidadFormRequest extends FormRequest
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
            'ruc'               =>  'required|digits:11',
            'nombre'            =>  'required|max:600',
            'tipo_entidad'      =>  'required',
            'ubigeo'            =>  'required|max:6',
            'direccion'         =>  'required',
            'tipo_incentivo'    =>  'required',
            'cadena_propuesta'  =>  'required',
            'nro_productores'   =>  'required',
            'nro_hectareas'     =>  'required',
            'inversion'         =>  'required',
            'compromiso'        =>  'required',
        ];
    }
}
