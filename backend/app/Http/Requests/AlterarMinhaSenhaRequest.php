<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\ResponseHelper;

class AlterarMinhaSenhaRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|max:20|confirmed',
            'new_password_confirmation' => 'required',
        ];

        return $rules;
    }

    public function messages() {
        return [
            'old_password.required' => 'O campo senha atual é obrigatório!',
            'new_password.required' => 'A campo nova senha é obrigatório!',
            'new_password.max' => 'A campo nova senha deve possuir no máximo 20 caractered!',
            'new_password.confirmed' => 'Os campos de senha e confirmação de senha devem ser iguais!!',
            'new_password_confirmation.required' => 'O campo de confirmação de senha é obrigatório!',
        ];
    }

    /**
     * Formatação da resposta
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::responseError($validator->errors()->all(), "Falha ao salvar usuário!"));
    }

}
