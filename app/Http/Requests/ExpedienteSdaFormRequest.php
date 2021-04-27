<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedienteSdaFormRequest extends FormRequest
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
            'tipo_entidad'      =>  'required',
            'tipo_iniciativa'   =>  'required',
            'razon_social'      =>  'required|max:600',
            'fecha_rrpp'        =>  'nullable|date',
            'ubigeo'            =>  'required|digits:6',
            'estado_sunat'      =>  'nullable',
            'direccion'         =>  'required|max:600',
            'nro_cut'           =>  'required|integer',
            'fecha_cut'         =>  'required|date',
            'nro_expediente'    =>  'required|integer',
            'fecha_expediente'  =>  'required|date',
            'oficina'           =>  'required',
            'personal'          =>  'required',
            'area'              =>  'required',
            'estado'            =>  'required',
        ];
    }
}
