<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyUserRequest extends FormRequest
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
            'Nom' => 'required|string|min:3|max:15',
            'Prenom' => 'required|string|min:3|max:20',
            'Telephone' => 'required|string|min:8|max:16|unique:users,telephone',
            'email' => 'required|email|unique:users,email',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'Nom.required' => 'Vous devez renseigner votre Nom.',
            'Nom.min' => 'Votre Nom doit comporter au moins trois caractères.',
            'Nom.max' => 'Votre Nom ne doit pas dépasser 15 caractères.',
            'Nom.string' => 'Votre Nom doit être une chaîne de caractères alphabétiques.',
            'Prenom.required' => 'Vous devez renseigner votre Prénom.',
            'Prenom.min' => 'Votre Prénom doit comporter au moins trois caractères.',
            'Prenom.max' => 'Votre Prénom ne doit pas dépasser 20 caractères.',
            'Prenom.string' => 'Votre Prénom doit être une chaîne de caractères alphabétiques.',
            'Telephone.required' => 'Vous devez renseigner votre numéro de téléphone.',
            'Telephone.min' => 'Numéro de téléphone invalide.',
            'Telephone.max' => 'Numéro de téléphone invalide.',
            'Telephone.unique' => 'Numéro de téléphone déjà utilisé.',
            'email.required' => 'Veuillez renseigner votre adresse email.',
            'email.email' => 'Votre adresse email n\'est pas valide.',
            'email.unique' => 'Adresse email déjà utilisée.',
        ];
    }
}