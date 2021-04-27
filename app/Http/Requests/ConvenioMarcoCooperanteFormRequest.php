<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvenioMarcoCooperanteFormRequest extends FormRequest
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
            'ruc'           =>  'required|digits:11',
            'razon_social'  =>  'required|max:255',
            'ubigeo'        =>  'required|digits:6',
            'tipo'          =>  'required|max:255',
            'direccion'     =>  'required|max:600',
            'dni'           =>  'required|digits:8',
            'nombres'       =>  'required|max:255',
            'paterno'       =>  'required|max:255',
            'materno'       =>  'required|max:255',
            'cargo'         =>  'required|max:255',
        ];
    }
}
