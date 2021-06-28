<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoObjecionDetalleFormRequest extends FormRequest
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
            'ruc'               =>  'required|digits:11',
            'razon_social'      =>  'required|max:600',
            'direccion'         =>  'required|max:600',
            'tipo_proveedor'    =>  'required|max:255',
            'esta_activo'       =>  'required',
            'esta_habido'       =>  'required',
            'banco'             =>  'required',
            'nro_cuenta'        =>  'required|max:255',
            'nro_cci'           =>  'required|max:255',
            'tipo_cuenta'       =>  'required',
            'descripcion'       =>  'required|max:300',
            'nro_poa'           =>  'required|integer',
            'tipo_gasto'        =>  'required',
            'importe'           =>  'required|numeric',
            'evidencia'         =>  'nullable|file',
        ];
    }
}
