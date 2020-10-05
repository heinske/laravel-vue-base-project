<?php

namespace App;

use App\Helpers\UtilHelper;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Classe de modelo de  usuários
 *
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class User extends Authenticatable implements JWTSubject
{

    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'nome', 
        'cpf', 
        'password', 
        'email', 
        'foto', 
        'ativo', 
        'cargo',
        'setor',
        'alterar_senha'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Método de relacionamento com perfis
     *
     * @return void
     */
    public function perfis()
    {
        return $this->belongsToMany('App\Models\Perfil', 'perfis_users', 'user_id', 'perfil_id');
    }

    /**
     * Método de relacionamento com perfis
     *
     * @return void
     */
    public function perfisUser()
    {
        return $this->hasMany('App\Models\PerfilUser', 'user_id', 'id');
    }

    /**
     * Método de relacionamento com tokens
     *
     * @return void
     */
    public function token()
    {
        return $this->hasMany('App\Models\Token');
    }
   
    /**
     * @param $value
     * @return null|string|string[]
     * @info Mutator para formatação da saída do CPF
     */
    public function getCpfAttribute($value)
    {
        return UtilHelper::formatarCPF($value);
    }

    /**
     * @param $value
     * @return string
     * @info Mutator para formatação da data de cadastro
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     * @info Esse é o payload retornado no token JWT
     */
    public function getJWTCustomClaims()
    {

        $perfis = [];

        foreach ($this->perfis as $key => $perfil) {
            $perfis[] = $perfil->id;
        }

        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'perfis' => $perfis
            //'permissoes'
        ];
    }



}
