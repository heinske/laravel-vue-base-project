<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe modelo de perfis
 *
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class Perfil extends Model {

    protected $table = 'perfis';
    protected $fillable = [
        'nome', 
        'descricao',
        'ativo',
        'publico'        
    ];

    /**
     * Método de relacionamento com Usuários
     *
     * @return void
     */
    public function Users(){
        return $this->belongsToMany('App\User', 'perfis_users', 'perfil_id', 'user_id');
    }

    /**
     * Método de relacionamento com Recursos
     *
     * @return void
     */
    public function Recursos() {
        return $this->belongsToMany('App\Models\Recurso', 'perfis_recursos', 'perfil_id', 'recurso_id');
    }

    /**
     * Método de relacionamento com Sistema
     *
     * @return void
     */
    public function Sistema(){
        return $this->belongsTo('App\Models\Sistema', 'sistema_id', 'id');
    }


}
