<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedientePrpFormRequest extends FormRequest
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
            'referencia'            =>  'required',
            'fecha_recepcion'       =>  'date|required',
            'area'                  =>  'required',
            'tipo_documento'        =>  'required',
            'nro_documento'         =>  'required',
            'fecha_documento'       =>  'date|required',
            'estado'                =>  'required',
            'evidencia'             =>  'required|file',
            'comentarios'           =>  'max:900',
        ];
    }
}
