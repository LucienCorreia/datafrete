<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroImportarRequest extends FormRequest
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
            'file' => 'required|mimes:csv',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'O campo arquivo é obrigatório',
            'file.mimes' => 'O arquivo deve ser do tipo CSV',
        ];
    }
}