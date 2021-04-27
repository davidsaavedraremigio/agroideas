<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvenioMarcoAmpliacionFormRequest extends FormRequest
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
            'numero'        =>  'digits_between:1,10|required',
            'fecha'         =>  'date|required',
            'tipo'          =>  'required',
            'objetivo'      =>  'required|max:900',
            'termino'       =>  'required|date',
        ];
    }
}
