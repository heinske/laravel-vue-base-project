<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Validation\UserValidation;
use App\Models\Token;
use App\Repository\UserRepository;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
use JWTAuth;

/**
 * Controller com todos os endpoints referentes a autenticação e informações do usuário logado
 *
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class AuthController extends Controller {

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
     *
     * @param UserRepository $userRepository
     * @param UserValidation $userValidation
     */
    public function __construct(UserRepository $userRepository, UserValidation $userValidation) {
        $this->userRepository = $userRepository;
        $this->userValidation = $userValidation;
    }

    /**
     * Serviço de autenticação de um usuário da área administrativa
     *
     * @param Request $request
     * @return type
     */
    public function auth(AuthRequest $request) {
        try{

            if (config('services.recaptcha.enabled') && !$this->userRepository->verificarRecaptcha($request->get('token'), $request->ip())) {
                return ResponseHelper::responseError([], 'Recaptcha inválido!', true, 401);
            }

            if ($this->userRepository->verificarUsuarioSuspenso($request->get('cpf'))) {
                return ResponseHelper::responseError([], 'Seu acesso encontra-se suspenso. Entre em contato com o administrador do sistema para ativar seu acesso.', true, 401);
            }
            
            $auth = $this->userRepository->auth($request->get('cpf'), $request->get('password'));

            if($auth){
                return ResponseHelper::responseSuccess($auth, "Usuário autenticado com sucesso!");
            }else{
                return ResponseHelper::responseError([], 'Usuário e/ou senha inválidos!', true, 401);
            }
        }catch(\Exeption $ex){
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Serviço de recuperação de senha
     *
     * @param Request $request
     * @return type
     */
    public function recuperarSenha(Request $request) {
        try {
            $result = $this->userRepository->recuperarSenha($request->get('cpf'));

            if ($result['success']) {
                return ResponseHelper::responseSuccess(['email' => $result['email']], "");
            } else {
                return ResponseHelper::responseError([], "Este CPF não foi encontrado em nossos registros, revise novamente.");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Serviço de alteração de senha
     *
     * @param Request $request
     * @return type
     */
    public function alterarSenha(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validacao->fails())
            return ResponseHelper::responseError([$validacao->errors()], "");

        $result = $this->userRepository->alterarSenha($request->all());

        if ($result)
            return ResponseHelper::responseSuccess([],"Senha alterada com sucesso!");

        return ResponseHelper::responseError([], "");
    }

    /**
     * Faz a validação do token
     *
     * @return void
     */
    public function validarToken(){
        try{
            $token = JWTAuth::parseToken();

            if($token){
                return ResponseHelper::responseSuccess([], "Token válido!");
            }else{
                return ResponseHelper::responseError([], 'Token inválido!');
            }
        }catch(\Exception $ex){
            return ResponseHelper::responseError([], 'Token inválido!');
        }
    }

    /**
     * Faz a validação se o token para recuperação de senha ainda é válido
     *
     * @return void
     */
    public function validarTokenEmail(Request $request){

        $validacao = Validator::make($request->all(), [
          'token' => 'required'
        ]);

        if ($validacao->fails())
            return ResponseHelper::responseError([$validacao->errors()], "Token expirado",true,403);

        // Ver no code review qual a melhor alternativa para isso, se realmente vale a pena criar um método no repository para isso
        $token = $request->get('token');
        $tokenValido = Token::where('token', $token)->where('expirado', false)->first();

        if ($tokenValido)
            return ResponseHelper::responseSuccess([], "Token válido!");

         return ResponseHelper::responseError([], "Token expirado!",true,403);
    }

    public function refresh(){
        try {
            $token = JWTAuth::parseToken()->refresh();

            return response()->json(compact('token'));
        } catch (JWTException $exception){
            report($exception);
            return response()->json(['error' => 'token_invalid'],400);
        }
    }

}
