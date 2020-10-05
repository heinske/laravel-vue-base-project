<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest;
use App\Http\Validation\PerfilValidation;
use App\Repository\PerfilRepository;
use App\Helpers\ResponseHelper;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Http\Request;
use JWTAuth;

/**
 * Controller com todos os endpoints referentes aos perfis
 *
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class PerfilController extends Controller
{

    /**
     * Repository de perfis
     *
     * @var PerfilRepository
     */
    protected $perfilRepository;

    /**
     * Repository de usuáros
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Validation de perfis
     *
     * @var PerfilValidation
     */
    protected $perfilValidation;

    /**
     * Construtor
     *
     * @param PerfilRepository $perfilRepository
     * @param UserValidation $perfilValidation
     */
    public function __construct(PerfilRepository $perfilRepository, UserRepository $userRepository, PerfilValidation $perfilValidation)
    {
        $this->perfilRepository = $perfilRepository;
        $this->userRepository = $userRepository;
        $this->perfilValidation = $perfilValidation;
    }

    /**
     * Busca um usuário
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $perfis = [];

            $busca = $request->get('filter');
            $filtros = $request->toArray();
            $recursos = $request->get('recursos') ? (boolean) $request->get('recursos') : false;

            if ($request->has('length')) {
                $perfis["data"] = $this->perfilRepository->busca($busca, $filtros, true, $request->get('length'));
            } else {
                $perfis['data'] = $this->perfilRepository->busca($busca, $filtros, $recursos);
            }

            return ResponseHelper::responseSuccess($perfis, "");
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Insere o perfil
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerfilRequest $request)
    {
        try {
            $validation = $this->perfilValidation->validate($request->toArray());
            if ($validation['success']) {
                $dados = $request->toArray();
                $dados['recursos'] = json_decode($dados['recursos'], true);

                if ($this->perfilRepository->save($dados)) {
                    return ResponseHelper::responseSuccess([], "Perfil inserido com sucesso!");
                } else {
                    return ResponseHelper::responseError([], "Falha ao inserir perfil!");
                }
            } else {
                return response()->json($validation);
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Exibe os dados do perfil
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $perfil = $this->perfilRepository->find($id, true);

            if ($perfil) {
                return ResponseHelper::responseSuccess($perfil->toArray(), "");
            } else {
                return ResponseHelper::responseSuccess([], "");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Atualiza os dados do perfil
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerfilRequest $request, $id)
    {
        try {
            $validation = $this->perfilValidation->validate($request->toArray(), $id);

            if ($validation['success']) {

                $dados = $request->toArray();
                $dados['id'] = $id;
                $dados['recursos'] = json_decode($dados['recursos'], true);

                if ($this->perfilRepository->save($dados)) {
                    return ResponseHelper::responseSuccess([], "Perfil alterado com sucesso!");
                } else {
                    return ResponseHelper::responseError([], "Falha ao alterar perfil!!");
                }
            } else {
                return response()->json($validation);
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Remove o perfil
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Valida a senha do usuário
        $payload =  JWTAuth::getPayload()->toArray();
        if(!$this->userRepository->validarSenha($payload['cpf'], $request->get('password'))){
            return ResponseHelper::responseError([], "Senha inválida!");
        }
        
        try {
            if ($this->perfilRepository->delete($id)) {
                return ResponseHelper::responseSuccess([], "Perfil excluído com sucesso!");
            } else {
                return ResponseHelper::responseError([], "Falha ao excluir perfil, é necessário não existir nenhum usuário associado ao mesmo, para assim concluir a ação!");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Valida a permissão e um determinado recursp
     *
     * @param Request $request
     * @return void
     */
    public function validarRecurso(Request $request){
        try {
            $perfis =  JWTAuth::getPayload()->getCustom('perfis');
            $recurso = $request->get('recurso');
            $acao = $request->get('acao');

            if($this->perfilRepository->validarPermissaoPerfil($perfis, $recurso, $acao)){
                return ResponseHelper::responseSuccess([], 'Com permissão');
            }else{
                return ResponseHelper::responseError([], 'Sem permissão');
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    public function buscarPerfis() {
        $perfis = $this->perfilRepository->getListaCombo();
        return ResponseHelper::responseSuccess(['perfis'=>$perfis], '');
    }

    public function buscarPerfisInterno() {
        $perfis = $this->perfilRepository->getListaComboInterno();
        return ResponseHelper::responseSuccess(['perfis' => $perfis], '');
    }

}
