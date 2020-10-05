<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Repository\PerfilRepository;
use App\Repository\RecursoRepository;

/**
 * Realiza as validações negociais das requisições do recurso Perfil
 *
 * @author Eduardo Praxedes Heinske (eduardo.praxedes@jointecnologia.com.br)
 */
class PerfilValidation implements IValidation {

    protected $perfilRepository;
    protected $recursoRepository;

    /**
     * Injeta os repositorys necessários para as validações
     *
     * @param IRepository $perfilRepository
     */
    public function __construct(PerfilRepository $perfilRepository, RecursoRepository $recursoRepository) {
        $this->perfilRepository = $perfilRepository;
        $this->recursoRepository = $recursoRepository;
    }

    /**
     * Realiza as validações necessárias
     *
     * @param array $dado
     * @param array $id
     * @return type
     */
    public function validate(array $dados, $id = 0) {

        //Valida se o nome não está sendo utilizado por outro usuário
        if ($this->perfilRepository->verificarPerfil($dados['nome'], $id) > 0) {
            return ResponseHelper::responseError([], 'O nome informado já está sendo utilizado por outro perfil!', false);
        }

        //Realiza a validação do perfil
        if ($id) {
            $perfil = $this->perfilRepository->find($id)->withCount('Users');
            
            if (!$perfil) {
                return ResponseHelper::responseError([], 'O perfil informado para o usuário não existe!', false);
            }

            if($dados['ativo'] == 0 && $this->perfilRepository->totalUsersPerfil($id) > 0){
                return ResponseHelper::responseError([], 'O perfil informado possuí usuários vinculados, portanto não pode ser desativado!', false);
            }
        }

        // Verifica se todos os recursos informados existem
        $recursos= json_decode($dados['recursos'], true);
        $totalRecursos = count($recursos);
        $total = $this->recursoRepository->totalRecursos($recursos);

        //Valida as permissoes
        if(!$totalRecursos == $total){
            return ResponseHelper::responseError([], 'Recursos inválidos! Verifique se todos os recursos informados estão corretos', false);
        }

        return ResponseHelper::responseSuccess([], '', false);
    }

}
