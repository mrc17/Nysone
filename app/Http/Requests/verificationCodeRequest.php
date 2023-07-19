<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class verificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //Customisation des valideurs

            'code'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'code.required'=>'Le code Verication est obligatoire',
        ];
    }
}
