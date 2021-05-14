<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormulacionFormRequest extends FormRequest
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
            'fecha_inicio'      =>  'required|date',
            'duracion'          =>  'required|numeric',
            'objetivo'          =>  'required|max:900',
            'nro_ha'            =>  'required|numeric',
            'nro_productores'   =>  'required|integer',
            'aporte_pcc'        =>  'required|numeric',
            'aporte_entidad'    =>  'required|numeric',
            'aporte_total'      =>  'required|numeric', 
        ];
    }
}
