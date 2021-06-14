<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostulanteProcesoFormRequest extends FormRequest
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
            'fecha_recepcion'       =>  'required|date',
            'tipo_documento'        =>  'required',
            'nro_documento'         =>  'required|integer',
            'fecha'                 =>  'required|date',
            'especialista'          =>  'required',
            'comentario'            =>  'max:3000',
        ];
    }
}
