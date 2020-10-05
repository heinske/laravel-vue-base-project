<?php

namespace App\Http\Requests;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        $rules = [
            'cpf' => 'required|size:11',
            'nome' => 'required|max:255',
            'email' => 'required|confirmed|email',
            'email_confirmation' => 'required|email',
            'ativo' => 'required|boolean',
        ];

        if ($this->isMethod('post')) {
            $rules['perfis'] = 'required|json';
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'perfis.required' => 'O campo perfis é obrigatório!',
            'perfis.json' => 'O campo perfis não está no formato correto!',
            'cpf.required' => 'O campo cpf é obrigatório!',
            'cpf.size' => 'O campo cpf deve ter 11 caracteres!',
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.max' => 'A campo nome deve possuir no máximo 255 caractered!',
            'email.required' => 'O campo e-mail é obrigatório!',
            'email.email' => 'O campo e-mail deve estar no formato de e-mail!',
            'email.confirmed' => 'O campo confirmação de e-mail não confere.',
            'email_confirmation.required' => 'A confirmação de e-mail é obrigatória!',
            'email_confirmation.email' => 'A confirmação de e-mail deve estar no formato de e-mail!',
            'ativo.required' => 'O campo ativo é obrigatório',
            'ativo.boolean' => 'O campo ativo deve ser booleano',
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
