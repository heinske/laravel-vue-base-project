<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Repository\RecursoRepository;
use Illuminate\Http\Request;
use Exception;

/**
 * Controller com todos os endpoints referentes aos recursos
 *
 * @author Eduardo Praxedes Heinske <eduardo.praxedes@jointecnologia.com.br>
 */
class RecursoController extends Controller {

    protected $recursoRepository;

    /**
     *
     * @param RecursoRepository $recursoRepository
     */
    public function __construct(RecursoRepository $recursoRepository) {
        $this->recursoRepository = $recursoRepository;
    }

    /**
     * ´Busca de recursos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        try {

            $recursos = $this->recursoRepository->all(['nome_recurso', 'asc'])->toArray();
            return ResponseHelper::responseSuccess($recursos, "");
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    /**
     * Realiza a busca de um recurso específico
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            $recurso = $this->recursoRepository->find($id);

            if ($recurso) {

                return ResponseHelper::responseSuccess($recurso->toArray(), "");
            } else {
                return ResponseHelper::responseSuccess([], "");
            }
        } catch (Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }
}
