<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostulanteCierreFormRequest extends FormRequest
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
            'tipo_documento_me'         =>  'required',
            'nro_documento_me'          =>  'required|integer',
            'fecha_me'                  =>  'required|date',
            'especialista_me'           =>  'required',
            'comentario_me'             =>  'max:3000',
            'tipo_documento_uaj'        =>  'required',
            'nro_documento_uaj'         =>  'required|integer',
            'fecha_uaj'                 =>  'required|date',
            'especialista_uaj'          =>  'required',
            'comentario_uaj'            =>  'max:3000',
        ];
    }
}
