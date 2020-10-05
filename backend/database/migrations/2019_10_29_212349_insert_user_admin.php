<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertUserAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $next_id = \DB::select("select nextval('users_id_seq')");

        \DB::table('users')->insert([
            [
                'id' => $next_id[0]->nextval, 
                'nome' => 'Administrador', 
                'cpf' => '11111111111', 
                'password' => bcrypt('123456'), 
                'email' => 'administrador@teste.com', 
                'foto' => 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg', 
                'ativo' => 1, 
                'cargo' => null,
                'setor' => null,
                'alterar_senha' => false,
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        \DB::table('perfis_users')->insert([
            ['perfil_id' => 1, 'user_id' => $next_id[0]->nextval]
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('perfis_users')->where('user_id', 1)->delete();
        \DB::table('users')->where('id', 1)->delete();
    }
}
