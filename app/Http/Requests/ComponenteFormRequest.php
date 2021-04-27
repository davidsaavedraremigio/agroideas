<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComponenteFormRequest extends FormRequest
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
            'nro_orden'      =>  'required|integer',
            'descripcion'    =>  'required|max:600',
        ];
    }
}
