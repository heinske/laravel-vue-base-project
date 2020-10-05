<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Estado;
use App\Models\UserCidade;
use App\Models\PerfilUser;

/**
 * Controller para a responsábilidade definida a Estados
 *
 * @author Ezequiel Lafuente <ezequiel.coelho@jointecnologia.com.br>
 */
class EstadoController extends Controller
{
    private $estado;

    public function __construct(Estado $estado, PerfilUser $perfilUser)
    {
        $this->estado = $estado;
        $this->perfilUser = $perfilUser;
    }

    /**
     * @return array|\Illuminate\Http\JsonResponse
     * @info Retorna uma lista de uf's dos estados brasileiros
     */
    public function getEstados()
    {
        $estados = $this->estado->pluck('sigla', 'id');
       
        return ResponseHelper::responseSuccess(['estados' => $estados], "");
    }

    /**
     * @return array|\Illuminate\Http\JsonResponse
     * @info Retorna uma lista de uf's dos estados brasileiros
     */
    public function getEstadosPorRegiao()
    {

        $estados = $this->estado->select(['sigla', 'id'])->get();

        return ResponseHelper::responseSuccess(['estados' => $estados], "");
    }

    /**
     * @param null $id
     * @return array|\Illuminate\Http\JsonResponse
     * @info Retorna as cidades a partir de um id de estado, ou todas as cidades
     */
    public function getEstadosPorUsuario(Request $request)
    {

        $user_id = $request->get('user_id');

        $isAdmin = $this->perfilUser->isAdmin($user_id);

        if ($isAdmin) {
            $estados = \DB::table('estados')->get();
        } else {

            $estados = \DB::select('
                      
                      SELECT DISTINCT (estados.id)
                           , estados.sigla

                        FROM estados 
                  
                  INNER JOIN cidades 
                          ON cidades.estado_id = estados.id
                  
                  INNER JOIN users_cidades
                          ON users_cidades.cidade_id = cidades.id 

                       WHERE users_cidades.user_id = ?', [$user_id]);
        }

        return ResponseHelper::responseSuccess(['estados' => $estados], "", true, 200);
    }

}
