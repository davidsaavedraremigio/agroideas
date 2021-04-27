<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcesoFormRequest extends FormRequest
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
            'nombre'        =>  'required|max:600',
            'ruta'          =>  'required|max:600',
            'icono'         =>  'nullable',
            'parent'        =>  'nullable',
            'orden'         =>  'required',
            'descripcion'   =>  'required|max:600',
        ];
    }
}
