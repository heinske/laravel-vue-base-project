<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ResponseHelper;
use App\Repository\PerfilRepository;

class VerifyRolePermissions {

    /**
     * Repository de perfis
     *
     * @var PerfilRepository
     */
    protected $perfilRepository;

    /**
     * Construtor
     *
     * @param PerfilRepository $perfilRepository
     */
    public function __construct(PerfilRepository $perfilRepository)
    {
        $this->perfilRepository = $perfilRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //Busca o controller e ação que estão sendo acessados
        $namespace = $request->route()->getActionName();
        $arrNamespace = explode('\\', $namespace);
        $permissao = explode('@', end($arrNamespace));

        $resource = strtolower(str_replace('Controller', '', $permissao[0]));
        $action = $permissao[1];
        //Busa o perfil
        $payload =  JWTAuth::getPayload()->toArray();
        $perfis = $payload['perfis'];

        $valid = $this->perfilRepository->validarPermissaoPerfis($perfis, $resource, $action);

        //Valida a permissão e em caso de sucesso segue com a requisição
        if ($valid) {
            return $next($request);
        }

        //Retorna o erro de acesso
        return ResponseHelper::responseError([], 'Sem permissão para acessar essa ação!', true, 403);
    }

}
