<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterarSenhaRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AlterarMeusDadosRequest;
use App\Http\Validation\UserValidation;
use App\Helpers\ResponseHelper;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Exception;
use JWTAuth;

/**
 * Controller com todos os endpoints referentes aos usuários
 *
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class UserController extends Controller
{

    /**
     * Repository de usuários
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Validation de usuários
     *
     * @var UserValidation
     */
    protected $userValidation;

    /**
     * Construtor
     *
     * @param UserRepository $userRepository
     * @param UserValidation $userValidation
     */
    public function __construct(UserRepository $userRepository, UserValidation $userValidation)
    {
        $this->userRepository = $userRepository;
        $this->userValidation = $userValidation;
    }

    /**
     * Busca um usuário
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            //Realiza a busca dos usuários
            $usuarios = [];
            $busca = $request->get('filter');
            $filtros = $request->toArray();

            if ($request->has('length')) {
                $usuarios["data"] = $this->userRepository->busca($busca, $filtros, $request->get('length'));
            } else {
                $usuarios['data'] = $this->userRepository->busca($busca, $filtros);
            }

            return ResponseHelper::responseSuccess($usuarios, "");
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Insere o usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $validation = $this->userValidation->validate($request->toArray());

            if ($validation['success']) {
                $data = $request->toArray();
                $data['perfis'] = json_decode($data['perfis'], true);

                $result = $this->userRepository->save($data);

                if ($result['success']) {

                    $msgSuccess = "Usuário criado com sucesso!";

                    if (!empty($result['user'])) {
                      return ResponseHelper::responseSuccess([$result['user']],  $msgSuccess);
                    }

                    return ResponseHelper::responseSuccess([], $msgSuccess);
                } else {
                    return ResponseHelper::responseError([], "Falha ao inserir usuário!");
                }
            } else {
                return response()->json($validation);
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Exibe os dados do usuário
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $usuario = $this->userRepository->buscarUsuario($id);

            if ($usuario) {
                return ResponseHelper::responseSuccess([$usuario], "");
            } else {
                return ResponseHelper::responseSuccess([], "Usuário não encontrado");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Retorna os dados cadastrais do usuário autenticado
     *
     * @param Request $request
     * @return json
     */
    public function meusDados(Request $request)
    {
        try {
            $user = $this->userRepository->find(JWTAuth::getPayload()->getSubject());

            if ($user) {
                return ResponseHelper::responseSuccess([$user], "");
            } else {
                return ResponseHelper::responseError([], "Usuário não encontrado");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Atualiza os dados do usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {

            $validation = $this->userValidation->validate($request->toArray(), $id);

            if ($validation['success']) {

                $data = $request->toArray();
                $data['id'] = $id;
                $data['perfis'] = json_decode($data['perfis'], true);

                if ($this->userRepository->save($data)) {
                    return ResponseHelper::responseSuccess([], "Usuário alterado com sucesso!");
                } else {
                    return ResponseHelper::responseError([], "Falha ao alterado usuário!");
                }
            } else {
                return response()->json($validation);
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Altera os dados de um usuário autenticado
     *
     * @param DadosAdministradorRequest $request
     * @return type
     */
    public function alterarMeusDados(AlterarMeusDadosRequest $request)
    {
        try {
            $dados = $request->only(['nome', 'email']);
            $dados['id'] = JWTAuth::getPayload()->getSubject();

            if ($this->userRepository->save($dados)) {
                return ResponseHelper::responseSuccess([], "Dados alterados com sucesso");
            } else {
                return ResponseHelper::responseError([], "Falha ao alterar os dados");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Serviço de alteração de senha do usuário logado
     *
     * @param AlterarSenhaRequest $request
     * @return type
     */
    public function alterarMinhaSenha(AlterarSenhaRequest $request)
    {
        try {
            $validation = $this->userValidation->validateAlterarSenha($request->get('old_password'));

            if ($validation['success']) {
                if ($this->userRepository->alterarMinhaSenha(['id' => JWTAuth::getPayload()->getSubject() , 'senha' => $request->get('new_password')])) {
                    return ResponseHelper::responseSuccess([], "Senha alterada com sucesso!");
                } else {
                    return ResponseHelper::responseError([], "Falha ao alterar senha!");
                }
            } else {
                return ResponseHelper::responseError([], $validation['msg']);
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Remove o usuário
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($this->userRepository->delete($id)) {
                return ResponseHelper::responseSuccess([], "Usuário excluído com sucesso!");
            } else {
                return ResponseHelper::responseSuccess([], "Falha ao excluir usuário!");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Suspende o usuário
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function suspender($id){
        try {
            if ($this->userRepository->suspender($id)) {
                return ResponseHelper::responseSuccess([], "Usuário suspenso com sucesso!");
            } else {
                return ResponseHelper::responseError([], "Falha ao suspender usuário!");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Ativar o usuário
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function ativar($id){
        try {
            if ($this->userRepository->ativar($id)) {
                return ResponseHelper::responseSuccess([], "Usuário ativado com sucesso!");
            } else {
                return ResponseHelper::responseError([], "Falha ao ativar usuário!");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Exclui o usuário
     * @param int $id
     * @return \Illuminate\Http\Response
     * @info Esse método excluir o usuário, através de sua inativação no sistema
     */
    public function excluir($id){
        try {
            if ($this->userRepository->delete($id)) {
                return ResponseHelper::responseSuccess([], "Usuário excluído com sucesso!");
            } else {
                return ResponseHelper::responseError([], "Falha ao excluir usuário!");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }



}
