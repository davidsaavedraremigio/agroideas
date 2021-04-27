<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvenioMarcoCoordinadorEntidadFormRequest extends FormRequest
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
            'dni'           =>  'required|digits:8',
            'nombres'       =>  'required|max:255',
            'paterno'       =>  'required|max:255',
            'materno'       =>  'required|max:255',
            'cargo'         =>  'required|max:255',
            'referencia'    =>  'required|max:255',
            'fecha'         =>  'required|date', 
            'tipo'          =>  'required',
        ];
    }
}
