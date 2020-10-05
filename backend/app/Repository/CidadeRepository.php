<?php

namespace App\Repository;

use App\Models\Cidade;

/**
 * Description of CidadeRepository
 *
 * @author Ezequiel Lafuente (ezequiel.coelho@jointecnologia.com.br)
 */
class CidadeRepository extends BaseRepository {

    protected $model;

    public function __construct(Cidade $cidade) {
        $this->model = $cidade;
    }

}
