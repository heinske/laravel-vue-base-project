<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilUser extends Model
{
    protected $table = 'perfis_users';

    protected $fillable = ['perfil_id', 'user_id'];

    public function isAdmin($userId = null) {

        $perfil = $this->whereUserId($userId)->first();

        if ($perfil->perfil_id == 1) {
            return true;
        }

        return false;
    }

    public function isGestor($userId = null) {

        $perfil = $this->whereUserId($userId)->first();

        if ($perfil->perfil_id == 4 || $perfil->perfil_id == 5) {
            return true;
        }

        return false;
    }

    public function isPresidenteConselho($userId = null) {

        $perfil = $this->whereUserId($userId)->first();

        if ($perfil->perfil_id == 6) {
            return true;
        }

        return false;
    }

    public function isMobilizador($userId = null) {

        $perfil = $this->whereUserId($userId)->first();

        if ($perfil->perfil_id == 2 || $perfil->perfil_id == 3) {
            return true;
        }

        return false;
    }
}
