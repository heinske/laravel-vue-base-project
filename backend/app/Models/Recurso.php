<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe modelo de recursos
 * 
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class Recurso extends Model {

    protected $table = 'recursos';
    protected $fillable = [
        'recurso', 
        'nome_recurso', 
        'acao', 
        'nome_acao'
    ];
    
    /**
     * Método de relacionamento com perfis
     *
     * @return void
     */
    public function Perfis() {
        return $this->belongsToMany('App\Models\Perfil', 'perfis_recursos', 'recurso_id', 'perfil_id');
    }

}
