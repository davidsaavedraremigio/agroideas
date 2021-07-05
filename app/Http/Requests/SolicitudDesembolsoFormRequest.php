<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudDesembolsoFormRequest extends FormRequest
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
            'numero'            =>  'required|integer',
            'fecha'             =>  'required|date',
            'numero_memo'       =>  'required|integer',
            'numero_informe'    =>  'required|integer',
            'fecha_informe'     =>  'required|date',
            'especialista'      =>  'required',
        ];
    }
}
