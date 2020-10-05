<?php

namespace App\Repository;

use App\Mail\ConfirmacaoCadastro;
use App\Mail\RecuperarSenha;
use App\Models\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use JWTAuth;
use Log;

/**
 * Repositório com todas as regras relacionadas a usuários
 *
 * @author Eduardo Praxedes Heinske (eduardo.praxedes@jointecnologia.com.br)
 */
class UserRepository extends BaseRepository
{
    /** Constantes sobre o estado do usuário */
    const ATIVO = 1;
    const INATIVO = 0;

    /**
     * Model de usuários
     *
     * @var User
     */
    public $model;

    /**
     * Construtor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Realiza a autenticação do usuário
     *
     * @param string $cpf
     * @param string $password
     * @return void
     */
    public function auth($cpf, $password)
    {

        // Armazena as credenciais
        $credentials = ['cpf' => $cpf, 'password' => $password];

        // Busca os  dados do usuário
        $user = $this->model->where('cpf', $cpf)->with(['Perfis.Recursos'])->first();
        $perfis = [];

        if (!$user) {
            return false;
        }

        foreach ($user->Perfis as $key => $perfil) {
            $perfis[] = $perfil->id;
        }

        $perfil_id = $perfis[0];

        // Realiza a autenticação
        $token = JWTAuth::attempt($credentials, ['perfis' => $perfis]);

        if (!$token) {
            return false;
        }

        // Obtem as permissões e retorna a relação de permissões
        $permissoes = [];

        foreach ($user->Perfis as $key => $perfil) {
            $permissoes[$key] = [
                'id' => $perfil->id,
                'nome' => $perfil->nome,
                'permissoes' => [],
            ];

            foreach ($perfil->recursos as $key2 => $recurso) {
                $permissoes[$key]['permissoes'][$key2] = $recurso->recurso . "." . $recurso->acao;
            }

            $permissoes[$key] = $permissoes;
        }

        return [
            'token' => $token, 
            'permissoes' => $permissoes, 
            'user' => $user->id, 
            'nome' => $user->nome, 
            'avatar', $user->foto, 
            'perfil_id' => $perfil_id,
            'situacao' => $user->situacao
        ];
    }

    /**
     * Verifica a disponibilidade de um e-mail
     *
     * @param string $email
     * @param string $user
     * @return integer
     */
    public function verificarEmail($email, $user)
    {
        return $this->model->where([['email', '=', $email], ['id', '<>', $user]])->count();
    }

    /**
     * Verifica a disponibilidade de um cpf
     *
     * @param string $cpf
     * @param string $user
     * @return integer
     */
    public function verificarCpf($cpf, $user)
    {
        return $this->model->where([['cpf', '=', $cpf], ['id', '<>', $user]])->count();
    }

    /**
     * Verifica a duplicidade por municío
     *
     * @param string $cpf
     * @param string $user
     * @return integer
     */
    public function verificarDuplicidade($perfil, $cidades)
    {
        return $this->model
                    ->where([['users_cidades.cidade_id', '=', $cidades], ['perfil_id', '=', $perfil]])
                    ->join('perfis_users', 'perfis_users.user_id', '=', 'users.id')
                    ->join('users_cidades', 'users_cidades.user_id', '=', 'users.id')
                    ->count();
    }

    /**
     * Verifica a duplicidade por UF
     *
     * @param string $cpf
     * @param string $user
     * @return integer
     */
    public function verificarDuplicidadePorUF($perfil, $uf)
    {

        $total = $this->model
                    ->where([['estados.id', '=', $uf], ['perfis_users.perfil_id', '=', $perfil]])
                    ->join('perfis_users', 'perfis_users.user_id', '=', 'users.id')
                    ->join('users_cidades', 'users_cidades.user_id', '=', 'users.id')
                    ->join('cidades', 'cidades.id', '=', 'users_cidades.cidade_id')
                    ->join('estados', 'estados.id', '=', 'cidades.estado_id')
                    ->select(\DB::raw('count(distinct(estados.id)) as total'));

        return $total->get()->toArray();
    }

    /**
     * Verifica a disponibilidade de um cpf
     *
     * @param string $cpf
     * @param string $user
     * @return integer
     */
    public function verificarUsuarioSuspenso($cpf)
    {
        return $this->model->where([['cpf', '=', $cpf], ['ativo', '=', false]])->count();
    }

