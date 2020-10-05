<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\ResponseHelper;

class AlterarMeusDadosRequest extends FormRequest {

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
            'nome' => 'required|max:255',
            'email' => 'required|email',
        ];

        return $rules;
    }

    public function messages() {
        return [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.max' => 'A campo nome deve possuir no máximo 255 caractered!',
            'email.required' => 'O campo e-mail é obrigatório!',
            'email.email' => 'O campo e-mail deve estar no formato de e-mail!',
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
        throw new HttpResponseException(ResponseHelper::responseError($validator->errors()->all(), "Falha ao alterar dados!"));
    }
}
