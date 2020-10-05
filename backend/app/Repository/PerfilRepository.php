<?php

namespace App\Repository;

use App\Models\Perfil;

/**
 * Repositório com todas as regras relacionadas a perfis
 *
 * @author Eduardo Praxedes Heinske (eduardo.praxedes@jointecnologia.com.br)
 */
class PerfilRepository extends BaseRepository
{

    /**
     * Model de perfis
     *
     * @var Perfil
     */
    protected $model;

    /**
     * Construtor
     *
     * @param Perfil $perfil
     */
    public function __construct(Perfil $perfil)
    {
        $this->model = $perfil;
    }

    /**
     * Busca de perfis
     *
     * @param string $search
     * @param boolean $recursos
     * @param integer $limit
     * @param integer $offset
     * @param integer $count
     * @return array
     */
    public function busca($search = '', $filtros = [], $recursos = false, $limit = false)
    {
        $query = $this->model->select(['perfis.id','perfis.nome', 'perfis.ativo']);

        $where = [];

        if ($where) {
            $query = $query->where($where);
        }

        if (isset($filtros['status']) && !empty($filtros['status'])) {
            $filtros['status'] = is_array($filtros['status']) ? $filtros['status'] : [$filtros['status']];
            $query->whereIn('perfis.ativo', $filtros['status']);
        }

        if ($search) {
            $query = $query->where('perfis.nome', 'ilike', '%' . $search . '%');
        }

        if ($limit !== false) {
            return $query->paginate($limit);
        } else {
            return $query->get();
        }
    }

    /**
     * Busca individual de perfil
     *
     * @param integer $id
     * @param boolean $withRelashions
     * @return Perfil
     */
    public function find($id, $withRelashions = false)
    {
        if ($withRelashions) {
            return $this->model->where('id', $id)->with(['recursos'])->first();
        } else {
            return $this->model->find($id);
        }
    }
    
    /**
     * Conta todos os usuários vinculados ao perfil
     *
     * @param integer $perfil
     * @return integer
     */
    public function totalUsersPerfil($perfil){
        return $this->model->selectRaw('count(perfis_users.user_id) as total')->from('perfis_users')->where('perfil_id', $perfil)->first()->total;
    }

    /**
     * Salvamento de perfis
     *
     * @param array $data
     * @return boolean
     */
    public function save(array $data)
    {
        try {

            if (!isset($data['id']) || empty($data['id'])) {

                $data['id'] = null;

                $this->model->fill($data)->save();

                foreach ($data['recursos'] as $id) {
                    $this->model->Recursos()->attach($id);
                }

            } else {

                $perfil = $this->model->find($data['id']);
                $perfil->update($data);
                $permissoes = [];

                foreach ($data['recursos'] as $id) {
                    $permissoes[] = $id;
                }

                $perfil->Recursos()->sync($permissoes);
            }

            return true;
        } catch (\Exception $ex) {
            report($ex);
            return false;
        }

    }

    /**
     * Exclusão de perfis
     *
     * @param integer $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $perfil = $this->model->find($id);

            if ($perfil) {
                if ($perfil->Users()->count() > 0) {
                    return false;
                } else {
                    $perfil->Recursos()->detach();
                    return $perfil->delete();
                }
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            report($ex);
            return false;
        }
    }

    public function verificarPerfil($nome, $id){
        return $this->model->where([['nome', '=', $nome], ['id', '<>', $id]])->count();
    }

    /**
     * Verifica se um ou mais perfis possuí determinada permissão baseado em sua ação e recurso
     *
     * @param integer $perfil
     * @param string $recurso
     * @param string $acao
     * @return boolean
     */
    public function validarPermissaoPerfis($perfis, $recurso, $acao) {
        return $this->model
                    ->whereIn('perfis.id', $perfis)
                    ->join('perfis_recursos', 'perfis_recursos.perfil_id' ,'=', 'perfis.id')
                    ->join('recursos', 'recursos.id', '=', 'perfis_recursos.recurso_id')
                    ->where('recursos.recurso', $recurso)
                    ->where('recursos.acao', $acao)
                    ->count() ? true : false;
    }

    /* Verifica a existência de um ou mais perfis
    *
    * @param integer $id
    * @return void
    */
    public function totalPerfis($ids){
       return $this->model->whereIn('id', $ids)->count();
    }

    public function getListaCombo(){
       return $this->model->where('publico', true)->get()->toArray();
    }

    public function getListaComboInterno(){
       return $this->model->where('id', '<>', 1)->orderBy('nome')->get()->toArray();
    }

    public function isAdmin($user_id){
       return $this->model->whereUserId('user_id', $user_id)->toSql();
    }


}
