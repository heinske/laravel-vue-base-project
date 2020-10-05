<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe modelo de Sistemas
 * 
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class Sistema extends Model {

    protected $table = 'sistemas';
    protected $fillable = [
        'id', 'nome', 'user_integracao', 'params_integracao'
    ];

    /**
     * Método de relacionamento com Perfis
     *
     * @return void
     */
    public function Perfis(){
        return $this->hasMany('App\Models\Perfil', 'sistema_id', 'id');
    }

    /**
     * Método de relacionamento com Recursos
     *
     * @return void
     */
    public function Recursos() {
        return $this->hasMany('App\Models\Recurso', 'sistema_id', 'id');
    }

}
