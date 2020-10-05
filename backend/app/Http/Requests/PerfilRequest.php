<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
{
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
        return [
            'nome' => 'required|max:255',
            'recursos' => 'required|json',
            'ativo' => 'required'
        ];
    }

    public function messages() {
        return [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.max' => 'O campo nome deve ter no máximo 255 caractered!',
            'recursos.required' => 'A lista de recursos deve ser informada!',
            'recursos.json' => 'A lista de recursos informados não está no formato correto!',
            'ativo.required' => 'O campo ativo é obrigatório'
        ];
    }

}
