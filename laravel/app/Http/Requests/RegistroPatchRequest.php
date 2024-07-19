<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroPatchRequest extends FormRequest
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
            'origem' => 'required|numeric|digits:8',
            'destino' => 'required|numeric|digits:8',
        ];
    }

    public function messages()
    {
        return [
            'origem.required' => 'O campo origem é obrigatório',
            'destino.required' => 'O campo destino é obrigatório',
            'origem.numeric' => 'O campo origem deve ser um número',
            'destino.numeric' => 'O campo destino deve ser um número',
            'origem.digits' => 'O campo origem deve ter 8 dígitos',
            'destino.digits' => 'O campo destino deve ter 8 dígitos',
        ];
    }
}
