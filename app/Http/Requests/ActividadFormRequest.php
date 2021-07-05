<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ActividadFormRequest extends FormRequest
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
            'orden'             =>  'required|integer',
            'descripcion'       =>  'required|max:600',
            'unidad'            =>  'required|max:255',
            'meta_fisica'       =>  'required|numeric',
            'meta_financiera'   =>  'required|numeric',
            'precio'            =>  'required|numeric',
            'aporte_pcc'        =>  'required|numeric',
            'aporte_oa'         =>  'required|numeric',
        ];
    }
}
