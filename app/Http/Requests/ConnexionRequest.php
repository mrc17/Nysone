<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnexionRequest extends FormRequest
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
            //Verication des données de connexion
            'Telephone' => 'required',
        ];
    }
    public function messages(){
        return
            [
            'telephone.required'=>'Le numero de Téléphone doit être require',
        ];
    }
}
