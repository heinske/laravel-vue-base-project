<?php

namespace App\Repository;

use App\Models\Recurso;

/**
 * Repositório com todas as regras relacionadas a recursos
 *
 * @author Eduardo Praxedes Heinske (eduardo.praxedes@jointecnologia.com.br)
 */
class RecursoRepository extends BaseRepository {

    /**
     * Model de recursos
     *
     * @var Recurso
     */
    protected $model;
    
    /**
     * Construtor
     *
     * @param Recurso $recurso
     */
    public function __construct(Recurso $recurso) {
        $this->model = $recurso;
    } 
    
    /**
     * Verifica a existência de um recurso
     *
     * @param integer $id
     * @return void
     */
    public function verificarRecurso($id){
        return $this->model->where('id', $id)->count();
    }

        
    /**
     * Verifica a existência de recursos
     *
     * @param array $id
     * @return void
     */
    public function totalRecursos($ids){
        return $this->model->whereIn('id', $ids)->count();
    }



}
