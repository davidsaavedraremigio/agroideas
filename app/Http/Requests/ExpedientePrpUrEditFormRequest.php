<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedientePrpUrEditFormRequest extends FormRequest
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
            'entidad'               =>  'required',
            'fecha_recepcion'       =>  'date|required',
            'nro_cut'               =>  'required|max:50',
            'nro_expediente'        =>  'required|max:50',
            'fecha_expediente'      =>  'date|required',
            'oficina'               =>  'required',
            'especialista'          =>  'required',
        ];
    }
}
