<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffFormRequest extends FormRequest
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
            'dni'       =>  'required|digits:8',
            'ruc'       =>  'required|digits:11',
            'nombres'   =>  'required|max:50',
            'paterno'   =>  'required|max:50',
            'materno'   =>  'required|max:50',
            'fecha'     =>  'date',
            'poliza'    =>  'max:50',
            'direccion' =>  'max:300',
            'telefono'  =>  'max:9',
        ];
    }
}
