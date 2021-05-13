<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoFormRequest extends FormRequest
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
            'titulo'            =>  'required|max:600',
            'incentivo'         =>  'required',
            'duracion'          =>  'required|digits_between:1,72',
            'inicio'            =>  'required|date',
            'aporte_pcc'        =>  'required|numeric',
            'aporte_entidad'    =>  'required|numeric',
            'aporte_total'      =>  'required|numeric',
            'prod_var'          =>  'required|numeric',
            'prod_muj'          =>  'required|numeric',
            'prod_total'        =>  'required|integer',
            'cadena'            =>  'required',
            'area'              =>  'required|numeric',
        ];
    }
}
