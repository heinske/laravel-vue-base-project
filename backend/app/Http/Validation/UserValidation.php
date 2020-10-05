<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Helpers\UtilHelper;
use App\Repository\PerfilRepository;
use App\Repository\UserRepository;
use JWTAuth;
use Illuminate\Support\Facades\Hash;

/**
 * Realiza as validações negociais das requisições do recurso Usuário
 *
 * @author Eduardo Praxedes Heinske (eduardo.praxedes@jointecnologia.com.br)
 */
class UserValidation implements IValidation {

    protected $perfilRepository;
    protected $usuarioRepository;
    protected $util;

    /**
     * Injeta os repositorys necessários para as validações
     *
     * @param IRepository $perfilRepository
     * @param IRepository $usuarioRepository
     */
    public function __construct(PerfilRepository $perfilRepository, UserRepository $usuarioRepository, UtilHelper $util) {
        $this->perfilRepository = $perfilRepository;
        $this->usuarioRepository = $usuarioRepository;
        $this->util = $util;
    }

    /**
     * Validação do salvamento de um usuário
     *
     * @param array $dados
     * @param type $id
     * @param type $validateId
     * @return type
     */
    public function validate(array $dados, $id = 0) {

        //Valida se o cpf não está sendo utilizado por outro usuário
        if ($this->usuarioRepository->verificarCpf($dados['cpf'], $id) > 0) {
            return ResponseHelper::responseError([], 'O cpf informado já está sendo utilizado por outro usuário!', false);
        }

        //Valida se o e-mail não está sendo utilizado por outro usuário
        if ($this->usuarioRepository->verificarEmail($dados['email'], $id) > 0) {
            return ResponseHelper::responseError([], 'O e-mail informado já está sendo utilizado por outro usuário!', false);
        }

        //Valida o id do usuário
        if ($id) {
            $usuario = $this->usuarioRepository->find($id);

            if (!$usuario) {
                return ResponseHelper::responseError([], 'O usuário informado não está cadastrado', false);
            }
        }

        return ResponseHelper::responseSuccess([], '', false);
    }

    /**
     * Valida a alteração de senha
     *
     * @param string $old_password
     * @return array
     */
    public function validateAlterarSenha($old_password) {
        // Valida a existência do usuário
        $user = $this->usuarioRepository->find(JWTAuth::getPayload()->getSubject());

        if (!$user) {
            return ResponseHelper::responseError([], 'Usuário não encontrado!', false);
        }

        $auth = $this->usuarioRepository->validarSenha(UtilHelper::limparCpfCnpj($user->cpf), $old_password);

        if ($auth) {
            return ResponseHelper::responseSuccess([], '', false);
        } else {
            return ResponseHelper::responseError([], 'Senha atual inválida!', false);
        }
    }

}
