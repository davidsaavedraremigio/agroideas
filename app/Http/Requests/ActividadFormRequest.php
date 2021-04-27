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
            'componente'        => 'required',
            'nro_orden'         =>  'integer|required',
            'unidad'            =>  'required',
            'descripcion'       =>  'required|max:600',
            'meta_fisica'       =>  'required|numeric',
            'precio'            =>  'required|numeric',
        ];
    }
}
