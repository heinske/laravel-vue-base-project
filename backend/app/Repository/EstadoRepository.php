<?php

namespace App\Repository;

use App\Models\Estado;

/**
 * Description of EstadoRepository
 *
 * @author Eduardo Praxedes (eduardo.praxedes@jointecnologia.com.br)
 */
class EstadoRepository extends BaseRepository {

    protected $model;

    public function __construct(Estado $estado) {
        $this->model = $estado;
    }

}
