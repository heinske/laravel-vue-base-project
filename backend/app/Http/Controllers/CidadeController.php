<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\ResponseHelper;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\UserCidade;
use App\Models\PerfilUser;

/**
 * Controller para a responsábilidade definida a cidades
 *
 * @author Ezequiel Lafuente <ezequiel.coelho@jointecnologia.com.br>
 */
class CidadeController extends Controller
{

    private $estado;

    public function __construct(Estado $estado, PerfilUser $perfilUser)
    {
        $this->estado = $estado;
        $this->perfilUser = $perfilUser;
    }

    /**
     * @param null $id
     * @return array|\Illuminate\Http\JsonResponse
     * @info Retorna as cidades a partir de um id de estado, ou todas as cidades
     */
    public function getCidades($id = null)
    {
        if (!$id) {
            $cidades = Cidade::pluck('cidade', 'id');
            return ResponseHelper::responseSuccess(['cidades' => $cidades], "", true, 200);
        }

        $estado = $this->estado->find($id);
        $cidades = $estado->cidades()->select(['cidade', 'id'])->get();

        return ResponseHelper::responseSuccess(['cidades' => $cidades], "", true, 200);
    }

    /**
     * @param null $id
     * @return array|\Illuminate\Http\JsonResponse
     * @info Retorna as cidades a partir de um id de estado, ou todas as cidades
     */
    public function getCidadesPorConferencia($id = null)
    {

        $cidades = \App\Models\ConferenciaCidade::with('cidade')->whereConferenciaId($id)->get();

        return ResponseHelper::responseSuccess(['cidades' => $cidades], "", true, 200);
    }

    /**
     * @param null $id
     * @return array|\Illuminate\Http\JsonResponse
     * @info Retorna as cidades a partir de um id de estado, ou todas as cidades
     */
    public function getCidadesPorUsuario(Request $request)
    {
        $user_id = $request->get('user_id');

        $isAdmin = $this->perfilUser->isAdmin($user_id);

        if ($isAdmin) {
            $arr = Cidade::all();
        } else {
            $cidades = UserCidade::with('cidade')->whereUserId($user_id)->get();
            
            foreach ($cidades as $cidade) {
                $arr[] = $cidade->cidade;
            }
        }

        return ResponseHelper::responseSuccess(['cidades' => $arr], "", true, 200);
    }
}
