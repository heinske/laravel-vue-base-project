<?php

namespace App\Http\Requests;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
            'password' => 'required|min:6',
            'captcha' => 'required'
        ];

        return $rules;

    }

    public function messages()
    {
        return [
            'cpf.required' => 'O campo CPF é obrigatório!',
            'cpf.size' => 'O campo CPF deve ter 11 caracteres!',
            'password.required' => 'O campo Senha é obrigatório!',
            'password.min' => 'O campo Senha deve ter no mínimo 6 caracteres',
            'captcha.required' => 'O Captcha deve ser preenchido',
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
        throw new HttpResponseException(ResponseHelper::responseError(['erros' => $validator->errors()], "", true, 401));
    }

}
