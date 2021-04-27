<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoSdaFormRequest extends FormRequest
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
            'postulante'            =>  'required',
            'titulo'                =>  'required|max:600',
            'proposito'             =>  'nullable|max:900',
            'duracion'              =>  'required|integer',
            'fecha_inicio'          =>  'required|date',
            'inversion_total'       =>  'nullable|numeric',
            'inversion_pcc'         =>  'required|numeric',
            'inversion_entidad'     =>  'required|numeric',
            'nro_has'               =>  'required|numeric',
            'beneficiarios_total'   =>  'nullable|integer',
            'beneficiarios_varones' =>  'required|integer',
            'beneficiarios_mujeres' =>  'required|integer',
            'cadena'                =>  'required',
            'tipo_produccion'       =>  'required',
        ];
    }
}