    /**
     * Verifica se o recaptcha está validado
     */
    public function verificarRecaptcha($token, $ip)
    {
        $response = (new Client)->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret'),
                'response' => $token,
                'remoteip' => $ip,
            ],
        ]);

        return $response->getBody();
    }

    /**
     * Busca de usuários
     *
     * @param string $search
     * @param array $filtros
     * @param integer $limit
     * @param integer $offset
     * @param integer $count
     * @return array
     */
    public function busca($search, $filtros = [], $limit = false)
    {

        $query = $this->model
            ->select(\DB::raw('distinct users.id AS id_user'))
            ->addSelect(['users.*', 'perfis.nome AS perfil', 'perfis.id AS perfil_id'])
            ->join('perfis_users', 'perfis_users.user_id', '=', 'users.id')
            ->join('perfis','perfis.id','=','perfis_users.perfil_id');

        $where = [];

        if (isset($filtros['tipo']) && !empty($filtros['tipo'])) {
            $where[] = ['perfis.id', '=', $filtros['tipo']];
        }

        if ($where) {
            $query = $query->where($where);
        }

        if (!empty($filtros['consultarData'])) {
            $inicio = Carbon::createFromFormat('d/m/Y',$filtros['dataStart'])->format('Y-m-d');
            $final = Carbon::createFromFormat('d/m/Y',$filtros['dataEnd'])->format('Y-m-d');

            $query->whereBetween('users.created_at', [$inicio,$final]);
        }

        if (isset($filtros['status']) && $filtros['status'] !== "") {
            $query->where('users.ativo', $filtros['status']);
        }

        if ($search) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('users.nome', 'ilike', '%' . $search . '%')
                  ->orWhere('users.cpf', 'ilike', '%' . $search . '%')
                  ->orWhere('users.email', 'ilike', '%' . $search . '%');
            });
        }

        # Necessário agrupar para montar paginação
        $query->groupBy('users.id', 'perfis.nome', 'perfis.id');

        if ($limit !== false) {
            return $query->paginate($limit);
        } else {
            return $query->get();
        }
    }

    /**
     * Valida a senha de um usuário
     *
     * @param string $cpf
     * @param string $password
     * @return boolean
     */
    public function validarSenha($cpf, $password)
    {
        $cpf = str_replace(['-', '.'], ['', ''], $cpf);
        $user = $this->model->where('cpf', '=', $cpf)->first();
        $hasher = app('hash');
        
        if ($user && $hasher->check($password, $user->password)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @param $arquivo
     * @param $id
     * @return string
     */
    public function salvarFoto($arquivo)
    {
        try {
            if (isset($arquivo)) {

                $diretorioPai = 'fotos';

                $ext = substr($arquivo, 11, strpos($arquivo, ';') - 11);
                $urlImagem = $diretorioPai . DIRECTORY_SEPARATOR . time() . rand(0, 10) . '.' . $ext;

                $file = str_replace('data:image/' . $ext . ';base64,', '', $arquivo);

                $file = base64_decode($file);

                if (!file_exists($diretorioPai)) {
                    mkdir($diretorioPai, 0700, true);
                }

                file_put_contents($urlImagem, $file);

                return asset($urlImagem);
            }
        } catch (\Exception $ex) {
            report($ex);
            return ['success' => false];
        }
    }


    /**
     * Realiza o salvamento de um usuário
     *
     * @param array $data
     * @return boolean
     */
    public function save(array $data)
    {
    
        try {
            \DB::beginTransaction();

            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            if (!isset($data['id']) || empty($data['id'])) {
                $password = rand(100000, 999999);
                $data['password'] = bcrypt($password);
                $data['token'] = null;
                $data['alterar_senha'] = false;
                # Decode the avatar to base64
                if($data['foto']){
                    $data['foto'] = $this->salvarFoto($data['foto']);
                }else{
                    $data['foto'] = 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg';
                }

                # Save user model
                $this->model->fill($data)->save();

                # Salva o usuário
                $token = new Token();
                $token->user_id = $this->model->id;
                $token->token = rand(100000, 999999);
                $token->expirado = false;
                $token->save();

                # Save perfis_recursos model
                if (is_array($data['perfis'])) {
                    foreach ($data['perfis'] as $perfil) {
                        $this->model->perfis()->attach($perfil['id']);
                    }
                } else {
                    $this->model->perfis()->attach($data['perfis']);
                }
                
                Mail::to($this->model->email)->send(new ConfirmacaoCadastro($this->model, $password, $token->token));
                
                \DB::commit();
                return ['success' => true, 'user' => $this->model];
            } else {
                $model = $this->model->find($data['id']);    
                if (strpos($data['foto'], 'base64')){
                    $data['foto'] = $this->salvarFoto($data['foto']);
                }else{
                    $data['foto'] = 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg';
                }
                $model->perfis()->detach();
                # Save perfis_recursos model
                if (is_array($data['perfis'])) {
                    foreach ($data['perfis'] as $perfil) {
                        $model->perfis()->attach($perfil['id']);
                    }
                } else {
                    $model->perfis()->attach($data['perfis']);
                }
                $model->update($data);

                \DB::commit();
                return ['success' => true];
            }

        } catch (\Exception $ex) {
            \DB::rollBack();
            report($ex);
            return ['success' => false];
        }
    }

    /**
     * Recupera a senha
     *
     * @param string $email
     */
    public function recuperarSenha($cpf)
    {
        try {
            $model = $this->model->where('cpf', $cpf);
            $user = $model->first();

            if (!$user)
                return array('success' => false);

            $token = Token::create([
                'user_id' => $user->id,
                'token' => uniqid()
            ]);

            Mail::to($user)->send(new RecuperarSenha($token, $user));

            return array('success' => true, 'email' => $user->email);
        } catch (\Exception $ex) {
            report($ex);
            return array('success' => false);
        }
    }

    /**
     * Altera a senha
     *
     * @param array $data
     */
    public function alterarSenha($data)
    {
        try {
            $token = $data['token'];
            $dbToken = Token::where('token', $token)->where('expirado', false)->first();

            if (!$dbToken) return false;

            $user = $this->model->where('id', $dbToken->user_id)->first();

            $user->password = bcrypt($data['password']);
            $user->save();

            $dbToken->expirado = true;
            $dbToken->save();

            return true;
        } catch (\Exception $ex) {
            report($ex);
            return false;
        }
    }

    /** Busca um usuário específico */
    public function buscarUsuario($id)
    {
        $usuario = $this->model->select(['users.*','perfis.nome AS perfil','perfis.id AS perfil_id'])
            ->join('perfis_users', 'perfis_users.user_id', '=', 'users.id')
            ->join('perfis','perfis.id','=','perfis_users.perfil_id')
            ->where('users.id', $id)->first();

        if (!$usuario)
            return false;

        return $usuario;
    }

    /** Suspender usuário específico */
    public function suspender($id){
        try {
            \DB::beginTransaction();
            $usuario = $this->model->find($id);

            if (!$usuario) return false;

            $usuario->ativo = self::INATIVO;
            $usuario->save();

            \DB::commit();
            return true;
        } catch (\Exception $exception) {
            report($exception);
            \DB::rollBack();
            return false;
        }
    }

    /** Ativar usuário específico */
    public function ativar($id){
        try {
            \DB::beginTransaction();
            $usuario = $this->model->find($id);

            if (!$usuario) return false;

            $usuario->ativo = self::ATIVO;
            $usuario->save();

            \DB::commit();
            return true;
        } catch (\Exception $exception) {
            report($exception);
            \DB::rollBack();
            return false;
        }
    }

    /**
     * @param $dados
     * @return bool
     * @info Altera a senha através do meu perfil
     */
    public function alterarMinhaSenha($dados) { 
        try {
            $user = $this->model->find($dados['id']);
            $user->password = bcrypt($dados['senha']);
            $user->save();

            return true;
        } catch (\Exception $ex) {
            report($ex);
            return false;
        }
    }

    public function delete($id) {
        try {
            \DB::beginTransaction();

            $model = $this->model->find($id);
            $model->token()->delete();
            $model->perfisUser()->delete();
            $model->delete();

            \DB::commit();
            return true;
        } catch (\Exception $ex) {
            \DB::rollBack();
            report($ex);
            return false;
        }
    }

}
